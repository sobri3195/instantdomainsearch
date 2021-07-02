<?php
error_reporting(0);
if(!isset($_SESSION)) session_start();

if($_SESSION['install_step']<3)
header("Location: database.php");

include '../config/config.php';

$error = "";


function xssClean($data) {

	return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
	
}

function mres($var) {

    if (get_magic_quotes_gpc()) {
	
        $var = stripslashes(trim($var));
		
    }

return mysql_real_escape_string(trim($var));
}

function checkEmail($email)
{
  return preg_match('/^\S+@[\w\d.-]{2,}\.[\w]{2,6}$/iU', $email) ? TRUE : FALSE;
}

if(isset($_POST['title'])) {

	if($_SESSION['csrf'] != $_POST['csrf'])
		$error = "Error Try Again";

	if($error=="") {
	
	$title = mres($_POST['title']);
	
	$path = rtrim(mres($_POST['path']), "/");
	
	$username = mres($_POST['username']);
	
	$password = mres($_POST['password']);
	
	$email = mres($_POST['email']);
	
	if($password!= mres($_POST['confirm_password']))
		$error ="Password Doesn't Match";
	else
		$password = md5($password);
	
	$email = mres($_POST['email']);
	
	}
	
	if($error=="") {
		$title=mysql_real_escape_string($title);
		
		$update_query = "UPDATE `settings` SET `title`='$title', `username`='$username', `password`='$password',`email`='$email',`rootpath`='$path' WHERE 1";
		
		mysql_query($update_query);
		
		$sql = mysql_fetch_array(mysql_query("SELECT * FROM language WHERE status=1 ORDER BY display_order"));
		
		$_SESSION['reset_lang_file'] = $sql['lang_file'];	
		
		$_SESSION['reset_lang_name'] = $sql['lang_name'];
		
		$_SESSION['reset_language'] = 1;
		
		$_SESSION['install_step']=4;
	}
}
$key = sha1(microtime());

$_SESSION['csrf'] = $key;
?>
<script src="style/js/jquery-1.9.1.min.js"></script>
<script>
	$(document).ready(function() {
		$("#finish").click(function() {
			var pass = $("#password").val();
			var cpass = $("#confirm_password").val();
			if(pass!=cpass) {
			
			$('#msg').css('display',''); 
				return false;
			}
			else {
				$('#msg').css('display','none');
			}
			});
});

</script>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Website Details - Installation Wizard</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" href="../style/images/favicon.png">
		<link href="style/css/bootstrap.min.css" rel="stylesheet">
		<link href="style/css/font-awesome.min.css" rel="stylesheet">
		<link href="style/css/style.css" rel="stylesheet">

		<script>     
			 $(document).ready(function(){
				$(function() {
					$("#confirm_password").keyup(function() {
						var password = $("#password").val();
						$("#divconfirmpass").html(password == $(this).val()
							? "<i class='fa fa-check-square'></i> Passwords matched."
							: "<i class='fa fa-times-circle'></i> Passwords do not match!"
						);
					});
				});​
			});
		</script>
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
					  <li class="list-group-item"><i class="fa fa-gavel"></i> License Verification</li>
					  <li class="list-group-item"><i class="fa fa-list-alt"></i> Database Details</li>
					  <li class="list-group-item active"><i class="fa fa-book"></i> Website Details</li>
					  <li class="list-group-item"><i class="fa fa-thumbs-up"></i> Finish</li>
					</ul>

					<div class="hidden-xs hidden-sm">
					  <center>All Rights Reserved <a href="http://www.nexthon.com">
						Nexthon.com</center>
					  </a>
					</div>
				</div> 
				<form id="details" action="./website.php" method="post">
					<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
						<div class="panel panel-default">
							<div class="panel-heading">
								<strong><i class="fa fa-book"></i> Website Details</strong>
								<div class="pull-right">
									<span class="badge badge-warning">Step 4</span>
								</div>
							</div>
							<div class="panel-body">
								<p>
									<b>Enter Website Details</b>
								<?php if($error!="") { ?>
								
									<div class="alert alert-danger">
										<i class="fa fa-times-circle"></i> 
										<?php echo($error) ?>
									</div>
									
								<?php } else {
								
									if(isset($_POST['title'])) {	?>
									
										<div class="alert alert-success">
											<i class="fa fa-check-square"></i> 
											Website Details Added Successfully. Proceeding ...
										</div>
										
										<?php echo ('<META HTTP-EQUIV="Refresh" Content="2; URL=finish.php?' . time() . '">');
										
									}
								}
								?>
									<div class="input-group">
										<span class="input-group-addon">Website Title</span>
										<input maxlength="70" name="title" type="text" class="form-control" placeholder="Enter Your Website Title" required>
									</div>
									<br>
									<div class="input-group">
										<span class="input-group-addon">Installation Path</span>
										<input maxlength="255" name="path" type="url" value="<?php echo('http://' . $_SERVER['SERVER_NAME'] . str_replace("/install","",dirname($_SERVER['SCRIPT_NAME']))); ?>" class="form-control" placeholder="Enter Installation path leave blank if you don't want to change" required>
									</div>
								</p>
								<br />
								<p>
									<b>Enter Administrator's details</b>
									<div class="input-group">
										<span class="input-group-addon">Username</span>
										<input name="username"  type="text" class="form-control" placeholder="Enter User Name" required>
									</div>
									<br>
									<div class="input-group">
										<span class="input-group-addon">Email Address</span>
										<input maxlength="255" name="email" type="text" class="form-control" placeholder="Enter Your Email Address" required>
									</div>
									<br>
									<div class="input-group">
										<span class="input-group-addon">Password</span>
										<input id="password" maxlength="25" name="password" type="password" class="form-control" placeholder="Enter Your Desired Password" required>
									</div>
									<br>
									<div class="input-group">
										<span class="input-group-addon">Conform Password</span>
										<input id="confirm_password" maxlength="25" name="confirm_password" type="password" class="form-control" placeholder="Confirm Password" required>
										<div id="divconfirmpass"></div><br /><br />
									</div> 
								</p>
								<span id="msg" style="margin-left:150px;color:red;display:none">
									<i class="fa fa-check-circle"></i>  Password Don't Match
								</span>
								<input type="hidden" name="csrf" value="<?php echo $key; ?>" />
								<br />
								<p>
									<button id="finish" type="submit" name="submit" class="btn btn-primary btn-lg">Finish</button>
								</p>  
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</body>
</html>
