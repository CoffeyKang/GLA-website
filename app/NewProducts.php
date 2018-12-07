<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewProducts extends Model
{
    protected $table = 'new_items';
    public $timestamps =false;

    public function itemDetails(){
    	return $this->hasOne('App\Inventory','item','item');
    }

    public function checkImgExists(){
        if (file_exists('.'.$this->img_path)) {
            
        }else{
            $this->img_path = '/images/default_bg.jpg';
        }
    }
}
