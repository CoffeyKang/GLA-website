@extends('layouts.admin') 
@section('content')
<div>
    <div class="alert alert-dark">
        <b>Quote for {{$somast->order_num}}</b>
    </div>

    <table class="table ">
        <thead>
            <tr>
                <th scope='col'>Order Date</th>
                <th scope="col">Order Number</th>
                <th scope="col">Customer Name</th>
                <th scope="col">Payment Total</th>
                <th scope="col">Shipment Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{substr($somast->date_order,0,10)}}</td>
                <td>{{$somast->order_num}}</td>
                <td>
                    {{$customerInfo->fullname()}}
                </td>
                <td>${{number_format($somast->subtotal+$somast->shipping+$somast->tax,2)}}</td>
                <td>{{$somast->statusCode()}}</td>
            </tr>
        </tbody>
    </table>

    
    <div class=" row col-sm-12 d-flex justify-content-between mb-3">
    
        <div class="card col-sm-5">
            <div class="card-body">
                <h5 class="card-title">Billing Address</h5>
                <h6 class="card-subtitle mb-2 text-muted">{{$billing->firstname}} {{$billing->lastname}}</h6>
                <p class="card-text">{{$billing->address1}}, {{$billing->city}}, {{$billing->province}},
                    {{$billing->postalcode}}, {{$billing->country}}<br>
                    {{$billing->phone}},
                </p>

            </div>
        </div>

        <div class="card col-sm-5">
            <div class="card-body">
                <h5 class="card-title">Shipping Address</h5>
                <h6 class="card-subtitle mb-2 text-muted">{{$shippingArray['name']}}</h6>
                <p class="card-text">{{$shippingArray['address_line1']}}, {{$shippingArray['city']}}, {{$shippingArray['province']}}, {{$shippingArray['postal_code']}},
                    {{$shippingArray['country']}}<br> {{$shippingArray['phone_number']}},
                </p>
        
            </div>
        </div>
    </div>

    <table class='table table-sm table-border'>
        <thead>
            <tr class='table-primary'>
                
                <th scope="col">Order Number</th>
                <th scope="col">Item</th>
                <th scope='col'>Description</th>
                <th scope="col">Qty</th>
                <th scope="col">Price</th>
                <th scope="col">Compatible Make</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sotran as $item)
            <tr class='table-success'>
                
                <td>{{$item->order_num}}</td>
                <td>{{$item->item}}</td>
                <td>{{$item->itemInfo->descrip}}</td>
                <td>{{$item->qty}}</td>
                <td>$ {{number_format($item->price,2)}}</td>
                @if ($item->itemInfo()->first())
                <td>{{$item->itemInfo()->first()->allMakes()->all_makes}}</td>
                @else
                <td>{{$item->make}}</td>
                @endif
            </tr>
            @endforeach
        </tbody>
    
    </table>

    <div class='d-flex'>
        <div class="col-10 text-right">
            <b>Subtotal:</b><br>
            <b>Tax:</b><br>
            <b>Total:</b><br>
        </div>
        <div class="col-1 text-right">
            <b>${{number_format($somast->subtotal,2)}}</b><br>
    
            <b>${{number_format($somast->tax,2)}}</b><br>
    
            <b>${{number_format(($somast->tax + $somast->shipping + $somast->subtotal),2) }}</b>
        </div>
    
    </div>
    
    
    <div class='d-flex justify-content-center'>
        <form action="/updateQuote"  class='col-md-6' method='POST'>
            <input type="hidden" name="sono" value='{{$somast->order_num}}'>
            {{ csrf_field() }}
            <div class="row mb-3">
                <div class="col-md-6 ">
                    <label for="courier">Shipping</label>
                    @if ($somast->sales_status==3)
                        <input type="number" step='0.01' class="form-control" min='0' name="shipping" placeholder="Shipping Fees" >                        
                    @else
                        <input type="number" step='0.01' class="form-control" min='0' name="shipping" value="{{$somast->shipping}}">   
                    @endif
                </div>
                <div class="col-md-6 ">
                    <label for="track_num">Take Days</label>
                    @if ($somast->sales_status==3)
                        <input type="number" class="form-control" name="takedays" min='0' placeholder="Take days" >
                    @else
                        <input type="number" class="form-control" min='0' name="takedays" value="{{$somast->shippingdays}}"> 
                    @endif
                </div>
            </div>
            {{-- <div class="row mb-3">
                <div class="col-md-12 ">
                    <label for="note">Note</label>
                    <textarea name="note" id="note" class='form-control' cols="30" rows="10"></textarea>
                </div>
            </div> --}}
            
            <div class='row '>
                <div class="col-md-12 d-flex flex-row-reverse">
                    <button class="btn btn-success" type='submit'>Quote</button>
                </div>
            </div>
                    
                
            
        </form>
    
       
            
            
            
            
    </div>
    {{-- {{$somast}}

    {{$customer}}
</div> --}}
<script>
    $(window).ready(function(){
        $('.nav-link').removeClass('active');
        $('#newDealer').addClass('active');
    });
</script>
@endsection