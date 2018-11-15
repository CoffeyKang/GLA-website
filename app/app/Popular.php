<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Popular extends Model
{
    protected $table = 'popular';

    protected $primaryKey = 'item';

    public $incrementing = false;
    
    public $timestamps = false;

    public function itemInfo(){
        return $this->hasOne('App\Inventory','item','item');
    }
}
