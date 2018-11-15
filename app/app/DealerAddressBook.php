<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DealerAddressBook extends Model
{
    protected $connection = 'mysql2';

    protected $table = 'aradrs';

    public $timestamps = false;

    public function dealerInfo(){
        return $this->belonsTo('App\DealerInfo','custno','custno');
    }
}
