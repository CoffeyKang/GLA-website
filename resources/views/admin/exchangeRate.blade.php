@extends('layouts.admin') 
@section('content')
    <div class="alert alert-dark">
        <b>Change Exchange Rate and Tax</b>
    </div>
    <div class="d-flex p2 justify-content-center ">
        @if (session()->has('status'))
        <div class="alert alert-success container">
            {{session()->get('status')}}
        </div>
        @endif @if (count($errors)>0)
        <div class="alert alert-danger container">
            @foreach ($errors->all() as $item)
            <li>{{$item}}</li>
            @endforeach
        </div>
        @endif
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
        
        </form>
        
    </div>

    <div class="d-flex p2 justify-content-center m-y-5">
    
        <form action="/changeTaxRate" class='col-6' method='POST'>
            {{csrf_field()}}
            <div class="form-group row">
            @foreach ($taxRate as $item)
                
                    <div class="input-group form-group col-6">
                        <div class="input-group-prepend">
                        <span class="input-group-text"  style='width:50px;'>{{$item->province}}</span>
                        </div>
                        <input type="number" class='form-control' step="0.001" min=0 max=99 name={{$item->province}} value='{{$item->tax}}' style='text-align:right'>
                        <div class="input-group-append">
                            <span class="input-group-text"  style='width:50px;'>%</span>
                        </div>
                    </div>
                
            @endforeach
                    </div>
                <div class="form-group row d-flex justify-content-end">
                    <div class="col-4"><button class="btn btn-primary btn-block">Change Tax Rate</button></div>
                </div>
    
        </form>
    
    </div>
@endsection