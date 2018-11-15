<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    protected $table = 'billing';

    public $timestamps = false;

    public function cust(){
        
        return $this->hasOne('App\User','id','cust_id');
    }
}
