<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory_img extends Model
{   
    protected $table = 'inventory_img';

    public $timestamps = false;
    /**
     * realationship with inventory 
     * one to one ralationship
     * @return [type] [description]
     */
    public function itemDtails(){
        $connection = 'mysql';
    	return $this->hasOne('App\Inventory','item','item');
    }
}
