<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeatureProduct extends Model
{
    protected $table = 'feature_items';
    public $timestamps =false;

    public function itemDetails(){
    	return $this->hasOne('App\Inventory','item','item');
    }

    public function checkImgExists(){
        if (file_exists(public_path().$this->img_path)) {
            
        }else{
            $this->img_path = '/images/default_bg.jpg';
        }
    }
}
