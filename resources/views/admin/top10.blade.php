@extends('layouts.admin') 
@section('content')
<div>
    <div class="alert alert-dark">
        <b>Most Sold</b>
    </div>
    <table class="table table-striped ">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Item</th>
                <th scope="col">Capatible Make</th>
                <th scope="col">Sold</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($top10 as $item)
                <tr>
                    <th scope="row">{{$i++}}</th>
                    <td>{{$item->item}}</td>
                    <td>{{$item->itemInfo()->first()->allMakes()->all_makes}}</td>
                    <td>{{$item->sold}}</td>
                </tr>
            @endforeach          
        </tbody>
    </table>

    <div class="alert alert-dark">
        <b>Most Viewed</b>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Item</th>
                <th scope="col">Capatible Make</th>
                <th scope="col">Viewed</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($viewed as $item)
            <tr>
                <th scope="row">{{$v++}}</th>
                <td>{{$item->item}}</td>
                <td>{{$item->itemInfo()->first()->allMakes()->all_makes}}</td>
                <td>{{$item->viewed}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    
</div>
<script>
    $(window).ready(function(){
        $('.nav-link').removeClass('active');
        $('#top10').addClass('active');
    });
</script>
@endsection