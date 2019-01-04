<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Inventory;
use Illuminate\Pagination\Paginator;
use App\Inventory_img;
use App\Item_make;
use App\Wishlist_dealer;
use App\Dealer;
use App\DealerInfo;
use App\DealerHistory;
use App\DealerDetails;
use App\Temp_SO_dealer;
use App\DealerAddressBook;
use App\DealerShipAddress;
use Mail;
use App\Mail\DealerSO;

class DealerController extends Controller
{
    public function login(Request $request){

        $account = $request->account;
        
        $password = $request->password;

        $dealer = Dealer::where('account',$account)->where('pass',$password)->first();

        if ($dealer) {

            $dealerInfo = $dealer->dealerInfo;

            if (!$dealerInfo) {
                return response()->json(['dealer'=>"not a dealer"],401);
            }else{
                return response()->json(['dealer'=>$dealer,'dealerInfo'=>$dealerInfo],200);
            }

            
        }else{
            return response()->json(['dealer'=>"not a dealer"],401);
        }
    }

    /** dealer info */

    public function dealerInfo($id){
        
        $dealerInfo = DealerInfo::where('custno',$id)->first();

        if ($dealerInfo) {
            return response()->json(['dealerInfo'=>$dealerInfo],200);
        }
    }

    /** change password */

    public function changePass(Request $request){
        $account = $request->account;
        $pass = $request->data['oldPass'];

        
        $dealer = Dealer::where('account',$account)->where('pass',$pass)->first();

        if ($dealer) {
           
            $dealer->pass = $request->data['newPass'];

            $dealer->save();

            return response()->json(['dealer'=>$dealer],200);
        }else{
            return response()->json(['dealer'=>'not found dealer'],401);
        }
    }


    public function dealerConfirm(Request $request){

        
       
        $dealer = Dealer::where('id',$request->dealerId)->first();
        
        try {
            $dealerInfo = $dealer->dealerInfo;
        }
        catch (\Exception $e) {
            Log::useFiles(storage_path('/logs/GLAlog.log'));

            Log::error("Dealer Id: $request->dealerId not found");
        }
        if ($dealer&&$dealerInfo) {
            
            // somast
            $order_num = DealerHistory::orderBy('id','desc')->first()->order_num;

            $new_sono = str_replace('D','',$order_num);

            $sono = intval($new_sono)+1;

            $sono = "D".strVal($sono);
            
            $somast = new DealerHistory;

            $somast->order_num = $sono;

            $somast->account = $dealerInfo->custno;

            $somast->subtotal = 0;

            $somast->tax = 0;

            $somast->shipping = 0;

            $somast->date_order = date('Y-m-d h:i:s');

            $somast->sales_status = 7;
            
            $somast->courier = '';
            
            $somast->track_num = '';

            $somast->notes = '';

            $somast->address = '';

            $somast->notes = $request->note;
            
            $somast->save();

            //short list
            $shortlist = $dealer->shortlist;
            
            $subtotal = 0;

            foreach ($shortlist as $short) {
                
                $info = $short->itemInfo;

                $sotran = new DealerDetails;

                $sotran->order_num = $sono;
                
                $sotran->account = $dealerInfo->custno;

                $sotran->item = $short->item;

                $sotran->qty = $short->qty;

                switch ($dealerInfo->pricecode) {
                    case '4':
                        $sotran->price = $info->price4;
                        break;
                    case '3':
                        $sotran->price = $info->price3;
                        break;
                    case '2':
                        $sotran->price = $info->price2;
                        break;
                    case '1':
                        $sotran->price = $info->price;
                        break;
                    default:
                        $sotran->price = $info->pricel;
                    break;
                }

                $sotran->date_sold = date('Y-m-d h:i:s');

                $sotran->make = $info->make;

                $sotran->save();

                $subtotal += $sotran->price * $sotran->qty;

                $short->delete();

            }

            /** update somast */

            $somast->subtotal = round($subtotal,2);

            switch ($dealerInfo->terr)
            {
                case "AB":
                    $tax = 5;
                    break;  
                case "BC":
                    $tax = 12;
                    break;
                case "MB":
                    $tax = 13;
                    break;  
                case "NB":
                    $tax = 15;
                    break;
                case "NL":
                    $tax = 5;
                    break; 
                case "NT":
                    $tax = 5;
                    break; 
                case "NS":
                    $tax = 15;
                    break;
                case "NU":
                    $tax = 5;
                    break;
                case "ON":
                    $tax = 13;
                    break;  
                case "PE":
                    $tax = 15;
                    break;
                case "QC":
                    $tax = 14.975;
                    break;
                case "SK":
                    $tax = 11;
                    break;  
                case "YT":
                    $tax = 5;
                    break;
                
                default:
                    $tax = 0;
            }

            $somast->tax = round(($subtotal * $tax / 100),2);

            $somast->save();

            /** store new shipping related to sono */
            $newAdd = $request->address;
            if (array_key_exists('company',$newAdd)&&array_key_exists('address',$newAdd)) {
                $dealerShip = new DealerShipAddress;

                $dealerShip->company = $newAdd['company'];

                $dealerShip->address = $newAdd['address'];

                $dealerShip->city = $newAdd['city'];

                $dealerShip->postalcode = $newAdd['zipcode'];

                $dealerShip->country = $newAdd['country'];

                $dealerShip->province = $newAdd['state'];

                $dealerShip->tel = $newAdd['tel'];

                $dealerShip->order_num = $sono;

                $dealerShip->save();

                $somast->address = $dealerShip->id;

                $somast->save();

            }else{

            }
            dealerSOSendemail($somast);
            
            return response()->json(['status'=>"ok",'sono'=>$sono],200);
        }else{
            return response()->json(['status'=>"dealerNotFound"],401);
        }
    }


    public function oneOrder_dealer_finish(Request $request){
        
        $so = $request->so;

        $account = $request->account;

        $history = Dealerhistory::where('order_num',$so)->where('account',$account)->first();

        if ($history) {
            
            $oneOrder = $history->dealerDetails()->get();

            foreach ($oneOrder as $item) {
                $iteminfo = $item->itemInfo()->first()->allMakes();
                $item->make = $iteminfo->all_makes;
            }

            $shipTo = $history->address;

            if ($shipTo!='') {
                $address = DealerShipAddress::find($shipTo);
            }else{
                $address = '';
            }

            $dealerInfo = $history->dealer->dealerInfo;

            return response()->json(['somast'=>$history, 'oneOrder'=>$oneOrder, 'status'=>'valid','address'=>$address,'dealerInfo'=>$dealerInfo],200);
        
        }else{

            return response()->json(['status'=>'invalid']);
        }
    }
}
