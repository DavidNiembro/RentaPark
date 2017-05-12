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
        'useMail',
        'password',
        'usePictureProfil',
        'useFirstName',
        'useName',
        'useCity',
        'useLand',
        'useToken',
        'useVerified',
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

}
