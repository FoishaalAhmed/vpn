<!DOCTYPE html>
<html lang="en" id="myStream">
<script>
  document.getElementById("myStream").dir = '<?php echo $valueLTR; ?>'; 
</script>

<head>
	<meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="msapplication-tap-highlight" content="no">
    <title><?= APP_NAME;?></title>

    <!-- Favicons-->
    <link rel="icon" href="assets/images/favicon/favicon-32x32.png" sizes="32x32">
    <!-- Favicons-->
    <link rel="apple-touch-icon-precomposed" href="assets/images/favicon/apple-touch-icon-152x152.png">
    <!-- For iPhone -->
    <meta name="msapplication-TileColor" content="#00bcd4">
    <meta name="msapplication-TileImage" content="assets/images/favicon/mstile-144x144.png">
    <!-- For Windows Phone -->

    <!-- Sweet Alert -->
    <link rel="stylesheet" href="assets/sweet-alert/sweetalert.min.css">

    <!-- CORE CSS-->
    <link href="assets/css/app.min.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="assets/css/style.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="assets/css/sticky-footer.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="assets/css/dropify.css" type="text/css" rel="stylesheet" media="screen,projection">

    <!-- Country Selection-->
    <link href="assets/css/countrySelect.css" type="text/css" rel="stylesheet" media="screen,projection">

    <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
    <link href="assets/css/prism.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="assets/js/plugins/perfect-scrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet"
          media="screen,projection">



    <!-- datatable -->
    <link href="http://cdn.datatables.net/1.10.6/css/jquery.dataTables.min.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="assets/js/plugins/data-tables/css/jquery.dataTables.min.css" type="text/css" rel="stylesheet" media="screen,projection">
 
    <style type="text/css">
        @font-face { font-family: Poppins; src: url('Poppins-Regular.ttf'); }
        @font-face { font-family: Calibri; src: url('Calibri.ttf'); } 
       
        @-webkit-keyframes autofill {
            to {
                color: #000;
                background: transparent;
            }
        }
        input:-webkit-autofill {
            -webkit-animation-name: autofill;
            -webkit-animation-fill-mode: both;
        }

    </style>

    <style type="text/css">
        .input-field div.error{
            position: relative;
            top: -1rem;
            left: 0rem;
            font-size: 0.8rem;
            color:#FF4081;
            -webkit-transform: translateY(0%);
            -ms-transform: translateY(0%);
            -o-transform: translateY(0%);
            transform: translateY(0%);
        }

        .div-error{
            position: relative;
            left: 0rem;
            font-size: 0.8rem;
            color:#FF4081;
            -webkit-transform: translateY(0%);
            -ms-transform: translateY(0%);
            -o-transform: translateY(0%);
            transform: translateY(0%);
        }

        .input-field label.active{
            width:100%;
        }
        .left-alert input[type=text] + label:after,
        .left-alert input[type=password] + label:after,
        .left-alert input[type=email] + label:after,
        .left-alert input[type=url] + label:after,
        .left-alert input[type=time] + label:after,
        .left-alert input[type=date] + label:after,
        .left-alert input[type=datetime-local] + label:after,
        .left-alert input[type=tel] + label:after,
        .left-alert input[type=number] + label:after,
        .left-alert input[type=search] + label:after,
        .left-alert textarea.materialize-textarea + label:after{
            left:0px;
        }
        .right-alert input[type=text] + label:after,
        .right-alert input[type=password] + label:after,
        .right-alert input[type=email] + label:after,
        .right-alert input[type=url] + label:after,
        .right-alert input[type=time] + label:after,
        .right-alert input[type=date] + label:after,
        .right-alert input[type=datetime-local] + label:after,
        .right-alert input[type=tel] + label:after,
        .right-alert input[type=number] + label:after,
        .right-alert input[type=search] + label:after,
        .right-alert textarea.materialize-textarea + label:after{
            right:70px;
        }
    </style>

</head>

<body>
<!-- Start Page Loading -->
    <!--
    <div id="loader-wrapper">
        <div id="loader"></div>
        <div class="loader-section section-left"></div>
        <div class="loader-section section-right"></div>
    </div> 
    -->
<!-- End Page Loading -->
<!-- //////////////////////////////////////////////////////////////////////////// -->

<?php 
$users = $_SESSION['users'];

?>

<!-- START HEADER -->
<header id="header" class="page-topbar">
    <!-- start header nav-->
    <div class="navbar-fixed">
        <nav class="deep-orange">
            <div class="nav-wrapper">
                <h1 class="logo-wrapper footer1">
                <a href="dashboard.php" class="brand-logo"><?php echo APP_NAME;?></a></h1>
                <ul class="hide-on-med-and-down footer2" id="my-ul">
                    
                    <li style="padding:0 5px;"><?php echo $users['username']."<span class='ultra-small white-text'> (" .$users['email'] . ")</span>";?></li>    
                    
                    <li><a href="notification.php">
                        <i class="mdi-social-notifications"></i></a>
                    </li>
                    <!-- Dropdown Trigger -->
                    <li><a class="dropdown-button" href="javascript:void(0);"
                           data-activates="dropdown1"><i class="mdi-navigation-arrow-drop-down"></i></a>
                    </li>

                    <!-- Dropdown Structure -->
                    <ul id="dropdown1" class="dropdown-content">
                        <li><a href="admin.php">Profile</a></li>
                        <li><a href="logout.php">Logout</a></li>
                    </ul>
                </ul>
            </div>
        </nav>
    </div>
    <!-- end header nav-->
</header>
<!-- END HEADER -->