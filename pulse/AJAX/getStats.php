<?php
require_once '../CoreLib.php';
//Set Time Zone
date_default_timezone_set("Asia/Kolkata"); 
session_start();

if (($_SESSION['LoginStatus'] == 0) || ($_SESSION['LoginStatus'] == NULL)) {
	header("location: ../");
}

	$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
	mysql_select_db($mysql_database, $bd) or die("Could not select database");
	$qry="SELECT * FROM `data_logs` ORDER BY `TIMESTAMP` DESC LIMIT 1";
	$res=mysql_query($qry);
	if(!mysql_query($qry,$bd)){
		die ("An unexpected error occured while Retriving Data Please try again!");
	}
	$stats=mysql_fetch_assoc($res);
	
	$valueTime = strtotime($stats['TIMESTAMP']);	
	
	$currentTime = strtotime(date('Y-m-d H:i:s'));
	
	$seconds = $currentTime - $valueTime;
	/*if($seconds >=1800){
		$naValues['heartRate']="<i class=\"fa fa-exclamation-triangle\"></i>";
		$naValues["temp"] = "<i class=\"fa fa-exclamation-triangle\"></i>";
		$naValues["steps"] = "<i class=\"fa fa-exclamation-triangle\"></i>";
		echo json_encode($naValues,JSON_PRETTY_PRINT);  
	
	}else{*/
		$JSONstr=($stats);
		echo json_encode($JSONstr,JSON_PRETTY_PRINT);
	//}
?>