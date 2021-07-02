<?php
if(!isset($_SESSION)) 
session_start();

include "../config/config.php";

include "../includes/functions.php";

include 'libs/login_captcha.php';

include '../language/lang_array.php';

$error = false;

$csrfVariable = 'csrf_main' . basename($_SERVER['PHP_SELF']);

if(isset($_POST['email']) && isset($_POST['password']))
{

    if($_SESSION[$csrfVariable] != $_POST['csrf'])
    $error = true;
	
	if(captcha_admin_login_status()) 
	{ 
	
		if(isset($_POST["captcha_code"]) && trim($_POST["captcha_code"])!="") 
		{ 
		
			if (trim($_POST["captcha_code"])!=$_SESSION['captcha']['code'])
			{
			
				$error = $lang_array['Invalid_Code'];
			
			}
			else
			{
			
				if(authenticate(trim($_POST['email']) , trim($_POST['password'])) && !$error)
				{
				
					$_SESSION['admin_vd_secure'] = 1;
					
					if (valid_license(get_license_user() , get_license_code()))
					$_SESSION['admin_vd_license'] = 1;
					else 
					$error .= $lang_array['Invlalid_license'];
					
				}
				else
				{
				
				    $error .= $lang_array['Invlalid_user_password'];
				
				}
				
			}	
			
		}
		else
		{
		
			$error = $lang_array['captcha_empty'];
		
		}
		
	}	
	else
	{
		if (authenticate(trim($_POST['email']) , trim($_POST['password'])))
		{
		
			$_SESSION['admin_vd_secure'] = 1;
			if (valid_license(get_license_user() , get_license_code()))
			$_SESSION['admin_vd_license'] = 1;
			else 
			$error .= $lang_array['Invlalid_license'];
			
		}
		else
		{
		
		    $error .= $lang_array['Invlalid_user_password'];
		
		}
		
	}
	
}

$key = sha1(microtime());

if(isset($_SESSION[$csrfVariable]))
unset($_SESSION[$csrfVariable]);

$_SESSION[$csrfVariable] = $key;

$_SESSION['captcha'] = simple_php_captcha();

if(isset($_SESSION['admin_vd_secure']) && isset($_SESSION['admin_vd_license']))
header('Location: ./stats.php');

if(isset($_SESSION['admin_vd_secure']) && !isset($_SESSION['admin_vd_license'])) 
header('Location: ./license.php');

?>
<!DOCTYPE html>
<html>
	<head>
	    <meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>Login <?php echo get_title() ; ?></title>
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
				<a href="http://nexthon.com"><img alt="nexthon.com" src="http://muvaa.com/wsvcnew/admin/style/images/n2.png"/></a>
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
			?>
				<form  action="index.php" method="post">
					<?php
					if(isset($_POST['email']))
					{
					?>
					<fieldset>
						<div class="form-group">
							<div class="input-group mrg-btm-max">
								<span class="input-group-addon"><i class="fa fa-user"></i></span>
								<input type="text" name="email" class="form-control input-lg" id="emails" value="<?php echo ($_POST['email']);?>" placeholder="Email">
							</div>
						</div>
						<div class="form-group">
							<div class="input-group mrg-btm-max">
								<span class="input-group-addon"><i class="fa fa-lock"></i></span>
								<input type="password" name="password" id="passwords" class="form-control input-lg"  placeholder="password" value="<?php echo ($_POST['password']);?>">
							</div>      
						</div>
						<?php 
						if(captcha_admin_login_status()) 
						{ 
						?>
						<div class="col-xs-6 mrg-btm-min pull-left">
							<img class="img-responsive" src="<?php echo($_SESSION['captcha']['image_src']) ?>"/>
						</div>
						<div style="margin-top: 8px;" class="input-group col-xs-6 pull-right">
							<span class="input-group-addon"><i class="fa fa-eye-slash"></i></span>
							<input type="text"  class="form-control input-lg"  name="captcha_code" placeholder="Enter Code" value="" required/>
						</div>
						<?php	
						} 
						?>
						<div class="clearfix"></div>
						<input type="hidden" name="csrf" value="<?php echo $key; ?>" />
						<div class="form-group">
							<div class="modal-footer row">
								<div class="col-xs-6 pad-min">
									<a href="reset.php" class="btn btn-primary reset-btn" ><?php echo $lang_array['reset']; ?> ?</a>
								</div>
								<div class="col-xs-6 pad-min">
									<button class="btn btn-success login-btn" id="hide"><i class="fa fa-chevron-right"></i> <?php echo $lang_array['login']; ?></button>
								</div>
							</div>
						</div>
					</fieldset>
					<?php
					} 
					else 
					{ 
					?>
					<fieldset>
						<div class="form-group">
							<div class="input-group mrg-btm-max">
								<span class="input-group-addon"><i class="fa fa-user"></i></span>
								<input type="text" name="email" class="form-control input-lg" id="emails" placeholder="Email">
							</div>
						</div>
						<div class="form-group">
							<div class="input-group mrg-btm-max">
								<span class="input-group-addon"><i class="fa fa-lock"></i></span>
								<input type="password" name="password" id="passwords" class="form-control input-lg"  placeholder="password">
							</div>
						</div>
						<?php 
						if(captcha_admin_login_status()) 
						{ 
						?>
						<div class="col-xs-6 mrg-btm-min pull-left">
							<img class="img-responsive" src="<?php echo($_SESSION['captcha']['image_src']) ?>"/>
						</div>
						<div style="margin-top: 8px;" class="input-group col-xs-6 pull-right">
							<span class="input-group-addon"><i class="fa fa-eye-slash"></i></span>
							<input type="text"  class="form-control input-lg"  name="captcha_code" placeholder="Enter Code" value="" required/>
						</div>
						<?php	
						} 
						?>
						<div class="clearfix"></div>
						<input type="hidden" name="csrf" value="<?php echo $key; ?>" />
						<div class="form-group">
							<div class="modal-footer row">
								<div class="col-xs-6 pad-min">
									<a href="reset.php" class="btn btn-primary reset-btn" ><?php echo $lang_array['reset']; ?> ?</a>
								</div>
								
								<div class="col-xs-6 pad-min">
									<button class="btn btn-success login-btn" id="hide"><i class="fa fa-chevron-right"></i> <?php echo $lang_array['login']; ?></button>
								</div>
							</div>
						</div>
					</fieldset>
					<?php
					}
					?>
				</form>
			</div>
		</div>	
	</div>  
</body>
</html>