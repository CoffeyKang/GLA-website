@extends('layouts.admin') 
@section('content')
<div>
    <div class="alert alert-dark d-flex justify-content-between">
        <b>Dealer Order History --{{$dealer->account}},  {{$dealer->fullname()}}</b>
        <b><a href="/dealerList">Back TO Dealer List</a></b>
    </div>
    <table class="table ">
        <thead>
            <tr>
                <th scope='col'>Order Date</th>
                <th scope="col">Order Number</th>
                <th scope="col">Dealer Name</th>
                <th scope="col">Subtotal</th>
                <th scope="col">Sales Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dealerHistory as $so)
            <tr onclick='showDetails_Dealer("{{$so->order_num}}")'
                 {{-- @if ($so->sales_status != 9) class='table-danger' @endif --}}
                 >
                <td>{{substr($so->date_order,0,10)}}</td>
                <td>{{$so->order_num}}</td>
                <td>
                    {{$so->fullname()}}
                </td>
                <td>${{number_format($so->subtotal,2)}}</td>
                <td>{{$so->statusCode()}}</td>
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
                            @foreach ($so->dealerDetails()->get() as $item)
                            <tr class='table-success'>
                                <td>&nbsp;</td>
                                <td>{{$item->order_num}}</td>
                                <td>{{$item->item}}</td>
                                <td>{{$item->qty}}</td>
                                <td>$ {{number_format($item->price,2)}}</td>

                                @if ($item->itemInfo()->first())
                                <td>{{$item->itemInfo()->first()->allMakes()->all_makes}}</td>
                                @else
                                <td>{{$item->make}}</td>
                                @endif
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="6">
                                    <b> NOTE:</b> {{$so->notes}}
                                </td>
                            </tr>
                        </tbody>

                    </table>
                </td>
            </tr>

            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center">
        {{ $dealerHistory->links() }}
    </div>




</div>
<script>
    $(window).ready(function(){
        $('.nav-link').removeClass('active');
        $('#dealerHistory').addClass('active');
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