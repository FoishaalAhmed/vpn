<?php 
    ob_start(); 
    session_start();
    include_once('includes/config.php');
?>
<!DOCTYPE html>
<html lang="en" id="myStreamLogin">
<script>
  document.getElementById("myStreamLogin").dir = '<?php echo $valueLTR; ?>'; 
</script>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="msapplication-tap-highlight" content="no">
  <meta name="description" content="Materialize is a Material Design Admin Template,It's modern, responsive and based on Material Design by Google. ">
  <meta name="keywords" content="materialize, admin template, dashboard template, flat admin template, responsive admin template,">
  <title><?=APP_NAME;?></title>

  <!-- Favicons-->
  <link rel="icon" href="assets/images/favicon/favicon-32x32.png" sizes="32x32">
  <!-- Favicons-->
  <link rel="apple-touch-icon-precomposed" href="assets/images/favicon/apple-icon-152x152.png">
  <!-- For iPhone -->
  <meta name="msapplication-TileColor" content="#00bcd4">
  <meta name="msapplication-TileImage" content="assets/images/favicon/mstile-144x144.png">
  
  <!-- CORE CSS-->
  <link href="assets/css/app.min.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="assets/css/style.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="assets/css/page-center.css" type="text/css" rel="stylesheet" media="screen,projection">

  <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
  <link href="assets/css/prism.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="assets/js/plugins/perfect-scrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet" media="screen,projection">
  
  <!-- Old 		blue theme	#2196f3 -->
  <!-- Current	deep-oragne	#ff5722 -->
  <style>
  @-webkit-keyframes autofill {
    to {
        color: #666;
        background: transparent;
    }
  }
  input:-webkit-autofill {
    -webkit-animation-name: autofill;
    -webkit-animation-fill-mode: both;
  }
  </style>
</head>

<body  style="background-image: url('assets/images/bg-pattern.jpg');background-color: #343b4a; background-size: cover; padding-bottom: 0; min-height: 100px; background-attachment:fixed;">

    <?php include('templates/login_form.php');?>


  <!-- jQuery Library -->
  <script type="text/javascript" src="assets/js/jquery-1.11.2.min.js"></script>
  <!--materialize js-->
  <script type="text/javascript" src="assets/js/app.js"></script>
  <!--prism-->
  <script type="text/javascript" src="assets/js/prism.js"></script>
  <!--scrollbar-->
  <script type="text/javascript" src="assets/js/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>

  <!--plugins.js - Some Specific JS codes for Plugin Settings-->
  <script type="text/javascript" src="assets/js/plugins.js"></script>

</body>

</html>