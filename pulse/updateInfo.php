<?php

require_once './CoreLib.php';
session_start();

if (($_SESSION['LoginStatus'] == 0) || ($_SESSION['LoginStatus'] == NULL)) {
	header("location: index.php");
}
if($_POST['age']!=NULL & $_POST['weight']!=NULL & $_POST['height']!=NULL & is_numeric($_POST['age']) & is_numeric($_POST['weight']) & is_numeric($_POST['height']) ){
	$age = $_POST['age'];
	$height = $_POST['height'];
	$weight = $_POST['weight'];
	$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
	mysql_select_db($mysql_database, $bd) or die("Could not select database");
	$query="UPDATE `meta` SET col3='".$age."', col4='".$height."', col5='".$weight."' WHERE id='login'";
	if(!mysql_query($query,$bd)){
		//die ("Couldn't update weight and height!");
		//Couldnt update
		header("location: myStats.php?selectTab=settings&updateStatus=failure");
		exit();
	}else{
		//Values Updated
		header("location: myStats.php?selectTab=settings&updateStatus=success");
		exit();
	}
	
	
}else{
	header("location: myStats.php?selectTab=settings&updateStatus=invalid");
	exit();
}
?>