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
		
 $locationArray = explode(',',$stats['location']);
 
?>
<!DOCTYPE html>
<html>
  <head>
   <style type="text/css">
  html { height: 100% }
  body { height: 100%; margin: 0; padding: 0;}
  #map-canvas { height: 100% }
  div#loader {
    width: 100px;
    height: 100px;
    position: absolute;
    top:0;
    bottom: 0;
    left: 0;
    right: 0;

    margin: auto;
}
</style>
    <script type="text/javascript"
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCFjWMwJrXsyxCxMThDwaObPZnA0G_FG44">
    </script>
	<link rel="stylesheet" href="./font-awesome-4.4.0/css/font-awesome.min.css">
    <script type="text/javascript">
	
      function initialize() {
		var myLatlng = new google.maps.LatLng(<?php echo $locationArray[0];?>,<?php echo $locationArray[1];?>);
	//	var image = 'marker.png';
        var mapOptions = {
          center: myLatlng,
          zoom: 14
        };
        var map = new google.maps.Map(document.getElementById('map-canvas'),mapOptions);
		var marker = new google.maps.Marker({
			  // icon : image,
			  position: myLatlng,
			  map: map,
			  title: 'You are here!'
		  });
		document.getElementById("loader").style.display = 'none';
      }
      google.maps.event.addDomListener(window, 'load', initialize);
    </script>
  </head>
  <body> 
<div id="loader"><i class="fa fa-circle-o-notch fa-spin fa-5x"></i></div>
<div id="map-canvas"></div>
 </body>
</html>