<?php
error_reporting(0);
if(!isset($_SESSION)) session_start();

if($_SESSION['upgrade_step']<2) {
header("Location: requirements.php");
exit();
}

include '../../config/config.php';

$username = "";
$password = "";
$error = false;

function validAdmin($username, $password) {

	$password=md5($password);
	$count = mysql_num_rows(mysqlQuery("SELECT * FROM `settings` WHERE `username`='$username' AND `password`='$password'"));
	if($count>0)
		return true;
	else
		return false;

}
	
	
if(isset($_POST['submit'])) {

	if($_SESSION['csrf'] != $_POST['csrf'])
		$error = "Error Try Again";
	if(!$error) {
		$username = $_POST['username'];
		$password = $_POST['password'];

		if(!validAdmin($username,$password)) {
			$error = "Invalid User name or Password Can't Proceed";
		}
	}
}
$key = sha1(microtime());

$_SESSION['csrf'] = $key;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Admin Verification</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" href="../../static/images/favicon.png">
<link href="../style/css/bootstrap.min.css" rel="stylesheet">
<link href="../style/css/font-awesome.min.css" rel="stylesheet">
<link href="../style/css/style.css" rel="stylesheet">
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
  <li class="list-group-item active"><i class="fa fa-user"></i> Admin Verification</li>
  <li class="list-group-item"><i class="fa fa-list-alt"></i> Upgrade Database</li>
  <li class="list-group-item"><i class="fa fa-thumbs-up"></i> Finish</li>
</ul>

<div class="hidden-xs hidden-sm">
  <center>All Rights Reserved <a href="http://www.nexthon.com">
    Nexthon.com</center>
  </a>
</div>
</div>
<form action="./adminVerify.php" method="post">
<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
<div class="panel panel-default">
<div class="panel-heading">
   <strong><i class="fa fa-gavel"></i> License Verification</strong>
    <div class="pull-right"><span class="badge badge-warning">Step 3</span>
    </div>
</div>  
<div class="panel-body">
<p><b>Please verify your Admin Login Details</b>
 <?php
if(isset($_POST['username']) && isset($_POST['password']) && $error!="")
{
?>
	<div class="alert alert-danger">
		<i class="fa fa-times-circle"></i> 
		<?php echo($error) ?>
	</div>
<?php } 
else
{
if(isset($_POST['username']) && isset($_POST['password']) && $error=="")
{
?>
	<div class="alert alert-success">
		<i class="fa fa-check-square"></i> 
		Login Details Verified Please Wait ...
	</div>
<?php
$_SESSION['upgrade_step'] = 3;
echo ('<META HTTP-EQUIV="Refresh" Content="2; URL=database.php?' . time() . '">');
} 
}
?>
<div class="input-group">
<span class="input-group-addon">User Name</span>
<input name="username" type="text" class="form-control" placeholder="e.g. Admin" required>
</div>
<br />
<div class="input-group">
<span class="input-group-addon">Password</span>
<input name="password" type="password" class="form-control"  required>
</div>
</p>
<input type="hidden" name="csrf" value="<?php echo $key; ?>" />
<br />
<p>
<button type="submit" name="submit" class="btn btn-primary btn-lg">Next</button>
</p>
</div>
</div>
</div>
</form>
</div>
</div>
</body>
</html>