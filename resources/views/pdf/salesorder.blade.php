<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Golden Leaf Automotive</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B"
        crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js" integrity="sha384-o+RDsa0aLu++PJvFqy8fFScvbHFLtbvScb8AjopnFD+iEQ7wo/CG0xlczd+2O/em"
        crossorigin="anonymous"></script>
    <style>
        body{
            margin: auto;
            text-transform: uppercase;
        }

        .header{
            margin-top:30px;
            
        }
        table{
            width: 100%;
        }
    </style>
       
</head>

<body>
    <div class='logo'>
        <img src="http://retail.goldenleafautomotive.com/images/header_logo.png" alt="" width="40%;">
    </div>
        
    <div class='header'>
        <table>
            <tr>
                <td style='width:50%;'><span style='font-size:18px'><i>GOLDEN LEAF AUTOMOTIVE</i></span></td>
                <td style='width:50%;'>
                    <span style='font-size:14px'>Receipt Number: {{$somast->order_num}}</span>
                </td>
            </tr>
            <tr>
                <td>
                    <span style='font-size:12px'>
                        170 ZENWAY BLVD UNIT#2<br> WOODBRIDGE, ONTARIO L4H 2Y7<br> TELEPHONE 905/850-3433<br> GST/HST # 864767512RT0001
                    </span>
                </td>
                <td>

                </td>
            </tr>

        </table>
            
            
        
    </div>

    <div class='header'>
        <table>
            <tr>
                <td style='width:50%;'>
                    <b style='font-size:12px'>Bill To</b>
                </td>
                <td style='width:50%;'>
                    <b style='font-size:12px'>Ship To</b>
                </td>
            </tr>
            <tr>
                <td>
                    <b style='font-size:12px'>{{$billing->firstname . ' ' .$billing->lastname}}<br>{{$billing->address1}}, {{$billing->city}},<br> {{$billing->postalcode}},
                        {{$billing->province}}, {{$billing->country}}<br>{{$billing->phone}}</b>
                </td>
                <td>

                    @if (is_numeric($address))
                    <b style='font-size:12px'>{{$userInfo->m_forename . ' ' . $userInfo->m_surname}} <br>{{$userInfo->m_address}}, {{$userInfo->m_city}},<br> {{$userInfo->m_zipcode}},{{$userInfo->m_state}},
                        {{$userInfo->m_country}}
                        <br>{{$userInfo->m_tel}}</b>
                    @else
                        <b style='font-size:12px'>{{$address->surname . ' ' . $address->surname}} <br> <br>{{$address->address}}, {{$address->city}}, <br>{{$address->zipcode}},{{$address->state}},
                            {{$address->country}}
                            <br>{{$address->tel}}
                        </b>
                    </div>
                    @endif
                </td>
            </tr>
        </table>
       
            
            
        
    </div>


    <table class="table table-bordered" style='margin-top:30px; font-size:10px;'>
        <thead>
            <tr>
                <th>Item</th>
                <th>QTY</th>
                <th>Description</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($oneOrder as $item)
                <tr>
                    <td>{{$item->item}}</td>
                    <td>{{$item->qty}}</td>
                    <th>{{$item->descrip}}</th>
                    <td>${{number_format($item->price,2)}}</td>
                </tr>
            @endforeach
            
        </tbody>

    </table>
        <h4>NOTES: {{$somast->notes}}</h4>
     <table>
            <tr>
                <td style='width:90%; text-align: right'>
                    <b style='font-size:12px'>Subtotal:</b>
                </td>
                <td style='width:10%; text-align: right'>
                    <b style='font-size:12px'>${{number_format($somast->subtotal,2)}}</b>
                </td>
            </tr>

            <tr>
                <td style='width:90%; text-align: right'>
                    <b style='font-size:12px'>Shipping:</b>
                </td>
                <td style='width:10%; text-align: right'>
                    <b style='font-size:12px'>${{number_format($somast->shipping,2)}}</b>
                </td>
            </tr>

            <tr>
                <td style='width:90%; text-align: right'>
                    <b style='font-size:12px'>Tax:</b>
                </td>
                <td style='width:10%; text-align: right'>
                    <b style='font-size:12px'>${{number_format($somast->tax,2)}}</b>
                </td>
            </tr>

            <tr>
                <td style='width:90%; text-align: right'>
                    <b style='font-size:14px'>Total:</b>
                </td>
                <td style='width:10%; text-align: right'>
                    <b style='font-size:14px'>${{number_format(($somast->tax + $somast->shipping + $somast->subtotal),2) }}</b>
                </td>
            </tr>
    </table>
    
    
</div>
        


</body>

</html>