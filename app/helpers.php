<?php
use App\Inventory;
use App\SOMAST;
use App\AddressBook;
use App\Billing;
use App\User;
use App\Mail\registration;
use App\Mail\SalesOrder;
use App\Mail\FinishQuotation;
use App\Temp_SO;
use App\Dealer;
use App\Mail\DealerSO;
use App\Mail\Reminder;
use App\Mail\CustomerCancelledOrder;

    function InventoryExcelFile(){
        // Generate and return the spreadsheet price 
        Excel::create("InventoryExcelPrice", function($excel){
            // Set the spreadsheet title, creator, and description
            $excel->setTitle('Inventory Report');
            $excel->setCreator('Visual Elements Image Studio Inc')->setCompany('Golden Leaf Automotive Inc.');
            $excel->setDescription('Inventory file');
            //sheet
            $excel->sheet("date('Y-m-d')",function($sheet){
                $details = Inventory::select(['item','descrip',"price",'make','year_from','year_end','length','height','width','lbs'])->get();
                $sheet->fromModel($details,'0', 'A1', true)->setfitToWidth(true);
                $sheet->cell('C1', function($cell) {$cell->setValue('Price');   });
                $sheet->cells('A1:J1', function($cells) {
                    $cells->setFont(array(
                        'size'       => '12',
                        'bold'       =>  true,
                        'text-transform'=> 'uppercase'
                    ));
                });
            })->store('XLS', './Excel/1/');
        });

        Excel::create("InventoryExcelPrice", function($excel){
            // Set the spreadsheet title, creator, and description
            $excel->setTitle('Inventory Report');
            $excel->setCreator('Visual Elements Image Studio Inc')->setCompany('Golden Leaf Automotive Inc.');
            $excel->setDescription('Inventory file');
            //sheet
            $excel->sheet("date('Y-m-d')",function($sheet){
                $details = Inventory::select(['item','descrip',"price2",'make','year_from','year_end','length','height','width','lbs'])->get();
                $sheet->fromModel($details,'0', 'A1', true)->setfitToWidth(true);
                $sheet->cell('C1', function($cell) {$cell->setValue('Price');   });
                
                $sheet->cells('A1:J1', function($cells) {
                    $cells->setFont(array(
                        'size'       => '12',
                        'bold'       =>  true,
                        'text-transform'=> 'uppercase'
                    ));
                });
            })->store('XLS', './Excel/2/');
        });

        Excel::create("InventoryExcelPrice", function($excel){
            // Set the spreadsheet title, creator, and description
            $excel->setTitle('Inventory Report');
            $excel->setCreator('Visual Elements Image Studio Inc')->setCompany('Golden Leaf Automotive Inc.');
            $excel->setDescription('Inventory file');
            //sheet
            $excel->sheet("date('Y-m-d')",function($sheet){
                $details = Inventory::select(['item','descrip',"price3",'make','year_from','year_end','length','height','width','lbs'])->get();
                $sheet->fromModel($details,'0', 'A1', true)->setfitToWidth(true);
                $sheet->cell('C1', function($cell) {$cell->setValue('Price');   });
                
                $sheet->cells('A1:J1', function($cells) {
                    $cells->setFont(array(
                        'size'       => '12',
                        'bold'       =>  true,
                        'text-transform'=> 'uppercase'
                    ));
                });
            })->store('XLS', './Excel/3/');
        });

        Excel::create("InventoryExcelPrice", function($excel){
            // Set the spreadsheet title, creator, and description
            $excel->setTitle('Inventory Report');
            $excel->setCreator('Visual Elements Image Studio Inc')->setCompany('Golden Leaf Automotive Inc.');
            $excel->setDescription('Inventory file');
            //sheet
            $excel->sheet("date('Y-m-d')",function($sheet){
                $details = Inventory::select(['item','descrip',"price4",'make','year_from','year_end','length','height','width','lbs'])->get();
                $sheet->fromModel($details,'0', 'A1', true)->setfitToWidth(true);
                $sheet->cell('C1', function($cell) {$cell->setValue('Price');   });
                $sheet->cells('A1:L1', function($cells) {
                    $cells->setFont(array(
                        'size'       => '12',
                        'bold'       =>  true,
                        'text-transform'=> 'uppercase'
                    ));
                });
            })->store('XLS', './Excel/4/');
        });  
    }

    function soSendemail(SOMAST $somast){
        
        $user = $somast->customer;

        $billing = $user->BillingAddress;

        $add_id = $somast->address;

        if (!$add_id==0) {
            $address = AddressBook::find($add_id);
        }else{
            $address =AddressBook::find(1);
        }

        Mail::to("$user->email")->send(new SalesOrder($user,$somast,$billing,$address));
        
    }

    function finishQuotation(SOMAST $somast){
        
        $user = $somast->customer;

        $billing = $user->BillingAddress;

        $add_id = $somast->address;

        if (!$add_id==0) {
            $address = AddressBook::find($add_id);
        }else{
            $address =AddressBook::find(1);
        }

        Mail::to("$user->email")->send(new FinishQuotation($user,$somast,$billing,$address));
        
    }

    function SO_PDF($sono){
        
        $history = SOMAST::where('order_num',$sono)->first();
        $customer = $history->customer;
        $billing = $customer->BillingAddress;
        $userInfo = $customer->userDetails;
        $oneOrder = $history->sotran;
        if ($history) {
            
            $oneOrder = $history->sotran()->get();

            foreach ($oneOrder as $item) {
                $iteminfo = $item->itemInfo()->first()->allMakes();
                $item->make = $iteminfo->all_makes;
                $item->descrip = $item->itemInfo->descrip;
            }

            $address = $history->address;
            if ($address==0) {
                $pdf = PDF::loadView('pdf.salesorder', 
                ['somast'=>$history, 'oneOrder'=>$oneOrder, 
                'status'=>'valid','address'=>0,'billing'=>$billing,
                'userInfo'=>$userInfo,'oneOrder'=>$oneOrder]);
                
            }else{
                $addressBook = AddressBook::find($address);
                $pdf = PDF::loadView('pdf.salesorder', 
                ['somast'=>$history, 'oneOrder'=>$oneOrder, 'status'=>'valid','address'=>$addressBook,'billing'=>$billing,
                'userInfo'=>$userInfo,'oneOrder'=>$oneOrder]);
                
            }
            
            return $pdf->setPaper('a4')->save("PDF/salesOrder/$sono.pdf")->stream('download.pdf');
        }else{
           
        }
       
    }


    function createShippingXML($userID,$addressID){
        $customer = User::find($userID);
        $customerDetails = $customer->userDetails;
        if ($addressID!=0) {
            $addr = AddressBook::find($addressID);
            
            if ($addr) {
                $shippingArray =  array(
                    'name' => $addr->forename.' '.$addr->forename,
                    'phone_number' =>$addr->tel,
                    'address_line1' => $addr->address,
                    'city' => $addr->city,
                    'province' => $addr->state,
                    'postal_code' =>$addr->zipcode,
                    'country' => $addr->country,
            );
            }else{
                $addr = $customer->userDetails;
                $shippingArray =  array(
                    'name' => $addr->m_forename.' '.$addr->m_forename,
                    'phone_number' =>$addr->m_tel,
                    'address_line1' => $addr->m_address,
                    'city' => $addr->m_city,
                    'province' => $addr->m_state,
                    'postal_code' =>$addr->m_zipcode,
                    'country' => $addr->m_country,
                ); 
            }
            
        }else{
            $addr = $customer->userDetails;
            $shippingArray =  array(
                    'name' => $addr->m_forename.' '.$addr->m_forename,
                    'phone_number' =>$addr->m_tel,
                    'address_line1' => $addr->m_address,
                    'city' => $addr->m_city,
                    'province' => $addr->m_state,
                    'postal_code' =>$addr->m_zipcode,
                    'country' => $addr->m_country,
            );
        }

        $shortlist = Temp_SO::where('cust_id',$userID)->get();

        $xml = new \DomDocument("1.0","UTF-8");

        $envelope = $xml->createElement("soapenv:Envelope");
        $envelope->setAttribute('xmlns:soapenv','http://schemas.xmlsoap.org/soap/envelope/');
        $envelope->setAttribute('xmlns:ws','http://ws.rating.uss.transforce.ca');
        $envelope->setAttribute('xmlns:xsd','http://ws.rating.uss.transforce.ca/xsd');
        $envelope->setAttribute('xmlns:xsd1','http://dto.uss.transforce.ca/xsd');
        

        $envelopeHeader = $xml->createElement('soapenv:Header');

        /** text node */

        $pass = $xml->createTextNode("vs6Dp5Iw");
        $userID = $xml->createTextNode("LSHIPM34538@GLACANADA.COM");
        $delivery_address = $xml->createTextNode("170 Zenway Blvd. Unit 2");
        $delivery_city_text = $xml->createTextNode("Woodbridge");
        $delivery_country_text = $xml->createTextNode("CA");
        $delivery_name_text = $xml->createTextNode("Golden Leaf Automotive.");
        $delivery_postal_code_text = $xml->createTextNode("L4H2Y7");
        $delivery_province_text = $xml->createTextNode("ON");
        $dimension_unit_text = $xml->createTextNode("I");



        /** xml node */
        $envelopeHeader = $envelope->appendChild($envelopeHeader);
        $body = $xml->createElement('soapenv:Body');
        $getRates = $xml->createElement('ws:getRates');
        $getRequest = $xml->createElement('ws:request');
        $password = $xml->createElement('xsd:password');
        $pass = $password->appendChild($pass);
        $password = $getRequest->appendChild($password);
        $user_id = $xml->createElement('xsd:user_id');
        $userID = $user_id->appendChild($userID);
        $user_id = $getRequest->appendChild($user_id);
        $shipment = $xml->createElement('xsd:shipment');
        $delivery_address_line_1 = $xml->createElement('xsd1:delivery_address_line_1');
        $delivery_address = $delivery_address_line_1->appendChild($delivery_address);
        $delivery_address_line_1 = $shipment->appendChild($delivery_address_line_1);
        $delivery_city = $xml->createElement('xsd1:delivery_city');
        $delivery_city_text = $delivery_city->appendChild($delivery_city_text);
        $delivery_city = $shipment->appendChild($delivery_city);
        $delivery_country = $xml->createElement('xsd1:delivery_country');
        $delivery_country_text = $delivery_country->appendChild($delivery_country_text);
        $delivery_country = $shipment->appendChild($delivery_country);
        $delivery_name = $xml->createElement('xsd1:delivery_name');
        $delivery_name_text = $delivery_name->appendChild($delivery_name_text);
        $delivery_name = $shipment->appendChild($delivery_name);
        $delivery_postal_code = $xml->createElement('xsd1:delivery_postal_code');
        $delivery_postal_code_text = $delivery_postal_code->appendChild($delivery_postal_code_text);
        $delivery_postal_code = $shipment->appendChild($delivery_postal_code);
        $delivery_province = $xml->createElement('xsd1:delivery_province');
        $delivery_province_text = $delivery_province->appendChild($delivery_province_text);
        $delivery_province = $shipment->appendChild($delivery_province);
        $dimension_unit = $xml->createElement('xsd1:dimension_unit');
        $dimension_unit_text = $dimension_unit->appendChild($dimension_unit_text);
        $dimension_unit = $shipment->appendChild($dimension_unit);
        $shipment = $getRequest->appendChild($shipment);
        $getRequest = $getRates->appendChild($getRequest);
        $getRates = $body->appendChild($getRates);
        $body = $envelope->appendChild($body);
        $envelope = $xml->appendChild($envelope);


        // need loop short list 
        foreach ($shortlist as $item) {
            $iteminfo = $item->itemInfo;
            if ($iteminfo) {
                $h = $iteminfo->height?:1;
                $w = $iteminfo->width?:1;
                $l = $iteminfo->length?:1;
                $lb = $iteminfo->lbs?:1;

                for ($i=0; $i <$item->qty ; $i++) { 
                    # code...
                
                $h_label = $xml->createTextNode("HEIGHT");
                $w_label = $xml->createTextNode("WIDTH");;           
                $l_label = $xml->createTextNode("LENGTH");
                $packages = $xml->createElement('xsd1:packages');
                $packages = $shipment->appendChild($packages);
                $package_info_num_l = $xml->createElement('xsd1:package_info_num');
                $package_info_num_w = $xml->createElement('xsd1:package_info_num');
                $package_info_num_h = $xml->createElement('xsd1:package_info_num');
                $reported_weight = $xml->createElement('xsd1:reported_weight');
                $package_info_num_l = $packages->appendChild($package_info_num_l);
                $package_info_num_w = $packages->appendChild($package_info_num_w);
                $package_info_num_h = $packages->appendChild($package_info_num_h);
                $reported_weight = $packages->appendChild($reported_weight);
                $xsd1_name_height = $xml->createElement('xsd1:name');
                $xsd1_value_height = $xml->createElement('xsd1:value');
                $xsd1_name_width = $xml->createElement('xsd1:name');
                $xsd1_value_width = $xml->createElement('xsd1:value');
                $xsd1_name_length = $xml->createElement('xsd1:name');
                $xsd1_value_length = $xml->createElement('xsd1:value');
                $package_info_num_h->appendChild($xsd1_name_height);
                $package_info_num_w->appendChild($xsd1_name_width);
                $package_info_num_l->appendChild($xsd1_name_length);
                $package_info_num_h->appendChild($xsd1_value_height);
                $package_info_num_w->appendChild($xsd1_value_width);
                $package_info_num_l->appendChild($xsd1_value_length);
                /** set l w g lb  working on packages */
                $height = $xml->createTextNode($h);
                $width = $xml->createTextNode($w);
                $length = $xml->createTextNode($l);
                $weigth = $xml->createTextNode($lb);
                $xsd1_name_height->appendChild($h_label);
                $xsd1_name_width->appendChild($w_label);
                $xsd1_name_length->appendChild($l_label);
                $xsd1_value_height->appendChild($height);
                $xsd1_value_width->appendChild($width);
                $xsd1_value_length->appendChild($length);
                $reported_weight->appendChild($weigth);

                }

            }else{

            }

        }


        $pickup_address_line1_label = $xml->createTextNode($shippingArray['address_line1']);
        $pickup_city_label = $xml->createTextNode($shippingArray['city']);
        $pickup_name_label = $xml->createTextNode($shippingArray['name']);
        $pickup_postal_code_label = $xml->createTextNode(str_replace(' ','',$shippingArray['postal_code']));
        $pickup_province_label = $xml->createTextNode($shippingArray['province']);
        $reported_weight_unit_label = $xml->createTextNode("L");// l pound, K kilogram
        $service_type_label = $xml->createTextNode("DD"); // api pdf document page80 DD loomis ground

        $pickup_address_line_1 = $xml->createElement('xsd1:pickup_address_line_1');
        $pickup_city = $xml->createElement('xsd1:pickup_city');
        $pickup_name = $xml->createElement('xsd1:pickup_name');
        $pickup_postal_code = $xml->createElement('xsd1:pickup_postal_code');
        $pickup_province = $xml->createElement('xsd1:pickup_province');
        $reported_weight_unit = $xml->createElement('xsd1:reported_weight_unit');
        $service_type = $xml->createElement('xsd1:service_type');

        $pickup_address_line_1->appendChild($pickup_address_line1_label);
        $pickup_city->appendChild($pickup_city_label);
        $pickup_name->appendChild($pickup_name_label);
        $pickup_postal_code->appendChild($pickup_postal_code_label);
        $pickup_province->appendChild($pickup_province_label);
        $reported_weight_unit->appendChild($reported_weight_unit_label);
        $service_type->appendChild($service_type_label);


        $shipment->appendChild($pickup_address_line_1);
        $shipment->appendChild($pickup_city);
        $shipment->appendChild($pickup_name);
        $shipment->appendChild($pickup_postal_code);
        $shipment->appendChild($pickup_province);
        $shipment->appendChild($reported_weight_unit);
        $shipment->appendChild($service_type);

        /** shipping options */
        // $shipment_info_str1 = $xml->createElement('xsd1:shipment_info_str');
        // $shipment_info_str2 = $xml->createElement('xsd1:shipment_info_str');



        /** shiping date and account */
        $shipper_num = $xml->createElement("xsd1:shipper_num");
        $shipping_date = $xml->createElement("xsd1:shipper_date");
        $shipper_num_label = $xml->createTextNode("M34538");
        $shipping_date_label = $xml->createTextNode(date('Y-m-d'));
        $shipper_num->appendChild($shipper_num_label);
        $shipping_date->appendChild($shipping_date_label);
        $shipment->appendChild($shipper_num);
        $shipment->appendChild($shipping_date);
        
        $xml->FormatOutput = true;

        $string_value = $xml->saveXML();
        
        $xml->save('shipping/loomis_'.$customer->id.'.xml');
    }


    function dealerSOSendemail($dealerHistory){
        
        $dealer = $dealerHistory->account;

        $dealerEmail = Dealer::where('account',$dealer)->first();
        if ($dealerEmail===null) {
            $emailAddress = "coffeykang@gmail.com";
        }else{
            $emailAddress = $dealerEmail->email?:'coffeykang@gmail.com';
        }
        Mail::to("coffeykang@gmail.com")->cc("$emailAddress")->send(new DealerSO($dealer,$dealerHistory));
        
    }

    function reminder(SOMAST $somast){
        $user = $somast->customer;

        $billing = $user->BillingAddress;

        $add_id = $somast->address;

        if (!$add_id==0) {
            $address = AddressBook::find($add_id);
        }else{
            $address =AddressBook::find(1);
        }

        Mail::to("coffeykang@gmail.com")->send(new Reminder($user,$somast,$billing,$address));
    }


    /** customer cancelled order */
    function customerCancelledOrder(SOMAST $somast){
        
        $user = $somast->customer;

        $billing = $user->BillingAddress;

        $add_id = $somast->address;

        if (!$add_id==0) {
            $address = AddressBook::find($add_id);
        }else{
            $address =AddressBook::find(1);
        }

        Mail::to("service@goldenleafautomotive.com")->send(new CustomerCancelledOrder($user,$somast,$billing,$address));
        
    }


    
 
?>
