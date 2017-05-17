<?php

namespace App\Http\Controllers;

use App\Park;
use Illuminate\Http\Request;
use App\Repositories\ParkRepository;
use App\User;
use Illuminate\Support\Facades\Auth;
use MaddHatter\LaravelFullcalendar\Facades\Calendar;

class ParkController extends Controller
{
    protected $user;
    protected $n = 10;

    public function __construct(ParkRepository $parkRepository, User $user)
    {
        $this->parkRepository = $parkRepository;
        $this->User = $user;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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

    // return redirect('user')->withOk("L'utilisateur " . $user->name . " a été créé.");
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

        return view('userProfile.showPark',  compact('Park'));
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

    public function search(){
     $Parks = $this->parkRepository->getPaginate($this->n);
        $links = $Parks->render();

        return view('search.all', compact('Parks', 'links'));
    }
    public function showOne($id)
    {
        $Park = $this->parkRepository->getById($id);

        $events[] = \Calendar::event(
            "Valentine's Day", //event title
            true, //full day event?
            new \DateTime('2015-02-14'), //start time (you can also use Carbon instead of DateTime)
            new \DateTime('2015-02-14'), //end time (you can also use Carbon instead of DateTime)
            'stringEventId' //optionally, you can specify an event ID
        );
        $calendar = \Calendar::addEvents($events); //add an array with addEvents

        return view('search.one',  compact('Park','calendar'));
    }
}
