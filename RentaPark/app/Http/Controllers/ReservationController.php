<?php

namespace App\Http\Controllers;

use App\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{


    public function __construct()
    {

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Responses
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = array_merge($request->all());

        $idUser = Auth::user()->getAuthIdentifier();

        $user = User::find($idUser);
        $user->parkreservation()->attach($inputs['PlaceID'], ['resStartingDate' => $inputs['Start'],'resFinishDate' => $inputs['End'],'resDelete'=> false, 'resStatus'=>'En Attente']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function changeStatus($id, $status, $start, $end){

        $idUser = Auth::user()->getAuthIdentifier();

        DB::table('t_reservation')
            ->where('fkUser', $idUser)->where('fkPark', $id)->where('resStartingDate',$start)->where('resFinishDate',$end)
            ->update(['resStatus' => $status]);
        return back();
        //$user = User::find($idUser);
        //$user->parkreservation()->updateExistingPivot([$id =>['resStatus'=> $status]],false);
    }

    public function myReservationsIndex(){

        $idUser = Auth::user()->getAuthIdentifier();
        $Reservations = Reservation::all()->where('fkUser', $idUser)->where('resStatus','Accepte');
        $events = [];
        foreach($Reservations as $reservation){
            $events[] = \Calendar::event(
                "Réservé", //event title
                false, //full day event?
                $reservation->resStartingDate,
                $reservation->resFinishDate

            );
        }

        $calendar = \Calendar::addEvents($events);


        $calendar->setOptions([ //set fullcalendar options
            'locale'=> 'es',
            'firstDay' => 1,
        ]);


        return view('userProfile/myReservations', compact('calendar'));
    }

}
