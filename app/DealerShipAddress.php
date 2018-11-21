<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DealerShipAddress extends Model
{
    protected $table = 'dealershipaddress';

    public $timestamps = false;

    /** dealer ship to */
    public function somast(){
        return $this->hasOne('App\DealerHistory','order_num','order_num');
    }

    
}
