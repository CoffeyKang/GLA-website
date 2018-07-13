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

    // has many so details
    public function sotran(){
        return $this->hasMany('App\SOTRAN','order_num','order_num');
    }
    
}
