<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Wishlist;
use App\Inventory;
use App\User;

class ShoppingController extends Controller
{
    public function wishlist(){
    	
    	$wishlist = WIshlist::all();

    	$result = collect();
    	foreach ($wishlist as $w) {
    		$item = $w->itemDetails()->get();
    		$result = $result->merge($item);
    	}

    	foreach ($result as $re) {
    		$re->itemFullInfo();
    	}
    	return response()->json(['items'=>$result]);
    }

}
