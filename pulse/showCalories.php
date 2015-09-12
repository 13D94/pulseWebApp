<?php
require_once './CoreLib.php';
session_start();

if (($_SESSION['LoginStatus'] == 0) || ($_SESSION['LoginStatus'] == NULL)) {
	header("location: index.php");
}

	$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
	mysql_select_db($mysql_database, $bd) or die("Could not select database");
	$qry="SELECT * FROM `data_logs` ORDER BY `TIMESTAMP` DESC LIMIT 1";
	$res=mysql_query($qry);
	if(!mysql_query($qry,$bd)){
		die ("An unexpected error occured while Retriving Data Please try again!");
	}
	$stats=mysql_fetch_assoc($res);
	//print_r($stats);
	
	$qry="SELECT * FROM `meta` WHERE id='login'";
	$res=mysql_query($qry);
	if(!mysql_query($qry,$bd)){
		die ("An unexpected error occured while Retriving Data Please try again!");
	}	
	$loginRow=mysql_fetch_assoc($res);
	//print_r($loginRow);
	
	
	//start calculating calories burnt
	echo "weight in kg= ".$loginRow['col5'];echo "<br>";
	
	$weightInlb =  $loginRow['col5'] * 2.2046;
	echo "weight in pounds= ".$weightInlb;echo "<br>";
	
	$calBurntPerMile = 0.57 * $weightInlb;
	echo "caloriesburntpermile= ".$calBurntPerMile;echo "<br>";
	
	$yourStrip = $loginRow['col4'] * 0.415;
	echo "yourstrip= ".$yourStrip;echo "<br>";
	
	$stepIn1Mile = 160934.4 / $yourStrip;
	echo "stepIn1Mile= ".$stepIn1Mile;echo "<br>";
	
	$conversionFactor = $stats['steps'] / $stepIn1Mile;
	echo "conversionFactor= ".$conversionFactor;echo "<br>";
	
	$caloriesBurnt = ($stats['steps'] * $conversionFactor)/1000.0;
	echo "caloriesBurnt= ".round($caloriesBurnt,2)." kcal";echo "<br>";
	
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
	<!-- WARNING: Respond.js doesnt work if you view the page via file:// -->
	<!--[if lt IE 9]>
	  <script src="bootstrapForIE9/html5shiv/3.7.2/html5shiv.min.js"></script>
	  <script src="bootstrapForIE9/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
					
	<link rel="stylesheet" href="./font-awesome-4.4.0/css/font-awesome.min.css">
	
</head>
<body>
</body>
<i class="fa fa-flash fa-5x"></i> <h3>You have burnt <?=$caloriesBurnt;?> calories.</h3>