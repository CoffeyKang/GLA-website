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
            width: 530px;
        }

        .content {
            text-align: left !important;
            padding: 50px 0;
        }


        .footer {
            width: 530px;
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
        .p530{width: 530px;}
        .p105{
            width: 105px;

        }
        .p160{
            width: 160px;
        }
        .pd-10{
        	padding: 10px;
        }
    </style>
</head>

<body>
    
    <table class='body'>
        <tr>
            <td><img src="http://retail.goldenleafautomotive.com/images/emailHeader.jpg" alt=""></td>
        </tr>
        <tr class='content'>
            <td>
                <span class='hi'>Hi {{$user->firstname}}, Thank you for your Order</span><br>
                <p>Your Order is now being processed. Please review the order details and contact us as soon as possible 
                    if any details are incorrect.
                </p>

                <b>ORDER # {{$somast->order_num}}</b><br>
                <span>Order Placed on {{substr($somast->date_order,0,10)}}</span>
                <table width="530px" class='pd-10'>
                    <tr>
                        <td class='p265' style='text-align: left'>
                            <b>BILLING ADDRESS</b>
                        </td>
                        <td class='p265' style='text-align: left'>
                            <b>ORDER TOTAL</b>
                        </td>
                    </tr>
                    <tr>
                        <td style='background-color:darkgray; text-align: left'>
                            {{$billing->firstname}} {{$billing->lastname}}<br>
                            {{$billing->address1}} @if (strlen($billing->address2)>=1)
                                {{$billing->address2}}
                            @endif <br>
                            {{$billing->city}}, {{$billing->province}}
                            {{$billing->postalcode}}
                            {{$billing->country}}<br>
                            
                        </td>
                        
                        <td style='background-color:lightgray;'>
                            <table class='p265'>
                                <tr class='p265'>
                                    <td class='px160' style='text-align: left'>
                                        Subtotal
                                    </td>
                                    <td class='p105 text-right' style='text-align: right'>
                                        ${{number_format($somast->subtotal,2)}}
                                    </td>
                                </tr>
                                <tr >
                                    <td class='px160 text-left' style='text-align: left'>
                                        Shipping
                                    </td>
                                    <td class='p105 text-right' style='text-align: right'>
                                        ${{number_format($somast->shipping,2)}}
                                    </td>
                                </tr>
                                <tr >
                                    <td class='px160 text-left' style='text-align: left'> 
                                        Taxes
                                    </td>
                                    <td class=' p105 text-right' style='text-align: right'>
                                        ${{number_format($somast->tax,2)}}
                                    </td>
                                </tr>
                                <tr>
                                    <td class='px160 text-left' style='text-align: left'>
                                        Total
                                    </td>
                                    <td class='p105 text-right' style='text-align: right'>
                                        ${{$somast->subtotal + $somast->shipping + $somast->tax}}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

                <b>Delivery</b><span style='text-transform:uppercase; text-align: left; font-size:12px; color: gray'> to @if ($address->id!=1)
                    {{$address->forename}} {{$address->surname}} {{$address->address}} {{$address->city}}
                    {{$address->state}} {{$address->zipcode}}  @if($address->country=="CA")CANADA @else USA @endif
                @else
                    {{$user->firstname}} {{$user->lastname}} {{$user->userDetails->m_address}} {{$user->userDetails->m_city}} 
                    {{$user->userDetails->m_state}} {{$user->userDetails->m_zipcode}} @if($user->userDetails->m_country=="CA")CANADA @else USA @endif
                @endif

                <table style='font-size:10px;' width="530px" class='p530'>
                    <tr style='border-bottom:1px solid gray'>
                        <th class='p60'>Item</th>
                        <th  style='word-wrap: break-word; width:"290px"'>Description</th>
                        <th class='p60'>Unit Price</th>
                        <th class='p60'>QTY</th>
                        <th class='p60'>Price</th>
                    </tr>
                    <tr><td colspan='5'><hr></td></tr>
                    @foreach ($somast->sotran as $item)
                        <tr style='border-bottom:1px solid lightgray'>
                            <td  class='p60'>{{$item->item}}</td>
                            <td style='word-wrap: break-word; width:"290px"'>{{$item->itemInfo->descrip}}</td>
                            <td  class='p60'>{{$item->qty}}</td>
                            <td class='p60'>${{$item->price}}</td>
                            <td class='p60'>${{$item->price * $item->qty}}</td>
                        </tr>
                        <tr><td colspan='5'><hr></td></tr>
                    @endforeach
                </table>
            </span>
            </td>
        </tr>
        <tr>
            <td class='footer'>70 Zenway Blvd. Unit 2, Woodbridge, ON., L4H 2Y7 CANADA | 905-850-3433<br> &copy; {{date("Y")}} Golden Leaf Automotive.
                All rights reserved.</td>
        </tr>
    </table>

</body>

</html>