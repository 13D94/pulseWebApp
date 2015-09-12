<?php 
/* All the core functions and configurations are listed here.
============================================================
*/
//Database connections.
$mysql_hostname = "localhost";
$mysql_user = "db_nichromic";
$mysql_password = "twinParadox123";		//sql login password
$mysql_database = "db_iiot2015";
$mysql_prefix = "";		//name of the main sql database

//BUILD INFO
$Version="3";
$MajorBuildDate="15.06.05";//BUILD Date in Format YY.DD.MM
//Function to echo BUILD INFO
function GetBUILDinfo(){
		global $Version,$MajorBuildDate;
		echo "<small><b>Dep. of C.S.E</small><br><span class=\"glyphicon glyphicon-copyright-mark\"></span> SMVITM, Bantakal</b>";
}
function GetBUILD(){
		global $Version,$MajorBuildDate;
		return('<b>FFS v'.$Version.'</b><font color="red">BUILD#</font>'.$MajorBuildDate.'');
}
// TO HASH string with the crypt function
function HashString($str){
		return(md5($str));
}
?>