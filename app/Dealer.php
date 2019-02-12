<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\TaxRate;
class Dealer extends Model
{   
    // I set protected attribute $connection in Model File. Set $connection = sql1
    protected $table ='dealer_main';
    
    public $timestamps = false;

    public function dealerInfo(){
        return $this->hasOne('App\DealerInfo','custno','account');
    }

    public function orderHis(){
        return $this->hasMany('App\DealerHistory','account','account');
    }

    public function shortlist(){
        return $this->hasMany('App\Temp_SO_dealer','cust_id','id');
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

    public function getRate(){
        
        $billing = $this->dealerInfo;

        if ($billing) {
            $province = $billing->state;
        }else{
            $province = "OT";
        }

        $taxRate = TaxRate::where('province',$province)->first()->tax/100;

        return $taxRate;
    }


}
