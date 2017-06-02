<?php
/**
 * ETML
 * Auteur: David Niembro
 * Date:
 * Description: Model de User
 */
namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    //défini le nom de la table
    protected $table = 't_user';

    //Défini le nom de la clé primaire
    protected $primaryKey= 'idUser';

    //Défini les champs qui peuvent être modifié par Laravel
    protected $fillable = [
        'useUsername',
        'email',
        'password',
        'usePictureProfil',
        'useFirstName',
        'useName',
        'useCity',
        'useLand',
        'confirmed',
        'confirmation_code',
        'useDelete',
    ];

    //Défini les champs qui ne peuvent pas être modifié par l'utilisateur
    protected $hidden = [
        'password', 'remember_token',
    ];

    //Permet de récupérer les places de l'utilisateur
    public function park(){
        return $this->hasMany('App\Park', 'fkUser', 'idUser');
    }

    //Permet de récuper les réservations.
    public function parkreservation()
    {
        return $this->belongsToMany('App\Park', 't_reservation',
            'fkUser' ,'fkPark' );
    }
}
