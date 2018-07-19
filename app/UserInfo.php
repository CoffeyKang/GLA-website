<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    protected $table = 'member_info';
    public $timestamps = false;
    
    
    public function somast(){
        return $this->hasMany('App\SOMAST','m_id','m_id');
    }

    public function fullname(){
        return $this->m_forename . ' ' .$this->m_surname;
    }
    
}
