<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item_make extends Model
{
    protected $table ='item_makes';

    public $timestamps = false;

    public function itemDtails(){
    	return $this->belongsTo('App\Inventory','item','item');
    }
}
