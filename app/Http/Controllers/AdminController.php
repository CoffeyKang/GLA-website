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
use App\Dealer;
use App\DealerInfo;
use App\DealerHistory;
use App\DealerDetails;
use App\Catalog;
use Auth;

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
        $orderHistory = SOMAST::orderBy('sales_status','asc')->orderBy('order_num','desc')->paginate(18);

        return view('admin.orderHistory',compact('orderHistory'));
    }

    public function viewed(Request $request){
        
        $id = $request->item;
        
        $item = Popular::where('item',$id)->first();
        
        $item->viewed++;
        
        $item->save();
        
        return response()->json(['message'=>'item viewed plus one'],200);
    }


    public function customerList(){

        $customerList = UserInfo::orderBy('m_id','asc')->paginate(18);

        return view('admin.customerList',compact('customerList'));
    }

    public function pendingQuotes(){

        $pendingQuotes = SOMAST::where('sales_status','!=',9)->get();

        return view('admin.pendingQuotes',compact('pendingQuotes'));
    }

    public function changePassword(){
        return view('admin.changePassword');
    }

    public function updatePassword(Request $request){

        $this->validate($request,[
            'email'=>'exists:users',
            'name'=>'required',
            'password'=>'required|max:15|alpha_num',
            'newPass'=>'required|min:6|confirmed|alpha_num',
            'newPass_confirmation'=>'required|min:6|alpha_num'
        ]);

        if (Auth::attempt(['email'=>$request->email,'password'=>$request->password])) {
            $user = Auth::user();
            $user->name = $request->name;
            $user->password = bcrypt($request->newPass);
            $user->save();
        }else{
            return redirect()->back()->with('status_fail','Password is not validate.');
        }
        return redirect()->back()->with('status','Password changed.');
    }

    public function updateInfo(){

        // $user = Auth::user();

        // $userInfo = UserInfo::find($user->id);

        return view('admin.changePassword');
    }

    public function updateUser(){
         return view('admin.updateInfo');
    }

    public function dealerList(){
        $dealers = Dealer::orderBy('account','asc')->paginate(18);
        return view('admin.dealerList',compact('dealers'));
    }  

    public function dealerHistory(){

        $dealerHistory = DealerHistory::orderBy('id','asc')->paginate(18);

        return view('admin.dealerHistory',compact('dealerHistory'));
    }

    public function dealerHistory_oneDealer($id){
        
        $dealer = Dealer::find($id);
        
        $dealerHistory = $dealer->orderHis()->orderBy('id','desc')->paginate(18);
        
        return view('admin.dealerHistory_oneDealer',compact('dealer','dealerHistory'));
    }

    public function newDealer(){
        return view('admin.newDealer');
    }

    public function storeDealer(Request $request){
        
        $this->validate($request,[
            'account'=>'required|unique:dealer_main|max:8',
            'name'=>'required|max:200',
            'password'=>'required|confirmed|min:6',
            'address'=>'required|max:200',
            'city'=>'required|max:200',
            'province'=>'required|max:200',
            'postalcode'=>'required|max:10',
            'country'=>'required|max:200',
            'pplan'=>'required|max:200',
            'email_address'=>'required|max:200',
        ]);

        $d = new Dealer;

        $d->account = $request->account;

        $d->name = $request->name;

        $d->pass = $request->password;

        

        $d->dealerInfo()->create([
            'name'=>$request->name,
            'address'=>$request->address,
            'city'=>$request->city,
            'province'=>$request->province,
            'postalcode'=>$request->postalcode,
            'country'=>$request->country,
            'pplan'=>$request->pplan,
            'email_address'=>$request->email_address,
        ]);

        $d->save();

        return redirect()->back()->with('status','Create new dealer successfully.');

    }

    public function editDealer($id){
        
        $dealer = Dealer::find($id);

        return view('admin.eidtDealer',compact('dealer'));
    }    

    public function updateDealer($id,Request $request){
        $this->validate($request,[
            'account'=>'required|exists:dealer_main|max:8',
            'name'=>'required|max:200',
            'address'=>'required|max:200',
            'city'=>'required|max:200',
            'province'=>'required|max:200',
            'postalcode'=>'required|max:10',
            'country'=>'required|max:200',
            'pplan'=>'required|max:200',
            'email_address'=>'required|max:200',
        ]);

        $dealer = Dealer::find($id);
        
        $dealer->name = $request->name;

        $dealer->save();

        if ($dealer->dealerInfo()->first()) {
            $dealer->dealerInfo()->update([
                'name'=>$request->name,
                'address'=>$request->address,
                'city'=>$request->city,
                'province'=>$request->province,
                'postalcode'=>$request->postalcode,
                'country'=>$request->country,
                'pplan'=>$request->pplan,
                'email_address'=>$request->email_address,
            ]);
        }else{
            $dealer->dealerInfo()->create([
                'name'=>$request->name,
                'address'=>$request->address,
                'city'=>$request->city,
                'province'=>$request->province,
                'postalcode'=>$request->postalcode,
                'country'=>$request->country,
                'pplan'=>$request->pplan,
                'email_address'=>$request->email_address,
            ]);
        }

        return redirect()->back()->with('status','Dealer information has been updated.');
    }

    public function uploadCatalog(){
        $catalogs = Catalog::all();
        return view('admin.uploadCatalog',compact('catalogs'));
    }

}