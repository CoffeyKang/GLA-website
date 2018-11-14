<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\TaxRate;
class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     * different level determin different price level
     * @var array
     */
    protected $fillable = [
        'firstname','lastname', 'email', 'password','level','receiveEmail'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function userDetails(){
        return $this->hasOne('App\UserInfo','m_id');
    }

    public function BillingAddress(){
        return $this->hasOne('App\Billing','cust_id','id');
    }

    public function addressBook(){
        return $this->hasMany('App\AddressBook','cust_id');
    }

    public function somast(){
        return $this->hasMany('App\SOMAST','m_id');
    }

    public function sotran(){
        return $this->hasMany('App\SOTRAN','m_id');
    }

    public function getRate(){
        
        $billing = $this->BillingAddress;

        if ($billing) {
            $province = $billing->province;
        }else{
            $province = "OT";
        }

        $taxRate = TaxRate::where('province',$province)->first()->tax/100;

        return $taxRate;
    }

    /** 1 admin 2 dealer 3 customer */
    public function level(){
        if ($this->level==1) {
            return "Admin";
        }else{
            return "Customer";
        }
    }
    
}
