<?php
if(!isset($_SESSION)) 
session_start();

include "../config/config.php";

include "../includes/functions.php"; 

include '../language/lang_array.php';

include '../libs/mail.php';

if(isset($_SESSION['admin_vd_secure']))
header('Location: ./stats.php');
else
{

	$csrfVariable = 'csrf_' . basename($_SERVER['PHP_SELF']);

	if((isset($_POST['email']) && $_POST['email']!="") || (isset($_POST['username']) && $_POST['username']!=""))
	{
	
		if($_SESSION[$csrfVariable] != $_POST['csrf'])
		$error = true;
		
		$email = "";
		
		$username="";
		
		if($_POST["email"]!="")
		{
		
			$email = xssClean(mres($_POST["email"]));
			
			$username=xssClean(mres($_POST["username"]));
			
			$rows=mysql_fetch_array(mysqlQuery("SELECT username FROM settings WHERE email='$email'"));
			
			$username=$rows['username'];
			
			if(!checkEmail($email))
			$error .= 'Invalid Email Address !';
			
			if(checkEmail($email) && !email_exists($email))
			$error .= 'Email Does not Exists !';
			
		}
		else if($_POST["username"]!="")
		{
		
			$username=$_POST["username"];
			
			$sql_select=mysqlQuery("SELECT email FROM settings WHERE username='$username'");
			
			$rows=mysql_fetch_array($sql_select);
			
			$count=mysql_num_rows($sql_select);
			if($count > 0)
			$email=$rows['email'];
			else
			$error .= 'Username Does not Exists !';
			
		}
		
		if(email_exists($email,0) && $error=="")
		{
		
			send_email(get_admin_email(),"noreply@" . getdomain(rootPath()),"Password Reset","Password Reset Request - " . getMetaTitle(),"Please click on the link below to reset your password <br/> <a href='". rootPath() . "/admin/reset.php?rid=" . sencrypt($email) . "'>" . rootPath() . "/admin/reset.php?rid=" . sencrypt($email) . "</a>");
			
		}
		
	}

}

$key = sha1(microtime());

$_SESSION[$csrfVariable] = $key;
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>Reset Password <?php echo(get_title()) ?></title>
		<meta name="description" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
		<link rel="stylesheet" href="./style/font-awesome/css/font-awesome.css">
		<link rel="stylesheet" href="./style/css/bootstrap.css">
		<link rel="stylesheet" href="./style/css/loginstyle.css">
		<link rel="shortcut icon" type="image/png" href="<?php echo (rootpath() ."/style/images/" . get_favicon());?>"/> 
</head>

<body class="admin-login">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header login-header">
				<a href="http://nexthon.com"><img alt="nexthon.com" src="<?php echo rootpath(); ?>/admin/style/images/nexthon.png"/></a>
			</div>			
			<div class="modal-body">
			<?php 
			if($error)
			{
				?>
				<div class="form-group mrg-btm-min">
					<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> <?php echo $error;  ?></div>
				</div>
				<?php
			} 
			else 
			{
			
				if(isset($_GET['rid']) && $_GET['rid']!="")
				{
					$dec_email = sdecrypt($_GET['rid']);
					if(email_exists($dec_email,0))
					{
						reset_pass($dec_email);
						?>
						<div class="form-group mrg-btm-min">
							<div class="alert alert-success"><i class="fa fa-check"></i> New Password Generated And Emailed To You!
							</div>
						</div>
						<?php 
					} 
					else 
					{ 
						?>
						<div class="form-group mrg-btm-min">
							<div class="alert alert-danger"><i class="fa fa-times"></i> Request Session Timed Out Or Invalid Request! 
							</div>
						</div>
						<?php
					}
					
				} 
				else if($_POST['email'] || $_POST['username'])
				{
					?>
					<div class="form-group mrg-btm-min">
						<div class="alert alert-success"><i class="fa fa-check"></i> Password Reset Link Sent To You Please Check Your Email!
						</div>
					</div>
					<?php
				}
				
			}
			?>			
				<form action="reset.php" method="post">
					<div class="input-group mrg-btm-max">
						<span class="input-group-addon"><i class="fa fa-user"></i></span>
						<input type="email" class="form-control input-lg" name="email" placeholder="Enter Email">
					</div>
					
					<h3 class="or-txt">OR</h3>
					<div class="input-group mrg-btm-normal">
						<span class="input-group-addon"><i class="fa fa-user"></i></span>
						<input type="text" class="form-control input-lg" name="username" placeholder="Enter Username">
					</div>
					
					<div class="form-group">
						<div class="modal-footer row">
							<div class="col-xs-6 pad-min">
								<a href="index.php" class="btn btn-primary reset-btn"><i class="fa fa-chevron-left"></i>&nbsp;Cancel</a>
							</div>
							<input type="hidden" name="csrf" value="<?php echo $key; ?>" />
							<div class="col-xs-6 pad-min">
								<button type="submit" name="submit" id="hide" class="btn btn-success login-btn">Reset &nbsp;<i class="fa fa-chevron-right"></i></button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</body>

</html>