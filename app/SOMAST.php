<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SOMAST extends Model
{
    // status 1 3 5 7 9
    // currency
    // CAD AND USD
    protected $table = 'somast';

    public $timestamps = false;

    // belongs to this customer
    public function customer(){
        return $this->belongsTo('App\User',"m_id","m_id");
    }

    // has many so details
    public function sotran(){
        return $this->hasMany('App\SOTRAN','order_num','order_num');
    }
    
}
