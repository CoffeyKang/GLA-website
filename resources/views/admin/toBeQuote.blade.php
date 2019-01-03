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
                <th scope='col'>Payment Total</th>
                <th scope='col'>tax</th>
                <th scope='col'>Shipping</th>
                <th scope="col">Order Date</th>
                <th scope="col">Order Status</th>
                <th scope="col">Shipping Status</th>
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
                <td>$ {{number_format(($so->subtotal+$so->tax+$so->shipping),2)}}</td>
                <td>$ {{number_format($so->tax,2)}}</td>
                <td>$ {{number_format($so->shipping,2)}}</td>
                <td>{{substr($so->date_order,0,10)}}</td>
                <td>{{$so->statusCode()}}</td>
                @if ($so->sales_status==3)
                    <td><a class="btn btn-success" href="/QuoteOrder/{{$so->order_num}}">
                        Quote
                    </a></td>
                @else 
                    <td><a class="btn btn-success" href="/QuoteOrder/{{$so->order_num}}">
                        Pending for reply
                    </a></td>
                @endif
            </tr>


            @endforeach
        </tbody>
    </table>
    




</div>
<script>
    $(window).ready(function(){
        $('.nav-link').removeClass('active');
        $('#toBeQuotes').addClass('active');
    });

</script>
@endsection