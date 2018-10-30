<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    function TestPayment(){
        $merchant_id = '117686147'; //INSERT MERCHANT ID (must be a 9 digit string)
        $api_key = 'B452F4E8020a4746aDa2FC5c468Ab17a'; //INSERT API ACCESS PASSCODE
        $api_version = 'v1'; //default
        $platform = 'api'; //default
        $token = 'a10-096444f0-7904-402c-a3ae-a5a6cbc690e1';

        //Create Beanstream Gateway
        $beanstream = new \Beanstream\Gateway($merchant_id, $api_key, $platform, $api_version);

        //Example Card Payment Data
        $payment_data = array(
                'order_number' => '0000124',
                'amount' => 1.00,
                'payment_method' => 'card',
                'card' => array(
                    'name' => 'Mr. Card Testerson',
                    'number' => '4030000010001234',
                    'expiry_month' => '07',
                    'expiry_year' => '22',
                    'cvd' => '321'
                )
        );

        $legato_payment_data = array(
            'order_number' => "orderNum45678",
            'amount' => 100.0,
            'name' => 'Mr. Card Testerson'
        );
        
        $complete = TRUE; //set to FALSE for PA


            
        //Try to submit a Card Payment
        try {
            // $result = $beanstream->reporting()->getTransaction(10000001);
            $result = $beanstream->payments()->makeLegatoTokenPayment($token, $legato_payment_data, TRUE);
            // $result = $beanstream->payments()->makeCardPayment($payment_data, $complete);
            dd( $result );
            
            
            /*
            * Handle successful transaction, payment method returns
            * transaction details as result, so $result contains that data
            * in the form of associative array.
            */
        } catch (\Beanstream\Exception $e) {
            /*
            * Handle transaction error, $e->code can be checked for a
            * specific error, e.g. 211 corresponds to transaction being
            * DECLINED, 314 - to missing or invalid payment information
            * etc.
            */
            

            dd($e);
            
        }
    }
}
