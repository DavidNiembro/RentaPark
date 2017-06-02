<?php
/**
 * ETML
 * Auteur: David Niembro
 * Date:
 * Description: Model de Reservation
 */
namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    //défini le nom de la table
    protected $table = 't_reservation';

    //Défini les champs qui peuvent être modifié par Laravel
    protected $fillable = [
        'fkUser',
        'fkPark',
        'resStartingDate',
        'resFinishDate',
        'resDelete',
        'resStatus',
    ];

    //Désactive le timestamps
    public $timestamps = false;

    //Permet de récupérer l' utilisateur d'une réservation
    public function user(){
       return $this->hasMany('App\User',  'idUser','fkUser');
    }

    //Permet de récuperer la place d'une réservation
    public function park()
    {
        return $this->belongsToMany('App\Park', 't_reservation',
            'fkPark', 'fkUser');
    }
}
