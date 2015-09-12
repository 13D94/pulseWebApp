<?php

require_once './CoreLib.php';

session_start();

if (($_SESSION['LoginStatus'] == 0) || ($_SESSION['LoginStatus'] == NULL)) {
	header("location: index.php");
}

//get existing weight and height from database.
	$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
	mysql_select_db($mysql_database, $bd) or die("Could not select database");
	$qry="SELECT * FROM `meta` WHERE id='login'";
	$res=mysql_query($qry);
	if(!mysql_query($qry,$bd)){
		die ("An unexpected error occured while Retriving weight and height");
	}
	$user=mysql_fetch_assoc($res);	
		
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
	<!-- jQuery Transit -->
    	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.transit/0.9.12/jquery.transit.min.js"></script>
   	 <link href="http://cdn.bootcss.com/animate.css/3.4.0/animate.min.css" rel="stylesheet">				
	<link rel="stylesheet" href="./font-awesome-4.4.0/css/font-awesome.min.css">
	<link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
	<!-- High Charts -->
	<script src="http://code.highcharts.com/highcharts.js"></script>
	<script src="http://code.highcharts.com/modules/exporting.js"></script>
				
	<style>
	.bs-docs-example {
		position: relative;
		padding: 15px;
		//background-color: #444444;
		border: 1px solid #DDD;
		-webkit-border-radius: 0px;
		-moz-border-radius: 0px;
		border-radius: 0px;
		
	}
	 body { 
	 	//background:#444444;
		 padding-top: 70px; 
		 padding-bottom: 20px;
		font-family: 'Roboto', sans-serif;
	 }
	.navbar-brand-cust{
	    position: absolute;
	    height:51px;
	    left: 10px;
	    top: 2px;
	    text-align: center;
	    margin: auto;
	}
	.navbar-brand-center{
	    position: absolute;
	    width: 100%;
	    height:51px;
	    left: 10px;
	    top: 10px;
	    text-align: center;
	    //margin: auto;
	   
	}
	</style>
	 <script type="text/javascript">
	
   	 $(".nav a").on("click", function(){
		$(".nav").find(".active").removeClass("active");
		$(this).parent().addClass("active");
	});
	$(function(){
		$("#myLocationModal").on('show.bs.modal', function (e) {
			$("#mapIframe").attr('src', './map.php');			
		});
	});
	$(function(){
		$("#myCaloriesModal").on('show.bs.modal', function (e) {
			$("#caloriesIframe").attr('src', './showCalories.php');			
		});
	});
	<?php if($_GET['updateStatus'] != "success") goto nosuccess;?>
	$(function(){
		   $("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
		  	  $("#success-alert").alert('close');
			});
	});
	$(function(){
		   $("#error-alert").fadeTo(2000, 500).slideUp(500, function(){
		  	  $("#success-error").alert('close');
			});
	});
	<?php nosuccess:?>
	
	//HighCharts Starts Here
		$(function () {
			var hrChart,tempChart,stepChart;
	   		 $(document).ready(function () {
			        Highcharts.setOptions({
			            global: {
			                useUTC: false
			            }
	       		});
	
	      hrChart = new Highcharts.Chart({
		     chart: {
		        renderTo: 'hrGraph',
	                type: 'line',
	                animation: Highcharts.svg, // don't animate in old IE
	                marginRight: 10,
	                events: {
	                    load: function () {
	                    
	                    	var req = setInterval(requestStatus, freq);
	
	                        // set up the updating of the chart each second
	                      /*  var series = this.series[0];
	                        setInterval(function () {
	                            var x = (new Date()).getTime(), // current time
	                                y = Math.random();
	                            series.addPoint([x, y], true, true);
	                        }, 1000);*/
	                    }
	                }
	            },
	            title: {
	                text: 'Live Heart Rate'
	            },
	            xAxis: {
	            	title: {
	                    text: 'Time'
	                },
	                 type: 'datetime',
	                tickPixelInterval: 150
	            },
	            yAxis: {
	                title: {
	                    text: 'BPM'
	                },
	                plotLines: [{
	                    value: 0,
	                    width: 1,
	                    color: '#808080'
	                }]
	            },
	           
	            legend: {
	                enabled: false
	            },
	            exporting: {
	                enabled: true
	            },
	            series: [{
	                name: 'Heart Rate',
	                 color: '#E61727',
	                data: (function () {
	                    // generate an array of random data
		                    var data = [],
	                        time = (new Date()).getTime(),
	                        i;
	
	                    for (i = -19; i <= 0; i += 1) {
	                        data.push({
	                            x: time + i * 1000,
	                            y: 0
	                        });
	                    }
	                    return data;
	                }())
	            }]
	        });
	
	
	 tempChart = new Highcharts.Chart({
		     chart: {
		        renderTo: 'tempGraph',
	                type: 'line',
	                animation: Highcharts.svg, // don't animate in old IE
	                marginRight: 10,
	                events: {
	                    load: function () {
	                    
	                    	//var req = setInterval(requestStatus, freq);
	
	                        // set up the updating of the chart each second
	                      /*  var series = this.series[0];
	                        setInterval(function () {
	                            var x = (new Date()).getTime(), // current time
	                                y = Math.random();
	                            series.addPoint([x, y], true, true);
	                        }, 1000);*/
	                    }
	                }
	            },
	            title: {
	                text: 'Live Temperature'
	            },
	            xAxis: {
	            	title: {
	                    text: 'Time'
	                },
	                 type: 'datetime',
	                tickPixelInterval: 150
	            },
	            yAxis: {
	                title: {
	                    text: 'Temperature'
	                },
	                plotLines: [{
	                    value: 0,
	                    width: 1,
	                    color: '#808080'
	                }]
	            },
	           
	            legend: {
	                enabled: false
	            },
	            exporting: {
	                enabled: true
	            },
	            series: [{
	                name: 'Temperature',
	                 color: '#5cb85c',
	                data: (function () {
	                    // generate an array of random data
		                    var data = [],
	                        time = (new Date()).getTime(),
	                        i;
	
	                    for (i = -19; i <= 0; i += 1) {
	                        data.push({
	                            x: time + i * 1000,
	                            y: 0
	                        });
	                    }
	                    return data;
	                }())
	            }]
	        });
	        stepChart = new Highcharts.Chart({
		     chart: {
		        renderTo: 'stepGraph',
	                type: 'line',
	                animation: Highcharts.svg, // don't animate in old IE
	                marginRight: 10,
	                events: {
	                    load: function () {
	                    
	                    	//var req = setInterval(requestStatus, freq);
	
	                        // set up the updating of the chart each second
	                      /*  var series = this.series[0];
	                        setInterval(function () {
	                            var x = (new Date()).getTime(), // current time
	                                y = Math.random();
	                            series.addPoint([x, y], true, true);
	                        }, 1000);*/
	                    }
	                }
	            },
	            title: {
	                text: 'Live Step Count'
	            },
	            xAxis: {
	            	title: {
	                    text: 'Time'
	                },
	                 type: 'datetime',
	                tickPixelInterval: 150
	            },
	            yAxis: {
	                title: {
	                    text: 'Steps'
	                },
	                plotLines: [{
	                    value: 0,
	                    width: 1,
	                    color: '#808080'
	                }]
	            },
	           
	            legend: {
	                enabled: false
	            },
	            exporting: {
	                enabled: true
	            },
	            series: [{
	                name: 'Steps',
	                 color: '#5bc0de',
	                data: (function () {
	                    // generate an array of random data
		                    var data = [],
	                        time = (new Date()).getTime(),
	                        i;
	
	                    for (i = -19; i <= 0; i += 1) {
	                        data.push({
	                            x: time + i * 1000,
	                            y: 0
	                        });
	                    }
	                    return data;
	                }())
	            }]
	        });
	});
			var getStatsAJAXreq = null;
			var freq = 1000;
			
			console.info("Main Initialization Done..");
			function requestStatus() {
				getStatsAJAXreq = $.ajax({
						type : "GET",
						url : "./AJAX/getStats.php",
						dataType : 'json',
						beforeSend : function () {
							if (getStatsAJAXreq != null) {
								getStatsAJAXreq.abort();
							}
						},
						success : function (data, textStatus) {
							console.info("JSON Data Recieved...[heartRate:"+data["heartRate"]+",temp:"+data["temp"]+",steps:"+data["steps"]+",location:"+data["location"]+"]");
							$("#heartRate").html(data["heartRate"]).fadeIn("slow");
							$("#temperature").html(data["temp"]).fadeIn("slow");
							$("#steps").html(data["steps"]).fadeIn("slow");
							
							 var x = (new Date()).getTime(); // current time
							 var series = hrChart.series[0]
							series.addPoint([x, parseInt(data["heartRate"])], true, true);
							console.error("HR Graph Updated..");
							
							var series1 = tempChart.series[0]
							series1.addPoint([x, parseInt(data["temp"])], true, true);
							console.error("Temperature Graph Updated..");
							
							var series2 = stepChart.series[0]
							series2.addPoint([x, parseInt(data["steps"])], true, true);
							console.error("Steps Graph Updated..");
							
						},
						error : function () {
							
							console.error("JSON Data not Recieved..");
						}
						});
						
				}
				
			 });
			
				
			<?php if ($_GET['selectTab'] != "settings") goto loadNormal;?>
			
					$(function(){
					  $('#mainTab a[href="#settings"]').tab('show');
					}
					 );
			 
			 <?php loadNormal:?>
	 
	 </script>
</head>
<body>
<div class="container">
<form action="logout.php" method="post"><input class="form-control" type=hidden name=val value="logout">
<nav class="navbar navbar-default navbar-fixed-top">
	 <div class="navbar-header pull-right" style="margin-right:15px;">
        	<button type="submit" class="btn btn-danger navbar-btn" style="background:#e61727">Logout</button>
        </div>
	<div style="margin-right: 100px; margin-left: -100px; padding-left: 200px;" class="navbar-brand-center"><font size="5">Pulse</font></div>
 	<div class="navbar-brand-cust"><a href="./"><img src="../images/pulse.png" height="45" alt="Pulse Logo" class="animated infinite pulse"/></a></div>
</nav>		
 </form>
<div class="row">
	<div class="col-xs-12">
		 <div class="bs-docs-example center-block">
		 <div role="tabpanel" id="mainTab">
			 <!-- Nav tabs -->
			<ul class="nav nav-tabs" role="tablist">
			  <li role="presentation" class="active"><a href="#myStats" aria-controls="myStats" role="tab" data-toggle="tab">Stats</a></li>
			 <li role="presentation"><a href="#graph" aria-controls="graph" role="tab" data-toggle="tab">Graphs</a></li>
			 <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Settings</a></li>
			  <li role="presentation"><a href="#about" aria-controls="about" role="tab" data-toggle="tab">About</a></li>
			</ul>
		
			 <!-- Tab panes -->
			  <div class="tab-content">
				<div role="tabpanel" class="tab-pane fade in active" id="myStats">
					
						<div class="row" style="margin-top:15px">
							<div class="col-xs-6 text-right" style="color:red;padding-right:0;">
						<font size="7"><div id="heartRate">0</div></font>
						</div>
							<div class="col-xs-6 text-left " style="color:red;padding-left:0;">
							&nbsp;BPM&nbsp;<i class="fa fa-heartbeat fa-4x animated infinite pulse"></i>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-xs-6 text-right" style="color:#5cb85c;padding-right:0;">
							<font size="7"><div id="temperature">0</div></font> 
						</div>
							<div class="col-xs-6 text-left" style="color:#5cb85c;padding-left:0;">
							&nbsp;&#8451 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-street-view fa-4x"></i>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-xs-6 text-right" style="color:#5bc0de;padding-right:0;">
							<font size="7"><div id="steps">0</div></font> 
						</div>
							<div class="col-xs-6 text-left" style="color:#5bc0de;padding-left:0;">
							 &nbsp;Steps&nbsp;&nbsp;<i class="fa fa-male fa-4x"></i>
							</div>
						</div>
						<hr>
						<!--<div class="text-center"><i class="fa fa-exclamation-triangle"></i> - Device OFF/Unavailable</div><br>-->
						<a class="btn btn-default btn-lg center-block" onclick="requestStatus();">
							<i class="fa fa-circle-o-notch fa-spin"></i>&nbsp;Refresh</a>
						<hr>
						<div class="row">
							<div class="col-xs-6">
								<a class="btn btn-warning btn-lg center-block" href="#" data-toggle="modal" data-target="#myLocationModal">
									<i class="fa fa-location-arrow"></i>&nbsp;Location</a>
							</div>
							<div class="col-xs-6">
								<a class="btn btn-primary btn-lg center-block" href="#" data-toggle="modal" data-target="#myCaloriesModal">
							<i class="fa fa-heart-o"></i>&nbsp;Calories</a>
							</div>
						
						</div>
				</div>
				<div role="tabpanel" class="tab-pane fade" id="graph">
					<br>
					<div class="bs-docs-example">
					<div class="row">
						<div class="col-md-6 col-md-offset-2">
							
							<div id="hrGraph" class="text-center" style="margin: 0"></div>
							
						</div>
						<div class="col-md-12"><hr></div>
						<div class="col-md-6 col-md-offset-2">
							
							<div id="tempGraph" class="text-center" style="margin: 0"></div>
							
						</div>
						<div class="col-md-12"><hr></div>
						<div class="col-md-6 col-md-offset-2">
							
							<div id="stepGraph" class="text-center" style="margin: 0"></div>
							
						</div>
					</div>
					</div>				
				</div>
				<div role="tabpanel" class="tab-pane fade" id="settings">
				<form action="updateInfo.php" method="post">
				<h3><span class="label label-success center-block">Add your personal data here.</span></h3>
				<div class="input-group input-group-lg">
					  <span class="input-group-addon" id="sizing-addon1"><b>Age :</b></span>
					  <input type="number" name="age" value="<?php echo $user['col3'];?>" class="form-control" placeholder="your age." aria-describedby="sizing-addon1">
					<span class="input-group-addon" id="basic-addon2">Years</span>
				</div>
				
				<br>
				<div class="input-group input-group-lg">
					  <span class="input-group-addon" id="sizing-addon1"><b>Height :</b></span>
					  <input type="number" name="height" value="<?php echo $user['col4'];?>" class="form-control" placeholder="in centimeters." aria-describedby="sizing-addon1">
						<span class="input-group-addon" id="basic-addon2">CM</span>
				</div>
				<br>
				<div class="input-group input-group-lg">
					  <span class="input-group-addon" id="sizing-addon1"><b>Weight :</b></span>
					  <input type="number" name="weight" value="<?php echo $user['col5'];?>" class="form-control" placeholder="in kilograms." aria-describedby="sizing-addon1">
					<span class="input-group-addon" id="basic-addon2">KG</span>
				</div>
				<?php if($_GET['updateStatus'] == "invalid"){
					echo "
					<br>
					<div class=\"alert alert-danger alert-dismissible\" role=\"alert\">
					<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
					<span aria-hidden=\"true\">
					&times;
					</span>
					</button>
					<strong>
					Invalid Inputs!
					</strong>
					</div>
					";
					}
				?>
				<?php if($_GET['updateStatus'] == "success"){
					echo "
					<br>
					<div class=\"alert alert-success alert-dismissible\" role=\"alert\" id=\"success-alert\">
					<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
					<span aria-hidden=\"true\">
					&times;
					</span>
					</button>
					<strong>
					Values Updated!
					</strong>
					</div>
					";
					}
				?>
				<?php if($_GET['updateStatus'] == "failure"){
					echo "
					<br>
					<div class=\"alert alert-danger alert-dismissible\" role=\"alert\" id=\"success-failure\">
					<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
					<span aria-hidden=\"true\">
					&times;
					</span>
					</button>
					<strong>
					Unable to update Age, Weight and Height!
					</strong>
					</div>
					";
					}
				?>
				<hr>
				<button type="submit" class="btn btn-success btn-lg center-block"> Update</button>
				
				
				</form>
				</div>
				
				<div role="tabpanel" class="tab-pane fade" id="about">
				<h5 class="text-center"><b>A Multifunctional Smart Fitness Band</b></h3>
				<div class="well"><p align="justify">
				This project etches a cost effective microcontroller based health monitor and a protector, smartly disguised as a digital watch that measures many vital physical parameters - Heart rate, Temperature, Body fat and a few more. The data is then recorded to a smartphone most suitably via Bluetooth or an online server accessed through a web browser. It consists of various modes of operation, the novel Red switch is a key feature that notifies and sends a distress signal to the selected contact during emergencies no matter what the device's condition is. The system has a wide range of application including fitness, law enforcement, health care tracking and physiological research. This is a versatile system which doesn’t just record data but the phone will call the necessary contacts in case of an emergency signaled by the smartband, may as well show the precise location of the user.
The system is a cluster of sensors smartly wrapped around a person’s wrist, monitoring the key factors. A unique log of these values is also maintained for every user, enabling the doctors/medical facilities to keep a track of the user’s health and to understand the heart’s condition over a period of time. This device can be used for fitness, protection and 24x7 care of the elderly/injured.
				</p>
				</div>
				<hr>
				<div class="row" style="margin-bottom:15px;"><div class="col-sm-12 text-center"><font size="4"><i class="fa fa-code"></i></font> By</div></div>
				<div class="row">
				<div class="col-xs-2 col-xs-offset-2 text-center">
				<img src="https://graph.facebook.com/100000683643146/picture?access_token=CAACEdEose0cBAP2tOJnZCJTHwFemKmmaLVeMRV1dZACyv1XkyWQwlmYkTdINwtqmXY6b6DT4bY7g2XwMf3ZA7iKPlBZB0EYt0ULBrSV27jkqCrR4YrMMTlEbvVHUY3OI89ZBrZAhUdAPwbOLabszlVivcQZBYgHwJRmxHHkt8VPGSLZBWgiqMSrNsFPlIcnu1uVMiftINsKWiwZDZD" class="img-circle">
				</div>
				
				<div class="col-xs-2 text-center">
				<img src="https://graph.facebook.com/100001113781419/picture?access_token=CAACEdEose0cBAP2tOJnZCJTHwFemKmmaLVeMRV1dZACyv1XkyWQwlmYkTdINwtqmXY6b6DT4bY7g2XwMf3ZA7iKPlBZB0EYt0ULBrSV27jkqCrR4YrMMTlEbvVHUY3OI89ZBrZAhUdAPwbOLabszlVivcQZBYgHwJRmxHHkt8VPGSLZBWgiqMSrNsFPlIcnu1uVMiftINsKWiwZDZD" class="img-circle">
				</div>
				
				<div class="col-xs-2 text-center">
				<img src="https://graph.facebook.com/1598403905/picture?access_token=CAACEdEose0cBAP2tOJnZCJTHwFemKmmaLVeMRV1dZACyv1XkyWQwlmYkTdINwtqmXY6b6DT4bY7g2XwMf3ZA7iKPlBZB0EYt0ULBrSV27jkqCrR4YrMMTlEbvVHUY3OI89ZBrZAhUdAPwbOLabszlVivcQZBYgHwJRmxHHkt8VPGSLZBWgiqMSrNsFPlIcnu1uVMiftINsKWiwZDZD" class="img-circle">
				</div>
				
				<div class="col-xs-2 text-center">
				<img src="https://graph.facebook.com/100002585360430/picture?access_token=CAACEdEose0cBAP2tOJnZCJTHwFemKmmaLVeMRV1dZACyv1XkyWQwlmYkTdINwtqmXY6b6DT4bY7g2XwMf3ZA7iKPlBZB0EYt0ULBrSV27jkqCrR4YrMMTlEbvVHUY3OI89ZBrZAhUdAPwbOLabszlVivcQZBYgHwJRmxHHkt8VPGSLZBWgiqMSrNsFPlIcnu1uVMiftINsKWiwZDZD" class="img-circle">
				</div>
				
				</div><!-- row end -->
				</div>
			  </div>
		</div>
	</div>
	</div>
	
	<!-- My Location Modal -->
		<div class="modal fade" id="myLocationModal" tabindex="-1" role="dialog" aria-labelledby="myLocationModalLabel">
		  <div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
	
			  <div class="modal-body">
					<div id="container">
					
					 <iframe id="mapIframe" style="position: relative; height: 400px; width: 100%" frameborder="0"></iframe>
					</div>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			  </div>
			</div>
		  </div>
		</div>
		
	<!-- My Calories Modal -->
		<div class="modal fade" id="myCaloriesModal" tabindex="-1" role="dialog" aria-labelledby="myCaloriesModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
				 <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Your Calories Burnt</h4>
				  </div>
			  <div class="modal-body">
					<div id="container">
					<iframe id="caloriesIframe" class="center-block" style="width: 100%;" frameborder="0" scrolling="no"></iframe>
					
					</div>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			  </div>
			</div>
		  </div>
		</div>
</div>
</div>
</body>
</html>