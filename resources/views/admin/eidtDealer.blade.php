@extends('layouts.admin') 
@section('content')
<div>

    <div class="alert alert-dark d-flex justify-content-between">
    <b>Edit Dealer {{$dealer->account}}, {{$dealer->name}}</b>
    <b><a href="/dealerList">Back TO Dealer List</a></b>
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
        <form method="POST" action="/updateDealer/{{$dealer->id}}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group row">
                <label for="account" class="col-sm-2 col-form-label">Account</label>
                <div class="col-sm-10">
                    <input type="text" readonly class="form-control-plaintext form-control-sm "  id="account" name='account' value="{{$dealer->account}}" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">Dealer Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control form-control-sm" id="name" name='name' value="{{$dealer->name}}" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="address" class="col-sm-2 col-form-label">Address</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control form-control-sm" id="address" name='address' value="{{$dealer->getProperty('address')}}" required>
                </div>
            </div>

            <div class="form-group row">

                <label for="city" class="col-sm-2 col-form-label">City</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control form-control-sm" id="city" name='city' value="{{$dealer->getProperty('city')}}" required>
                </div>

                <label for="province" class="col-sm-1 col-form-label">Province</label>
                <div class="col-sm-4">
                    <select class="custom-select" id='province' name='province' value="{{$dealer->getProperty('province')}}">
                        <option value="AB">Alberta</option>
                        <option value="BC">British Columbia</option>
                        <option value="MB">Manitoba</option>

                        <option value="NB">New Brunswick</option>
                        <option value="NL">Newfoundland</option>
                        <option value="NT">Northwest Territories</option>

                        <option value="NS">Nova Scotia</option>
                        <option value="NU">Nunavut</option>
                        <option value="ON">Ontario</option>

                        <option value="PE">Prince Edward Island</option>
                        <option value="QC">Quebec</option>
                        <option value="SK">Saskatchewan</option>

                        <option value="TY">Yukon Territory</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="postalcode" class="col-sm-2 col-form-label">Postal Code</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control form-control-sm" id="postalcode" name='postalcode' value="{{$dealer->getProperty('postalcode')}}" required>
                </div>

                <label for="country" class="col-sm-1 col-form-label">Country</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-sm" id="country" name='country' value="{{$dealer->getProperty('country')}}" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="pplan" class="col-sm-2 col-form-label">Price Plan</label>

                <div class="col-sm-5">
                    <select class="custom-select" id='pplan' name='pplan' value="{{$dealer->getProperty('pplan')}}">
                        <option value="price1">price 1</option>
                        <option value="price2">price 2</option>
                        <option value="price3">price 3</option>
                        <option value="price4">price 4</option>
                        <option value="price5">price 5</option>
                        <option value="price6">price 6</option>
                        
                    </select>
                </div>

                <label for="email_address" class="col-sm-1 col-form-label">Email</label>
                <div class="col-sm-4">
                    <input type="email" class="form-control form-control-sm" id="email_address" name='email_address' value="{{$dealer->getProperty('email_address')}}"
                        required>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-2 offset-8">
                    <button class="btn btn-primary btn-block" type='reset'>Reset</button>
                </div>
                <div class="col-2 ">
                    <button class="btn btn-success btn-block" type='submit'>Update</button>
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