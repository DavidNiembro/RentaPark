<?php
/**
 * ETML
 * Auteur: David Niembro
 * Date:
 * Description: Model de la place
 */
namespace App;

use Illuminate\Database\Eloquent\Model;

class Park extends Model
{
    //défini le nom de la table
    protected $table = 't_park';

    //défini le nom de la clé primaire
    protected $primaryKey= 'idPark';

    //Défini les champs qui peuvent être modifié par Laravel
    protected $fillable = [
        'parNumber',
        'parAddress',
        'parPostCode',
        'ParCity',
        'parDelete',
        'parPrice',
        'parLatitude',
        'parLongitude',
        'parCouvert',
        'fkUser',
    ];

    //Désactive le timestamps
    public $timestamps = false;

    //Permet de récuperér l'utilisateur associé à la place de parc
    public function user(){
        return $this->belongsTo('App\User','fkUser','idUser');
    }

    //Permet de récupéer les réservations.
    public function userreservation()
    {
        return $this->belongsToMany('App\User')->using('App\Reservation');
    }
}
