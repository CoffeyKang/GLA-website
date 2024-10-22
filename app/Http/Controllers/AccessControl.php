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
use App\Billing;
use DB;
use Excel;
use Mail;
use App\Mail\registration;
use App\Mail\SalesOrder;
use App\Mail\LeaveMessege;
use App\Mail\DealerMessege;
use App\Mail\InquiryOnline;
use App\Mail\DealerSO;
use App\Dealer;
use App\DealerHistory;
use App\NewProducts;



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

        // if(Auth::attempt(['email'=>$email,'password'=>$password])){
        //     $user = Auth::user();
        //     $userInfo = UserInfo::where('m_id',$user->id)->first();
        //     $userBilling = Billing::where('cust_id',$user->id)->first();
        //     return response()->json(['user'=>$user, 'userInfo'=>$userInfo,'billing'=>$userBilling],200);
        // }else{
        //     return response()->json([], 401);
        // };
        /** log in use md5 encrypt, and also need to change register and reset password */
        $user = User::where('email', $request->email)
                    ->where('password',md5($request->password))
                    ->first();

        if($user){
            $userInfo = UserInfo::where('m_id',$user->id)->first();
            $userBilling = Billing::where('cust_id',$user->id)->first();
            return response()->json(['user'=>$user, 'userInfo'=>$userInfo,'billing'=>$userBilling],200);
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

        $check = $request->checked?1:0;
        
        $password = $request->password;

        $receiveEmail = $request->receiveEmail;
        
        $user = User::create([
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email,
            'receiveEmail'=>$check,
            'password' => md5($password),
        ]);
        
        @Mail::to("$user->email")->send(new registration($user));
       

        
        $userInfo = UserInfo::where('m_id',$user->id)->first();

        
        // @Mail::to($user->email)->send(
        //     (new registration($user))
        // );

        return response()->json(['user'=>$user,'userInfo'=>$userInfo],200);
        
    }


    /** reset password */

    public function resetPassword(Request $request){

        $user = User::where('email',$request->email)->first();

        if ($user===null) {
            return response()->json(['status'=>"good"],200);
        }else{
            /** send email */
            $user->resetPass = str_random(40);
            $user->save();
            resetPass($user);
            return response()->json(['status'=>"good"],200);
        }
        
    }


    public function userDetails(Request $request){

        
        
         //check the userInfo exsits or not

         $userID = $request->userID;

         $data = $request->data;

         $check = UserInfo::where('m_id',$userID)->first();
        
         if ($check) {
            $userInfo = $check;
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


             $billing = new Billing;

             $billing->cust_id = $userID;
             $billing->lastname = $data["surname"];
             $billing->firstname = $data["forename"];
             if ($data["sameAsBilling"]) {
                $billing->address1 = $data["address"];
                $billing->city = strtoupper($data["city"]);
                $billing->province = strtoupper($data["state"]);
                $billing->postalcode = strtoupper($data["zipcode"]);
                $billing->country = $data["country"];
                $billing->phone = $tel;
             }else{
                $billing->address1 = $data["b_address1"];
                $billing->address2 = $data["b_address2"];
                $billing->city = strtoupper($data["b_city"]);
                $billing->province = strtoupper($data["b_state"]);
                $billing->postalcode = strtoupper($data["b_zipcode"]);
                $billing->country = $data["b_country"];
                $billing->phone = $data["b_tel"]?:'';
             }

             $billing->save();




         }

         return response()->json(['userinfo'=>$userInfo,'billing'=>$billing],200);
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

             /** also change user table customer firstname and lastname */
            $user = $userInfo->main_user;

            $user->firstname = $data["forename"];

            $user->lastname = $data["surname"];

            if ($data["checked"]) {
                $user->receiveEmail = 1;
            }else{
                $user->receiveEmail = 0;
            }

            $user->save();

         }

        

        $billing = Billing::where('cust_id',$userID)->first();

        $billing->firstname = $data["b_firstname"];
        $billing->lastname = $data["b_lastname"];
        $billing->address1 = $data["b_address1"];
        if (array_key_exists('b_address2',$data)){
            $billing->address2 = $data["b_address2"];
            # code...
        }else{

        }
        $billing->city = $data["b_city"];
        $billing->province = $data["b_state"];
        $billing->postalcode = $data["b_zipcode"];
        $billing->country = $data["b_country"];
        $billing->phone = $data["b_tel"];
        $billing->save();

        return response()->json(['userinfo'=>$userInfo,'billing'=>$billing],200);
    }

    public function changePassword(Request $request){

        $userID = $request->userID;
        
        $data = $request->data;

        $password = $data['oldPass'];

        

        $user = User::where('id', $userID)
                    ->where('password',md5($password))
                    ->first();


        if($user){
            // $user = Auth::user();
            $user ->password = md5($data['newPass']);
            $user->save();
            return response()->json(['user'=>$user,'status'=>'OK'],200);
        }else{
            return response()->json(['status'=>'fail'], 401);
        };
        
       

    }

    /** sending email to inquiry */

    // public function inquiry(Request $request){
    //     $email['user'] = $request->user;
    //     $email['subject'] = $request->subject;
    //     $email['messege'] = $request->messege;

    //     if ($request->type=='customer') {

    //         Mail::to('info@goldenleafautomotive.com')->send(new LeaveMessege($email));
    //         # code...
    //     }else{
    //         Mail::to('info@goldenleafautomotive.com')->send(new DealerMessege($email));
    //     }





    //     return response()->json(['status'=>true],200);
    // }
    public function inquiry(Request $request){
        $email['user'] = $request->user;
        $email['subject'] = $request->subject;
        $email['messege'] = $request->messege;

        if ($request->type=='customer') {

            $custno = $request->custno;
            $dealer = User::where('id',$custno)->first();

            if ($dealer===null) {
                $emailAddress = 'info@goldenleafautomotive.com';
            }else{
                $emailAddress = $customer->email?:'info@goldenleafautomotive.com';
            }
            config(['mail.from' => ['address'=>$emailAddress,'name'=>$emailAddress]]);
            Mail::to('info@goldenleafautomotive.com')->cc("$emailAddress")->send(new LeaveMessege($email));
            config(['mail.from' => ['address'=>'GLA@goldenleafautomotive.com','name'=>'GLA Website']]);
            # code...
        }else{
            $custno = $request->custno;
            $dealer = Dealer::where('account',$custno)->first();

            if ($dealer===null) {
                $emailAddress = 'info@goldenleafautomotive.com';
            }else{
                $emailAddress = $dealer->email?:'info@goldenleafautomotive.com';
            }
            config(['mail.from' => ['address'=>$emailAddress,'name'=>$emailAddress]]);
            Mail::to('info@goldenleafautomotive.com')
            ->cc("$emailAddress")->send(new DealerMessege($email));
            config(['mail.from' => ['address'=>'GLA@goldenleafautomotive.com','name'=>'GLA Website']]);
        }





        return response()->json(['status'=>true],200);
    }

    public function inquiryOnline(Request $request){
        $email['name'] = $request->name;
        $email['email'] = $request->email;
        $email['subject'] = $request->subject;
        $email['messege'] = $request->messege;
        config(['mail.from' => ['address'=>$request->email,'name'=>'Customer']]);

        Mail::to('info@goldenleafautomotive.com')->send(new InquiryOnline($email));

        config(['mail.from' => ['address'=>'GLA@goldenleafautomotive.com','name'=>'GLA Website']]);
    





        return response()->json(['status'=>true],200);
    }
    /** test page */
    public function kang(){
        /** payment api config */
        // $somast = SOMAST::where('order_num',1000549)->first();

        //  soSendemail($somast);

    	// $n = NewProducts::all();
        // $somast = SOMAST::where('order_num',1000549)->first();
        // customerCancelledOrder($somast);

    	// foreach ($n as $a) {
    	// 	$a->item = strtoupper($a->item);

    	// 	$a->save();
    	// }
        

        
    	// $users = User::where('email','')->get();
    	// foreach ($users as $user) {
    	// 	$user->userDetails->first()->delete();
    	// 	$user->delete();
    	// }
    	
    	
       // $arr = scandir('./images/products/large');
       //  $len = count($arr);
       //  $name = [];
       //  foreach ($arr as $i){ 
       //      array_push($name,basename($i,'.jpg')) ;
       //  }
        
       //  $inventory = Inventory::whereNotIn('item',$name)->get();

       //  $notIn = [];

       //  foreach ($inventory as $i) {
       //      array_push($notIn,$i->item);
       //  }

       //  dd($notIn);
        
            
        // $user = User::find(3)
    //     $arr = scandir('./images/products/large');
    //     $len = count($arr);
    //     $name = [];
    //     foreach ($arr as $i){ 
    //         array_push($name,basename($i,'.jpg')) ;
    //     }
        
    //     $inventory = Inventory::whereNotIn('item',$name)->get();

    //     $notIn = [];

    //     foreach ($inventory as $i) {
    //         array_push($notIn,$i->item);
    //     }

        
    //    $i=0;

    //     $handle = opendir('./Imagebank/');

    //     while ($file = readdir($handle)) {
    //         if ($file!='.'&&$file!='..') {
    //             $nameOnly = substr($file, 0, -4);
    //             if (in_array($nameOnly, $not)) {
    //                 echo $nameOnly,'<br>';
    //                 $i++;
    //             }else{
    //                 unlink("./Imagebank/$file");
    //             }
    //         }else{}
            
            
    //     }

    //     echo $i;
    }

    

    
}
