<?php

/**
 * ETML
 * Auteur: David Niembro
 * Date:
 * Description: Contient les fonctions pour la gestion des réservations
 */

namespace App\Http\Controllers;

use App\Park;
use App\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

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
     * Création d'une réservation
     *
     * @param  $request, Valeur des champs du formulaire soumis
     * @return
     */
    public function store(Request $request)
    {
        //Création d'un tableau avec toutes les valeurs reçues
        $inputs = array_merge($request->all());


        //Tranformation des dates en timestamp
        $start = new Carbon($inputs['Start']);
        $start = $start->getTimestamp();

        $end = new Carbon($inputs['End']);
        $end = $end->getTimestamp();

        //Récupération de l'id de la personne qui est connecté
        $idUser = Auth::user()->getAuthIdentifier();

        //Récupération d'une place de park avec son ID
        $Park = Park::find($inputs['PlaceID']);

        //Récupération de l'adresse email du proriétaire de la place
        $email = $Park->user->email;

        //Récupération de l'utilisateur avec son ID
        $user = User::find($idUser);

        //Récupération des réservations déjà accepté
        $reservationsToTest = Reservation::all()->where('resStatus','Accepte');

        foreach($reservationsToTest as $reservationToTest)
        {
            //Tranformation des dates en timestamp
            $startToTest = new Carbon($reservationToTest['resStartingDate']);
            $startToTest = $startToTest->getTimestamp();

            $FinishToTest = new Carbon($reservationToTest['resFinishDate']);
            $FinishToTest = $FinishToTest->getTimestamp();

            //Verification que la nouvelle réservation ne gêne pas une autre pour la même place
            if($end<$startToTest||($end>$FinishToTest && $start>$FinishToTest)){

            }else
            {
                return redirect('showOne/'.$inputs['PlaceID'])->withOk("Une autre réservation est déjà prévue dans cette tranche horaires. Veuillez vous référer au calendrier des réservations");
            }
        }

        if($idUser==$Park['fkUser']){

            //Création de la réservation en la mettant en accepté
            $user->parkreservation()->attach($inputs['PlaceID'], ['resStartingDate' => $inputs['Start'],'resFinishDate' => $inputs['End'],'resDelete'=> false, 'resStatus'=>'Accepte']);

            return back();

        }else{

            //Création de la réservation en la mettant en attente
            $user->parkreservation()->attach($inputs['PlaceID'], ['resStartingDate' => $inputs['Start'],'resFinishDate' => $inputs['End'],
                'resDelete'=> false, 'resStatus'=>'En Attente']);

            //Création du mail
            $title = "Réservation de votre place";
            $user_email = $email;

            //Envoi du mail
            $data = ['email'=> $user_email,'subject' => $title];
            Mail::send('park/confirmMail', $data, function($message) use($data)
            {
                $subject=$data['subject'];
                $message->from('info@rentapark.section-inf.ch');
                $message->to($data['email'], 'Rentapark.section-inf.ch')->subject($subject);
            });

            return back();
        }
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
     * Changement du status
     *
     * @param  $id , $idUser, $status, $start, $end
     * @return
     */
    public function changeStatus($id, $idUser, $status, $start, $end){

        //Changement du status dans la base de données
        DB::table('t_reservation')
            ->where('fkUser', $idUser)->where('fkPark', $id)->where('resStartingDate',$start)->where('resFinishDate',$end)
            ->update(['resStatus' => $status]);

        return back();
    }

    /**
     * Affiche les réservations de l'utilisateur.
     *
     * @return Vue MyReservations, Variables calendar, Reservations
     */
    public function myReservationsIndex(){

        //Récupération de l'ID de l'utilisateur connecté
        $idUser = Auth::user()->getAuthIdentifier();

        //Récupération des réservation de l'utilisateur qui ont été accepté
        $Reservations = Reservation::all()->where('fkUser', $idUser)->where('resStatus','Accepte')->where('resDelete', 0);

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

            //Le premier jour doit commencer par 1
            'firstDay' => 1,
        ]);

        return view('userProfile/myReservations', compact('calendar','Reservations'));
    }

    /**
     * Affiche la page de modification.
     * @param $request, Valeur de la réservation à modifier
     * @return vue myReservationsEdit, Variable Reservations.
     */
    public function reservationEdit(Request $request){

        $inputs = array_merge($request->all());

        //Récupération de la réservation.
        $Reservations = Reservation::all()->where('fkUser', $inputs['fkUser'])->where('fkPark', $inputs['fkPark'])->where('resStartingDate',$inputs['start'])->where('resFinishDate',$inputs['end'])->where('resDelete',0);

        return view('userProfile/myReservationsEdit',  compact('Reservations'));

    }

    /**
     * Récupère les valeurs du formulaire de modifacation est les persistes dans la base
     * @param $id, ID de la place
     * @param $idUser ID du propriétaire
     * @param $start Ancienne date de début de la réservation
     * @param $end Ancienne date de Fin de la réservation
     * @param $request Valeur du formulaire de modification
     * @return Route MyReservation
     */
    public function reservationEditStore($id, $idUser, $start, $end, Request $request){

        //Récupération de l'id de la personne qui est connecté
        $idUserAuth = Auth::user()->getAuthIdentifier();

        $inputs = array_merge($request->all());

        //Transformation de la date en TimeStamp
        $startOld = new Carbon($start);
        $startOld = $startOld->getTimestamp();

        $endOld = new Carbon($end);
        $endOld = $endOld->getTimestamp();

        $startCheck = new Carbon($inputs['Start']);
        $startCheck = $startCheck->getTimestamp();

        $endCheck = new Carbon($inputs['End']);
        $endCheck = $endCheck->getTimestamp();

        //Récupération des réservation accepté
        $reservationsToTest = Reservation::all()->where('resStatus','Accepte');

        //Parcours les réservations
        foreach($reservationsToTest as $reservationToTest)
        {
            //Transforme les date en timeStamp
            $startToTest = new Carbon($reservationToTest['resStartingDate']);
            $startToTest = $startToTest->getTimestamp();

            $FinishToTest = new Carbon($reservationToTest['resFinishDate']);
            $FinishToTest = $FinishToTest->getTimestamp();

            //? Réservation valable
            if($startToTest==$startOld && $FinishToTest==$endOld){

            }else{

                if($endCheck<$startToTest||($endCheck>$FinishToTest && $startCheck>$FinishToTest)){

                }else
                {
                    //return redirect()->back()->withOk("Une autre réservation est déjà prévue dans cette tranche horaires. Veuillez vous référer au calendrier des réservations");
                    return redirect('MyReservations');
                }
            }
        }

        //Si le propriétaire est le locataire
        if($idUserAuth==$idUser){
            DB::table('t_reservation')
                ->where('fkPark', $id)->where('fkUser', $idUser)->where('resStartingDate',$start)->where('resFinishDate',$end)
                ->update(['resStartingDate'=> $inputs['Start'],'resFinishDate'=> $inputs['End'], 'resStatus'=>'Accepte']);
        }else{
            DB::table('t_reservation')
                ->where('fkPark', $id)->where('fkUser', $idUser)->where('resStartingDate',$start)->where('resFinishDate',$end)
                ->update(['resStartingDate'=> $inputs['Start'],'resFinishDate'=> $inputs['End'], 'resStatus'=>'En Attente']);
        }

        return redirect('MyReservations');
    }

    /**
     * Suppression de la place
     * @param $id, id de la place
     * @param $idUser, id de l'utilisateur
     * @param $start, Date de début
     * @param $end, Date de fin
     */
    public function reservationDestroy($id, $idUser, $start, $end){

        DB::table('t_reservation')
            ->where('fkPark', $id)->where('fkUser', $idUser)->where('resStartingDate',$start)->where('resFinishDate',$end)
            ->update(['resDelete'=> 1 ]);
    }
}
