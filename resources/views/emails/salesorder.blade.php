<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B"
        crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js" integrity="sha384-o+RDsa0aLu++PJvFqy8fFScvbHFLtbvScb8AjopnFD+iEQ7wo/CG0xlczd+2O/em"
        crossorigin="anonymous"></script>
    <title>GLA Inventory Website Admin</title>

    <style>
        body {
            margin: auto;
            text-align: center;
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 24px;
            
        }

        .body {
            margin: auto;
            text-align: center;
            width: 600px;
        }

        .content {
            text-align: left !important;
            padding: 50px 0;
        }


        .footer {
            width: 600px;
            padding: 10px 0;
            background-color: #FFE512;
            font-size: 12px;
            text-align: center;
        }

        .hi {
            font-size: 120%;
        }

        .text-right{
            text-align: right;
        }
        .text-left{
            text-align: left;
        }
        hr{
            border-color: lightgray;
        }
        .p265{
            width: 265px;
        }
        .p60{
            width: 60px;
        }
        .p530{width: 600px;}
        .p105{
            width: 105px;

        }
        .p160{
            width: 160px;
        }
        .pd-10{
        	padding: 10px;
        }
        .headerNav{
            font-size: 20px;
            color: #1d4077;
            font-weight: 700;
            border-bottom:1px solid black;
        }
        .headerNav a{
            color: #1d4077;
        }
        .headerNav a:hover{
            text-decoration: none;
        }
        a{ text-decoration: none; }
    </style>
</head>

<body>
    
    <table class='body'>
        <tr>
            <td class='text-left'><img src="http://retail.goldenleafautomotive.com/images/header_logo.png" alt="" width="80%;"></td>
            <td class='text-right'> <span class='headerNav'>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="http://retail.goldenleafautomotive.com/#/CustomerInfo/HomePage">Your Account</a></span></td>
        </tr>
        <tr class='content'>
            <td colspan=2 style='padding-top:30px'>
                <span class='hi'>Hi {{$user->firstname}}, Thank you for your Order</span><br>
                <p>Your Order is now being processed. Please review the order details and contact us as soon as possible 
                    if any details are incorrect.
                </p>

                <b>ORDER # {{$somast->order_num}}</b><br>
                <span>Order Placed on {{substr($somast->date_order,0,10)}}</span>
                <table width="600px" class='pd-10'>
                    <tr>
                        <td class='p265' style='text-align: left'>
                            <b>BILLING ADDRESS</b>
                        </td>
                        <td class='p265' style='text-align: left'>
                            <b>SHIPPING ADDRESS</b>
                        </td>
                    </tr>
                    <tr>
                        <td style='background-color:darkgray; text-align: left;text-transform:uppercase'>
                            {{$billing->firstname}} {{$billing->lastname}}<br>
                            {{$billing->address1}} @if (strlen($billing->address2)>=1)
                                {{$billing->address2}}
                            @endif <br>
                            {{$billing->city}}, {{$billing->province}}
                            {{$billing->postalcode}}
                            {{$billing->country}}<br>
                            
                        </td>

                        <td style='background-color:lightgray; text-align: left; text-transform:uppercase'>
                            @if ($address->id!=1) {{$address->forename}} {{$address->surname}}<br>{{$address->address}}<br> {{$address->city}} {{$address->state}}
                            {{$address->zipcode}} @if($address->country=="CA")CANADA @else USA @endif 
                            @else {{$user->firstname}} {{$user->lastname}}<br>
                            {{$user->userDetails->m_address}}<br> {{$user->userDetails->m_city}} {{$user->userDetails->m_state}} {{$user->userDetails->m_zipcode}}
                            @if($user->userDetails->m_country=="CA")CANADA @else USA @endif @endif
                            <br>
                        
                        </td>
                        
                        
                    </tr>
                </table>
                <br>
                

                <table style='font-size:10px;' width="600px;" class='p530'>
                    <tr style='border-bottom:1px solid gray;padding-top:30px'>
                        <th class='p60'>Item</th>
                        <th  style='word-wrap: break-word; width:"290px"'>Description</th>
                        <th class='p60'>Unit Price</th>
                        <th class='p60'>QTY</th>
                        <th class='p60'>Price</th>
                    </tr>
                    @foreach ($somast->sotran as $item)
                        <tr style='border-bottom:1px solid lightgray'>
                            <td  class='p60'>{{$item->item}}</td>
                            <td style='word-wrap: break-word; width:"290px"'>{{$item->itemInfo->descrip}}</td>
                            <td  class='p60'>{{$item->qty}}</td>
                            <td class='p60'>${{$item->price}}</td>
                            <td class='p60'>${{$item->price * $item->qty}}</td>
                        </tr>
                    @endforeach
                        
                </table>
                <table style='font-size:12px;' width="600px;" class='p530 text-center'>
                    <tr>
                        <th>
                            Subtotal
                        </th>
                        <th>
                            Shipping
                        </th>
                        <th>
                            HST/GST/QST
                        </th>
                        <th>
                            Total
                        </th>
                    </tr>
                    <tr>    
                        <td>${{number_format($somast->subtotal,2)}}</td>
                        <td>${{number_format($somast->shipping,2)}}</td>
                        <td>${{number_format($somast->tax,2)}}</td>
                        <td>${{$somast->subtotal + $somast->shipping + $somast->tax}}</td>
                    </tr>
                </table>
            </span>
            </td>
        </tr>
        <br>
        <tr>
            <td class='footer' colspan=2>70 Zenway Blvd. Unit 2, Woodbridge, ON., L4H 2Y7 CANADA | 905-850-3433<br> &copy; {{date("Y")}} Golden Leaf Automotive.
                All rights reserved.</td>
        </tr>
    </table>

</body>

</html>
