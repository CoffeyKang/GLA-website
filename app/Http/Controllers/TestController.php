<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inventory;
use App\Inventory_img;
use App\FeatureProduct;
use Cart;


class TestController extends Controller
{
    public function test(){
    	return Cart::content();


    }
}
