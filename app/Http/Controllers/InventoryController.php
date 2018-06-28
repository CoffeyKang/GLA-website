<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inventory;
use Illuminate\Pagination\Paginator;
use App\Inventory_img;
use App\FeatureProduct;
use App\Wishlist;
use App\Temp_SO;
use App\User;
use App\UserInfo;
use App\AddressBook;
class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inventory::all()->take(2);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    /**
     * display products_list
     * @param  make $data [description]
     * @return [type]       [description]
     */
    public function product_list($make,$mycurrentPage){
        
        Paginator::currentPageResolver(function () use ($mycurrentPage) {
            return $mycurrentPage;
        });
        $product_list = Inventory::
        join('inventory_img','inventory.item','inventory_img.item')->
        where('make',$make)->paginate(20) ;

        foreach ($product_list as $item) {
            if (file_exists(public_path().$item->img_path)) {
                
            }else{
                $item->img_path = "/images/default_sm.jpg";
            }
            
        }
        
        return $product_list;
    }

    /**
     * get a single item with img path
     * @param  [type] $item [description]
     * @return [type]       [description]
     */
    public function singleItem($item){
        $singleItem = Inventory::where('item',$item)->first();

        $singleItem->itemFullInfo();

        $single = $singleItem->toArray();
        return $singleItem;
    }

    public function related($item){
        
        $make = Inventory::where('item',$item)->first()->make;

        $related = Inventory::where('item','!=',$item)->where('make',$make)->inRandomOrder()->take(4)->get();
        
        foreach ($related as $r) {
            $r->itemFullInfo();
        }

        foreach ($related as $item) {
            $item->checkImgExists();
        }

        return $related;
    }

    /**
     * get feature products
     * @param  [type] $item [description]
     * @return [type]       [description]
     */
    public function featureProducts(){
        $features = FeatureProduct::inRandomOrder()->take(4)->get();
        $resualt = [];
        foreach ($features as $f) {
            array_push($resualt, $f->itemDetails()->first());
        }

        foreach ($resualt as $item) {
            $item->img_path = $item->itemImg()->first()->img_path;
            $item->checkImgExists();
        }   

        

        

        return $resualt;
    }


    public function popularProducts(){
        $popuar = Inventory_img::orderBy('viewed','aesc')->take(4)->get();

        $resault = collect();
        foreach ($popuar as $p) {
            $item_details = $p->itemDtails()->get();
            $resault = $resault->merge($item_details);
        }
        foreach ($resault as $r) {
            $item = $r->itemImg()->first();

            if ($item&&file_exists(public_path().$item->img_path)) {
                $r->img_path = $item->img_path;
            }else{
                $r->img_path = "/images/default_bg.jpg";
            }

        }
        return $resault;
    }

    public function searchResualt(Request $request){
        $item = $request->item?$request->item:'item';
        $make = $request->make?$request->make:'make';
        $year = $request->year?$request->year:'year';
        $desc = $request->desc?$request->desc:'desc';
        $page = $request->page?$request->page:1;
        
        $data = [$item,$make,$year,$desc,$page];

        
                             
        // set paginator
        $mycurrentPage = $page;
        Paginator::currentPageResolver(function () use ($mycurrentPage) {
            return $mycurrentPage;
        });

        $items = Inventory::orderBy('item','asc');

        /** make */
        if ($item!='item') {
                
            $items = $items->where('item',$item);

        }else{

        }

        
        /** make */
        if ($make!='make') {
                
            $items = $items->where('make',$make);

        }else{
        }
        
        /** year */
        if ($year!='year' && is_numeric($year) ) {
                
            $items = $items->where('year_from','<=',$year)->where('year_end','>=',$year);
                    // ->join('inventory_img','inventory.item','inventory_img.item')->paginate(20); 
                
        }else{
                
        }
        
        /** desc */
        if ($desc!='desc') {
            $items = $items->where('descrip','LIKE',"%".$desc."%");
        }else{
                
        }

        $items=$items->paginate(20);

            
        return $items;
            
    }

    // getItems_carts
    public function getItems_carts(Request $request){
        
        $item_numbers = array_reverse($request->data);
    
        $carts = Inventory::whereIn('item',$item_numbers)->get();

        foreach ($carts as $cart) {
            
            $cart->itemFullInfo();
        
        }

        
        

        return response()->json(['carts'=>$carts]);
    }


    // removeFromWishlist
    public function removeFromWishlist(Request $request){
        
        $user = $request->user;
        
        $item = $request->item;

        
        
        $items = Wishlist::where('cust_id',$user)->where('item',$item)->first();

        if ($items) {
            $items->delete();
            return 1;
        }else{
            return 0;
        }
        
    }

    // add to wish list
    public function addToWishlist(Request $request){
        
        $user = $request->user;

        $item = $request->item;

        $checkExist = Wishlist::where('cust_id',$user)->where('item',$item)->first();

        if ($checkExist) {
            return response()->json(['status'=>'exist'],200);
        }else{

            $wishlist = new Wishlist;

            $wishlist->cust_id = $user;

            $wishlist->item = $item;

            $wishlist->save();

            return response()->json(['status'=>'saved'],200);
        }

    }

    // clearWishlist
    public function clearWishlist(Request $request){
        $user = $request->user;
        
        $wishlist = Wishlist::where('cust_id',$user)->get();

        foreach ($wishlist as $w) {
            $w->delete();
        }
        return response()->json(['status'=>'deleted'],200);
        
    }

    public function checkout(Request $request){
        
        $items = $request->storage;

        $userID = $request->userID;
        


        $inventory = Inventory::select('item')->get()->pluck('item')->toArray();
        
        $deleteTheOldItem = Temp_SO::where('cust_id',$userID)->delete();

        foreach ($items as $key => $value) {
            if (in_array($key,$inventory)) {
                $so = new Temp_SO;
                $so->cust_id = $userID;
                $so->item = $key;
                $so->qty = $value;
                $so->date = date('Y-m-d');
                $so->save();
            }else{

            }
        }

        return response()->json(['status'=>"Success"],200);

    }

    /** KEY PROCESS HERE
     * 1. get sales order
     * 2. caculate shipping fee
     * 3. determin wich price shoud be used for the current client
     */
    public function shortlist(Request $request){
        $userID = $request->userid;

        $oversize = false;
        
        $user = User::find($userID);

        $addressBook = $user->addressBook()->get();

        $userInfo = UserInfo::where('m_id',$userID)->first();

        $fullName = $userInfo->m_surname . ' ' . $userInfo->m_forename;

        $shortlist = Temp_SO::where('cust_id',$userID)
            ->get();

        $subtotal = 0;

                    
        switch ($user->state)
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
                $tax = 13;
        }


        

        foreach ($shortlist as $item) {
            $info = $item->itemInfo()->first();
            $info->itemFullInfo();
            // different level determin different price level
            $item->price=$info->price;
            $item->descrip=$info->descrip;
            $item->img_path=$info->img_path;
            $item->year_from=$info->year_from;
            $item->year_end=$info->year_end;
            $item->make=$info->make;
            $subtotal += $item->price * $item->qty;

            // length + (2 x width) + (2 x height), may not exceed 165 in. 

            if ($info->length + (2*$info->width) + (2*$info->height)>=165) {
                $oversize = true;
            }
        }

        $tax_total = $subtotal * $tax / 100;


        // calculate shipping

        if (!$oversize) {
            # code...
        

            $xml = new \DomDocument("1.0","UTF-8");
            $Eshipper = $xml->createElement("Eshipper");
            $Eshipper->setAttribute('xmlns',"http://www.eshipper.net/XMLSchema");
            $Eshipper->setAttribute('username',"veistrading");
            $Eshipper->setAttribute('password',"229280");
            $Eshipper->setAttribute('version',"3.0.0");
            $Eshipper = $xml->appendChild($Eshipper);


            $QuoteRequest = $xml->createElement("QuoteRequest");
            $QuoteRequest = $Eshipper->appendChild($QuoteRequest);

            $From = $xml->createElement("From");
            $From->setAttribute("id",$userID);
            $From->setAttribute("company","Veis Trading Inc.");
            $From->setAttribute("address1","200 Riviera Drive, Unit 2");
            $From->setAttribute("city","Toronto");
            $From->setAttribute("state","ON");
            $From->setAttribute("country","CA");
            $From->setAttribute("zip","L3R5M1");
            $From = $QuoteRequest->appendChild($From);

            $To = $xml->createElement("To");
            $To->setAttribute("company",$fullName);
            $To->setAttribute("address1",$userInfo->m_address);
            $To->setAttribute("city",$userInfo->m_city);
            $To->setAttribute("state",$userInfo->m_state);
            $To->setAttribute("country",$userInfo->m_country);
            $To->setAttribute("zip",$userInfo->m_zipcode);
            $To = $QuoteRequest->appendChild($To);

            $Packages = $xml->createElement("Packages");
            $Packages->setAttribute("type","Package");

            /** need foreach every items */

            foreach ($shortlist as $item) {
                $item_info = $item->itemInfo()->first();

                if ($item_info->length<=1) {
                    $item_info->length=1;
                }
                if ($item_info->width<=1) {
                    $item_info->width=1;
                }
                if ($item_info->height<=1) {
                    $item_info->height=1;
                }
                if ($item_info->weight<=1) {
                    $item_info->weight=1;
                }

                $Package = $xml->createElement("Package");
                    $Package->setAttribute("length",$item_info->length);
                    $Package->setAttribute("width",$item_info->width);
                    $Package->setAttribute("height",$item_info->height);
                    $Package->setAttribute("weight",$item_info->weight);
                $Package=$Packages->appendChild($Package);

                $Packages = $QuoteRequest->appendChild($Packages);

            }

            $xml->FormatOutput = true;

            $string_value = $xml->saveXML();
            
            $xml->save("shipping/eshipping_$userID.xml");

            // call api

            $myXml = file_get_contents("shipping/eshipping_$userID.xml");

            $client = new \GuzzleHttp\Client([
                
            ]);
            
            $response = $client->POST('http://web.eshipper.com/rpc2',[
            'body'=>$myXml,
            ]);
            
            $res = $response->getBody();
            
            $r = new \SimpleXMLElement($res);
            
            $quotes = $r->QuoteReply->Quote;
                
            if (count($quotes)<1) {
                     $shippingRate = 'TBD';
                    return response()->json(['userInfo'=>$userInfo,'carts'=>$shortlist,'subtotal'=>$subtotal,
                    'tax_total'=>$tax_total, "shippingRate"=>$shippingRate,
                    'quotes'=>"tbd",'groundDay'=>0,'expressDay'=>0,'addressBook'=>$addressBook],200);
                }else{
                    
                }

            $myQuotes = [];

            $quoteOpt = [];

            $groundDay= 1;
            
            $expressDay= 1;
            
            foreach ($quotes as $q) {
                
                $arr = (array)$q[0];
                
                $carrierName = $arr['@attributes']['carrierName'];

                $serviceName = $arr['@attributes']['serviceName'];

                $totalCost = $arr['@attributes']['totalCharge'];

                $transitDays = $arr['@attributes']['transitDays'];

                array_push($myQuotes,[$carrierName,$serviceName,$totalCost,$transitDays]);
            
                }

                
                foreach ($myQuotes as $quote) {
                    if ($quote[0]=="Purolator" &&$quote[1]=="Purolator Ground") {
                        $quoteOpt['ground'] = $quote[2];
                        $groundDay = $quote[3]; 
                    }elseif($quote[0]=="Purolator" &&$quote[1]=="Purolator Express"){
                        $quoteOpt['express'] = $quote[2]; 
                        $expressDay = $quote[3];
                    }
                }
                
                if (!isset($quoteOpt['ground'])) {
                    $quoteOpt['ground']=1000000000;
                    foreach ($myQuotes as $quote) {
                        if ($quoteOpt['ground']>=$quote[2]) {
                            $quoteOpt['ground'] = $quote[2];
                            $groundDay = $quote[3];
                            
                        }else{

                        }
                    }
                }

                if (!isset($quoteOpt['express'])) {
                    $quoteOpt['express']=0;
                    foreach ($myQuotes as $quote) {
                        if ($quoteOpt['express']<=$quote[2]) {
                            $quoteOpt['express'] = $quote[2];
                            $expressDay = $quote[3];
                        }else{

                        }
                    }
                }

                

                $shippingRate = 'quotable';
                return response()->json(['userInfo'=>$userInfo,'carts'=>$shortlist,'subtotal'=>$subtotal,
                'tax_total'=>$tax_total, "shippingRate"=>$shippingRate, 'quotes'=>$quoteOpt,
                'groundDay'=>$groundDay,'expressDay'=>$expressDay,'addressBook'=>$addressBook],200);
            }else{
                $shippingRate = 'TBD';
                return response()->json(['userInfo'=>$userInfo,'carts'=>$shortlist,'subtotal'=>$subtotal,
                'tax_total'=>$tax_total, "shippingRate"=>$shippingRate,
                'quotes'=>"tbd",'groundDay'=>0,'expressDay'=>0,'addressBook'=>$addressBook],200);
            }
        

        

        
    }


    public function test(){
        $myXml = file_get_contents("shipping/eshipping_18.xml");

            $client = new \GuzzleHttp\Client([
                
            ]);
            
            $response = $client->POST('http://web.eshipper.com/rpc2',[
            'body'=>$myXml,
            ]);
            
            $res = $response->getBody();
            
            $r = new \SimpleXMLElement($res);
            
            $quotes = $r->QuoteReply->Quote;
        

            $myQuotes = [];

            $quoteOpt = [];

            $groundDay= 1;
            
            $expressDay= 1;
            
            foreach ($quotes as $q) {
                
                $arr = (array)$q[0];
                
                $carrierName = $arr['@attributes']['carrierName'];

                $serviceName = $arr['@attributes']['serviceName'];

                $totalCost = $arr['@attributes']['totalCharge'];

                $transitDays = $arr['@attributes']['transitDays'];

                array_push($myQuotes,[$carrierName,$serviceName,$totalCost,$transitDays]);
            
                }
                

                
                foreach ($myQuotes as $quote) {
                    if ($quote[0]=="Purolator" && $quote[1]=="Purolator Ground") {
                        $quoteOpt['ground'] = $quote[2];
                        $groundDay = $quote[3]; 
                    }elseif($quote[0]=="Purolator" && $quote[1]=="Purolator Express"){
                        $quoteOpt['express'] = $quote[2]; 
                        $expressDay = $quote[3];
                    }
                }

                
                
                if (!isset($quoteOpt['ground'])) {
                    $quoteOpt['ground']=1000000000;
                    foreach ($myQuotes as $quote) {
                        if ($quoteOpt['ground']>=$quote[2]) {
                            $quoteOpt['ground'] = $quote[2];
                            $groundDay = $quote[3];
                            
                        }else{

                        }
                    }
                }
                if (!isset($quoteOpt['express'])) {
                    $quoteOpt['express']=0;
                    foreach ($myQuotes as $quote) {
                        if ($quoteOpt['express']<=$quote[2]) {
                            $quoteOpt['express'] = $quote[2];
                            $expressDay = $quote[3];
                        }else{

                        }
                    }
                }

                $shippingRate = 'quotable';
                return response()->json([
                "shippingRate"=>$shippingRate, 'quotes'=>$quoteOpt,'groundDay'=>$groundDay,'expressDay'=>$expressDay],200);
            



        
        
        
        
        
        

        

        

        
        


    }

    /***    addd new shipping address */
    public function newShippingAdd(Request $request){
        
        
        $userid = $request->userID;
        $data = $request->data;
        $data['zipcode'] = str_replace(' ','',$data['zipcode']);
        $user = User::find($userid);
        
        $newAdd = new AddressBook;
        $newAdd->cust_id=$userid;
       
        $newAdd->address=$data['address'];
        
        $newAdd->city=$data['city']; 
        $newAdd->state=$data['state'];
        $newAdd->zipcode=$data['zipcode'];
        $newAdd->country=$data['country'];
        $newAdd->tel=$data['tel'];
        $newAdd->forename=$data['forename'];
        $newAdd->surname=$data['surname'];
        $newAdd->save();
        
        $addressBook = $user->addressBook()->get();

        return response()->json(['addressBook'=>$addressBook],200);

        
    }

    public function deleteAddress(Request $request){
        $id = $request->id;

        

        $addr = AddressBook::find($id);
        
        if ($addr) {
            $user = $addr->user()->first();
            
            $addr->delete();
            $addressBook = $user->addressBook()->get();

            return response()->json(['addressBook'=>$addressBook],200);
        }else{
            $addressBook = $user->addressBook()->get();

            return response()->json(['addressBook'=>$addressBook],200);
        }
        
    }

    public function changeAddress(Request $request){
        $id = $request->id;

        $oneAdd = AddressBook::find($id);

        

        if ($oneAdd) {

            $userID = $oneAdd->cust_id;
            
            $user = User::find($userID);

            $addressBook = $user->addressBook()->get();
            
            
            $userInfo = $oneAdd;

            $fullName = $userInfo->surname . ' ' . $userInfo->forename;

            $shortlist = Temp_SO::where('cust_id',$userID)
                ->get();

            $subtotal = 0;

            $oversize = 1;

            switch ($user->state)
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
                    $tax = 13;
            }



            foreach ($shortlist as $item) {
                $info = $item->itemInfo()->first();
                $info->itemFullInfo();

                
                // different level determin different price level
                $item->price=$info->price;
                $item->descrip=$info->descrip;
                $item->img_path=$info->img_path;
                $item->year_from=$info->year_from;
                $item->year_end=$info->year_end;
                $item->make=$info->make;
                $subtotal += $item->price * $item->qty;

                

                if ($info->length + (2*$info->width) + (2*$info->height) >= 165) {
                    
                    $oversize = 2;
                }
            }

            $tax_total = $subtotal * $tax / 100;
            
            // calculate shipping
            if ($oversize==1) {

                
                $xml = new \DomDocument("1.0","UTF-8");
                $Eshipper = $xml->createElement("Eshipper");
                $Eshipper->setAttribute('xmlns',"http://www.eshipper.net/XMLSchema");
                $Eshipper->setAttribute('username',"veistrading");
                $Eshipper->setAttribute('password',"229280");
                $Eshipper->setAttribute('version',"3.0.0");
                $Eshipper = $xml->appendChild($Eshipper);


                $QuoteRequest = $xml->createElement("QuoteRequest");
                $QuoteRequest = $Eshipper->appendChild($QuoteRequest);

                $From = $xml->createElement("From");
                $From->setAttribute("id",$userID);
                $From->setAttribute("company","Veis Trading Inc.");
                $From->setAttribute("address1","200 Riviera Drive, Unit 2");
                $From->setAttribute("city","Toronto");
                $From->setAttribute("state","ON");
                $From->setAttribute("country","CA");
                $From->setAttribute("zip","L3R5M1");
                $From = $QuoteRequest->appendChild($From);

                $To = $xml->createElement("To");
                $To->setAttribute("company",$fullName);
                $To->setAttribute("address1",$userInfo->address);
                $To->setAttribute("city",$userInfo->city);
                $To->setAttribute("state",$userInfo->state);
                $To->setAttribute("country",$userInfo->country);
                $To->setAttribute("zip",$userInfo->zipcode);
                $To = $QuoteRequest->appendChild($To);

                $Packages = $xml->createElement("Packages");
                $Packages->setAttribute("type","Package");

                /** need foreach every items */

                foreach ($shortlist as $item) {
                    $item_info = $item->itemInfo()->first();

                    if ($item_info->length<=1) {
                        $item_info->length=1;
                    }
                    if ($item_info->width<=1) {
                        $item_info->width=1;
                    }
                    if ($item_info->height<=1) {
                        $item_info->height=1;
                    }
                    if ($item_info->weight<=1) {
                        $item_info->weight=1;
                    }

                    $Package = $xml->createElement("Package");
                        $Package->setAttribute("length",$item_info->length);
                        $Package->setAttribute("width",$item_info->width);
                        $Package->setAttribute("height",$item_info->height);
                        $Package->setAttribute("weight",$item_info->weight);
                    $Package=$Packages->appendChild($Package);

                    $Packages = $QuoteRequest->appendChild($Packages);

                }

                $xml->FormatOutput = true;

                $string_value = $xml->saveXML();
                
                $xml->save("shipping/eshipping_$userID.xml");

                
                // call api

                

                

                $myXml = file_get_contents("shipping/eshipping_$userID.xml");

                $client = new \GuzzleHttp\Client([
                    
                ]);
                
                $response = $client->POST('http://web.eshipper.com/rpc2',[
                'body'=>$myXml,
                ]);
                
                $res = $response->getBody();
                
                $r = new \SimpleXMLElement($res);
                
                $quotes = $r->QuoteReply->Quote;
                
                if (count($quotes)<1) {
                     $shippingRate = 'TBD';
                    return response()->json(['userInfo'=>$userInfo,'carts'=>$shortlist,'subtotal'=>$subtotal,
                    'tax_total'=>$tax_total, "shippingRate"=>$shippingRate,
                    'quotes'=>"tbd",'groundDay'=>0,'expressDay'=>0,'addressBook'=>$addressBook],200);
                }else{

                }
            
                $myQuotes = [];

                $quoteOpt = [];

                $groundDay= 1;
                
                $expressDay= 1;
                
                foreach ($quotes as $q) {
                    
                    $arr = (array)$q[0];
                    
                    $carrierName = $arr['@attributes']['carrierName'];

                    $serviceName = $arr['@attributes']['serviceName'];

                    $totalCost = $arr['@attributes']['totalCharge'];

                    $transitDays = $arr['@attributes']['transitDays'];

                    array_push($myQuotes,[$carrierName,$serviceName,$totalCost,$transitDays]);
                
                    }

                    

                    
                    foreach ($myQuotes as $quote) {
                        if ($quote[0]=="Purolator" &&$quote[1]=="Purolator Ground") {
                            $quoteOpt['ground'] = $quote[2];
                            $groundDay = $quote[3]; 
                        }elseif($quote[0]=="Purolator" &&$quote[1]=="Purolator Express"){
                            $quoteOpt['express'] = $quote[2]; 
                            $expressDay = $quote[3];
                        }
                    }
                    
                    if (!isset($quoteOpt['ground'])) {
                        $quoteOpt['ground']=1000000000;
                        foreach ($myQuotes as $quote) {
                            if ($quoteOpt['ground']>=$quote[2]) {
                                $quoteOpt['ground'] = $quote[2];
                                $groundDay = $quote[3];
                            }else{

                            }
                        }
                    }

                    if (!isset($quoteOpt['express'])) {
                        $quoteOpt['express']=0;
                        foreach ($myQuotes as $quote) {
                            if ($quoteOpt['express']<=$quote[2]) {
                                $quoteOpt['express'] = $quote[2];
                                $expressDay = $quote[3];
                            }else{

                            }
                        }
                    }

                    
                    $shippingRate = 'quotable';

                    return response()->json(['userInfo'=>$userInfo,'carts'=>$shortlist,'subtotal'=>$subtotal,
                    'tax_total'=>$tax_total, "shippingRate"=>$shippingRate, 'quotes'=>$quoteOpt,
                    'groundDay'=>$groundDay,'expressDay'=>$expressDay,'addressBook'=>$addressBook],200);
                
                }else{
                    $shippingRate = 'TBD';
                    return response()->json(['userInfo'=>$userInfo,'carts'=>$shortlist,'subtotal'=>$subtotal,
                    'tax_total'=>$tax_total, "shippingRate"=>$shippingRate,
                    'quotes'=>"tbd",'groundDay'=>0,'expressDay'=>0,'addressBook'=>$addressBook],200);
                }    
        }else{
            
        }
    }
    
}
