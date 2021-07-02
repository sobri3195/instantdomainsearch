<?php
include dirname(__FILE__) . '/includes/header.php';
 
include dirname(__FILE__) . '/includes/header_under.php';

$error = false;

$csrfVariable = 'csrf_' . basename($_SERVER['PHP_SELF']);

if(isset($_POST['submit']))
{

	if($_SESSION[$csrfVariable] != $_POST['csrf'])
	$error = true;
	
	if($_POST['f_status'] == "on")
	$f_status = 1;
	else
	$f_status = 0;
	
	if($_POST['t_status'] == "on")
	$t_status = 1;
	else
	$t_status = 0;
	
	if($_POST['g_status'] == "on")
	$g_status = 1;
	else
	$g_status = 0;
	
	if($_POST['all_status'] == "on")
	$all_status = 1;
	else
	$all_status = 0;
	
	if(isset($_POST['facebook']) && $_POST["facebook"]!="" && !$error)
	{
	
		if(valid_facebook_url($_POST["facebook"]) && $_POST["facebook"]!="")
		$facebook = mres($_POST["facebook"]);
		else if(!$error)
		echo $error .= $lang_array['social_invalid_facebook'];
        
	}
	if(isset($_POST['twitter']) && $_POST["twitter"]!="" && !$error)
	{
	
		if(valid_twitter_username($_POST["twitter"]) && $_POST["twitter"]!="")
		$twitter = mres($_POST["twitter"]);
		else if(!$error)
		$error .= $lang_array['social_invalid_twitter'];
		
	}
	if(isset($_POST['google']) && $_POST["google"]!="" && !$error)
	{
	
		if(valid_google_url($_POST["google"]))
		$google = mres($_POST["google"]);
		else if(!$error)
		$error .= $lang_array['social_invalid_google'];
		
	}
	
	if(!$error)
		update_social($facebook,$twitter,$google,$f_status,$t_status,$g_status,$all_status); 
	
} 
else 
{
	$row=mysql_fetch_array(mysqlQuery("SELECT * FROM `social_profiles`"));
	
	$facebook = $row['facebook'];
	$f_status = $row['f_status'];
	$twitter = $row['twitter'];
	$t_status = $row['t_status'];
	$google = $row['google_plus'];
	$g_status = $row['g_status'];
	$all_status = $row['social_buttons'];
}

$key = sha1(microtime());

$_SESSION[$csrfVariable] = $key;
?>
	<title>
	Edit Social Profiles: <?php echo(get_title());?>
	</title>
	</head>
	<body>
	    <?php include "includes/top_navbar.php"; ?>
		<div id="wrapper">
			<div id="page-wrapper">
				<div class="row page-ttl">
					<div class="col-lg-12">
						<h1>
							<i class="fa fa-users"></i> Social Profiles <small>Manage your Social Profiles</small>
						</h1>
					</div>
				</div><!-- /.row -->
				<div class="page-content">
					<div class="margin_sides">
						<div class="row">
							<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
								<form action="social.php" method="post">
									<?php
									if(isset($_POST['submit']))
									{
										if(valid_facebook_url($_POST["facebook"]) && valid_google_url($_POST["google"]) && valid_twitter_username($_POST["twitter"]))
										{
											
											?>
											<div class="alert alert-success alert-dismissable">
												<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="fa fa-check-square-o"></i> <?php echo $lang_array['social_success']; ?>
											</div>
											<?php
										
										}
										else if($error)
										{ 
										
											?>
											<div class="alert alert-danger alert-dismissable">
												<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="fa fa-exclamation-triangle"></i> <?php echo $error ; ?>
											</div>
											<?php 
										
										} 
										?>
										<div class="form-group">
											<label>Facebook Fanpage ID/Name</label>
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-facebook">&nbsp;&nbsp;</i></span> <input class="form-control" name="facebook" id="face" value="<?php echo ($_POST["facebook"])?>"/>
											</div>
										</div>
										<div class="form-group">
											<?php 
											if($f_status)
											{ 
											?>
											<input class="my_checkbox" name="f_status" type="checkbox"   checked="checked" />
											<?php 
											} 
											else 
											{ 
											?>
											<input class="my_checkbox" name="f_status"  type="checkbox" name="com_status" /> 
											<?php 
											} 
											?>
										</div>
										<div class="form-group">
											<label>Twitter Username</label>
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-twitter">&nbsp;&nbsp;</i></span><input class="form-control" name="twitter" id="tweet" value="<?php echo ($_POST["twitter"]);?>"/>
											</div>
										</div>
										<div class="form-group">
											<?php 
											if($t_status)
											{ 
											?>
											<input class="my_checkbox" name="t_status" type="checkbox"   checked="checked" />
											<?php 
											} 
											else 
											{ 
											?>
											<input class="my_checkbox" name="t_status"  type="checkbox" name="com_status" /> 
											<?php 
											} 
											?>
										</div>
										<div class="form-group">
											<label>Google+ Page ID</label>
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-google-plus">&nbsp;&nbsp;</i></span><input class="form-control" name="google" id="ggl" value="<?php echo ($_POST["google"]);?>"/>
											</div>
										</div>
										<div class="form-group">
											<?php 
											if($g_status)
											{ 
											?>
											<input class="my_checkbox" name="g_status" type="checkbox"   checked="checked" />
											<?php 
											} 
											else 
											{ 
											?>
											<input class="my_checkbox" name="g_status"  type="checkbox" name="com_status" /> 
											<?php 
											} 
											?>
										</div>
										<div class="form-group">
										    <label>Social Buttons</label></br>
											<?php 
											if($all_status)
											{ 
											?>
											<input class="my_checkbox" name="all_status" type="checkbox"   checked="checked" />
											<?php 
											} 
											else 
											{ 
											?>
											<input class="my_checkbox" name="all_status"  type="checkbox" name="com_status" /> 
											<?php 
											} 
											?>
										</div>
										<hr />
										<input type="hidden" name="csrf" value="<?php echo $key; ?>" />
										<div class="form-group">
											<button type="submit" name="submit" class="btn btn-success" value="Add"><i class="fa fa-check"></i> Update</button>
										</div>
										<?php 
									} 
									else 
									{ 
										?>
										<div class="form-group">
											<label>Facebook Fanpage ID/Name</label>
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-facebook">&nbsp;&nbsp;</i></span> <input class="form-control" name="facebook" id="face" value="<?php echo ($facebook); ?>" />
											</div>
										</div>
										<div class="form-group">
											<?php 
											if($f_status)
											{ 
											?>
											<input class="my_checkbox" name="f_status" type="checkbox"   checked="checked" />
											<?php 
											} 
											else 
											{ 
											?>
											<input class="my_checkbox" name="f_status"  type="checkbox" name="com_status" /> 
											<?php 
											} 
											?>
										</div>
										<div class="form-group">
											<label>Twitter Username</label>
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-twitter">&nbsp;&nbsp;</i></span><input class="form-control" name="twitter" id="tweet" value="<?php echo ($twitter); ?>" />
											</div>
										</div>
										<div class="form-group">
											<?php 
											if($t_status)
											{ 
											?>
											<input class="my_checkbox" name="t_status" type="checkbox"   checked="checked" />
											<?php 
											} 
											else 
											{ 
											?>
											<input class="my_checkbox" name="t_status"  type="checkbox" name="com_status" /> 
											<?php 
											} 
											?>
										</div>
										<div class="form-group">
											<label>Google+ Page ID</label>
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-google-plus">&nbsp;&nbsp;</i></span><input class="form-control" name="google" id="ggl" value="<?php echo ($google); ?>" />
											</div>
										</div>
										<div class="form-group">
											<?php 
											if($g_status)
											{ 
											?>
											<input class="my_checkbox" name="g_status" type="checkbox"   checked="checked" />
											<?php 
											} 
											else 
											{ 
											?>
											<input class="my_checkbox" name="g_status"  type="checkbox" name="com_status" /> 
											<?php 
											} 
											?>
										</div>
										<div class="form-group">
										    <label>Social Buttons</label></br>
											<?php 
											if($all_status)
											{ 
											?>
											<input class="my_checkbox" name="all_status" type="checkbox"   checked="checked" />
											<?php 
											} 
											else 
											{ 
											?>
											<input class="my_checkbox" name="all_status"  type="checkbox" name="com_status" /> 
											<?php 
											} 
											?>
										</div>
										<hr />
										<input type="hidden" name="csrf" value="<?php echo $key; ?>" />
										<div class="form-group">
											<button type="submit" name="submit" class="btn btn-success" value="Add"><i class="fa fa-check"></i> Update</button>
										</div>
										<?php 
									} 
									?>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php include dirname(__FILE__) . '/includes/footer.php'; ?>
	</body>
</html>