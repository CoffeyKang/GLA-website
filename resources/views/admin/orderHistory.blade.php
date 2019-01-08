@extends('layouts.admin') 
@section('content')
<div>
    
    <div class="alert alert-dark">
        <b>Order History</b>
    </div>
    <table class="table ">
        <thead>
            <tr>
                <th scope="col">Order Number</th>
                <th scope="col">Customer Name</th>
                <th scope='col'>Order Date</th>
                <th scope="col">Subtotal</th>
                <th scope="col">Sales Status</th>
                <th scope="col" style='max-width:300px'>Note</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orderHistory as $so)
            <tr onclick='showDetails({{$so->order_num}})' @if ($so->sales_status != 9) class='table-danger' @endif>
                <td>{{$so->order_num}}</td>
                <td>
                    @if ($so->customerInfo()->first())
                        {{$so->customerInfo()->first()->fullname()}}
                    @else
                        Data Missing...
                    @endif
                </td>
                <td>{{substr($so->date_order,0,10)}}</td>
                <td>${{number_format($so->subtotal,2)}}</td>
                <td>{{$so->statusCode()}}</td>
                <td style='max-width:300px'>{{$so->notes}}</td>
            </tr>
            <tr id="{{$so->order_num}}" class='details'> 
                <td colspan="6">
                    <table class='table table-sm table-border'>
                        <thead>
                            <tr class='table-primary'>
                                <th scope="col">&nbsp;</th>
                                <th scope="col">Order Number</th>
                                <th scope="col">Item</th>
                                <th scope="col">Qty</th>
                                <th scope="col">Price</th>
                                <th scope="col">Compatible Make</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($so->sotran()->get() as $item)
                                <tr class='table-success'>
                                    <td>&nbsp;</td>
                                    <td>{{$item->order_num}}</td>
                                    <td>{{$item->item}}</td>
                                    <td>{{$item->qty}}</td>
                                    <td>$ {{number_format($item->price,2)}}</td>
{{--                                     
                                    @if ($item->itemInfo()->first())
                                        <td>{{$item->itemInfo()->first()->allMakes()->all_makes}}</td>
                                    @else --}}
                                        <td>{{$item->make}}</td>
                                    {{-- @endif --}}
                                </tr>
                            @endforeach
                        </tbody>
                        
                    </table>
                </td>
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
    function showDetails(sono){
        
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