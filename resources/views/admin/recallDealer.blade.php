@extends('layouts.admin') 
@section('content')
<div class="alert alert-dark">
    <b>Recall Dealer</b>
</div>
<div class="d-flex p2 justify-content-center ">
    @if (session()->has('status'))
    <div class="alert alert-success container-fluid">
        {{session()->get('status')}}
    </div>
    @endif 
</div>

<table class="table table-striped table-bordered table-sm">
    <thead>
        <th>Account</th>
        <th>Company</th>
        <th>Email</th>
        <th>Recall</th>
    </thead>
    <tbody>
        
        @foreach ($dealers as $d)
            <tr>
                <td>{{$d->account}}</td>
                <td>{{$d->name}}</td>
                <td>{{$d->email}}</td>
                <td><a href="/dealerRecall/{{$d->id}}" class="btn btn-danger">Recall</a></td>
            </tr>
        @endforeach
    </tbody>
</table>

<script>
    $(window).ready(function(){
        $('.nav-link').removeClass('active');
        $('#recallDealer').addClass('active');
    });

</script>
@endsection