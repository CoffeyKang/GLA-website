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
        .p300{
            width: 300px;
        }
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
            <td class='text-left'><img src="https://www.goldenleafautomotive.com/images/header_logo.png" alt="" width="80%;"></td>
            <td class='text-right'> <span class='headerNav'>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="https://www.goldenleafautomotive.com/#/CustomerInfo/HomePage">Your Account</a></span></td>
        </tr>
        <tr class='content'>
            <td colspan=2 style='padding-top:30px'>
                @if($somast->sales_status==3)
                    <span class='hi'>Hi {{$user->firstname}}, </span><br>
                    <p>The following order requires shipping quotation.
                    </p>
                @elseif($somast->sales_status==6)
                <span class='hi'>Hi {{$user->firstname}}, </span><br>
                <p>The Order {{$somast->order_num}} has been cancelled due to no reply or by request from the member for a period of allowed time.<br> If you still want to order these products, please place your order on our website again.
                </p>
                @elseif($somast->sales_status==9)
                    <span class='hi'>Hi {{$user->firstname}}, </span><br>
                    <p>Congratulation, your order {{$somast->order_num}} has been shipped!
                        <br>Shipping Courier:{{$somast->courier}}
                        <br>Tracking Number:{{$somast->track_num}}
                    </p>     
                @else
                    <span class='hi'>Hi {{$user->firstname}}, Thank you for your Order</span><br>
                    <p>Your Order is now being processed. Please review the order details and contact us as soon as possible 
                        if any details are incorrect.
                    </p>
                    <b>Payment Status: Success</b><br>
                @endif

                <b>ORDER # {{$somast->order_num}}</b><br>
                <span>Order Placed on {{substr($somast->date_order,0,10)}}</span><br>
                <b>Notes # {{$somast->notes}}</b><br>
                
                <table width="600px" class='pd-10'>
                    <tr>
                        <td style='text-align: left;  '>
                            <b ><br>SHIPPING TO</b>
                        </td>
                    </tr>
                    <tr>
                       <td style='text-align: left; text-transform:uppercase; font-weight:700'>
                            {{$user->firstname}} {{$user->lastname}}<br>
                            {{$user->userDetails->m_address}}<br> {{$user->userDetails->m_city}} {{$user->userDetails->m_state}} {{$user->userDetails->m_zipcode}}
                            @if($user->userDetails->m_country=="CA")CANADA @else USA @endif 
                            <br>
                        
                        </td>
                        
                        
                    </tr>
                </table>
                <br>
                

                <table style='font-size:10px;' width="600px;" class='p530'>
                    <tr>
                        <td colspan=5 style='text-align: left'>
                            <b style='font-size:14px !important'>ORDER DETAILS</b>
                        </td>
                    </tr>
                    <tr style='border-bottom:1px solid gray;padding-top:30px'>
                        <th class='p60'>Item</th>
                        <th  style='word-wrap: break-word; width:"290px"'>Description</th>
                        <th class='p60'>Unit Price</th>
                        <th class='p60'>QTY</th>
                        <th class='p60 text-right'>Price</th>
                    </tr>
                    @foreach ($somast->sotran as $item)
                        <tr style='border-bottom:1px solid lightgray'>
                            <td  class='p60'>{{$item->item}}</td>
                            <td style='word-wrap: break-word; width:"290px"'>{{$item->itemInfo->descrip}}</td>
                            <td class='p60' @if($item->sale==1) style='color:red' @endif>${{number_format($item->price,2)}}</td>
                            <td class='p60'>{{$item->qty}}</td>                            
                            <td class='p60 text-right' >${{number_format($item->price * $item->qty,2)}}</td>
                        </tr>
                    @endforeach
                        
                </table>
                <br>
                <table style='font-size:12px;' width="600px;" class='p530 text-center'>
                    
                    <tr>
                        <td class='p300 text-right'>

                        </td>
                        <td>
                            <table width="600px;" class='p300 text-right'>
                                <tr>
                                    <td>
                                        Subtotal <br>
                                        Shipping <br>
                                        HST/GST/QST <br>
                                        <b>Total</b> <br><br>
                                    </td>
                                    <td>
                                        ${{number_format($somast->subtotal,2)}}<br>
                                        ${{number_format($somast->shipping,2)}}<br>
                                        ${{number_format($somast->tax,2)}}<br>
                                        <b>${{$somast->subtotal + $somast->shipping + $somast->tax}}</b><br><br>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                </table>
            </span>
            </td>
        </tr>
        <br>
        <tr>
            <td class='footer' colspan=2>170 Zenway Blvd. Unit 2, Woodbridge, ON., L4H 2Y7 CANADA | 905-850-3433<br> &copy; {{date("Y")}} Golden Leaf Automotive.
                All rights reserved.</td>
        </tr>
    </table>

</body>

</html>
