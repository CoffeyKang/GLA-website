<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $table='inventory';
    
    public $timestamps = false;

    /**
     * realationship with inventory 
     * one to one ralationship
     * @return [type] [description]
     */
    public function itemImg(){
    	return $this->hasOne('App\Inventory_img','item');
    }
}