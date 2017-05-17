<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Park extends Model
{
    protected $table = 't_park';

    protected $primaryKey= 'idPark';

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
    public $timestamps = false;

    public function user(){
        $this->belongsTo('App\User','idUser', 'fkUser');
    }
    public function userreservation()
    {
        return $this->belongsToMany('App\User')->using('App\Reservation');
    }
}
