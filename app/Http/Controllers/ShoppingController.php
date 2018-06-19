<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Wishlist;
use App\Inventory;
use App\User;

class ShoppingController extends Controller
{
    public function wishlist(Request $request){
		$userId = $request->userid;
		
		
    	$wishlist = WIshlist::where('cust_id',$userId)->get();

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
