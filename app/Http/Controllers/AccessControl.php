<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\UserInfo;
use Validator;


class AccessControl extends Controller
{
     /**
     * Handle an authentication attempt.
     *
     * @return Response
     */
    public function userinfo(Request $request)
    {	
        $email = $request->loginInfo['email'];
        
        $user = User::where('email',$email)->first();
        
        if ($user) {
            
            $userInfo = UserInfo::where('m_id',$user->id)->first();

            
            
            $token = $user->createToken('token')->accessToken;
            

            return response()->json(['user'=>$user, 'token'=>$token, 'userInfo'=>$userInfo],200);
        }else{
            return response()->json([],401);
        }    
    }

    /**
     * Handle an create new customer attempt.
     *
     * @return Response
     */
    public function newCustomer(Request $request){

        $this->validate($request,[
            'username'=>'required',
            'email'=>'email:unique:users',
        ]);



        $username = $request->username;

        $email = $request->email;

        $password = $request->password;

        $receiveEmail = $request->receiveEmail;

        $user = User::create([
            'name' => $username,
            'email' => $email,
            'password' => bcrypt($password),
        ]);

        $token = $user->createToken('token')->accessToken;

        return response()->json(['user'=>$user,'token'=>$token],200);
        // return response()->json(['data'=>$data],200);
    }

    

    
}
