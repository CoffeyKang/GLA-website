@extends('layouts.admin') 
@section('content')
<div>
    
    <div class="alert alert-dark d-flex justify-content-between">
        <b>Dealer Information,  {{$dealerInfo->company}} ({{$dealer->account}})</b>
        <b><a href="/dealerList">Back TO Dealer List</a></b>
    </div>
    @if (count($errors)>=1)
    <div class=' alert alert-danger'>
        <ul>
            @foreach ($errors->all() as $item)
            <li>{{$item}}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if (session()->has('status'))
        <div class="alert alert-success">
            {{session()->get('status')}}
        </div>
    @endif
    <div class='row justify-content-center mt-5'>
        <form action="/updateDealerPass" method='post' class='col-6'>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name='id' value='{{$dealer->id}}'>
            <div class="form-group row">
                <label for="Account" class="col-sm-2 col-form-label">Account:</label>
                <div class="col-sm-4">
                    <input type="text" readonly class="form-control" id="Account" value="{{$dealerInfo->custno}}">
                </div>
                <label for="Account" class="col-sm-2 col-form-label">Price Plan:</label>
                <div class="col-sm-4">
                    <input type="text" readonly class="form-control" id="Account" value="price{{$dealerInfo->pricecode}}">
                </div>
            </div>
            <div class="form-group row">
                <label for="password" class="col-sm-2 col-form-label">Password:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="password" name='password' value="{{$dealer->pass}}">
                </div>
            </div>
            <div class="form-group row">
                <label for="company" class="col-sm-2 col-form-label">Company:</label>
                <div class="col-sm-10">
                    <input type="text" readonly class="form-control" id="company" value="{{$dealerInfo->company}}">
                </div>
            </div>
            <div class="form-group row">
                <label for="address" class="col-sm-2 col-form-label">Address:</label>
                <div class="col-sm-10">
                    <input type="text" readonly class="form-control" id="address" value="{{$dealerInfo->address1}}">
                </div>
            </div>
            <div class="form-group row">
                <label for="address" class="col-sm-2 col-form-label">City:</label>
                <div class="col-sm-4">
                    <input type="text" readonly class="form-control" id="address" value="{{$dealerInfo->city}}">
                </div>
                <label for="Province" class="col-sm-2 col-form-label">Province:</label>
                <div class="col-sm-4">
                    <input type="text" readonly class="form-control" id="address" value="{{$dealerInfo->terr}}">
                </div>
                
            </div>

            <div class="form-group row">
                <label for="address" class="col-sm-2 col-form-label">Postalcode:</label>
                <div class="col-sm-4">
                    <input type="text" readonly class="form-control" id="address" value="{{$dealerInfo->zip}}">
                </div>
                <label for="Country" class="col-sm-2 col-form-label">Country:</label>
                <div class="col-sm-4">
                    <input type="text" readonly class="form-control" id="Country" value="{{$dealerInfo->country}}">
                </div>
            </div>

            <div class="form-group row">
                <label for="Province" class="col-sm-2 col-form-label">Email:</label>
                <div class="col-sm-4">
                    <input type="text" readonly class="form-control" id="address" value="{{$dealerInfo->email}}">
                </div>
                <label for="Country" class="col-sm-2 col-form-label">Tel:</label>
                <div class="col-sm-4">
                    <input type="text" readonly class="form-control" id="address" value="{{$dealerInfo->phone}}">
                </div>
            </div>

            <div class="form-group text-right">
                <button class="btn btn-default" type='reset'>Reset Password</button>
                <button class="btn btn-success" type='submit'>Update Password</button>
            </div>

        </form>
        
    </div>
    
    
</div>
<script>
    $(window).ready(function(){
        $('.nav-link').removeClass('active');
        $('#dealerList').addClass('active');
    });
</script>
@endsection