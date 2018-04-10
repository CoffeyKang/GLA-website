<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;

class AccessControl extends Controller
{
     /**
     * Handle an authentication attempt.
     *
     * @return Response
     */
    public function userinfo(Request $request)
    {	
    	$user = User::where('email',1)->where('password',2)->first();
        if ($user) {
            
            $success = $user->createToken('myApp')->accessToken;    
            
            return response()->json(['success'=>$success,'user'=>$user->id]);
        }else{
            
            return response()->json(['fail'=>'fail']);
        }
    }
}
