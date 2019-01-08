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
    <div class='d-flex justify-content-between'>
        <div class="card col-4">
            <div class="card-body">
                <h4 class="card-title">Personal Info.</h4>
                <div class="card-text row">
                    <div class="col-4 d-flex flex-column">
                        <span>E-Mail:</span>
                        <span>GLA ID:</span>
                        <span>Name:</span>
                        <span>Birth Date:</span>
                    </div>
                    <div class="col-8 d-flex flex-column">
                        <span>{{$customer->main_user->email}}</span>
                        <span>{{$customer->main_user->id}}</span>
                        <span>{{$customer->fullname()}}</span>
                        <span>{{$customer->main_user->birth}}</span>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="card col-4">
            <div class="card-body">
                <h4 class="card-title">Contact Info.</h4>
                <div class="card-text row">
                    <div class="col-4 d-flex flex-column">
                        <span>Address :</span>
                        <span>&nbsp;</span>
                        <span>Telephone:</span>
                        <span>Mobile:</span>
                    </div>
                    <div class="col-8 d-flex flex-column">
                        <span>{{$customer->m_address}}</span>
                        <span>{{$customer->m_city}},{{$customer->m_city}},{{$customer->m_state}},
                            {{$customer->m_zipcode}},{{$customer->m_country}}</span>
                        <span>{{$customer->m_tel}}</span>
                        <span>{{$customer->m_mobile}}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="card col-4">
            <div class="card-body">
                <h4 class="card-title">Other Info.</h4>
                <div class="card-text row">
                    <div class="col-4 d-flex flex-column">
                        <span>Car:</span>
                        <span>Make:</span>
                        <span>Year:</span>
                    </div>
                    <div class="col-8 d-flex flex-column">
                        <span>{{$customer->m_car}}</span>
                        <span>{{$customer->m_make}}</span>
                        <span>{{$customer->m_year}}</span>
                    </div>
                </div>
                <div class="container-fluid text-right">
                <a href="/deleteUser/{{$customer->m_id}}" class='btn btn-danger'>Delete Customer</a>
                </div>
            </div>
        </div>
            
            
        
        
    </div>

    
    
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th scope='col'>Order Date</th>
                <th scope="col">Order Number</th>
                <th scope="col">Subtotal</th>
                <th scope='col'>Shipping</th>
                <th scope='col'>Tax</th>
                <th scope='col'>Payment Total</th>
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
                <td>${{$so->tax + $so->subtotal + $so->shipping}}</td>
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