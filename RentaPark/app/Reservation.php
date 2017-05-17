<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $table = 't_reservation';

    protected $fillable = [
        'fkUser',
        'fkPark',
        'resStartingDate',
        'resFinishDate',
        'resDelete',
        'resStatus',
    ];

    public $timestamps = false;
    public function park()
    {
        return $this->belongsToMany('App\Park', 't_reservation',
            'fkPark', 'fkUser');
    }
}
