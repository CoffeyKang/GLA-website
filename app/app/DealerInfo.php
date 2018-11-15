<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DealerInfo extends Model
{   
    protected $connection = 'mysql2';

    protected $table ='customers';
    
    public $timestamps = false;

    protected $fillable = ['address', 'city', 'country','name','province',
        'postalcode','country','pplan','email_address'

];

    public function dealerMain(){

        return $this->hasOne('App\Dealer','account','custno');
    }

    public function addressBooks(){
        return $this->hasMany('App\DealerAddressBook','custno','custno');
    }
}
