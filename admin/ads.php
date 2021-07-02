<?php
include dirname(__FILE__) . '/includes/header.php';
 
include dirname(__FILE__) . '/includes/header_under.php';
 
$error=false;

$csrfVariable = 'csrf_' . basename($_SERVER['PHP_SELF']);

if(isset($_POST['submit']))
{
	
	if($_SESSION[$csrfVariable] != $_POST['csrf'])
    $error = true;
	
	$medrec1 = mres(trim(htmlspecialchars_decode($_POST["medrec1"])));
	
	$medrec2 = mres(trim(htmlspecialchars_decode($_POST["medrec2"])));
	
	if($_POST["medrec1_status"]=="on")
	$medrec1_status = 1;
	else 
	$medrec1_status = 0;
	if($_POST["medrec2_status"]=="on") 
	$medrec2_status = 1;
	else
	$medrec2_status = 0;
	
	update_ads($medrec1,$medrec1_status,$medrec2,$medrec2_status);
}

$key = sha1(microtime());

$_SESSION[$csrfVariable] = $key;
?>
	<title>Ads Settings: <?php echo(get_title());?></title>
	</head>
	<body>
	<?php include "includes/top_navbar.php"; ?>
	<div id="wrapper">
		<div id="page-wrapper">
			<div class="row page-ttl">
				<div class="col-lg-12">
					<h1>
						<i class="fa fa-puzzle-piece"></i> Ads Settings <small>Update Ads code</small>
					</h1>
				</div>
			</div><!-- /.row -->
			<div class="page-content">
				<div class="margin_sides">
					<div class="row">
						<div class="col-lg-12">
							<?php 
							if(isset($_POST['medrec1']))
							{ 
							?>
							<div class="alert alert-success alert-dismissable col-lg-8 col-md-8 col-sm-12 col-xs-12">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="fa fa-check-square-o"></i> <?php echo $lang_array['ads_success']; ?>
							</div>
							<?php
							} 
							?>
							<form action="ads.php" method="post">
								<div class="row">
									<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
										<div class="form-group">
											<label class="text-center"><b>Leaderboard Ad - 728x90 (Top)</b></label><br />
										</div>
									</div>
									<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
										<div class="form-group">
											<textarea class="form-control push-left min-height" rows="1" cols="1" name="medrec1"><?php echo (show_med_rec1_ad())?>
											</textarea>
										</div>
									</div>
									<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
									    <div class="form-group">
											<?php
											
											$row=mysql_fetch_array(mysqlQuery("SELECT medrec1_status,medrec2_status FROM ads"));
											
											$medrec1_status=$row['medrec1_status'];
											
											$medrec2_status=$row['medrec2_status'];
											
											if($medrec1_status)
											{
											?>
											<div class="form-group">
												<label class="text-center"><label class="text-center"><input class="my_checkbox" type="checkbox" name="medrec1_status" checked="checked" /></label></label>
											</div>
											<?php 
											} 
											else
											{ 
											?>
											<div class="form-group">
												<label class="text-center"><input class="my_checkbox" type="checkbox" name="medrec1_status" /></label>
											</div>
											<?php
											} 
											?>
									    </div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
										<div class="form-group">
											<label class="text-center"><b>Leaderboard Ad - 728x90 (Bottom)</b></label><br />
										</div>
									</div>
									<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
										<div class="form-group">
											<textarea class="form-control push-left min-height" rows="1" cols="1" name="medrec2"><?php echo (show_med_rec2_ad())?>
											</textarea>
										</div>
									</div>
									<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
										<div class="form-group">
											<?php
											if($medrec2_status)
											{
											?>
											<div class="form-group">
												<label class="text-center"><label class="text-center"><input class="my_checkbox" type="checkbox" name="medrec2_status" checked="checked" /></label></label>
											</div>
											<?php
											}
											else
											{ 
											?>
											<div class="form-group">
												<label class="text-center"><input class="my_checkbox" type="checkbox" name="medrec2_status" /></label>
											</div>
											<?php 
											} 
											?>
										</div>
								    </div>
								</div>
								<div class="clearfix"></div>
								<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
								    <hr>
								    <input type="hidden" name="csrf" value="<?php echo $key; ?>" />
								    <div class="form-group">
									    <button type="submit" name="submit" class="btn btn-success" value="Add"><i class="fa fa-check"></i> Update</button>
								    </div>
								</div>
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