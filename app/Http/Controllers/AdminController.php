<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inventory;
use Illuminate\Pagination\Paginator;
use App\Inventory_img;
use App\Item_make;
use App\FeatureProduct;
use App\Wishlist;
use App\Temp_SO;
use App\User;
use App\UserInfo;
use App\AddressBook;
use App\SOMAST;
use App\SOTRAN;
use App\Popular;

class AdminController extends Controller
{
    public function index(){
        return view('admin.index');
    }

    public function home(){
        return view('admin.home');
    }

    public function top10(){
        $top10 = Popular::orderBy('sold','desc')->paginate(10);
        $viewed = Popular::orderBy('viewed','desc')->paginate(10);
        $i=1;$v=1;
        return view('admin.top10',compact('top10','i','viewed','v'));
    }

    public function orderHistory(){
        $orderHistory = SOMAST::orderBy('order_num','asc')->paginate(18);

        return view('admin.orderhistory',compact('orderHistory'));
    }

    public function viewed(Request $request){
        
        $id = $request->item;
        
        $item = Popular::where('item',$id)->first();
        
        $item->viewed++;
        
        $item->save();
        
        return response()->json(['message'=>'item viewed plus one'],200);
    }



}