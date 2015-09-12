<?php 
require_once './CoreLib.php';
session_start();
if($_SESSION['LoginStatus']==1){
	header("location: myStats.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<title>Pulse</title>
         <!-- icons -->
	<link rel="apple-touch-icon" sizes="57x57" href="./favicons/apple-touch-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="./favicons/apple-touch-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="./favicons/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="./favicons/apple-touch-icon-76x76.png">
	<link rel="icon" type="image/png" href="./favicons/favicon-32x32.png" sizes="32x32">
	<link rel="icon" type="image/png" href="./favicons/favicon-96x96.png" sizes="96x96">
	<link rel="icon" type="image/png" href="./favicons/favicon-16x16.png" sizes="16x16">
	<link rel="manifest" href="./favicons/manifest.json">
	<link rel="shortcut icon" href="./favicons/favicon.ico">
	<meta name="apple-mobile-web-app-title" content="Pulse ">
	<meta name="application-name" content="Pulse ">
	<meta name="msapplication-TileColor" content="#ff0000">
	<meta name="msapplication-config" content="./favicons/browserconfig.xml">
	<meta name="theme-color" content="#ffffff">

				<script type="text/javascript" src ="./jquery-1.11.1.min.js"> </script>
				<!-- Latest compiled and minified CSS -->
				<link rel="stylesheet" href="./bootstrap-3.3.2-dist/css/bootstrap.min.css">
				<!-- Customized CSS -->
				<!--<link rel="stylesheet" href="bootstrap-3.3.2-dist/css/custom.css">-->
				<!-- Optional theme -->
				<link rel="stylesheet" href="./bootstrap-3.3.2-dist/css/bootstrap-theme.min.css">
				<!-- Latest compiled and minified JavaScript -->
				<script src="./bootstrap-3.3.2-dist/js/bootstrap.min.js"></script>
				 <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
				<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
				<!--[if lt IE 9]>
				  <script src="bootstrapForIE9/html5shiv/3.7.2/html5shiv.min.js"></script>
				  <script src="bootstrapForIE9/respond/1.4.2/respond.min.js"></script>
				<![endif]-->
				<link rel="stylesheet" href="./font-awesome-4.4.0/css/font-awesome.min.css">
				<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	<style>
	.bs-docs-example {
		position: relative;
		padding: 15px;
		background-color: white;
		border: 1px solid #DDD;
		-webkit-border-radius: 0px;
		-moz-border-radius: 0px;
		border-radius: 0px;
		
	}
	body{
		font-family: 'Open Sans', sans-serif;
		padding-top:20px;
		background:#444444;
		color:white;
	}
	 .input-group-addon-cust {
	    padding: 6px 12px;
	    font-size: 14px;
	    font-weight: normal;
	    line-height: 1;
	    color: white;
	    text-align: center;
	    background-color: #e61727;
	    border: 0px;
	    border-radius: 0;
	 }
	 .elevated{
	 	-webkit-border-radius: 99em;
		  -moz-border-radius: 99em;
		  border-radius: 99em;
		-webkit-box-shadow: 0px 5px 0px #222;
		 -moz-box-shadow: 0px 5px 0px #222;
		 box-shadow: 0px 5px 0px #222;
	}
	</style>
</head>
<body>
<div class="container">
	<div class="row"> 
		<div class="col-xs-12 text-center">
			<img src="../images/pulse.png" height="90" class="elevated"><br><font size="6">Pulse</font>
		</div>
		
	</div>
	<div class="row">
		<div class="col-xs-12">
		
				<form class="form-horizontal" action="login.php" method="post">
				  <div class="form-group">
					<div class="col-xs-12">
					<div class="input-group">
						<span class="input-group-addon input-group-addon-cust" id="basic-addon1">Username :</span>
					  <input type="text" class="form-control" id="Uname" name="Uname" placeholder="Username">
					  </div>
					</div>
				  </div>
				  <div class="form-group">
					<div class="col-xs-12">
					<div class="input-group">
						<span class="input-group-addon input-group-addon-cust" id="basic-addon1">Password :</span>
					  <input type="password" class="form-control" id="Pass" name="Pass" placeholder="Password">
					</div>
				  </div>
				  </div>
				  <div class="form-group">
					<div class="col-xs-12 text-center">
					  <button type="submit" class="btn btn-danger" style="background:#e61727">Sign in</button>
					  <?php if($_SESSION['LoginError']==1) echo "<h3><span class=\"label label-danger\">Username  Or Password Incorrect!</span></h3>";?>
					</div>
				  </div>
				</form>
		
		</div>
	</div>
	<div class="row">
	<div class="col-xs-12">
	<hr>
	 iIOT2015/pulse/beta/0.9.5
	 </div>
	</div>
</div>
</body>
</html>


	