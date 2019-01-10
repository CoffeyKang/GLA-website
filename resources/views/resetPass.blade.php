<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keywords" content="GLA,Golden Leaf Automotive,DII,Dynacorn International Inc.,
    classic car parts,muscle cars parts,parts developer and manufacturer,car parts and molding,canadian based">
    <meta name="description" content="Golden Leaf Automotive is the Canadian based extension 
    of Dynacorn International Inc. For over 18 years DII has been producing all the hard to find 
    parts for your classic cars. Because of the abilities of our manufacturing facilities, 
    our product development is without peer in the classic car industry. 
    Service is our number one goal. With over 100 dealers across Canada and continually 
    growing. Our ability to serve you is only matched by the quality of our products.">
    <meta name="author" content="Visual Elements Images Studio Inc. www.velements.com">
    <!-- Styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B"
        crossorigin="anonymous">
    <link href="{{ asset('css/index.css') }}" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js" integrity="sha384-o+RDsa0aLu++PJvFqy8fFScvbHFLtbvScb8AjopnFD+iEQ7wo/CG0xlczd+2O/em"
        crossorigin="anonymous"></script>
    <title>GLA Inventory Website Admin</title>
    <style>
        .login_div{
            width: 80%;
            padding: 50px;
            background-color: white;
        }
        .login_form{
            width: 80%;
        }
    </style>
</head>
<body>
    
    <div class="container login_main">
        @if (count($errors)>=1)
            <div class="alert alert-danger" role="alert" style='margin-top:100px'>
                <ul>
                    @foreach ($errors->all() as $item)
                    <li>{{$item}}</li>
                    @endforeach
                </ul>
            </div>
            @endif @if (session()->has('status'))
            <div class="alert alert-success" style='margin-top:100px'>
                {{session()->get('status')}}<br>
                <a href="https://www.goldenleafautomotive.com">Golden Leaf Automotive</a>
            </div>
            
            @endif
        <div class="login_div  ">
            
            <div class="login_logo">
            </div>
            <div class="login_form">
                <form method="POST" action="/resetPassword">
                    <input type="hidden" name='token' value="{{$_GET['token']}}">
                    {{ csrf_field() }}
                    <div class="form-group row">
                        <label for="username" class="col-sm-4 col-form-label">Email:</label>
                        <div class="col-sm-8">
                        <input type="email" class="form-control" name='email' id="email" value="{{$_GET['email']}}" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="col-sm-4 col-form-label">New Password:</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" id="password" name='password' placeholder="Password">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-sm-4 col-form-label">Confirm Password:</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" id="password_confirmation" name='password_confirmation' placeholder="Confirm Password">
                        </div>
                    </div>
                    <div class="form-group row ">
                        <div class="col-sm-12 text-right">

                            {{-- <span><a href="#" class='forget'> Forget password? </a></span> --}}

                            <button type="submit" class="btn btn-success" style='width:100px;'>Reset</button>

                            
                        </div>
                    </div>
                </form>

            </div>
            
            <div class="copyright text-center">
                &copy; {{date('Y')}} Golden Leaf Automotive. All rights reserved.
            </div>
        </div>
        
    </div> 
    <script>
        $().ready(function(){
            var height = $(window).height() + "px";
            $('.login_main').css('height', height);
        });
        
    </script>
    
</body>
</html>