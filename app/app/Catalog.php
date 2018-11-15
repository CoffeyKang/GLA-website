<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Catalog extends Model
{
    public function checkImg(){
        if (file_exists("images/catalog/$this->path")) {
            return "images/catalog/$this->path";
        }else{
            return "images/catalog/default.jpg";
        }
    }
}
