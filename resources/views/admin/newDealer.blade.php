@extends('layouts.admin') 
@section('content')
<div>

    <div class="alert alert-dark">
        <b>Create New Dealer</b>
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
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="col-8 offset-2">
        <form method="POST" action="/newDealer">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group row">
                <label for="account" class="col-sm-2 col-form-label">Account</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control form-control" id="account" name='account' value="{{old('account')}}"  required>
                </div>
            </div>
            <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">Email Address</label>
                <div class="col-sm-10">
                    <input type="email" class="form-control form-control" id="email" name='email' value="{{old('email')}}" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="password" class="col-sm-2 col-form-label">Password</label>
                <div class="col-sm-5">
                    <input type="password" class="form-control form-control" id="password" name='password' placeholder="Password">
                </div>
                <div class="col-sm-5">
                    <input type="password" class="form-control form-control" id="password_confirmation" name='password_confirmation' placeholder="Password Confirmation">
                </div>
            </div>

            

            <div class="form-group row">
                <div class="col-2 offset-8">
                    <button class="btn btn-primary btn-block" type='reset'>Reset</button>
                </div>
                <div class="col-2 ">
                    <button class="btn btn-success btn-block" type='submit'>Create</button>
                </div>
            </div>
        </form>
    </div>
    



</div>
<script>
    $(window).ready(function(){
        $('.nav-link').removeClass('active');
        $('#newDealer').addClass('active');
    });

</script>
@endsection