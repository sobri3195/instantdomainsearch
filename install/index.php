<?php
error_reporting(0);
if(!isset($_SESSION)) session_start();

if(!isset($_SESSION['install_step']))
$_SESSION['install_step']=1;
?>
<!DOCTYPE html> 
<html lang="en">

	<head>
		<meta charset="utf-8">
		<title>Instant Domain Search Installation Wizard</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" href="style/images/favicon.png">
		<link href="style/css/bootstrap.min.css" rel="stylesheet">
		<link href="style/css/style.css" rel="stylesheet">
		<script src="style/js/bootstrap.js"></script>
	</head>

	<body>
		<div class="hidden-xs">
			<div class="logo">
				<img src="style/images/logo.png">
			</div>
			<div class="sub-logo">
				Instant Domain Search Script
			</div>
		</div>
		<div class="visible-xs logo-sm">
			<img src="style/images/logo-sm.png">
		</div>
		  
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="panel panel-default">
						  <div class="panel-heading">
							<strong>Thank you for Purchasing <a href="http://www.nexthon.com">Nexthon's</a> Product</strong>
							<div class="pull-right">
								<span class="badge badge-warning">Begin</span>
							</div>
						  </div>
						  <div class="panel-body">
							<h1>Instant Domain Search</h1>
							<h4>Installation Wizard</h4>
							<br />
							<p>Instant Domain Search is a powerful PHP based script to search domain names instantly with AJAX. Instant Domain Search Script is built with fully responsive design based on Latest Bootstrap to ensure that your website will look absolutely flawless and beautiful on every mobile and desktop devices. It also has the strong cross browser support and utilize the power of open source technologies for its main components.<a href="http://nexthon.ticksy.com">Contact Our Support</a>.</p>
							<br>
							<p><a href="requirements.php?<?php echo(time()); ?>" class="btn btn-success btn-lg" role="button">Click Here to Proceed</a>
							</p>
						  </div>
						  <div class="hidden-xs hidden-sm">
							  <center>All Rights Reserved <a href="http://www.nexthon.com">
								Nexthon.com</center>
							  </a>
						  </div>
					</div>
				</div>
			</div>
		</div>
	</body>

</html>