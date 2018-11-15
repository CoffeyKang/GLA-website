<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DealerHistory extends Model
{
    protected $table = 'dsales_history';

    public $timestamps = false;
    
    // belongs to this customer
    public function dealer(){
        return $this->belongsTo('App\Dealer',"account","account");
    }

    // has many so details
    public function dealerDetails(){
        return $this->hasMany('App\DealerDetails','order_num','order_num');
    }

    // dealer company name
    public function fullname(){
        if ($this->dealer()->first()) {
            if ($this->dealer()->first()->dealerInfo()->first()) {
                return $this->dealer()->first()->dealerInfo()->first()->company;
            }else{
                return $this->account;
            }
            
        }else{
            return $this->account;
        }
    }
    // status code
    public function statusCode(){
        $status = '';
        switch ($this->sales_status) {
            case'':
                $status = 'Payment Failed';
                break;
            case 1:
                $status = 'Payment Success';
                break;
            case 3:
                $status = 'Pending for Quote';
                break;
            case 5:
                $status = 'Pending for Reply';
                break;
            case 7:
                $status = 'Under Process';
                break;
            case 9:
                $status = 'Shipped';
                break;
            default:
                 $status = 'Shipped';
                break;
        }

        return $status;
    }

}
