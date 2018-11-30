@extends('layouts.admin') 
@section('content')
<div>

    <div class="alert alert-dark">
        <b>Dealer List</b>
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
    <div >
        <form class="form-inline d-flex justify-content-center" action='/findDealer'>
            <div class="form-group  mb-2">
                <label for="account" class="form-label col">Account:</label>
                <input type="text" class="form-control col" id="account" name='account' placeholder="Dealer Account" required>
            </div>
            <button type="submit" class="btn btn-primary mb-2 ml-3">Find Dealer History</button>
        </form>
    </div>
    
    <div class='d-flex justify-content-around'>
        @foreach(range('A','Z') as $v)
            @if ($quickSearch[$v])
                <span><a href="/dealerList/{{$v}}"> <b>{{$v}}</b></a></span>
            @else
                <span>{{$v}}</span>
            @endif
        @endforeach
    </div>

    
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Dealer Id</th>
                <th scope="col">Company name</th>
                <th scope="col"># of Orders</th>
                <th scope='col'>price plan</th>
                <th scope='col'class='text-center'>History</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dealers as $d)
                <tr>
                    <td>{{$d->account}}</td>
                    <td>
                        {{$d->dealerInfo()->first()?$d->dealerInfo()->first()->company:$d->account}}
                    </td>
                    <td>{{$d->orderNum()}}</td>
                    <td>{{$d->dealerInfo()->first()?"Price".$d->dealerInfo()->first()->pricecode:"Price4"}}</td>
                    <td class='d-flex justify-content-around'>
                        <a class="btn btn-primary btn-sm" style='width:71px;' href="/dealerDetails/{{$d->id}}">Details</a>
                        <a class="btn btn-success btn-sm" style='width:71px;' href="/dealerHistory/{{$d->id}}">History</a>
                        {{-- <button class="btn btn-danger btn-sm delete_btn" style='width:71px;' @if($d->orderNum()>0) disabled @endif  
                            >Delete</button>
                        <a class="btn btn-warning btn-sm" style='width:71px;' href="/editDealer/{{$d->id}}">Edit</a> --}}
                    </td>
                </tr>
            
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center">
        {{ $dealers->links() }}
    </div>



</div>
<script>
    $(window).ready(function(){
        $('.nav-link').removeClass('active');
        $('#dealerList').addClass('active');
        $('.delete_btn').click(function(){
            alert(this);
        });



    });

    

</script>
@endsection