<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DealerInfo extends Model
{
    protected $table ='dealer_info';
    
    public $timestamps = false;

    protected $fillable = ['address', 'city', 'country','name','province',
        'postalcode','country','pplan','email_address'

];

    public function dealerMain(){
        return $this->hasOne('App\Dealer','account','account');
    }
}
