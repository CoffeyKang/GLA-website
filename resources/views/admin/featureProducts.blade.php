@extends('layouts.admin') 
@section('content')
<div class="alert alert-dark">
    <b>Feature Products</b>
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
    <form action="/addNewFeatureProduct" class='col-6' method='POST'>
        {{csrf_field()}}
        <div class="form-group row">
            <div class="input-group col-8">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon3">item number</span>
                </div>
                <input type="test" class='form-control' name='item' required>
            </div>
            <div class="col-4"><button class="btn btn-primary btn-block">Add new feature products</button></div>
        </div>
    </form>
</div>
<table class="table table-striped table-bordered table-sm">
    <thead>
        <th>Number</th>
        <th>Item</th>
        <th>Description</th>
        <th>Remove</th>
    </thead>
    <tbody>
        @php
            $i = 1;
        @endphp
        @foreach ($fitems as $item)
            <tr>
                <td>{{$i++}}</td>
                <td>{{$item->item}}</td>
                <td>{{$item->itemDetails->descrip}}</td>
                <td><a href="/deletefeatureItem/{{$item->id}}" class="btn btn-danger">DELETE</a></td>
            </tr>
        @endforeach
    </tbody>
</table>


@endsection