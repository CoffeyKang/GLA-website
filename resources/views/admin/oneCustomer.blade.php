@extends('layouts.admin') 
@section('content')
<div>
    <div class="alert alert-dark d-flex justify-content-between">
        <b>Customer Order History - {{$customer->m_surname}}  {{$customer->m_forename}}</b>
        <b><a href="/customerList">Back TO Customer List</a></b>
    </div>

    @if (session()->has('notFound'))
    <div class='alert alert-danger'>{{session()->get('notFound')}}</div>
    @endif

    
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th scope='col'>Order Date</th>
                <th scope="col">Order Number</th>
                <th scope="col">Subtotal</th>
                <th scope='col'>Shipping</th>
                <th scope='col'>Tax</th>
                <th scope='col'>Total</th>
                <th scope="col">Sales Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($customerHistory as $so)
            <tr>
                <td>{{substr($so->date_order,0,10)}}</td>
                <td> <a href="/oneOrder/{{$so->order_num}}"> {{$so->order_num}}</a></td>
                <td>${{number_format($so->subtotal,2)}}</td>
                <td>${{number_format($so->shipping,2)}}</td>
                <td>${{number_format($so->tax,2)}}</td>
                <td>${{$so->tax + $so->subtotal}}</td>
                <td>{{$so->statusCode()}}</td>
            </tr>
           

            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center">
        {{ $customerHistory->links() }}
    </div>




</div>
<script>
    $(window).ready(function(){
        $('.nav-link').removeClass('active');
        $('#customerHistory').addClass('active');
    });

    function showDetails_Dealer(sono){
        
        var id = sono;
        var details = $("#"+id);
        if (details.hasClass("details")) {
            details.removeClass("details");
        }else{
            details.addClass("details");
        }
        
    }

</script>
@endsection