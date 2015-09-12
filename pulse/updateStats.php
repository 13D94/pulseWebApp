<?php

require_once './CoreLib.php';
$heartRate = $_REQUEST['hr'];
$temperature = $_REQUEST['temp'];
$location = $_REQUEST['loc'];
$steps = $_REQUEST['steps'];


		$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
		mysql_select_db($mysql_database, $bd) or die("Could not select database");
	
               if($heartRate!= NULL & $temperature!=NULL & $location!=NULL & $steps!=NULL){
					   $query="INSERT INTO data_logs(heartRate,temp,location,steps)
                                                         VALUES($heartRate,$temperature,'$location',$steps)";
				
					  //update the values in the database
						if(!mysql_query($query,$bd)){
							die ("<h3>Looks like something went wrong while saving the values!</h3>");
						}else{
							echo "Values Updated!";
						}
                }else{
                           echo "Missing Parameters!";
                }


?>
								