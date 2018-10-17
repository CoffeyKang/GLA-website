<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item_make extends Model
{
    protected $connection = 'mysql2';
    
    protected $table ='arimak01';

    public $timestamps = false;

    public function itemDtails(){
    	return $this->belongsTo('App\Inventory','item','item');
    }
}
