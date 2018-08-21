@extends('layouts.admin') 
@section('content')
<div>

    <div class="alert alert-dark">
        <b>Upload Catalog</b>
    </div>{{count($catalogs)}}

    <div class="col-8 offset-2">
        <form method="POST" action="/newDealer">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group row">
                <label for="account" class="col-sm-2 col-form-label">Account</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control form-control-sm" id="account" name='account' value="{{old('account')}}" required>
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
        $('#uploadCatalog').addClass('active');
    });
</script>
@endsection