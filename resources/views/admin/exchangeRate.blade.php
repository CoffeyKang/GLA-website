@extends('layouts.admin') 
@section('content')
    <div class="alert alert-dark">
        <b>Change Exchange Rate</b>
    </div>
    <div class="d-flex p2 justify-content-center m-y-5">
        <form action="/updateExchangeRate" class='col-6'>
            <div class="form-group row">
                <div class="input-group col-8">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon3">USD TO CAD</span>
                    </div>
                    <input type="number" class='form-control' step="0.01" min=0 max=99 name='exchange' value='{{$exchange->exchangeRate}}'>
                </div>
                <div class="col-4"><button class="btn btn-primary btn-block">Change Exchange Rate</button></div>
            </div>
        @if (session()->has('status'))
            <div class="alert alert-success">
                {{session()->get('status')}}
            </div>
        @endif
        
        @if (count($errors)>0)
        <div class="alert alert-danger">
            @foreach ($errors->all() as $item)
                <li>{{$item}}</li>
            @endforeach
        </div>
        @endif
        </form>
        
    </div>
@endsection