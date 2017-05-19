<?php

namespace App\Repositories;

use App\Park;
use Illuminate\Support\Facades\Auth;

class ParkRepository
{

    protected $park;

    public function __construct(Park $park)
    {
        $this->park = $park;
    }

    private function save(Park $park, Array $inputs)
    {
        $response = \GoogleMaps::load('geocoding')
            ->setParam (['address' => $inputs['parAddress'].', '.$inputs['parPostCode'].' '.$inputs['parCity']])
            ->get();

        $result = json_decode($response);
        $json = $result->results[0];
        $inputs['parLatitude'] = (string) $json->geometry->location->lat;
        $inputs['parLongitude'] = (string) $json->geometry->location->lng;

        $park->parNumber = $inputs['parNumber'];
        $park->parAddress = $inputs['parAddress'];
        $park->parPostCode = $inputs['parPostCode'];
        $park->ParCity = $inputs['parCity'];
        $park->parPrice = $inputs['parPrice'];
        $park->parCouvert = isset($inputs['parCouvert']);
        $park->parLatitude = $inputs['parLatitude'];
        $park->parLongitude = $inputs['parLongitude'];
        $park->fkUser = Auth::id();

        $park->save();
    }

    public function getPaginate($n)
    {
        return $this->park->paginate($n);
    }

    public function store(Array $inputs)
    {
        $park = new $this->park;


        $this->save($park, $inputs);

        return $park;
    }

    public function getById($id)
    {
        return $this->park->findOrFail($id);
    }

    public function update($id, Array $inputs)
    {
        $this->save($this->getById($id), $inputs);
    }

    public function destroy($id)
    {
        $this->getById($id)->delete();
    }

}