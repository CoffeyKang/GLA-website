@extends('layouts.admin') 
@section('content')
<div>

    <div class="alert alert-dark">
        <b>Pending Quotes</b>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Order number</th>
                <th scope="col">customer</th>
                <th scope='col'>subtotal</th>
                <th scope='col'>tax</th>
                <th scope='col'>Shipping</th>
                <th scope="col">Currency</th>
                <th scope="col">Order Date</th>
                <th scope="col">Order Status</th>
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
                        Data Missing... 
                    @endif
                    
                </td>
                <td>$ {{number_format($so->subtotal,2)}}</td>
                <td>$ {{number_format($so->tax,2)}}</td>
                <td>$ {{number_format($so->shipping,2)}}</td>
                <td>{{$so->currency}}</td>
                <td>{{$so->date_order}}</td>
                <td>{{$so->statusCode()}}</td>
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