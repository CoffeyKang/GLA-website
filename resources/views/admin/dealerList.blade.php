@extends('layouts.admin') 
@section('content')
<div>

    <div class="alert alert-dark">
        <b>Dealer List</b>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Dealer Id</th>
                <th scope="col">Dealer name</th>
                <th scope="col"># of Orders</th>
                <th scope='col'>price plan</th>
                <th scope='col'class='text-center'>Actions</th>
                
                
            </tr>
        </thead>
        <tbody>
            @foreach ($dealers as $d)
                <tr>
                    <td>{{$d->account}}</td>
                    <td>
                        {{$d->dealerInfo()->first()?$d->dealerInfo()->first()->name:$d->account}}
                    </td>
                    <td>{{$d->orderNum()}}</td>
                    <td>{{$d->dealerInfo()->first()?$d->dealerInfo()->first()->pplan:"Price4"}}</td>
                    <td class='d-flex justify-content-around'>
                    <a class="btn btn-success btn-sm" style='width:71px;' href="/dealerHistory/{{$d->id}}">History</a>
                        <button class="btn btn-danger btn-sm delete_btn" style='width:71px;' @if($d->orderNum()>0) disabled @endif  
                            >Delete</button>
                        <a class="btn btn-warning btn-sm" style='width:71px;' href="/editDealer/{{$d->id}}">Edit</a>
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
            console.log(this.target);
            alert(this);
        });



    });

    

</script>
@endsection