<?php

namespace App\Http\Controllers;

use App\Park;
use App\Reservation;
use Illuminate\Http\Request;
use App\Repositories\ParkRepository;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use MaddHatter\LaravelFullcalendar\Facades\Calendar;
use App\Http\Requests\ParkCreateRequest;
use App\Http\Requests\ParkUpdateRequest;

class ParkController extends Controller
{
    // Nombre d'éléments par pages
    protected $n = 10;

    public function __construct(ParkRepository $parkRepository)
    {
        $this->parkRepository = $parkRepository;
    }
    /**
     * Renvoi vers la pages des places d'un utilisateur
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Récupère l'utilisateur qui est connecté
        $users = User::find(Auth::id());

        return view('userProfile/myPlaces', compact('users'));
    }

    /**
     * Renvoi vers la page de création de place de parc
     *
     * @return \Illuminate\Http\Responses
     */
    public function create()
    {
        //Renvoi vers la vue de création de place de parc
        return view('park/create');
    }

    /**
     * Création d'une place de parc
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ParkCreateRequest $request)
    {
        //Création de la place de parc avec le repository
        $park = $this->parkRepository->store($request->all());

        //Renvoi vers la vue des places de l'utilisateur avec un message de confirmation.
        return redirect('MyPlaces')->withOk("La place a été créé avec succès.");

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Récupération d'une place avec l'id
        $Park = $this->parkRepository->getById($id);

        //Récupération des réservation de la place de parc qui sont déjà accepté
        $reservationsAccepted = Reservation::all()->where('fkPark', $id)->where('resStatus','Accepte');

        //Tableau des évènenments
        $events = [];

        //Parcourt les réservations et les insères dans le tableau d'événement
        foreach($reservationsAccepted as $reservationAccepted){
            $events[] = \Calendar::event(
                "Réservé",
                false,
                $reservationAccepted->resStartingDate,
                $reservationAccepted->resFinishDate
            );
        }

        //Création d'un calendrier avec les événements en paramètres
        $calendar = \Calendar::addEvents($events);

        //Ajout d'options dans le calendrier
        $calendar->setOptions([
            'lang' => 'fr',
        ]);

        //Récupération des résérvations qui sont en attente pour la place
        $Reservations = Reservation::all()->where('resStatus', 'En Attente')->where('fkPark', $id);

        return view('userProfile.showPark',  compact('Park','calendar','Reservations'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ParkUpdateRequest $request, $id)
    {
        //Modification de la place en passant par le repository
        $park = $this->parkRepository->update($id, $request->all());

        return redirect('MyPlaces')->withOk("La place a été modifié avec succès.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Récupère l'id de l'utilisateur connecté
        $idUser = Auth::user()->getAuthIdentifier();

        //Supprime la place de park
        DB::table('t_park')
            ->where('fkUser', $idUser)->where('idPark', $id)
            ->update(['parDelete' => true]);

        //Supprime les réservation de la place de parc
        DB::table('t_reservation')
            ->where('fkPark', $id)
            ->update(['resDelete' => true]);

        //Retourne à la page des places
        return redirect('MyPlaces')->withOk("La place a été supprimé avec succès.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request){

        $inputs= array_merge($request->all());
        $Localisation = $inputs['ville'];

        $Parks = $this->parkRepository->getPaginate($this->n);
        $links = $Parks->render();


        $response = \GoogleMaps::load('geocoding')
            ->setParam (['address' => $Localisation])
            ->get();

        $result = json_decode($response);
        if(!empty($result->results)){


            $json = $result->results[0];
            $maps['parLatitude'] = (string) $json->geometry->location->lat;
            $maps['parLongitude'] = (string) $json->geometry->location->lng;

            return view('search.all', compact('Parks', 'links','Localisation','maps'));
        }else
        {

            return view('search.all', compact('Parks', 'links'));

        }

    }

    /**
     * Renvoi à la page de la place de parc
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response Park et Calendar
     */
    public function showOne($id)
    {
        $park = $this->parkRepository->getById($id);

        //Récupère les réservations pour la place donnée
        $reservations = Reservation::all()->where('fkPark', $id)->where('resStatus','Accepte');

        //Tableau des évènenments
        $events = [];

        //Parcourt les réservations
        foreach($reservations as $reservation){
            $events[] = \Calendar::event(
                "Réservé",
                false,
                $reservation->resStartingDate,
                $reservation->resFinishDate
            );
        }

        //Initialise un nouveau calendrier et ajoute les évènements
        $calendar = \Calendar::addEvents($events);

        $calendar->setOptions([
            'lang' => 'fr',
        ]);

        return view('search.one',  compact('park','calendar'));
    }
}
