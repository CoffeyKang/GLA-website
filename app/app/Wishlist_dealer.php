<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wishlist_dealer extends Model
{
    protected $table = 'wishlist_dealer';

    public $timestamps = false;

    /**
     * relationship to inventory table to check item details
     * 
     * @return [type] [description]
     */
   	public function itemDetails(){
      
   		return $this->belongsTo('App\Inventory','item','item');
   	}

   	/**
   	 * relationship to customer
   	 * @return [type] [description]
   	 */
   	public function customerDetails(){

   	}
}
