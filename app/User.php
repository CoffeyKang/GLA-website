<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     * different level determin different price level
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','level',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function addressBook(){
        return $this->hasMany('App\AddressBook','cust_id');
    }

    public function somast(){
        return $this->hasMany('App\SOMAST','m_id');
    }

    public function sotran(){
        return $this->hasMany('App\SOTRAN','m_id');
    }
    
}
