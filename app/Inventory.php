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
    	return $this->belongsTo('App\Inventory_img','item','item');
    }

    public function featureItem(){
        return $this->belongsTo('App\FeatureProduct','item','item');
    }

    /**
     * get item information with img_path and viewed
     */
    public function itemFullInfo(){
        $this->img_path = $this->itemImg()->first()->img_path;
        return $this;
    }

    /**
     * relationship to wishlist
     * @return [type] [description]
     */
    public function wishlist(){
        return $this->hasMany('app\Wishlist','item','item');
    }
}
