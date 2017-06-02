<?php
/**
 * ETML
 * Auteur: David Niembro
 * Date:
 * Description: Contient les fonctions de gestion des données dans la BD
 */
namespace App\Repositories;

use App\Park;
use Illuminate\Support\Facades\Auth;

class ParkRepository
{
    protected $park;

    /**
     * Constructeur
     *
     * @return
     */
    public function __construct(Park $park)
    {
        $this->park = $park;
    }

    /**
     * Renvoi vers la pages des places d'un utilisateur
     *
     * @return \Illuminate\Http\Response
     */
    private function save(Park $park, Array $inputs)
    {
        //Récupération des coordonnées d'une adresse en utilisant l'API de Google
        $response = \GoogleMaps::load('geocoding')
            ->setParam (['address' => $inputs['parAddress'].', '.$inputs['parPostCode'].' '.$inputs['parCity']])
            ->get();

        //Décodage de la réponse en json
        $result = json_decode($response);

        //Adresse trouvée?
        if(count($result->results)>0) {

            //Récupération des coordonnées.
            $json = $result->results[0];

            //Récupération de la latitude
            $inputs['parLatitude'] = (string) $json->geometry->location->lat;

            //Récupération de la longitude
            $inputs['parLongitude'] = (string) $json->geometry->location->lng;

            //atributiond des valeurs aux propriétées de l'objet par park
            $park->parNumber = $inputs['parNumber'];
            $park->parAddress = $inputs['parAddress'];
            $park->parPostCode = $inputs['parPostCode'];
            $park->ParCity = $inputs['parCity'];
            $park->parPrice = $inputs['parPrice'];
            $park->parCouvert = isset($inputs['parCouvert']);
            $park->parLatitude = $inputs['parLatitude'];
            $park->parLongitude = $inputs['parLongitude'];
            $park->parDelete = 0;
            $park->fkUser = Auth::id();

            //inscription dans la base de données.
            $park->save();

            return true;
        }
        else {

            return false;
        }
    }

    /**
     * Renvoi vers la pages des places d'un utilisateur
     *
     * @return places de park
     */
    public function getPaginate($n){

        //Rendu par page des données dans la base de données
        return $this->park->paginate($n);
    }

    /**
     * Renvoi vers la pages des places d'un utilisateur
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Array $inputs){

        //Nouvel objet
        $park = new $this->park;

        $result = $this->save($park, $inputs);

        //Place créée ?
        if($result==false){
            return $result;
        }
        else{
            return $park;
        }
    }

    /**
     * Renvoi vers la pages des places d'un utilisateur
     *
     * @return \Illuminate\Http\Response
     */
    public function getById($id)
    {
        //Récupération avec l'id
        return $this->park->findOrFail($id);
    }

    /**
     * Renvoi vers la pages des places d'un utilisateur
     *
     * @return \Illuminate\Http\Response
     */
    public function update($id, Array $inputs)
    {
        $result = $this->save($this->getById($id), $inputs);
        return $result;
    }

    /**
     * Renvoi vers la pages des places d'un utilisateur
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->getById($id)->delete();
    }
}