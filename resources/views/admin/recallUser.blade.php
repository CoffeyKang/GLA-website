@extends('layouts.admin') 
@section('content')
<div class="alert alert-dark">
    <b>Recall User</b>
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
        <th>Name</th>
        <th>Email</th>
        <th>Recall</th>
    </thead>
    <tbody>
        
        @foreach ($users as $u)
            <tr>
            <td>{{$u->firstname}} {{$u->lastname}}</td>
                <td>{{$u->email}}</td>
                <td><a href="/userRecall/{{$u->id}}" class="btn btn-success">Recall</a></td>
            </tr>
        @endforeach
    </tbody>
</table>

<script>
    $(window).ready(function(){
        $('.nav-link').removeClass('active');
        $('#recallUser').addClass('active');
    });

</script>
@endsection