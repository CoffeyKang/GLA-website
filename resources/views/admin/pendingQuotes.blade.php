@extends('layouts.admin') 
@section('content')
<div>

    <div class="alert alert-dark">
        <b>Pending Quotes</b>
    </div>

    @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
    @endif
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Order number</th>
                <th scope="col">customer</th>
                <th scope='col'>subtotal</th>
                <th scope='col'>tax</th>
                <th scope='col'>Shipping</th>
                <th scope="col">Order Date</th>
                <th scope="col">Order Status</th>
                <th scope="col">Shipping</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pendingQuotes as $so)
            <tr>
                <td>{{$so->order_num}}</td>
                <td>
                    @if ($so->customerInfo()->first())
                        {{$so->customerInfo()->first()->fullname()}}
                    @else
                        Customer
                    @endif
                    
                </td>
                <td>$ {{number_format($so->subtotal,2)}}</td>
                <td>$ {{number_format($so->tax,2)}}</td>
                <td>$ {{number_format($so->shipping,2)}}</td>
                <td>{{$so->date_order}}</td>
                <td>{{$so->statusCode()}}</td>
                @if ($so->sales_status==1)
                    <td><a class="btn btn-success" href="/shippingOrder/{{$so->order_num}}">
                        shipping
                    </a></td>
                @else 
                    <td>
                        Shipped
                    </td>
                @endif
            </tr>


            @endforeach
        </tbody>
    </table>
    




</div>
<script>
    $(window).ready(function(){
        $('.nav-link').removeClass('active');
        $('#pendingQuotes').addClass('active');
    });

</script>
@endsection