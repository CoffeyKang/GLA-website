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
            margin:auto;
            text-align: center;
            font-family: Arial,sans-serif;
        }
        .body{
            margin: auto;
            text-align: center;
            width: 600px;
        }

        .content{
            text-align: left !important;
            padding: 50px 0;
            
        }
        .text-right{ text-align: right; } .text-left{ text-align: left; }

        .footer{
            width:600px;
            padding: 10px 0;
            background-color: #FFE512;
            font-size: 12px;
            text-align: center;
        }
        .hi{
            font-size: 150%;
            color: #1d4077;
        }
        .headerNav{ font-size: 20px; color: #1d4077; font-weight: 700; border-bottom:1px solid black; } .headerNav a{ color: #1d4077;
        } .headerNav a:hover{ text-decoration: none; }
        a{
            text-decoration: none;
        }
    </style>
</head>
<body>
    
    <table class='body'>
        <tr>
            <td class='text-left'><img src="https://www.goldenleafautomotive.com/images/header_logo.png" alt="" width="80%;"></td>
            <td class='text-right'> <span class='headerNav'>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="https://www.goldenleafautomotive.com/#/CustomerInfo/HomePage">Your Account</a></span></td>
        </tr>
        
        <tr class='content'>
            <td colspan=2 style='padding-top:30px'><span class='hi'>Hi {{$user->firstname}},</span><br>
            <p>Your Account {{ $user->email }} has been set up.</p>
            <p>You can always log in to your account to check your order status and update your personal information.</p>
            <p>If you have any questions, please feel free to contact us.<br><br></p></td>
        </tr>
        
        <tr>
            <td class='footer' colspan=2  >170 Zenway Blvd. Unit 2, Woodbridge, ON., L4H 2Y7 CANADA | 905-850-3433<br>
            &copy; {{date("Y")}} Golden Leaf Automotive. All rights reserved.</td>
        </tr>
    </table>

</body>
</html>