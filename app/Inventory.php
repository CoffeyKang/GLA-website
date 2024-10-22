<?php

namespace App;

use App\Item_make;
use App\Scopes\STKCODE;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Inventory extends Model
{
    
    

    /**  add filter when inventory is called, the stkcode == N will not display */
    protected static function boot(){
        
        parent::boot();

        static::addGlobalScope(new STKCODE);

        

        
    }

    protected $connection = 'mysql2';

    protected $primaryKey = 'item';

    protected $table='inventory';
    public $incrementing = false;

    public $timestamps = false;

    protected $onsale = false;
    
    /**
     * realationship with inventory 
     * one to one ralationship
     * @return [type] [description]
     */
    public function itemImg(){
        
    	return $this->belongsTo('App\Inventory_img','item','item');
    }

    public function featureItem(){
        return $this->belongsTo('App\FeatureProduct','item','item');
    }

    public function newItem(){
        return $this->belongsTo('App\NewProduct','item','item');
    }

    public function itemMake(){
        return $this->hasMany('App\Item_make','item','item');
    }

    public function sotran(){
        return $this->hasMany('App\SOTRAN','item','item');
    }

    /**
     * get item information with img_path and viewed
     */
    public function itemFullInfo(){
        // $img = $this->itemImg;

        // if ($img) {
        //     $this->img_path = $this->itemImg->img_path;
            
        // }else{
        //     $this->img_path = "/images/default_bg.jpg"; 
        // }

        // if (file_exists('.'.$this->img_path)) {
                
        //     }else{
        //         $this->img_path = "/images/default_bg.jpg";
        //     }

        if (file_exists('./images/products/thumb/'.$this->item.'.jpg')) {

                $this->img_path = "/images/products/thumb/".$this->item.".jpg";
            }else{
                $this->img_path = "/images/default_bg.jpg";
            }
        
        if (file_exists('./images/products/large/'.$this->item.'.jpg')) {

                $this->big = "/images/products/large/".$this->item.".jpg";
            }else{
                $this->big = "/images/default_bg.jpg";
            }
        return $this;
    }

    /**
     * relationship to wishlist
     * @return [type] [description]
     */
    public function wishlist(){
        return $this->hasMany('App\Wishlist','item','item');
    }

    /**
     * relationship to wishlist
     * @return [type] [description]
     */
    public function temp_so(){
        return $this->hasMany('App\Temp_SO','item','item');
    }


    public function checkImgExists(){
        if (file_exists('.'.$this->img_path)) {
            
        }else{
            $this->img_path = '/images/default_bg.jpg';
        }
    }

    public function allMakes(){
        $makes = Item_make::where('item',$this->item)->get();
        $string = '';
        foreach ($makes as $make) {
            $string .= $make->make.' ';
        }
        $this->all_makes = $string;

        return $this;
    }

    public function popular(){
        return $this->hasOne('App\Popular','item','item');
    }

    public function onsale(){
        if($this->aloc <=0){
    		$this->aloc =0;
    	};
        if ($this->onhand - $this->aloc > $this->orderpt) {
            return true;
        }else{
            return false;
        }
    }

    /** check if oversize */

    public function oversize(){
        if ($this->lbs>100) {
            return true;
        }elseif ($this->length>90 || $this->width>90||$this->height>90) {
            return true;
        }else{
            return false;
        }
    }
}
