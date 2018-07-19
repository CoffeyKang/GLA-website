@extends('layouts.admin') 
@section('content')
<div>
    <div class="alert alert-dark">
        <b>Order History</b>
    </div>
    <table class="table table-striped ">
        <thead>
            <tr>
                <th scope="col">Order Number</th>
                <th scope="col">Customer Name</th>
                <th scope="col">Subtotal</th>
                <th scope="col">Sales Status</th>
                <th scope="col">Note</th>
                
            </tr>
        </thead>
        <tbody>
            @foreach ($orderHistory as $so)
            <tr >
                
                <td>{{$so->order_num}}</td>
                <td>
                    @if ($so->customerInfo()->first())
                        {{$so->customerInfo()->first()->fullname()}}
                    @else
                        Data Missing...
                    @endif
                </td>
                <td>${{number_format($so->subtotal,2)}}</td>
                <td>{{$so->statusCode()}}</td>
                <td>{{$so->notes}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
<div class="d-flex justify-content-center">
    {{ $orderHistory->links() }}
</div>

    


</div>
<script>
    $(window).ready(function(){
        $('.nav-link').removeClass('active');
        $('#orderHistory').addClass('active');
    });

</script>
@endsection