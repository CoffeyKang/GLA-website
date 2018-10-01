@extends('layouts.admin') 
@section('content')
<div>

    <div class="alert alert-dark">
        <b>Customer List</b>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Surname</th>
                <th scope="col">Forename</th>
                <th scope="col">Level</th>
                <th scope='col'>Address</th>
                <th scope='col'>City</th>
                <th scope="col">State</th>
                <th scope="col">Telephone Number</th>
                <th scope="col">Country</th>
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
                    {{$so->main_user()->first()?$so->main_user()->first()->level():"Customer"}}
                </td>
                <td>{{$so->m_address}}</td>
                <td>{{$so->m_city}}</td>
                <td>{{$so->m_state}}</td>
                <td>{{$so->m_tel}}</td>
                <td>{{$so->m_country}}</td>
            </tr>
            

            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center">
        {{ $customerList->links() }}
    </div>




</div>
<script>
    $(window).ready(function(){
        $('.nav-link').removeClass('active');
        $('#customerList').addClass('active');
    });
    
        
        

</script>
@endsection