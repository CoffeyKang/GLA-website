<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Temp_SO extends Model
{
    protected $table = 'temp_so';

    public $timestamps = false;

    public function itemInfo(){
        return $this->belongsTo('App\Inventory','item','item');
    }

}
