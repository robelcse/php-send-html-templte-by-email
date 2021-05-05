<?php ob_start(); ?>
<?php
include 'payment/class/Paypal.php';
include 'payment/class/Westernunion.php';

// Paypal information read from database
$paypal = new Paypal();
$paypal_data = $paypal->readDatafrompaypal();
//var_dump($paypal_data);

// Western union information read from databse
$wu = new Westernunion();
$wu_data = $wu->readDatafromwu();
//var_dump($wu_data);
?>

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require 'vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;

$lineItem = "Spouseware™ Online Pack";
$price = 300;
$deposit = 100;
$btccoin = file_get_contents("https://blockchain.info/tobtc?currency=USD&value=300");

if (isset($_GET['package'])) {
    $package = $_GET['package'];

    if($package==1) {
        $lineItem = "Spouseware™ Online Pack";
        $subject = "Spouseware™ Online Pack";
        $price = 300;
        $btccoin = file_get_contents("https://blockchain.info/tobtc?currency=USD&value=300");
        $loader = '<div id="loading"><img id="loading-image" class="mx-auto d-block" src="assets/images/online-pack.png" alt="Loading..." width="320" height="300"><div class="progress-bar stripes animated reverse slower"><span class="progress-bar-inner"></span><h4>Preparing your delivery..</h4></div></div>';
    } elseif ($package==2) {
        $lineItem = "Spouseware™ App Pack";
        $subject = "Spouseware™ App Pack";
        $price = 400;
        $btccoin = file_get_contents("https://blockchain.info/tobtc?currency=USD&value=400");
        $loader = '<div id="loading"><img id="loading-image" class="mx-auto d-block" src="assets/images/app-pack.png" alt="Loading..." width="320" height="300"><div class="progress-bar stripes animated reverse slower"><span class="progress-bar-inner"></span><h4>Preparing your delivery..</h4></div></div>';
    } else {
        $lineItem = "Spouseware™ Pro Pack";
        $subject = "Spouseware™ Pro Pack";
        $price = 500;
        $btccoin = file_get_contents("https://blockchain.info/tobtc?currency=USD&value=500");
        $loader = '<div id="loading"><img id="loading-image" class="mx-auto d-block" src="assets/images/pro-pack.png" alt="Loading..." width="320" height="300"><div class="progress-bar stripes animated reverse slower"><span class="progress-bar-inner"></span><h4>Preparing your delivery..</h4></div></div>';
    }
}


if(isset($_POST['download'])){
    $invoice = $_POST['invoice'];
    $dompdf = new Dompdf();
    $html = file_get_contents('https://spouseware.net/invoice.php?invoice_no='.$invoice.'&package='.$package);
    $dompdf->loadHtml($html);
    $dompdf->set_paper('a4','landscape');
    $dompdf->set_option('isHtml5ParserEnabled', true);
    $dompdf->set_option('isRemoteEnabled', true);
    $dompdf->render();
    $dompdf->stream("dompdf_out.pdf", array("Attachment" => false));
    //$dompdf->stream();
    exit(0);
}
?>





 

<?php


   
include 'class/mail.php';


if($_SERVER['REQUEST_METHOD']=='POST'){

         
            $email        = $_POST['email'];
            $price        = $_POST['price'];
            $subtotal     = $_POST['subtotal'];
            $total        = $_POST['total'];
            $deposit      = $_POST['deposit'];
            $payafterwork = $_POST['payafterwork'];
            $package      = $_POST['package'];
            $subject      = $_POST['subject']; 
            $invoice_no   = $_POST['invoice_no'];
            
            
            
            if(empty($email)){
                
                $url  = $_SERVER['REQUEST_URI']; 
                header('Location: '.$url);
               
            }else{
                
                $email = filter_var($email, FILTER_SANITIZE_EMAIL);
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $mail = new Mail($email, $price, $subtotal, $total, $deposit, $payafterwork, $package, $subject, $invoice_no);
                } else {
                    $url  = $_SERVER['REQUEST_URI']; 
                    header('Location: '.$url);
                }
            }
            
        
} 



?>


<?php


            $price = $price;
            $subtotal = $price;
            $total = $price;
            $deposit = $deposit;
            $payafterwork = ($price-$deposit);
            $package = $package;
            $subject =$subject;
            $invoice_no = date("Ymds").rand(11, 999); 
              


?>

 

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" lang="en" data-clp="clp-active">



<head>
    <meta charset="utf-8">
    <title>Payment Instructions - Spouseware™</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <meta name="description" content="protect your children, family by tracking their cell phone remotely. check their social media activity, gps location, camera etc etc">
    <meta name="keywords" content="get password of fb, get password of ig, login any fb anonymously, track family spouse phone, camera spy app, monitor iphone, spy phone app, iphone spy app, phone monitoring app, best phone monitoring app">
    <meta name="author" content="Spouseware™">
    <link rel="canonical" href="https://spouseware.net/payment.php" />
    <link rel="alternate" hreflang="en" href="https://spouseware.net/payment.php">

    <!-- Spouseware Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="assets/images/icons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/images/icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/icons/favicon-16x16.png">
    <link rel="manifest" href="assets/images/icons/site.webmanifest">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i&display=swap&subset=cyrillic" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
    <link rel="canonical" href="payment.php" />
    <script asyn src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    
    
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-180445870-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-180445870-1');
      gtag('config', 'AW-465171032');
    </script>
    
    <!-- Facebook Pixel Code -->
    <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '3765326700254178');
    fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=3765326700254178&ev=PageView&noscript=1"
    /></noscript>
    <!-- End Facebook Pixel Code -->
    
    <!-- Event snippet for SW Payment Page view conversion page -->
    <script>
      gtag('event', 'conversion', {'send_to': 'AW-465171032/Oe9LCLewofoBENjk590B'});
    </script>

    <style type="text/css">
        #loading {
            width: 100%;
            height: 100%;
            margin: 0 auto;
            top: 0;
            position: fixed;
            display: block;
            background-color: #333;
            z-index: 99;
            text-align: center;
        }
        #loading-image {
            position: relative;
            margin: 0 auto;
            top: 3%;
            z-index: 100;
        }
        #loading .progress-bar {
            margin-top: 20px;
        }
        #loading .form-inline {
            width: 50%;
            margin: 0 auto;
            
        }
        @keyframes animate-stripes {
            0% {
                background-position: 0 0;
            }
        
            100% {
                background-position: 60px 0;
            }
        }
        
        @keyframes auto-progress {
          0% {
            width: 0%;
          }
        
          100% {
            width: 100%;
          }
        }
        
        .progress-bar {
            background-color: #7cb937;
            height: 45px;
            margin: 0px auto;
            border-radius: 5px;
            box-shadow: 0 1px 5px #000 inset, 0 1px 0 #7cb937;
        }
        
        .stripes {
            background-size: 30px 30px;
            background-image: linear-gradient(
                135deg,
                rgba(124,185,55, .15) 25%,
                transparent 25%,
                transparent 50%,
                rgba(124,185,55, .15) 50%,
                rgba(124,185,55, .15) 75%,
                transparent 75%,
                transparent
            );
        }
        
        .stripes.animated {
            animation: animate-stripes 0.6s linear infinite;
        }
        
        .stripes.animated.slower {
            animation-duration: 1.25s;
        }
        
        .stripes.reverse {
            animation-direction: reverse;
        }
        
        .progress-bar-inner {
            display: block;
            height: 45px;
            width: 0%;
            background-color: #7cb937;
            border-radius: 3px;
            box-shadow: 0 1px 0 rgba(124,185,55, .5) inset;
            position: relative;
            animation: auto-progress 10s infinite linear;
        }
        @media (min-width:576px) {
            .progress-bar {
                width: 30%;
            }
            #loading .form-inline {
                width: 30%;
                margin: 20px auto;
            }
            .payment-table .pay-now {
                width: 40%;
            }
        }
        
        
        
        /******css code for email subscribe******/
        
        @media screen and (max-width: 767px) and (min-width: 200px) {
            
            .subscribe-form{
                width: 90%!important;
                margin: 20px auto!important;
                
            }
            .frm-group{
                
                width: 100%;
                display: flex!important;
            }
            .subscribe-form input[type='email']{
                
                width: 70%;
                float: left;
                height: 40px;
                border-radius: 0;
                padding: 15px;
                outline: 0;
            }
            
            .subscribe-form button{
                
                width: 30%;
                float: right;
                height: 40px;
                border-radius: 0;
                outline: 0;
                font-size: 18px;
                text-transform: uppercase;
                background: #7cb937;
                border: #7cb937;
            }
            
            .subscribe-form button:hover, .subscribe-form button:active{
                
                background: #7cb937;
                border: #7cb937;
            }
        }
        
        @media screen and (max-width: 850px) and (min-width: 767px) {
             
            .subscribe-form{
                width: 30%!important;
                margin: 20px auto!important;
                
            }
            .frm-group{
                
                width: 100%;
                display: flex!important;
            }
            .subscribe-form input[type='email']{
                
                width: 70%;
                float: left;
                height: 40px;
                border-radius: 0;
                padding: 15px;
                outline: 0;
            }
            
            .subscribe-form button{
                
                width: 30%;
                float: right;
                height: 40px;
                border-radius: 0;
                outline: 0;
                font-size: 18px;
                text-transform: uppercase;
                background: #7cb937;
                border: #7cb937;
            }
            
            .subscribe-form button:hover, .subscribe-form button:active{
                
                background: #7cb937;
                border: #7cb937;
            }
        }
        @media screen and (max-width: 950px) and (min-width: 850px) {
            
            .subscribe-form{
                width: 30%!important;
                margin: 20px auto!important;
                
            }
            .frm-group{
                
                width: 100%;
                display: flex!important;
            }
            .subscribe-form input[type='email']{
                
                width: 70%;
                float: left;
                height: 40px;
                border-radius: 0;
                padding: 15px;
                outline: 0;
            }
            
            .subscribe-form button{
                
                width: 30%;
                float: right;
                height: 40px;
                border-radius: 0;
                outline: 0;
                font-size: 18px;
                text-transform: uppercase;
                background: #7cb937;
                border: #7cb937;
            }
            
            .subscribe-form button:hover, .subscribe-form button:active{
                
                background: #7cb937;
                border: #7cb937;
            }
        }
        @media screen and (max-width: 1050px) and (min-width: 950px) {
            
            .subscribe-form{
                width: 30%!important;
                margin: 20px auto!important;
                
            }
            .frm-group{
                
                width: 100%;
                display: flex!important;
            }
            .subscribe-form input[type='email']{
                
                width: 70%;
                float: left;
                height: 40px;
                border-radius: 0;
                padding: 15px;
                outline: 0;
            }
            
            .subscribe-form button{
                
                width: 30%;
                float: right;
                height: 40px;
                border-radius: 0;
                outline: 0;
                font-size: 18px;
                text-transform: uppercase;
                background: #7cb937;
                border: #7cb937;
            }
            
            .subscribe-form button:hover, .subscribe-form button:active{
                
                background: #7cb937;
                border: #7cb937;
            }
        }
        @media screen and (max-width: 1150px) and (min-width: 1050px) {
            
            .subscribe-form{
                width: 30%!important;
                margin: 20px auto!important;
                
            }
            .frm-group{
                
                width: 100%;
                display: flex!important;
            }
            .subscribe-form input[type='email']{
                
                width: 70%;
                float: left;
                height: 40px;
                border-radius: 0;
                padding: 15px;
                outline: 0;
            }
            
            .subscribe-form button{
                
                width: 30%;
                float: right;
                height: 40px;
                border-radius: 0;
                outline: 0;
                font-size: 18px;
                text-transform: uppercase;
                background: #7cb937;
                border: #7cb937;
            }
            
            .subscribe-form button:hover, .subscribe-form button:active{
                
                background: #7cb937;
                border: #7cb937;
            }
        }
        @media screen and (max-width: 1250px) and (min-width: 1150px) {
            
            .subscribe-form{
                width: 30%!important;
                margin: 20px auto!important;
                
            }
            .frm-group{
                
                width: 100%;
                display: flex!important;
            }
            .subscribe-form input[type='email']{
                
                width: 70%;
                float: left;
                height: 40px;
                border-radius: 0;
                padding: 15px;
                outline: 0;
            }
            
            .subscribe-form button{
                
                width: 30%;
                float: right;
                height: 40px;
                border-radius: 0;
                outline: 0;
                font-size: 18px;
                text-transform: uppercase;
                background: #7cb937;
                border: #7cb937;
            }
            
            .subscribe-form button:hover, .subscribe-form button:active{
                
                background: #7cb937;
                border: #7cb937;
            }
        }
        @media (min-width:1250px){
            
            .subscribe-form{
                width: 30%!important;
                margin: 20px auto!important;
                
            }
            .frm-group{
                
                width: 100%;
                display: flex!important;
            }
            .subscribe-form input[type='email']{
                
                width: 70%;
                float: left;
                height: 40px;
                border-radius: 0;
                padding: 15px;
                outline: 0;
            }
            
            .subscribe-form button{
                
                width: 30%;
                float: right;
                height: 40px;
                border-radius: 0;
                outline: 0;
                font-size: 18px;
                text-transform: uppercase;
                background: #7cb937;
                border: #7cb937;
            }
            
            .subscribe-form button:hover, .subscribe-form button:active{
                
                background: #7cb937;
                border: #7cb937;
            }
           
        }
         
        
        /******************end******************/
        
        .loadingdiv{
            
              display: none!important;
        }
        
        
        .show-modal{
            
             padding-right: 16px; 
             display: block!important;
        }
        
        
        .modal {
            position: fixed;
            top: 20%!important;
            left: 0;
            z-index: 1050;
            display: none;
            width: 100%;
            height: 100%;
            overflow: hidden;
            outline: 0;
        }
        
    </style>

</head>

<body data-page-name='payment_page' class='payment-page ' data-country="GB">
    
    <div id="loading">
        
        <?php
        
              if($package==1) {
        ?>
             <img id="loading-image" class="mx-auto d-block" src="assets/images/online-pack.png" alt="Loading..." width="320" height="300">
        
        <?php }elseif($package==2){ ?>
        
             <img id="loading-image" class="mx-auto d-block" src="assets/images/app-pack.png" alt="Loading..." width="320" height="300">
        
         <?php }elseif($package==3){ ?>
            
            <img id="loading-image" class="mx-auto d-block" src="assets/images/pro-pack.png" alt="Loading..." width="320" height="300">
            
         <?php } ?>
        <div class="progress-bar stripes animated reverse slower">
            <span class="progress-bar-inner"></span>
            <h4>Preparing your delivery..</h4>
        </div>
        <form class="form-inline subscribe-form" id="myForm" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
            <div class="form-group frm-group">
                <input type="email" class="form-control" id="email" placeholder="Enter your valid email" name="email">
                <input type="hidden" class="form-control" id="price" name="price" value="<?php echo $price; ?>">
                <input type="hidden" class="form-control" id="subtotal" name="subtotal" value="<?php echo $price; ?>">
                <input type="hidden" class="form-control" id="total" name="total" value="<?php echo $price; ?>">
                <input type="hidden" class="form-control" id="deposit" name="deposit" value="<?php echo $deposit; ?>">
                <input type="hidden" class="form-control" id="payafterwork" name="payafterwork" value="<?php echo $price; ?>">
                <input type="hidden" class="form-control" id="package" name="package" value="<?php echo $package; ?>">
                <input type="hidden" class="form-control" id="subject" name="subject" value="<?php echo $subject; ?>">
                <input type="hidden" class="form-control" id="invoice_no" name="invoice_no" value="<?php echo $invoice_no; ?>">
                <button type="submit" class="btn btn-primary" id="submitbtn">Next</button>
            </div>
            
            <p style='color: red;font-size: 18px;text-align: center;margin: 5px auto;' id='errorMsg'></p>
            
        </form>
    </div>
    
    
    <?php //echo $loader; ?>


    <header data-button-translate="BUY NOW" style="background: black">
        <div class="wr wr-flex wr-flex-center wr-flex-space-between">
            <div class="l-side" style="height: 60px;">
                <a href="https://www.spouseware.net" class="logo-box" data-ga-event="onClick" data-ga-group="Menu Top" data-ga-details="https://spouseware.net/">
                    <img src="logo.png" width="50" alt="spouseware" title="Spouseware™">
                </a>

                <div class="mobile-menu">
                    <nav class="nav-main" style="margin: 14px 0 0 20px;">
                        <div class="mobile-menu__info"></div>

                        <ul>
                            <li>
                                <a href="index.php#features" class="scroll" style="color:white"><span>features</span></a>
                            </li>
                            <li>
                                <a href="index.php#how-it-works" class="scroll"  style="color:white"><span>how it works</span></a>
                            </li>
                            <li>
                                <a href="index.php#price" class="scroll"  style="color:white"><span>price</span></a>
                            </li>
                        </ul>
                    </nav>
                </div>

                <div class="language-select">
                    <div class="language-select-button">
                        <svg>
                            <use xlink:href="flags.svg#icon-en"></use>
                        </svg>
                    </div>
    
                    <ul class="language-select-wr">
                        <li>
                            <a href="https://www.spouseware.net/cn/" data-site-protocol="https" data-site-domain="www.spouseware.net" data-site-page="/" data-ga-event="onClick" data-ga-group="Language Switch" data-ga-details="ja" class="change-language">
                                <svg id="Layer_1" height="512" viewBox="0 0 128 128" width="512" xmlns="http://www.w3.org/2000/svg" data-name="Layer 1"><path d="m12 27.751h104v72.497h-104z" fill="#d60a2e"/><g fill="#fed953"><path d="m29.33 40.976 3.645 7.386 8.15 1.184-5.898 5.749 1.393 8.118-7.29-3.833-7.291 3.833 1.393-8.118-5.898-5.749 8.15-1.184z"/><path d="m50.92 55.152 1.457 2.951 3.257.473-2.357 2.298.556 3.243-2.913-1.531-2.913 1.531.556-3.243-2.356-2.298 3.257-.473z"/><path d="m49.196 42.248 2.662 1.936 3.103-1.095-1.019 3.13 2.001 2.613-3.291-.002-1.868 2.71-1.015-3.131-3.154-.938 2.663-1.933z"/><path d="m44.927 33.343-.622 3.232 2.31 2.345-3.266.407-1.516 2.921-1.396-2.98-3.247-.54 2.403-2.249-.491-3.254 2.882 1.59z"/><path d="m44.927 66.456-.622 3.232 2.31 2.344-3.266.407-1.516 2.921-1.396-2.98-3.247-.539 2.403-2.249-.491-3.254 2.882 1.59z"/></g></svg>Chinese
                            </a>
                        </li>
                        <li>
                            <a href="https://www.spouseware.net/jp/" data-site-protocol="https" data-site-domain="www.spouseware.net" data-site-page="/" data-ga-event="onClick" data-ga-group="Language Switch" data-ga-details="ja" class="change-language">
                                <svg>
                                    <use xlink:href="flags.svg#icon-ja"></use>
                                </svg>Japanese
                            </a>
                        </li>
                        <li>
                            <a href="https://www.spouseware.net/kr/" data-site-protocol="https" data-site-domain="www.spouseware.net" data-site-page="/" data-ga-event="onClick" data-ga-group="Language Switch" data-ga-details="ko" class="change-language">
                                <svg>
                                    <use xlink:href="flags.svg#icon-ko"></use>
                                </svg>Korean
                            </a>
                        </li>
                    </ul>
                </div>

                <a href="index.php#price" class="scroll buy-now-button buy-now-button--header" style="background: #7cb937;color:white">
                    <div class="span">
                        Buy Now
                    </div>
                </a>
            </div>
            <div class="main-menu-button"><i></i><i></i><i></i></div>
        </div>

        <div class="scroll-up">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" viewBox="0 0 46.001 46.001">
                <path d="M5.906 34.998a3.484 3.484 0 01-4.893 0 3.404 3.404 0 010-4.846l19.54-19.148a3.486 3.486 0 014.895 0l19.539 19.148a3.402 3.402 0 010 4.846 3.484 3.484 0 01-4.893 0L23 19.295 5.906 34.998z" fill="#fff" />
            </svg>
        </div>
    </header>

    <section id="printdata" class="payment-wrapper">
        <style type="text/css">
            /*.payment-wrapper .payment-header {*/
            /*    margin-bottom: 50px;*/
            /*}*/
            /*.payment-wrapper .payment-table {*/
            /*    margin-bottom: 15px;*/
            /*}*/
            /*.payment-wrapper .payment-instruction .footer-instruction {*/
            /*    margin-top: 50px;*/
            /*}*/
            thead, tfoot tr.deposit {
                color: #89b82a;
            }
            .checked {
                color: #89b929;
            }
            .card {
                border: 1px solid #89b929;
            }
        </style>
        
        
        
        
        <style type="text/css">
        
            @media (max-width:250px){
                
                .payment-header{}
                .payment-row{}
                .payment-single-col{}
                .payment-single-col p{
                    
                    margin-top:0;margin-bottom:0;
                }
                .payment-single-col img{}
            }
            @media screen and (max-width: 300px) and (min-width: 250px) {
                
                .payment-header{
                    
                    margin-bottom: 50px;
                    max-width: 1140px;
                    margin: 0px auto 50px auto;
                    background: #f8f9fa;
                    padding: 20px 15px;
                    
                }
                .payment-row{
                    
                    display:flex;
                }
                .payment-single-col{
                    
                    width: 100%;
                    margin: auto;
                    text-align: center;
                    margin-bottom: 25px;
                }
                .payment-single-col p{
                    
                    margin-top:0;margin-bottom:0;
                }
                .payment-single-col p a{
                    
                    text-decoration:none;
                }
                .payment-single-col img{}
            }
            @media screen and (max-width: 400px) and (min-width: 300px) {
                
                .payment-header{
                    
                    margin-bottom: 50px;
                    max-width: 1140px;
                    margin: 0px auto 50px auto;
                    background: #f8f9fa;
                    padding: 20px 15px;
                }
                .payment-row{
                    
                    display:flex;
                }
                .payment-single-col{
                    
                    width: 100%;
                    margin:auto;
                    text-align:center;
                    margin-bottom: 25px;
                }
                .payment-single-col p{
                    
                    margin-top:0;margin-bottom:0;
                }
                .payment-single-col p a{
                    
                    text-decoration:none;
                }
                .payment-single-col img{}
            }
            @media screen and (max-width: 500px) and (min-width: 400px) {
                
                 .payment-header{
                    
                    margin-bottom: 50px;
                    max-width: 1140px;
                    margin: 0px auto 50px auto;
                    background: #f8f9fa;
                    padding: 20px 15px;
                }
                .payment-row{
                    
                    display:flex;
                }
                .payment-single-col{
                    
                    width: 100%;
                    margin:auto;
                    text-align:center;
                    margin-bottom: 25px;
                }
                .payment-single-col p{
                    
                    margin-top:0;margin-bottom:0;
                }
                .payment-single-col p a{
                    
                    text-decoration:none;
                }
                .payment-single-col img{}
            }
            @media screen and (max-width: 600px) and (min-width: 500px) {
                
                 .payment-header{
                    
                    margin-bottom: 50px;
                    max-width: 1140px;
                    margin: 0px auto 50px auto;
                    background: #f8f9fa;
                    padding: 20px 15px;
                }
                .payment-row{
                    
                    display:flex;
                }
                .payment-single-col{
                    
                    width: 100%;
                    margin:auto;
                    text-align:center;
                    margin-bottom: 25px;
                }
                .payment-single-col p{
                    
                    margin-top:0;margin-bottom:0;
                }
                .payment-single-col p a{
                    
                    text-decoration:none;
                }
                .payment-single-col img{}
            }
            @media screen and (max-width: 700px) and (min-width: 600px) {
                
                .payment-header{
                    
                    margin-bottom: 50px;
                    max-width: 1140px;
                    margin: 0px auto 50px auto;
                    background: #f8f9fa;
                    padding: 20px 15px;
                    
                }
                .payment-row{
                    
                    display:flex;
                }
                .payment-single-col{
                    
                    width: 31%;
                    margin:auto;
                    text-align:center;
                    margin-bottom: 25px;
                }
                .payment-single-col p{
                    
                    margin-top:0;margin-bottom:0;
                }
                .payment-single-col p a{
                    
                    text-decoration:none;
                }
                .payment-single-col img{}
            }
            @media screen and (max-width: 800px) and (min-width: 700px) {
                
                .payment-header{
                    
                    margin-bottom: 50px;
                    max-width: 1140px;
                    margin: 0px auto 50px auto;
                    background: #f8f9fa;
                    padding: 20px 15px;
                     
                }
                .payment-row{
                    
                    display:flex;
                }
                .payment-single-col{
                    
                    width: 31%;
                    margin:auto;
                    text-align:center;
                    margin-bottom: 25px;
                     
                }
                .payment-single-col p{
                    
                    margin-top:0;margin-bottom:0;
                }
                .payment-single-col p a{
                    
                    text-decoration:none;
                }
                .payment-single-col img{}
            }
            @media screen and (max-width: 900px) and (min-width: 800px) {
                
                .payment-header{
                    
                    margin-bottom: 50px;
                    max-width: 1140px;
                    margin: 0px auto 50px auto;
                    background: #f8f9fa;
                    padding: 20px 15px;
                    display:flex;
                }
                .payment-row{
                    
                    display:flex;
                }
                .payment-single-col{
                    
                    width: 31%;
                    margin:auto;
                    text-align:center;
                    
                }
                .payment-single-col p{
                    
                    margin-top:0;margin-bottom:0;
                }
                .payment-single-col p a{
                    
                    text-decoration:none;
                }
                .payment-single-col img{}
            }
            @media screen and (max-width: 1000px) and (min-width: 900px) {
                
                .payment-header{
                    
                    margin-bottom: 50px;
                    max-width: 1140px;
                    margin: 0px auto 50px auto;
                    background: #f8f9fa;
                    padding: 20px 15px;
                    display:flex;
                }
                .payment-row{
                    
                    display:flex;
                }
                .payment-single-col{
                    
                    width: 31%;
                    margin:auto;
                    text-align:center;
                    
                }
                .payment-single-col p{
                    
                    
                    margin-top:0;margin-bottom:0;
                }
                .payment-single-col p a{
                    
                    text-decoration:none;
                }
                .payment-single-col img{}
            }
            @media screen and (max-width: 1100px) and (min-width: 1000px) {
                
                .payment-header{
                    
                    margin-bottom: 50px;
                    max-width: 1140px;
                    margin: 0px auto 50px auto;
                    background: #f8f9fa;
                    padding: 20px 15px;
                    display:flex;
                }
                .payment-row{
                    
                    display:flex;
                }
                .payment-single-col{
                    
                    width: 31%;
                    margin:auto;
                    text-align:center;
                }
                .payment-single-col p{
                    
                    margin-top:0;margin-bottom:0;
                }
                .payment-single-col p a{
                    
                    text-decoration:none;
                }
                .payment-single-col img{}
            }
            @media screen and (max-width: 1200px) and (min-width: 1100px) {
                
                .payment-header{
                    
                    margin-bottom: 50px;
                    max-width: 1140px;
                    margin: 0px auto 50px auto;
                    background: #f8f9fa;
                    padding: 20px 15px;
                    display:flex;
                }
                .payment-row{
                    
                    display:flex;
                }
                .payment-single-col{
                    
                    width: 31%;
                    margin:auto;
                    text-align:center;
                }
                .payment-single-col p{
                    
                    margin-top:0;margin-bottom:0;
                }
                .payment-single-col p a{
                    
                    text-decoration:none;
                }
                .payment-single-col img{}
            }
            @media screen and (max-width: 1300px) and (min-width: 1200px) {
                
                .payment-header{
                    
                    margin-bottom: 50px;
                    max-width: 1140px;
                    margin: 0px auto 50px auto;
                    background: #f8f9fa;
                    padding: 20px 15px;
                    display:flex;
                }
                .payment-row{
                    
                    display:flex;
                }
                .payment-single-col{
                    
                    width: 31%;
                    margin:auto;
                    text-align:center;
                }
                .payment-single-col p{
                    
                    margin-top:0;margin-bottom:0;
                }
                .payment-single-col p a{
                    
                    text-decoration:none;
                }
                .payment-single-col img{}
            }
            @media (min-width:1300px){
                
                .payment-header{
                    
                    margin-bottom: 50px;
                    max-width: 1140px;
                    margin: 0px auto 50px auto;
                    background: #f8f9fa;
                    padding: 20px 15px;
                    display:flex;
                }
                .payment-row{
                    
                    display:flex;
                }
                .payment-single-col{
                    
                    width: 31%;
                    margin:auto;
                    text-align:center;
                }
                .payment-single-col p{
                    
                    margin-top:0;margin-bottom:0;
                }
                .payment-single-col p a{
                    
                    text-decoration:none;
                }
                .payment-single-col img{}
            }
            
        </style>
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css">
        <!--<div class="container payment-header" style="background:#f8f9fa;padding-top:30px;">-->
        <!--    <div class="row payment-row">-->
                
        <!--         <div class="col payment-single-col">-->
        <!--            <img class="d-block m-auto" src="https://spouseware.net/logo.png" width="60" alt="logo" title="Spouseware™">-->
        <!--        </div>-->
        <!--        <div class="col text-center payment-single-col">-->
        <!--            <p style="margin-bottom:0;">Spouseware™Cears<br>Technology Ltd</p>-->
        <!--            <p style="margin-top:0;margin-bottom:0;"><a href="https://www.spouseware.net/" target="_blank">www.spouseware.net</a></p>-->
        <!--            <p style="margin-top:0;margin-bottom:0;"><a style="color:#000000;" href="mailto:support@spouseware.net">support@spouseware.net</a></p>-->
        <!--            <p style="margin-top:0;">ABN: 954 673 652</p>-->
        <!--        </div>-->
        <!--        <div class="col text-center payment-single-col">-->
        <!--            <p><?php echo $invoice_no; ?></p>-->
        <!--            <img width="60" src="payment/img/barcode.png" alt="barcode" title="SW Barcode">-->
        <!--            <p style='margin-top:10px;'><?php echo date('d M, Y'); ?></p>-->
        <!--        </div>-->
               
        <!--    </div>-->
        <!--</div>-->
        
        <!--============================-->
        
       
            <div class='payment-header'>
                 <div class='payment-single-col'>
                    <img class="d-block m-auto" src="https://spouseware.net/logo.png" width="60" alt="logo" title="Spouseware™">
                </div>
                <div class='payment-single-col'>
                    <p>Spouseware™Cears<br>Technology Ltd</p>
                    <p><a href="https://www.spouseware.net/" target="_blank">www.spouseware.net</a></p>
                    <p><a style="color:#000000;" href="mailto:support@spouseware.net">support@spouseware.net</a></p>
                    <p>ABN: 954 673 652</p>
                </div>
                <div class='payment-single-col'>
                    <p><?php echo $invoice_no; ?></p>
                    <img width="60" src="payment/img/barcode.png" alt="barcode" title="SW Barcode">
                    <p style='margin-top:10px;'><?php echo date('d M, Y'); ?></p>
                </div>
               
            </div>
        
        
        <!--============================-->
        
        <div class="container payment-table">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th style="font-size: 20px;"><strong>Line Item</strong></th>
                            <th style="font-size: 20px;"><strong>Qty</strong></th>
                            <th style="font-size: 20px;"><strong>Price</strong></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo $lineItem; ?></td>
                            <td>01</td>
                            <td>$<?php echo $price; ?></td>
                        </tr>
                        <tr>
                            <td>Subtotal</td>
                            <td></td>
                            <td>$<?php echo $price; ?></td>
                        </tr>
                        <tr>
                            <td>VAT</td>
                            <td></td>
                            <td>$0</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th><strong>Total</strong></th>
                            <th></th>
                            <th><strong>$<?php echo $price; ?></strong></th>
                        </tr>
                        <tr class="deposit">
                            <th><strong>Deposit</strong></th>
                            <th></th>
                            <th><strong>$<?php echo $deposit; ?></strong></th>
                        </tr>
                        <tr>
                            <th><strong>Pay after work delivery</strong></th>
                            <th></th>
                            <th><strong>$<?php echo ($price-$deposit) ?></strong></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="pay-now" style="margin: 10px auto; border: 1px solid #7cb937;">
                <h2 style="color: #7cb937;text-align:center;">Pay Now $100</h2>
            </div>
        </div>

        <div class="container payment-instruction">
            <h4>Payment options and  instructions</h4>
            <p>We ensure you pay anonymously and your transaction cannot be traced to Spouseware&trade;. Please pay by card, gift card, Bitcoin, PayPal following the instructions below:</p>
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-header text-center">Option 1: PayPal <img class="mx-auto" src="assets/images/cards.png" width="145" alt="paypal" title="We accept paypal"></div>
                        <div class="card-body">Log in <a href="https://www.xoom.com/" target="_blank">xoom.com</a> with your PayPal login. Click Send Money, Select country Bangladesh, enter <strong>$<?php echo $deposit; ?></strong>, Select Cash Pickup Send to receiver:<br><br>
                        <strong style="font-style: italic">
                            First Name: <?php echo $paypal_data['fname']; ?><br>
                            Last Name: <?php echo $paypal_data['lname']; ?><br>
                            Address: <?php echo $paypal_data['address']; ?><br>
                            District: <?php echo $paypal_data['district']; ?><br>
                            Division: <?php echo $paypal_data['division']; ?><br>
                            Phone: <?php echo $paypal_data['phone']; ?>
                        </strong>
                        <br><br>Forward to <a href="mailto:support@spouseware.net">support@spouseware.net</a> the Xoom transaction confirmation email when ready for pick up.<br><br>
                        <!--<img class="mx-auto d-block" src="assets/images/paypal.png" width="200" alt="paypal" title="We accept paypal">-->
                        <i>Remarks: <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span> Fast, familiar.</i>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card">
                        <div class="card-header text-center">Option 2: Western Union <img class="mx-auto" src="assets/images/wu.png" width="90" alt="bitcoin" title="We accept bitcoin"></div>
                        <div class="card-body">Visit your nearby store at <a href="https://location.westernunion.com/" target="_blank">locations.westernunion.com</a> and send <strong>$<?php echo $deposit; ?></strong> (equivalent BDT) to the receiver: <br><br>
                        <strong style="font-style: italic">
                            Full Name: <?php echo $wu_data['fullname']; ?><br>
                            Address: <?php echo $wu_data['address']; ?><br>
                            City/State: <?php echo $wu_data['state']; ?><br>
                            Postcode: <?php echo $wu_data['postcode']; ?><br>
                            Country: <?php echo $wu_data['country']; ?><br>
                            Tel: <?php echo $wu_data['tel']; ?>
                        </strong><br><br> Send to <a href="mailto:support@spouseware.net">support@spouseware.net</a> a photo of the full receipt. <br><br>
                        <i>Remarks: <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star"></span> Fast but takes 3 to 5 hours.</i>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-header text-center">Option 3: Bitcoin <img class="mx-auto" src="assets/images/bitcoin.png" width="75" alt="bitcoin" title="We accept bitcoin"></div>
                        <div class="card-body">Visit <a href="https://buy.coingate.com/" target="_blank">https://buy.coingate.com</a>, select USD, write <strong>$<?php echo $deposit; ?></strong>, Enter the  Bitcoin address 1McDpMvyztoPG7r154zjFaKQ26yGb8D9fH and Checkout. You may also send from <a href="https://paybis.com/" target="_blank">paybis.com</a>, <a href="http://bitpay.com/" target="_blank">bitpay.com</a> or <a href="https://buy.chainbits.com/" target="_blank">buy.chainbits.com</a> and many other companies. Send a screenshot of the Bitcoin transaction to <a href = "mailto:support@spouseware.net">support@spouseware.net</a><br><br>
                        <img class="mx-auto d-block" src="assets/images/qr-code.png" width="150" alt="qr-code" title="QR Code"><br>
                        <i>Remarks: <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star"></span> Fast but new to some users.</i>
                        </div>
                    </div>
                </div>
                
            </div>

            <div class="row footer-instruction">
                <div class="col-12">
                    <strong>Authorized by:</strong>
                    <p>Payment & Billing Team, Spouseware&trade;<br>Support Contact: support@spouseware.net</p>
                    <span class="float-left">
                        <!--<form method="post" target="_blank">
                            <input name="invoice" type="hidden" value="<?php //echo $invoice_no; ?>">
                            <button name="download" type="submit">Download Invoice</button>
                        </form>-->
                    </span>
                </div>
            </div>
        </div>
    </section>
    
    




<!--===============modal===============-->
<div class="container">

  <!-- The Modal -->
  <div class="modal" id="myModal" aria-modal="true" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title badge badge-success">Success</h4>
              <button type="button" class="close cls" data-dismiss="modal">&times;</button>
            </div>
            
            <!-- Modal body -->
            <div class="modal-body">
             Please check your email, also check spam/junk folder.
            </div>
            
            <!-- Modal footer -->
            <div class="modal-footer">
              <!--<button type="button" class="btn btn-danger cls" data-dismiss="modal">Close</button>-->
            </div>
      </div>
    </div>
  </div>
  
</div>
<!--==========//end modal==============-->

    

    <footer style="background: black;position: absolute;width: 100%;color: white">
        <div class="wr">
            <div class="m-side">
                <div class="col">
                    <ul class="">
                        <li><a href="index.php">Spouseware™</a></li>
                        <li><a href="terms-of-use.html">Terms of Use</a></li>
                        <li><a href="privacy-policy.html">Privacy Policy</a></li>
                        <li><a href="refund-policy.html">Refund Policy</a></li>
                        <li><a href="https://blog.spouseware.net/" target="_blank">Blog</a></li>
                    </ul>
                </div>
                <div class="col">
                    <div class="f-title">
                        Featured On:
                    </div>
                    <ul class="logo-list-2">
                        <li>
                            <a href="https://www.bbc.com/news/technology-50166147" target="_blank">
                                <img class="b-lazy" width="194" height="50" src="bbc.png" data-src="bbc.png" alt="bbc" title="BBC">
                            </a>
                        </li>
                        <li>
                            <a href="https://www.forbes.com/sites/thomasbrewster/2017/02/16/government-iphone-android-spyware-is-the-same-as-seedy-spouseware/#409e4e83455c" target="_blank" rel="nofollow">
                                <img class="b-lazy" width="150" height="100" src="forbes.png" data-src="forbes.png" alt="forbes" title="Forbes" style="max-width: 120px;">
                            </a>
                        </li>
                        <li>
                            <a href="https://finance.yahoo.com/news/stalkerware-technology-made-easy-abusive-200056821.html" target="_blank" rel="nofollow">
                                <img class="b-lazy" width="150" height="100" src="yahoo.png" data-src="yahoo.png" alt="yahoo" title="Yahoo" style="max-width: 120px;">
                            </a>
                        </li>
                        <li>
                            <a href="https://www.trustpilot.com/review/spouseware.net" target="_blank" rel="nofollow">
                                <img class="b-lazy" width="150" height="100" src="assets/images/trustpilot.png" data-src="assets/images/trustpilot.png" alt="trustpilot" title="TrustPilot" style="max-width: 120px;">
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col">
                    <div class="f-title">
                        Social:
                    </div>
                    <ul class="social-links">
                        <li><a href="https://www.facebook.com/spouseware" title="FaceBook" data-ga-event="onClick" data-ga-group="Social" data-ga-details="facebook" target="_blank" rel="nofollow"><i class="fab fa-facebook"></i></a></li>
                        <li><a href="https://www.linkedin.com/company/spouseware/" title="LinkedIn" rel="nofollow" target="_blank" data-ga-event="onClick" data-ga-group="Social" data-ga-details="linkedin"><i class="fab fa-linkedin"></i></a></li>
                        <li><a href="https://twitter.com/spouseware" title="Twitter" rel="nofollow" target="_blank" data-ga-event="onClick" data-ga-group="Social" data-ga-details="twitter"><i class="fab fa-twitter"></i></a></li>
                        <li><a href="https://www.youtube.com/channel/UClZzAwqjcQUiZm1-zw9TVJw" title="YouTube" rel="nofollow" target="_blank" data-ga-event="onClick" data-ga-group="Social" data-ga-details="youtube"><i class="fab fa-youtube"></i></a></li>
                    </ul>
                </div>
            </div>

            <div class="b-side">
                <div class="copyrights">
                    &copy; <?php echo date('Y') ?> <a href="https://spouseware.net/">Spouseware™</a> | All Rights Reserved.<br><br>
                    <p>Support Contact: <a href="mailto:support@spouseware.net">support@spouseware.net</a></p>
                </div>
            </div>
        </div>
    </footer>
    

    

    <script>
        window.localisation = 'GB';
        window.localeLanguage = 'en';
    </script>

    
    <script src="spouseware.js"></script>
    
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
$(document).ready(function(){
    $("#submitbtn").click(function(e){  
        e.preventDefault();
        
        var email = $('#email').val();
        var price = $('#price').val();
        var subtotal = $('#subtotal').val();
        var total = $('#total').val();
        var deposit = $('#deposit').val();
        var paw = $('#payafterwork').val();
        var package = $('#package').val();
        var subject = $('#subject').val();
        var invoice_no = $('#invoice_no').val();
        
        
        var payafterwork = price-deposit;
        
        if(email == ""){
             
              console.log('Please enter your email address!');
              $("#errorMsg").text('Please enter your email!');
              
        }else{
            
           var validEmail = validateEmail(email);
           if(validEmail == false){
               
              console.log('Please enter a valid email address!');
              $("#errorMsg").text('Please enter a valid email address!');
               
           }else{
               
              // console.log('success,this is valid email address',email);
               
                var form = $(this);
                var url = form.attr('action');
                
                $.ajax({
                      type: "POST",
                      url: url,
                      data: { 
                          email : email, 
                          price : price, 
                          subtotal : subtotal, 
                          total : total, 
                          deposit : deposit, 
                          payafterwork : payafterwork, 
                          package : package, 
                          subject : subject, 
                          invoice_no: invoice_no
                           
                      },  
                      success: function(data)
                      {
                          
                          console.log('data passing successfully');
                          $("#errorMsg").hide();
                          $("#loading").addClass("loadingdiv");
                          $(".modal").addClass("show-modal");
                          
                      }
                });
               
           }
            
        }//end else
       
       
    });
});



// function to validate email address

function validateEmail(email) {
    const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}



</script>


<script>
    $(document).ready(function(){
        $(".cls").click(function(){
            $(".modal").removeClass("show-modal");
        });
    });
</script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <script>
        $('.scroll').click(function() {
            if($('.main-menu-button').hasClass('open')) {
                $('.main-menu-button').removeClass('open');
                $('body').removeClass('mobile-menu-open');
            }
        });

        // handle links with @href started with '#' only
        $(document).on('click', '.scroll', function(e) {
            // target element id
            var id = $(this).attr('href');

            // target element
            var $id = $(id);
            if ($id.length === 0) {
                return;
            }

            // prevent standard hash navigation (avoid blinking in IE)
            e.preventDefault();

            // top position relative to the document
            var pos = $id.offset().top;

            // animated top scrolling
            $('body, html').animate({scrollTop: pos});
        });
        
        
        

        // $(window).on('load', function(){
        //     setTimeout(removeLoader, 400); // wait for page load PLUS two seconds.
        // });
        // function removeLoader() {
        //     $( "#loading" ).fadeOut(500, function() {
        //         // fadeOut complete. Remove the loading div
        //         $( "#loading" ).remove(); //makes page more lightweight
        //     });
        // }
        
       
    </script>
    

</body>
</html>