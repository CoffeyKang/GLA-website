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
        $email = $request->email;
        
        $password = $request->password;

        if(Auth::attempt(['email'=>$email,'password'=>$password])){
            $user = Auth::user();
            $userInfo = UserInfo::where('m_id',$user->id)->first();
            return response()->json(['user'=>$user, 'userInfo'=>$userInfo],200);
        }else{
            return response()->json([], 401);
        };
         
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
            'password'=>'required',
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

        
        $userInfo = UserInfo::where('m_id',$user->id)->first();


        return response()->json(['user'=>$user,'userInfo'=>$userInfo],200);
        
    }


    public function userDetails(Request $request){

        
         //check the userInfo exsits or not

         $userID = $request->userID;

         $data = $request->data;

         $check = UserInfo::where('m_id',$userID)->first();
        
         if ($check) {
            
         }else{

             $userInfo = new UserInfo;

             $userInfo->m_id = $userID;
             
             $userInfo->m_surname = $data["surname"];
             $userInfo->m_forename = $data["forename"];
             $userInfo->m_gender = $data["gender"];
             $userInfo->m_birth = $data["brithday"];
             $userInfo->m_address = $data["address"];
             $userInfo->m_city = $data["city"];
             $userInfo->m_state = $data["state"];
             $userInfo->m_zipcode = $data["zipcode"];
             $userInfo->m_country = $data["country"];
             $userInfo->m_tel = $data["tel"];
             $userInfo->m_mobile = $data["mobile"];
             $userInfo->m_edu = $data["edu"];
             $userInfo->m_job = $data["job"];
             $userInfo->m_title = $data["tit"];
             $userInfo->m_car = $data["car"];

             $userInfo->save();




         }

         return response()->json(['userinfo'=>$userInfo],200);
    }

    /** double check the user info */
    public function doubleCheck(Request $request){
        $username = $request->username;
        $password = $request->userPass;


        return $password;

    }

    

    
}
