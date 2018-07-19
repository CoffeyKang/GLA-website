<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SOMAST extends Model
{
    // case 0:
	// 	$status = "Payment Failed";
	// case 1:
	// 	$status = "Payment Success";
	// case 3:
	// 	$status = "Pending for Quote";
	// case 5:
	// 	$status = "Pending for Reply";
	// case 7:
	// 	$status = "Under Process";
	// case 9:
	// 	$status = "Shipped";
    

    protected $table = 'somast';

    public $timestamps = false;

    // belongs to this customer
    public function customer(){
        return $this->belongsTo('App\User',"m_id","m_id");
    }

    public function customerInfo(){
        return $this->belongsTo('App\UserInfo',"m_id","m_id");
    }

    // has many so details
    public function sotran(){
        return $this->hasMany('App\SOTRAN','order_num','order_num');
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
