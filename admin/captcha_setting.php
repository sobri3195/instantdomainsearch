<?php
include dirname(__FILE__) . '/includes/header.php';
 
include dirname(__FILE__) . '/includes/header_under.php';

$csrfVariable = 'csrf_' . basename($_SERVER['PHP_SELF']);
	
$error = false;
	
if(isset($_POST["submit"]))
{

	if($_SESSION[$csrfVariable] != $_POST['csrf'])
	$error = true;
		
	$contact_enable = $_POST["contact_status"];
	
	$login_enable = $_POST["login_status"];
	if ($contact_enable == "on") 
	$contact_enable = 1;
	else 
	$contact_enable = 0;
	if ($login_enable == "on") 
	$login_enable = 1;
	else
	$login_enable = 0;
	if(!$error)
		{
		    unset($_SESSION['contact_captcha_status']);
			captcha_enable_settings($contact_enable,$login_enable);
		
		}
		
}

$key = sha1(microtime());

$_SESSION[$csrfVariable] = $key;
?>
	<title>
	Captcha Settings: <?php echo(get_title()) ?>
	</title>
	</head>
	<body>
	<?php include "includes/top_navbar.php"; ?>
		<div id="wrapper">
			<div id="page-wrapper">
				<div class="row page-ttl">
					<div class="col-lg-12">
						<h1>
							<i class="fa fa-eye-slash"></i> Captcha Settings <small>Change website captcha status</small>
						</h1>
					</div>
				</div>
				<ol class="page-content">
					<div class="margin_sides">
						<div class="row">
							<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
								<div class="widget">
									<?php
									if(isset($_POST['submit']))
									{									
										?>
										<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="fa fa-check-square-o"></i> Captcha Settings Updated Successfully</div>
										<?php 										
									} 
									?>
									<form  role="form" action="captcha_setting.php" method="post">
										<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
											<div class="form-group">
												<label>Captcha Verification on Contact Page</label>
												<div class="switch res-switch">
													<?php
													if (captcha_contact_enable()) 
													{
													
														?>
														<input class="my_checkbox" type="checkbox" name="contact_status" checked>
														<label><i></i></label>
														<?php
														
													}
													else
													{
													
														?>
														<input class="my_checkbox" type="checkbox" name="contact_status">
														<label><i></i></label>
														<?php
													
													}
													?>
												</div>
											</div>
											<div class="form-group">
												<label>Captcha Verification on Login Page</label>
												<div class="switch res-switch">
													<?php
													if (captcha_login_enable()) 
													{
													
														?>
														<input class="my_checkbox" type="checkbox" name="login_status" checked>
														<label><i></i></label>
														<?php
													
													}
													else
													{
													
														?>
														<input class="my_checkbox" type="checkbox" name="login_status">
														<label><i></i></label>
														<?php
													
													}
													?>
												</div>
											</div>
											<hr>
											<input type="hidden" name="csrf" value="<?php echo $key; ?>" />
											<div class="form-group">
												<button type="submit" id="submit" name="submit" class="btn btn-success" ><i class="fa fa-check"></i> Update</button>
											</div>
										</div>
									</form> 
								</div>
							</div>
						</div>
					</div>
				</ol>
			</div>
		</div>
		<?php include dirname(__FILE__) . '/includes/footer.php'; ?>
	</body>
</html>