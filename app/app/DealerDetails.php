<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DealerDetails extends Model
{
    protected $table = 'dsales_detail';

    public $timestamps = false;

    // belongs to this customer
    public function dealer(){
        return $this->belongsTo('App\Dealer',"account","account");
    }

    // has many so details
    public function dealerHistory(){
        return $this->belongsTo('App\DealerHistory','order_num','order_num');
    }

    // item information
    public function itemInfo(){
        return $this->belongsTo('App\Inventory','item','item');
    }
}
