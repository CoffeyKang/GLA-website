@extends('layouts.admin') 
@section('content')
<div class="alert alert-dark d-flex justify-content-between">
    <b>Order Number: {{$somast->order_num}}</b>
    <b><a href="/CustomerHistory/{{$customer->m_id}}">Back TO Customer {{$customer->m_forename}} {{$customer->m_surname}}</a></b>
</div>
{{-- <div>
    <img src="http://retail.goldenleafautomotive.com/images/header_logo.png" alt="" width="40%;">
</div> --}}
<table class='table table-justify'>
    <tr>
        <td>
            <b style='font-size:18px'>Bill To</b>
        </td>
        <td>
            <b style='font-size:18px'>Ship To</b>
        </td>
    </tr>
    <tr>
        <td>
            <b style='font-size:16px'>{{$billing->firstname . ' ' .$billing->lastname}}<br>{{$billing->address1}}, {{$billing->city}},<br> {{$billing->postalcode}},
                        {{$billing->province}}, {{$billing->country}}<br>{{$billing->phone}}</b>
        </td>
        <td>

            @if (is_numeric($address))
            <b style='font-size:16px'>{{$customer->m_forename . ' ' . $customer->m_surname}} <br>{{$customer->m_address}}, {{$customer->m_city}},<br> {{$customer->m_zipcode}},{{$customer->m_state}},
                        {{$customer->m_country}}
                        <br>{{$customer->m_tel}}</b> @else
            <b style='font-size:16px'>{{$address->surname . ' ' . $address->surname}} <br> <br>{{$address->address}}, {{$address->city}}, <br>{{$address->zipcode}},{{$address->state}},
                            {{$address->country}}
                            <br>{{$address->tel}}
                        </b>
            </div>
            @endif
        </td>
    </tr>
</table>
<table class="table ">
    <thead>
        <tr>
            <th scope='col'>Order Date</th>
            <th scope="col">Order Number</th>
            <th scope="col">Customer Name</th>
            <th scope="col">Subtotal</th>
            <th scope="col">Sales Status</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{substr($somast->date_order,0,10)}}</td>
            <td>{{$somast->order_num}}</td>
            <td>
                {{$customer->fullname()}}
            </td>
            <td>${{number_format($somast->subtotal,2)}}</td>
            <td>{{$somast->statusCode()}}</td>
        </tr>
    </tbody>
</table>





    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Item</th>
                <th>QTY</th>
                <th>Description</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sotran as $item)
            <tr>
                <td>{{$item->item}}</td>
                <td>{{$item->qty}}</td>
                <td>{{$item->itemInfo->descrip}}</td>
                <td>${{number_format($item->price,2)}}</td>
            </tr>
            @endforeach
        </tbody>

    </table>
    
    <div class='d-flex'>
        <div class="col-11 text-right">
            <b>Subtotal:</b><br>
            <b>Shipping:</b><br>
            <b>Tax:</b><br>
            <b>Total:</b><br>
        </div>       
        <div class="col-1 text-right">
            <b>${{number_format($somast->subtotal,2)}}</b><br>
            
            <b>${{number_format($somast->shipping,2)}}</b><br>
            
            <b>${{number_format($somast->tax,2)}}</b><br>
            
            <b>${{number_format(($somast->tax + $somast->shipping + $somast->subtotal),2) }}</b>
        </div> 
        
    </div>

    <div class="text-right mt-5">
        {{-- <a href="/PDF/salesOrder/{{$somast->order_num}}.pdf" class="btn btn-primary">View Online</a> --}}
        <a href="/PDF/salesOrder/{{$somast->order_num}}.pdf" class="btn btn-success" download>Download PDF</a>
    </div>
@stop