<?php
namespace App\Http\Controllers;

use App\Park;
use App\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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
        //Création d'un tableau avec toutes les valeurs reçues
        $inputs = array_merge($request->all());

        //Récupération de l'id de la personne qui est connecté
        $idUser = Auth::user()->getAuthIdentifier();

        //Récupération d'une place de park avec son ID
        $Park = Park::find($inputs['PlaceID']);

        //Récupération de l'adresse email du proriétaire de la place
        $email = $Park->user->email;

        //Récupération de l'utilisateur avec son ID
        $user = User::find($idUser);

        //Création de la réservation en la mettant en attente
        $user->parkreservation()->attach($inputs['PlaceID'], ['resStartingDate' => $inputs['Start'],'resFinishDate' => $inputs['End'],'resDelete'=> false, 'resStatus'=>'En Attente']);

        //Création du mail
        $title = "Réservation de votre place";
        $content = "je suis le contenu du mail ". + $Park->parNumber;
        $user_email = $email;
        $user_name = "nom du destinataire";

        //Envoi du mail
        $data = ['email'=> $user_email,'name'=> $user_name,'subject' => $title, 'content' => $content];
        Mail::send('park/confirmMail', $data, function($message) use($data)
        {
            $subject=$data['subject'];
            $message->from('info@test.ch');
            $message->to($data['email'], 'test.ch')->subject($subject);
        });
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changeStatus($id, $status, $start, $end){

        //Récupération de l'ID de l'utilisateur connecté
        $idUser = Auth::user()->getAuthIdentifier();

        //Changement du status dans la base de données
        DB::table('t_reservation')
            ->where('fkUser', $idUser)->where('fkPark', $id)->where('resStartingDate',$start)->where('resFinishDate',$end)
            ->update(['resStatus' => $status]);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function myReservationsIndex(){

        //Récupération de l'ID de l'utilisateur connecté
        $idUser = Auth::user()->getAuthIdentifier();

        //Récupération des réservation de l'utilisateur qui ont été accepté
        $Reservations = Reservation::all()->where('fkUser', $idUser)->where('resStatus','Accepte');

        //Création d'un tableau d'événement
        $events = [];
        foreach($Reservations as $reservation){
            $events[] = \Calendar::event(
                //Titre
                "Réservé",

                //Evénement sur la journée complète
                false,

                //Date de début et de fin de l'événement
                $reservation->resStartingDate,
                $reservation->resFinishDate
            );
        }//endforeach($Reservations as $reservation)

        //Création d'un calendrier avec le tableau des événements.
        $calendar = \Calendar::addEvents($events);

        //Option suplémentaires pour le calendrier
        $calendar->setOptions([ //set fullcalendar options

            //Langue du calendrier.
            'locale'=> 'es',

            //Le premier jour doit commencer par 1
            'firstDay' => 1,
        ]);


        return view('userProfile/myReservations', compact('calendar'));
    }

}
