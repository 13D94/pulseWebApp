<?php 
require_once './CoreLib.php';
session_start();
if($_SESSION['LoginStatus']==NULL){
	header("location: index.php");
}
if(($_POST['Uname']==NULL) || ($_POST['Pass']==NULL)){
	header("location: index.php");
}
$uname=($_POST['Uname']);
$pass=($_POST['Pass']);

$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
	mysql_select_db($mysql_database, $bd) or die("Could not select database");
	$qry="SELECT * FROM `meta` WHERE id='login'";
	$res=mysql_query($qry);
	if(!mysql_query($qry,$bd)){
		die ("An unexpected error occured while saving the record, Please try again!");
	}
	$Startup=mysql_fetch_assoc($res);
	if(($Startup['col1']==$uname) && ($Startup['col2']==$pass)){
		$_SESSION['LoginStatus']=1;
		$_SESSION['LoginError']=0;
		header("location: myStats.php");
	}else {
		header("location: index.php");
		$_SESSION['LoginError']=1;
		$_SESSION['LoginStatus']=0;
	}
?>