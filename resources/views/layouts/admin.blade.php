<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
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
        *{
            text-transform:uppercase;
        }
        .name{

        }
        .body{
            margin: 20px;
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
            color: #FFE512;
        }
        .active{
            background-color: #8e8e8e !important;
            color: #FFE512 !important;
        }
    </style>

    <script>
        $().ready(function(){
            var h = $(window).height()-160;
            $('.body').css('min-height',h+"px");
        });


    </script>

</head>

<body>
    <div id="admin_app">
        <div class="gloable_nav" >
            <nav class="navbar navbar-expand-sm navbar-light">
                
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
            <div class="">
                <div class="row">
                    <div class="col-sm-2 golden_nav" style='padding:0'>
                        <div class="nav flex-column nav-pills" role="tablist" aria-orientation="vertical">
                            <a class="nav-link active" id="home"   href="/home" role="tab">Admin Home | {{Auth::user()->name}} </a>
                            <a class="nav-link" id="" href="#v" role="tab" aria-disabled="true"><b>Dealer Managenment</b></a>
                            <a class="nav-link" id="dealerList" href="/dealerList" role="tab">Dealer List</a>
                            <a class="nav-link" id="newDealer" href="/newDealer" role="tab">Add New Dealer</a>
                            <a class="nav-link" id="recallDealer" href="/recallDealer" role="tab">recall Dealer</a>
                            <a class="nav-link" id="dealerHistory" href="/dealerHistory" role="tab">Dealer Order History</a>
                            <a class="nav-link" id="" href="#v" role="tab" aria-disabled="true"><b>Customer Managenment</b></a>
                            <a class="nav-link" id="customerList"  href="/customerList" role="tab">Customer List </a>
                            <a class="nav-link" id="recallUser" href="/recallUser" role="tab">recall User</a>
                            {{-- <a class="nav-link" id="" href="#v" role="tab">Sales Records</a> --}}
                            <a class="nav-link" id="orderHistory"  href="/orderHistory" role="tab">Order History</a>
                            <a class="nav-link" id="pendingQuotes" href="/pendingShipment" role="tab">
                            Pending Shipment 
                            <span class="badge badge-light float-right">
                                {{count(App\SOMAST::where('sales_status','!=',9)->get())}}
                            </span>
                            </a>

                            <a class="nav-link" id="toBeQuotes" href="/pendingQuotes" role="tab">
                                Pending Quote
                                <span class="badge badge-light float-right">
                                    {{count(App\SOMAST::whereIn('sales_status',[3,5])->get())}}
                                </span>
                            </a>
                            

                            <a class="nav-link" id="" href="#v" role="tab" aria-disabled="true"><b>Website Managenment</b></a>
                            <a class="nav-link" id="top10" href="/top10">Top 10 Best Sellers</a>
                            <a class="nav-link" id="" href="/featureProducts" role="tab">Update Feature Products</a>
                            <a class="nav-link" id="" href="/NewProducts" role="tab">Update New Products</a>
                            <a class="nav-link" id="" href="#v" role="tab">Broadcasting Email</a>
                            <a class="nav-link" id="uploadNewImages" href="/uploadNewImages" role="tab">Upload New Images</a>
                            <a class="nav-link" id="" href="/exchangeRate" role="tab">Change Exchange Rate and Tax</a>
                            {{-- <a class="nav-link" id="" href="#v" role="tab">Account Details</a> --}}
                            {{-- <a class="nav-link" id="updateInfo"  href="/updateInfo" role="tab">Edit Profile</a> --}}
                            {{-- <a class="nav-link" id="uploadCatalog" href="/uploadCatalog" role="tab">UploadCatalog</a> --}}
                            {{-- <a class="nav-link" id="changePassword" href="/changePassword" role="tab">Change Password</a> --}}
                        </div>
                    </div>
            
                    <div class="col-sm-10"  style='min-height:750px;'>
                        @yield('content')
                    </div>   
                </div>
            </div>
        </div>
    </div>
    <footer class="footer pt-3">
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