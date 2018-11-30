@extends('layouts.admin') 
@section('content')
<div>

    <div class="alert alert-dark">
        <b>Change Password</b>
    </div>
    @if (session()->has('status'))
        <div class="alert alert-success">
            {{session()->get('status')}}
        </div>
    @endif

    @if (session()->has('status_fail'))
    <div class="alert alert-danger">
        {{session()->get('status_fail')}}
    </div>
    @endif

    @if (count($errors)>=1)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class='row justify-content-center'>
        
        <form class='col-6' method="POST" action="/updatePassword">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
                <label for="password"><b>Email</b></label>
            <input type="email" class="form-control" id="username" name='email' readonly value='{{Auth::user()->email}}'>
            </div>

            <div class="form-group">
                <label for="firstname"><b>Firstname</b></label>
                <input type="test" class="form-control" id="firstname" name='firstname' >
            </div>

            <div class="form-group">
                <label for="lastname"><b>Lastname</b></label>
                <input type="test" class="form-control" id="lastname" name='lastname'>
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
        $('#changePassword').addClass('active');
    });

</script>
@endsection