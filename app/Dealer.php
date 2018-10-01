<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dealer extends Model
{
    protected $table ='dealer_main';
    
    public $timestamps = false;

    public function dealerInfo(){
        return $this->hasOne('App\DealerInfo','account','account');
    }

    public function orderHis(){
        return $this->hasMany('App\DealerHistory','account','account');
    }

    public function orderNum(){
        return count($this->orderHis()->get());
    }

    // dealer getProperty
    public function getProperty($property){
        
        if ($this->dealerInfo()->first()) {
        
            return $this->dealerInfo()->first()->$property;
        
        }else{
            if ($property=="name") {
                return $this->account;
            }else{
                return "";
            }
            
        }
    }

    // dealer company name
    public function fullname(){
        if ($this->dealerInfo()->first()) {
            return $this->dealerInfo()->first()->name;
        }else{
            return $this->account;
        }
    }


}
