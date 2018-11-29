@extends('layouts.admin') 
@section('content')
<div>

    <div class="alert alert-dark d-flex justify-content-between">
        <b>Customer Search Result</b>
        <b><a href="/customerList">Back To All Customer</a></b>
    </div>
    
    @if (session()->has('notFound'))
    <div class='alert alert-danger'>{{session()->get('notFound')}}</div>
    @endif
    <div>
        <form class="form-inline d-flex justify-content-center" action='/findCustomer' >
            <div class="form-group mb-2">
                <label for="email" class="form-label col">Email:</label>
            <input type="email" class="form-control col" id="email" name='email' placeholder="Email" value="{{old('email')}}" >
                <label for="firstname" class="form-label col">Firstname:</label>
                <input type="text" class="form-control col" id="firstname" name='firstname' placeholder="Firstname" >
                <label for="lastname" class="form-label col">Lastname:</label>
                <input type="text" class="form-control col" id="lastname" name='lastname' placeholder="Lastname" >
                <label for="tel" class="form-label col">Tel:</label>
                <input type="text" class="form-control col" id="tel" name='tel' placeholder="Tel" >
            </div>

            <button type="submit" class="btn btn-primary mb-2 ml-3">Find Customer</button>
    
        </form>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Last Name</th>
                <th scope="col">First Name</th>
                <th scope="col">Email</th>
                <th scope='col'>Address</th>
                <th scope='col'>City</th>
                <th scope="col">Province</th>
                <th scope="col">Telephone Number</th>
                <th scope="col">Country</th>
                <th scope='col'>History</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($customerList as $so)
            <tr>
                <td>{{$so->m_surname}}</td>
                <td>
                   {{$so->m_forename}} 
                </td>
                <td>
                    {{$so->main_user()->first()?$so->main_user->email:"Email"}}
                </td>
                <td>{{$so->m_address}}</td>
                <td>{{$so->m_city}}</td>
                <td>{{$so->m_state}}</td>
                <td>{{$so->m_tel}}</td>
                <td>{{$so->m_country}}</td>
                <td><a class="btn btn-success btn-sm" style='width:71px;' href="/CustomerHistory/{{$so->m_id}}">History</a></td>
            </tr>
            

            @endforeach
        </tbody>
    </table>
    




</div>
<script>
    $(window).ready(function(){
        $('.nav-link').removeClass('active');
        $('#customerList').addClass('active');
    });
    
        
        

</script>
@endsection