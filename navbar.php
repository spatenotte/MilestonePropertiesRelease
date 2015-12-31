<?php session_start(); ?>
<?php require 'password.php'; ?>
<?php require 'login_modal.php'; ?>
<?php require 'signup_modal.php'; ?>
<?php require 'terms_conditions.php'; ?>
<?php include_once 'functions.php'; ?>
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/custom.css">
<link rel="stylesheet" type="text/css" href="css/basic.css">


<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php"><span class="glyphicon glyphicon-home"></span> Milestone Properties</a>
      
    </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
          <li class="divider-vertical" style="height: 35px;margin: 8px 9px;border-left: 1px solid darkgray;border-right: 1px solid darkgray;"></li>
          <li><a href="new_listing.php" class="btn btn-lg" style="font-family: 'Helvetica Neue', serif;
                font-weight: lighter;"role="button"> Sell</a></li>
			<li class="divider-vertical" style="height: 35px;margin: 8px 9px;border-left: 1px solid darkgray;border-right: 1px solid darkgray;"></li>
			<li><a href="contact.php" class="btn btn-lg" style="font-family: 'Helvetica Neue', serif;
                font-weight: lighter;" role="button"> Contact</a></li>
			<li class="divider-vertical" style="height: 35px;margin: 8px 9px;border-left: 1px solid darkgray;border-right: 1px solid darkgray;"></li>
			<li><a href="about.php" class="btn btn-lg" style="font-family: 'Helvetica Neue', serif;
                font-weight: lighter;" role="button"> About us</a></li>
      </ul>
<?php if (isset($_SESSION['id'])){
    $name = explode("@",$_SESSION['email']);
        if($_SESSION['admin'] == 0){
    echo '<ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button style="font-family: "Helvetica Neue", serif;
                font-weight: lighter;"><span class="glyphicon glyphicon-user"></span>  Hello, ' . $name[0] . ' <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="profile_user.php">My Profile</a></li>
            <li class="divider"></li>
            <!-- Button trigger modal -->
            <li><a href="sign_out.php">Sign-out</a></li>

          </ul>
        </li>
      </ul>';
        }
        elseif($_SESSION['admin'] == 1 ){
    echo '<ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" style="font-family: "Helvetica Neue", serif;
                font-weight: lighter;><span class="glyphicon glyphicon-user"></span>  Hello, ' . $name[0] . ' <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="profile_realtor.php">My Profile</a></li>
            <li class="divider"></li>
            <!-- Button trigger modal -->
            <li><a href="sign_out.php">Sign-out</a></li>

          </ul>
        </li>
      </ul>';
        }
    elseif( $_SESSION['admin'] == 2){
    echo '<ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" style="font-family: "Helvetica Neue", serif;
                font-weight: lighter;><span class="glyphicon glyphicon-user"></span>  Hello, ' . $name[0] . ' <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="profile_admin.php">My Profile</a></li>
            <li class="divider"></li>
            <!-- Button trigger modal -->
            <li><a href="sign_out.php">Sign-out</a></li>

          </ul>
        </li>
      </ul>';
        }
} else{
    echo'<ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button style="font-family: "Helvetica Neue", serif;
                font-weight: lighter;"><span class="glyphicon glyphicon-user"></span> My Account <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <!-- Button trigger modal -->
            <li><a href="#" data-toggle="modal" data-target="#logInModal">Sign-in</a></li>
            <li class="divider"></li>
            <li><a href="#" data-toggle="modal" data-target="#signUpModal">Sign-up</a></li>
          </ul>
        </li>
      </ul>';
} ?>
      
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <script src="js/jquery.js"></script>
        <script src="js/script.js"></script>