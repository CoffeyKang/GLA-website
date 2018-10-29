<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="http://www.goldenleafautomotive.com/favicon.ico" type="image/x-icon">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="author" content="Visual Elements Images Studio Inc. www.velements.com" />
        <META NAME="description" CONTENT="Golden Leaf Automotive is the Canadian based extension of Dynacorn International Inc. For over 18 years DII has been producing all the hard to find parts for your classic cars. Because of the abilities of our manufacturing facilities, our product development is without peer in the classic car industry. 
        Service is our number one goal. With over 100 dealers across Canada and continually growing. Our ability to serve you is only matched by the quality of our products." />
        <META NAME="keywords" CONTENT="GLA,Golden Leaf Automotive,DII,Dynacorn International Inc.,classic car parts,muscle cars parts,parts developer and manufacturer,car parts and molding,canadian based" />
        <title>{{ config('app.name')}}</title>
        <link rel="stylesheet" href="{{asset('/css/app.css')}}">
        <link rel="stylesheet" href="{{asset('/css/main.css')}}">
        {{-- google captcha --}}
        
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">

        {{-- checkout payment --}}
        <script src='https://libs.na.bambora.com/customcheckout/1/customcheckout.js'></script>

        <script src='https://libs.na.bambora.com/customcheckout/1/customcheckout.js'></script>
        
        

        <style>
            *{
                font-family: Arial, Helvetica, sans-serif;
                
            }
            /* .el-step__head.is-success{ color: yellow !important; border-color: yellow !important; }
            .el-step__title.is-success{ color: yellow !important } */
        </style>

        <script>
            var loadCaptcha = function() {   
                captchaContainer = grecaptcha.render('myCaptcha', {
                    'sitekey' : '{{env("CAPTCHA_SITE_KEY")}}',
                    // 'sitekey' : '6LfNO3QUAAAAANDNGpUMsEachCebsRdXCF76NtBl',
                    'theme':'dark',
                    'callback' : function(response) { 
                        console.log(response); 
                        window.localStorage.setItem('captcha',response);
                    },
                });
            };
        </script>
    </head>
    <body>
        <div id="app"> 
            
        </div>
        
    </body>
    
    <script src="{{ asset('js/app.js') }}"></script>
    
        
</html>

