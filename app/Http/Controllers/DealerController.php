<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Dealer;

use App\DealerInfo;

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
}
