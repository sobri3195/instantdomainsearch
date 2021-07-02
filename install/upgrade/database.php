<?php
error_reporting(0);
if(!isset($_SESSION)) session_start();

if($_SESSION['upgrade_step']<3) {
header("Location: adminVerify.php");
exit();
}

include '../../config/config.php';

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

	
$result = mysql_fetch_array(mysqlQuery("SELECT * FROM `settings`"));

$version = $result['version'];

$versions = array('1','1.1','1.2','1.3','1.4');

$totalVersions=count($versions);

$currentVersion=array_search($version, $versions);

for($i=$currentVersion+1; $i<$totalVersions; $i++)
{
	$sql_filename = "sql/".$versions[$i].".sql";
	if(file_exists($sql_filename))
		$sql_contents = SplitSQL($sql_filename);
}
$i=$i-1;

$latestVersion = $versions[$i];

mysqlQuery("UPDATE `settings` SET `version`='$latestVersion'");

$_SESSION['upgrade_step']=4;
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Database Details - Upgrade Wizard</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" href="../../style/images/favicon.png">
		<link href="../style/css/bootstrap.min.css" rel="stylesheet">
		<link href="../style/css/font-awesome.min.css" rel="stylesheet">
		<link href="../style/css/style.css" rel="stylesheet">
		<script src="../style/js/bootstrap.min.js"></script>
	</head>

	<body>
		<div class="hidden-xs">
			<div class="logo">
				<img src="../style/images/logo.png">
			</div>
			<div class="sub-logo">
				Instant Domain Search Upgrade Wizard
			</div>
		</div>
		<div class="visible-xs logo-sm">
			<img src="../style/images/logo-sm.png">
		</div>
		  
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
					<ul class="list-group">
					  <li class="list-group-item"><i class="fa fa-cogs"></i> Server Requirements</li>
					   <li class="list-group-item"><i class="fa fa-user"></i> Admin Verification</li>
					  <li class="list-group-item active"><i class="fa fa-list-alt"></i> Upgrade Database</li>
					  <li class="list-group-item"><i class="fa fa-thumbs-up"></i> Finish</li>
					</ul>
					<div class="hidden-xs hidden-sm">
					  <center>All Rights Reserved <a href="http://www.nexthon.com">Nexthon.com</center>
					  </a>
					</div>
				</div>
				<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
					<div class="panel panel-default">
						<div class="panel-heading">
							<strong><i class="fa fa-list-alt"></i> Database Upgrade</strong>
							<div class="pull-right"><span class="badge badge-warning">Step 4</span>
							</div>
						</div>
						<div class="panel-body">
							<div class="alert alert-success">
								<i class="fa fa-check-square"></i> 
								Database successfully Upgraded Click Next to Proceed..
							</div>
							<p>
							<a href="finish.php" class="btn btn-primary btn-lg">Next</a>
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>