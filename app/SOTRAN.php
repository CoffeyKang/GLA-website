<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SOTRAN extends Model
{
    protected $table = 'sotran';

    public $timestamps = false;

    // belongs to customer
    public function customer(){
        return $this->belongsTo('App\User',"m_id","m_id");
    }

    // belongs to somast
    public function somast(){
        return $this->belongsTo('App\SOMAST',"order_num","order_num");
    }
}
