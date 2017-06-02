<?php

/**
 * ETML
 * Auteur: David Niembro
 * Date:
 * Description: Contient les fonctions pour la gestion des places de parc
 */

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
     * @return La vue myPlaces et la variable users
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
     * @return La vue create
     */
    public function create()
    {
        //Renvoi vers la vue de création de place de parc
        return view('park/create');
    }

    /**
     * Création d'une place de parc
     *
     * @param  $request, Variable qui contient toutes les valeurs du formaulaire
     * @return La vue  MyPlaces
     */
    public function store(ParkCreateRequest $request)
    {
        //Est-ce que l'utilisateur a déjà 2 places
        if(count(Park::all()->where('fkUser',Auth::id())->where('parDelete',0))<2)
        {
            //Création de la place de parc avec le repository
            $park = $this->parkRepository->store($request->all());

            //Si l'adresse n'a pas pu être localisé
            if ($park==false){

                //Renvoi vers la vue des places de l'utilisateur avec un message d'erreur.
                return redirect('park/create')->withOk("L'adresse est introuvable. Veuillez la corriger");

            }else{

                //Renvoi vers la vue des places de l'utilisateur avec un message de confirmation.
                return redirect('MyPlaces')->withOk("La place a été créé avec succès.");
            }
        }
        else{

            //Renvoi vers la vue des places de l'utilisateur avec un message d'erreur.
            return redirect('MyPlaces')->withOk("Vous ne pouvez pas avoir plus de 2 places");
        }
    }

    /**
     * Affichage de la place
     *
     * @param  $id, id de la place à afficher
     * @return La vue showPark, Variable Park, calednar et Reservations
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
     * Modification de la place
     *
     * @param  $request, Valeur des champs du formulaire soumis.
     * @param  $id, id de la place à modifier
     * @return La vue MyPlaces
     */
    public function update(ParkUpdateRequest $request, $id)
    {
        //Modification de la place en passant par le repository
        $park = $this->parkRepository->update($id, $request->all());
        if ($park == false) {

            //Renvoi vers la vue des places de l'utilisateur avec un message d'erreur.
            return redirect('MyPlaces')->withOk("L'adresse est introuvable");

        } else {

            //Renvoi vers la vue des places de l'utilisateur avec un message de confirmation.
            return redirect('MyPlaces')->withOk("La place a été modifié avec succès.");
        }
    }

    /**
     * Suppression de la place et des réservations associés
     *
     * @param  $id, ID de la place de parc
     * @return La vue MyPlaces
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
     * Recherche de toutes les places de parc
     *
     * @param  $request valeur du champs de recherche.
     * @return La vue all. Variable Parks, links, Localisation, maps
     */
    public function search(Request $request)
    {
        //Récupération des champs envoyé
        $inputs= array_merge($request->all());

        //Récupération de la valeur du champs ville
        $Localisation = $inputs['ville'];

        //Récupération des places de park
        $Parks = $this->parkRepository->getPaginate($this->n);
        $links = $Parks->render();

        //Récupération des coordonnée de la ville passée en paramètre
        $response = \GoogleMaps::load('geocoding')
            ->setParam (['address' => $Localisation])
            ->get();
        $result = json_decode($response);

        //L'adresse existe pas ou le champs n'est pas vide
        if(!empty($result->results)){

            $json = $result->results[0];

            //Récupération de la latitude et la longitude
            $maps['parLatitude'] = (string) $json->geometry->location->lat;
            $maps['parLongitude'] = (string) $json->geometry->location->lng;

            return view('search.all', compact('Parks', 'links','Localisation','maps'));
        }
        else
        {
            return view('search.all', compact('Parks', 'links'));
        }
    }

    /**
     * Renvoi à la page de la place de parc
     *
     * @param  $id, id de la place à afficher.
     * @return La vue one, Variable park et calendar
     */
    public function showOne($id)
    {
        $park = $this->parkRepository->getById($id);

        //Récupère les réservations pour la place donnée
        $reservations = Reservation::all()->where('fkPark', $id)->where('resStatus','Accepte')->where('resDelete',0);

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

        return view('search.one',  compact('park','calendar'));
    }
}
