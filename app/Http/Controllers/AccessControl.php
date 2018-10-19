<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\UserInfo;
use Validator;
use Illuminate\Support\Facades\Log;

use App\Inventory_img;
use App\Item_make;
use App\FeatureProduct;
use App\Wishlist;
use App\Temp_SO;
use App\AddressBook;
use App\SOMAST;
use App\SOTRAN;
use App\Catalog;
use App\Inventory;
use DB;


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
            'firstname'=>'required',
            'lastname'=>'required',
            'email'=>'email:unique:users',
            'password'=>'required|min:8',
        ]);
        
        $captcha = $request->captcha;
        

        $checkEmail = User::where('email',$request->email)->first();

        if ($checkEmail) {
            
            return response()->json(['status'=>"userExists"],200);
        
        }else{

        }
        $firstname = $request->firstname;

        $lastname = $request->lastname;
        
        $email = $request->email;

        $password = $request->password;

        $receiveEmail = $request->receiveEmail;
        
        $user = User::create([
            'firstname' => $firstname,
            'lastname' => $lastname,
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

             if ($data["gender"]=='Female') {
                 $userInfo->m_gender = 2;
             }elseif($data["gender"]=='Male'){
                 $userInfo->m_gender = 1;
             }else{
                 $userInfo->m_gender = 3;
             }


             //check tel format 

             $tel = $data["tel"];

             $tel = preg_replace('/[^0-9]/','',$tel);
            //  if ( strlen($tel)>=10 ){
            //     $tel = substr_replace($tel,'(',0,0);
            //     $tel = substr_replace($tel,') ',4,0);
            //     $tel = substr_replace($tel,'-',9,0);
            //  }else{
                
            //  }

             $mobile = $data["mobile"];

             $mobile = preg_replace('/[^0-9]/','',$mobile);
             if ( strlen($mobile)>=10 ){
                $mobile = substr_replace($mobile,'(',0,0);
                $mobile = substr_replace($mobile,') ',4,0);
                $mobile = substr_replace($mobile,'-',9,0);
             }else{
                
             }
             
             $userInfo->m_birth = $data["brithday"];
             $userInfo->m_address = $data["address"];
             $userInfo->m_city = strtoupper($data["city"]);
             $userInfo->m_state = strtoupper($data["state"]);
             $userInfo->m_zipcode = strtoupper($data["zipcode"]);
             $userInfo->m_country = $data["country"];
             $userInfo->m_tel = $tel;
             $userInfo->m_mobile = $mobile;
             $userInfo->m_make = $data["make"];
             $userInfo->m_year = $data["year"];
            //  $userInfo->m_title = $data["tit"];
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


    public function updateUserInfo(Request $request){

        
         //check the userInfo exsits or not

         $userID = $request->userID;

         $data = $request->data;

         $check = UserInfo::where('m_id',$userID)->first();
        
         if ($check) {
             $userInfo = $check;
             $userInfo->m_surname = $data["surname"];
             $userInfo->m_forename = $data["forename"];
              if ($data["gender"]=='Female') {
                 $userInfo->m_gender = 2;
             }else if($data["gender"]=='Male') {
                 $userInfo->m_gender = 1;
             }else{
                 $userInfo->m_gender = 3;
             }
             $userInfo->m_birth = $data["brithday"];
             $userInfo->m_address = $data["address"];
             $userInfo->m_city = $data["city"];
             $userInfo->m_state = $data["state"];
             $userInfo->m_zipcode = $data["zipcode"];
             $userInfo->m_country = $data["country"];
             $userInfo->m_tel = $data["tel"];
             $userInfo->m_mobile = $data["mobile"];
             $userInfo->m_year = $data["year"];
             $userInfo->m_make = $data["model"];
             $userInfo->m_car = $data["car"];

            
             $userInfo->save();

         }

         return response()->json(['userinfo'=>$userInfo],200);
    }

    public function changePassword(Request $request){

        $userID = $request->userID;
        
        $data = $request->data;

        $password = $data['oldPass'];

        
        if(Auth::attempt(['id'=>$userID,'password'=>$password])){
            $user = Auth::user();
            $user ->password = bcrypt($data['newPass']);
            $user->save();
            return response()->json(['user'=>$user,'status'=>'OK'],200);
        }else{
            return response()->json(['status'=>'fail'], 401);
        };
        
       

    }



    /** test page */
    public function kang(){

        // $someModel = new Inventory;
        
        // /** remote database */
        // $someModel->setConnection('mysql2');
        

        $something = DB::connection('mysql2')->select("SELECT * FROM `inventory` WHERE `item` LIKE '100' ORDER BY `item` ASC");

        $something1 = Inventory::where('item',100)->first();
        
        
        var_dump($something );
        echo "<br>";
        var_dump($something1);

         Log::info(123);
        
    }

    

    
}
