<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B"
        crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js" integrity="sha384-o+RDsa0aLu++PJvFqy8fFScvbHFLtbvScb8AjopnFD+iEQ7wo/CG0xlczd+2O/em"
        crossorigin="anonymous"></script>
    <title>GLA Inventory Website Admin</title>
    
    <style>
        body{
            margin-top: 100px;
            font-family: Arial, Helvetica, sans-serif;
        }
        .main{
            display: flex;
            flex-direction: column;
            justify-content: space-around;
            
        }
        .header{
            height: 75px;
        }

        .footer{
            height: 75px;
        }
        .content{
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: flex-start;
        }
    </style>
</head>
<body class='container'>
    <div class="main">
        <div class="header">
            <img src="http://retail.goldenleafautomotive.com/images/header_logo.png" alt="">
        </div>
        <div class="content">
        <h3>Dear {{$user->firstname}} {{$user->lastname}}, THANK YOU FOR REGISTERING</h3>
        <p>Your Account {{ $user->email }} has been successfully registrered.
            Thank you for registering to the Oriel Alumni website. You should receive a confirmation email shortly with your user name
            and password reminder. Before you can be given access to the website we need to verify your registration, which can take
            up to 3 working days to process. A notification email will be sent to you once this has been completed. If you need any help
            using the website please email the Development Office or call them on 01865 276599.</p>
        </div>
        <div class="footer text-center" style='text-align:center'>
            Thank you. <br>Golden Leaf Automotive Inc.
        </div>
    </div>
    <script>
        $().ready(function(){
            var h = $(window).height()-200;
            $('.main').css('height',h+"px");
            $('.content').css('height',(h-150)+"px");
        });
    </script>
</body>
</html>