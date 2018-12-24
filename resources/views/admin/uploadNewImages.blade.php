@extends('layouts.admin') 
@section('content')
<div class="alert alert-dark">
    <b>Upload New Iamges</b>
</div>

@if (count($errors)>0)

<div class="col-12">
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error) {{$error}} @endforeach
        </ul>

    </div>
</div>

@endif @if (session()->has('status'))
<div class="col-12 alert alert-success">
    {{session()->get('status')}}
</div>

@endif



<div class="d-flex p2 justify-content-center m-y-5">

    <form action="/uploadImages" enctype="multipart/form-data" method='POST' class='col-6'>
        {{csrf_field()}}
        <div class="form-group">
            <div class="input-group col-8">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon3">Item Number</span>
                </div>
                <input type="text" class='form-control'  name='item' id='item' value=''>
            </div>
            
        </div>

        <div class="form-group">
            <div class="input-group col-8">
                <label for="exampleFormControlFile1">Upload New Image</label>
                <input type="file" class="form-control-file" id="image" name='image' accept="image/*">
                
            </div>
        
        </div>
        <div class="form-group ">
            <div class="col-8 row ">
                <div class="col-6"><button class="btn btn-warning btn-block" type='reset'>Reset</button></div>
                <div class="col-6"><button class="btn btn-primary btn-block" type='submit'>Upload New Images</button></div>
            </div>
                      
        </div>

    </form>

   

</div>
<script>
    $(window).ready(function(){
        $('.nav-link').removeClass('active');
        $('#uploadNewImages').addClass('active');
    });
</script>
@endsection