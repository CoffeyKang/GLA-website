<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Temp_SO_dealer extends Model
{
    protected $table = 'temp_so_dealer';

    public $timestamps = false;

    public function itemInfo(){
        return $this->belongsTo('App\Inventory','item','item');
    }
}
