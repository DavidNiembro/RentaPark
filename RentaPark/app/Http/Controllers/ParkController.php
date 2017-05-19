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

class ParkController extends Controller
{
    // Nombre d'éléments par pages
    protected $n = 10;

    public function __construct(ParkRepository $parkRepository)
    {
        $this->parkRepository = $parkRepository;
    }
    /**
     * Display a listing of the resource.
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Responses
     */
    public function create()
    {
        return view('park/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $park = $this->parkRepository->store($request->all());

        return redirect('MyPlaces');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Park = $this->parkRepository->getById($id);


        $events[] = \Calendar::event(
            "Réservé", //event title
            true, //full day event?
            new \DateTime('2017-05-14'), //start time (you can also use Carbon instead of DateTime)
            new \DateTime('2017-05-15') //end time (you can also use Carbon instead of DateTime)

        );
        $calendar = \Calendar::addEvents($events);


        $calendar->setOptions([
            'lang' => 'fr',
        ]);

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
    public function update(Request $request, $id)
    {
        $this->parkRepository->update($id, $request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $idUser = Auth::user()->getAuthIdentifier();

        DB::table('t_park')
            ->where('fkUser', $idUser)->where('idPark', $id)
            ->update(['parDelete' => true]);
        DB::table('t_reservation')
            ->where('fkPark', $id)
            ->update(['resDelete' => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function search(){

     $Parks = $this->parkRepository->getPaginate($this->n);
     $links = $Parks->render();

     return view('search.all', compact('Parks', 'links'));
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
