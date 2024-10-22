@extends('layouts.admin') 
@section('content')
<div>

    <div class="alert alert-dark">
        <b>Edit personal information</b>
    </div>
    @if (session()->has('status'))
    <div class="alert alert-success">
        {{session()->get('status')}}
    </div>
    @endif @if (session()->has('status_fail'))
    <div class="alert alert-danger">
        {{session()->get('status_fail')}}
    </div>
    @endif @if (count($errors)>=1)
    <div class="alert alert-danger">
        <ol>
            @foreach ($errors->all() as $error)
            <li>{{$error}}</li>
            @endforeach
        </ol>
    </div>
    @endif
    <div class='row justify-content-center'>
        <form class='col-6' method="POST" action="/updateInfo">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
                <label for="password"><b>Email</b></label>
                <input type="email" class="form-control" id="username" name='email' readonly value='{{Auth::user()->email}}'>
            </div>

            

            

            <div class="form-group">
                <label for="password"><b>Old Password</b></label>
                <input type="password" class="form-control" id="password" name='password' required>
            </div>
            <div class="form-group">
                <label for="newPass"><b>New Password</b></label>
                <input type="password" class="form-control" id="newPass" name='newPass' required>
            </div>
            <div class="form-group">
                <label for="newPass_confirmation"><b>Confirm Password</b></label>
                <input type="password" class="form-control" id="newPass_confirmation" name='newPass_confirmation' required>
            </div>
            <div class="invalid-feedback">
                Please choose a username.
            </div>
            <div class="form-group text-right">
                <button class="btn btn-success">
                    Change Password
                </button>
            </div>
        </form>
    </div>






</div>
<script>
    $(window).ready(function(){
        $('.nav-link').removeClass('active');
        $('#updateInfo').addClass('active');
    });

</script>
@endsection