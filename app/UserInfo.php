<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    protected $table = 'member_info';
    public $timestamps = false;
    
    protected $primaryKey = 'm_id';

    public function somast(){
        return $this->hasMany('App\SOMAST','m_id','m_id');
    }

    public function fullname(){
        return $this->m_forename . ' ' .$this->m_surname;
    }

    public function main_user(){
        return $this->hasOne('App\User','id','m_id');
    }
    
}
