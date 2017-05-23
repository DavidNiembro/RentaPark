<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 't_user';

    protected $primaryKey= 'idUser';

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

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function park(){
        return $this->hasMany('App\Park', 'fkUser', 'idUser');
    }

    public function parkreservation()
    {
        return $this->belongsToMany('App\Park', 't_reservation',
            'fkUser' ,'fkPark' );
    }
}
