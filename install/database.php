<?php
error_reporting(0);
if(!isset($_SESSION)) session_start();

if($_SESSION['install_step']<2)
header("Location: requirements.php");

$host = "";

$username = "";

$password = "";

$database = "";

$error = "";

$config_error = "";


function SplitSQL($file, $delimiter = ';')
{

$lines = file($file);
// Loop through each line
foreach ($lines as $line)
{
// Skip it if it's a comment
if (substr($line, 0, 2) == '--' || $line == '')
    continue;

// Add this line to the current segment
$templine .= $line;
// If it has a semicolon at the end, it's the end of the query
if (substr(trim($line), -1, 1) == ';')
{
    // Perform the query
    mysql_query($templine);
    // Reset temp variable to empty
    $templine = '';
}

}

}


if(!is_writable('../config/config.php'))
$config_error = "../config/config.php is not Writeable Please CHMOD 777";
	
if(isset($_POST['submit'])) {

	if($_SESSION['csrf'] != $_POST['csrf'])
		$error = "Error Try Again";
	
	if($error=="") {
	$host = $_POST['host'];
	
	$username = $_POST['username'];
	
	$password = $_POST['password'];
	
	$database = $_POST['database'];
	
	$connection = mysql_connect($host, $username, $password);
	
	if(!mysql_select_db($database,$connection))
	$error = "Invalid Details : Unable to Connect To Database";
	}
	
	if($error=="") {
	
			$connection = mysql_connect($host, $username, $password);
		
			mysql_select_db($database,$connection);
		
			$sql_filename = "./sql/db.sql";
		
			$sql_contents = SplitSQL($sql_filename);
		
			$config_sample_path = '../config/config.sample';
			
			$data = file_get_contents($config_sample_path);
			
			$data = str_replace("dbname",$database,$data);
			
			$data = str_replace("dbhost",$host,$data);
			
			$data = str_replace("dbuser",$username,$data);
			
			$data = str_replace("dbpass",$password,$data);
			
			$config_path = '../config/config.php';
			
			file_put_contents($config_path, $data);
			
			$_SESSION['install_step']=3;
	}
}
$key = sha1(microtime());

$_SESSION['csrf'] = $key;
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Database Details - Installation Wizard</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" href="../style/images/favicon.png">
		<link href="style/css/bootstrap.min.css" rel="stylesheet">
		<link href="style/css/font-awesome.min.css" rel="stylesheet">
		<link href="style/css/style.css" rel="stylesheet">
		<script src="style/js/bootstrap.min.js"></script>
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
				<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
					<ul class="list-group">
					  <li class="list-group-item"><i class="fa fa-smile-o"></i> Welcome</li>
					  <li class="list-group-item"><i class="fa fa-cogs"></i> Server Requirements</li>
					  <li class="list-group-item active"><i class="fa fa-list-alt"></i> Database Details</li>
					  <li class="list-group-item"><i class="fa fa-book"></i> Website Details</li>
					  <li class="list-group-item"><i class="fa fa-thumbs-up"></i> Finish</li>
					</ul>
					<div class="hidden-xs hidden-sm">
					  <center>All Rights Reserved <a href="http://www.nexthon.com">Nexthon.com</center>
					  </a>
					</div>
				</div>
				<form action="./database.php" method="post">
					<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
						<div class="panel panel-default">
							<div class="panel-heading">
								<strong><i class="fa fa-list-alt"></i> Database Details</strong>
								<div class="pull-right"><span class="badge badge-warning">Step 3</span>
								</div>
							</div>
							<div class="panel-body">
								<p>
								<b>Enter database details below</b>
								<?php if($config_error!="") { ?>
								
									<div class="alert alert-danger">
										<i class="fa fa-times-circle"></i> 
										<?php echo($config_error) ?>
									</div>
									
								<?php }	else if($error && isset($_POST['host'])) { ?>
								
									<div class="alert alert-danger">
										<i class="fa fa-times-circle"></i> 
										<?php echo($error) ?>
									</div>
								
								<?php } else {
								
									if(isset($_POST['host'])) {	?>
									
										<div class="alert alert-success">
											<i class="fa fa-check-square"></i> 
											Database Details Added Please Wait ...
										</div>
										
										<?php echo ('<META HTTP-EQUIV="Refresh" Content="2; URL=website.php?' . time() . '">'); 
										
									}
								}
								?>
									  <div class="input-group">
										<span class="input-group-addon">Database Server</span>
										<input name="host" type="text" class="form-control" placeholder="eg. localhost" required>
									  </div>
									  <br />
									  <div class="input-group">
										<span class="input-group-addon">Database Name</span>
										<input name="database" type="text" class="form-control" placeholder="Enter Database Name" required>
									  </div>
									  <br />
									  <div class="input-group">
										<span class="input-group-addon">Database Username</span>
										<input name="username" type="text" class="form-control" placeholder="Enter Database Username" required>
									  </div>
									  <br />
									  <div class="input-group">
										<span class="input-group-addon">Password</span>
										<input name="password" type="password" class="form-control" placeholder="Enter Password" required>
									  </div>
								  </p>
								  <input type="hidden" name="csrf" value="<?php echo $key; ?>" />
								  <br />
								  <?php if($config_error=="") { ?>
								  <p>
									<button type="submit" name="submit" class="btn btn-primary btn-lg">Next</button>
								  </p>
								  <?php } else { ?>
									<a class="btn btn-success btn-lg" onClick="window.location.reload()">Refresh</a>
								  <?php } ?>
							  </div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</body>
</html>