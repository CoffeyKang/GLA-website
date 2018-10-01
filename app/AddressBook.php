<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AddressBook extends Model
{
    protected $table = 'addressbook';

    public $timestamps = false;

    public function user(){
        return $this->belongsTo('App\User','cust_id');
    }
}
