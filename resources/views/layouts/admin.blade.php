<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B"
        crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js" integrity="sha384-o+RDsa0aLu++PJvFqy8fFScvbHFLtbvScb8AjopnFD+iEQ7wo/CG0xlczd+2O/em"
        crossorigin="anonymous"></script>
    <title>GLA Inventory Website Admin</title>
    <style>
        .name{

        }
        .body{
            margin: 30px 0;
        }
        .footer{
            background-color: #666666;
            color: white;
        }
        .gloable_nav{
            background-color:#666666;
            color: white;
        }
        .golden_nav
        {
            background-color: #666666;
        }
        .nav-link{
            color: white;
        }
        .nav-link:hover{
            color: yellow;
        }
        .active{
            background-color: #8e8e8e !important;
            color: yellow !important;
            
        }
    </style>

</head>

<body>
    <div id="admin_app">
        <div class="gloable_nav" >
            <nav class="navbar navbar-expand-sm navbar-light container">
                
                <div class="navbar-header col-sm-6" >
                    <a class="navbar-brand" href="{{ url('/') }}" target="_blank">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>
                
                
                <!-- Right Side Of Navbar -->
                <div class="name col-sm-6 text-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <span><a href="{{ route('login') }}">Login</a></span>
                        <span><a href="{{ route('register') }}">Register</a></span>
                    @else
                        <span>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                Logout
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </a>
                        </span>
                    @endif
                </div>
                
            </nav>
        </div>
        <div class="body ">
            <div class="container">
                <div class="row">
                    <div class="col-sm-3 golden_nav" style='padding:0'>
                        <div class="nav flex-column nav-pills" role="tablist" aria-orientation="vertical">
                            <a class="nav-link active" id="home"   href="/home" role="tab">Home | {{Auth::user()->name}}</a>
                            <a class="nav-link" id=""   href="#v" role="tab">Dealer Managenment</a>
                            <a class="nav-link" id=""   href="#v" role="tab">Add New Dealer</a>
                            <a class="nav-link" id=""   href="#v" role="tab">Dealer Order History</a>
                            <a class="nav-link" id=""   href="#v" role="tab">Download Dealer Info</a>

                            <a class="nav-link" id=""   href="" role="tab">Member Managenment</a>
                            <a class="nav-link" id=""   href="#v" role="tab">Member List - Canada</a>
                            <a class="nav-link" id=""   href="#v" role="tab">Member List - USA</a>

                            <a class="nav-link" id=""   href="#v" role="tab">Sales Records - CA</a>
                            <a class="nav-link" id=""   href="#v" role="tab">Order History</a>
                            <a class="nav-link" id=""   href="" role="tab">Pending Quotes (0)</a>
                            <a class="nav-link" id=""   href="#v" role="tab">Awaits Reply (0)</a>
                            <a class="nav-link" id=""   href="#v" role="tab">Confirm Shipment (0)</a>
                            <a class="nav-link" id="top10"   href="/top10">Top 10 Best Sellers</a>

                            <a class="nav-link" id=""   href="#v" role="tab">Sales Records - US</a>
                            <a class="nav-link" id=""   href="#v" role="tab">Order History</a>
                            <a class="nav-link" id=""   href="#v" role="tab">Pending Quotes (0)</a>
                            <a class="nav-link" id=""   href="" role="tab">Awaits Reply (0)</a>
                            <a class="nav-link" id=""   href="#v" role="tab">Awaits Reply (0)</a>
                            <a class="nav-link" id=""   href="#v" role="tab">Confirm Shipment (0)</a>

                            <a class="nav-link" id=""   href="#v" role="tab">Website Managenment</a>
                            <a class="nav-link" id=""   href="#v" role="tab">Update Feature Products</a>
                            <a class="nav-link" id=""   href="#v" role="tab">Broadcasting Email</a>

                            <a class="nav-link" id=""   href="#v" role="tab">Account Details</a>
                            <a class="nav-link" id="v-home"   href="" role="tab">Edit Profile</a>
                            <a class="nav-link" id=""   href="#v" role="tab">Change Password</a>
                        </div>
                    </div>
            
                    <div class="col-sm-9" >
                        @yield('content')
                    </div>   
                </div>
            </div>
        </div>
    </div>
    <footer class="footer">
        <div class="container">
            <b>©Golden Leaf Automotive Inc.. All rights reserved.<br>
                All data listed here are confidential. Do not Share the information without consent. Developed by </b><b style='color:#FFBA00'>Visual Elements Image Studio Inc.</b>
        </div>
    </footer>
    <!-- Scripts -->
<script>
    
</script>
</body>

</html>