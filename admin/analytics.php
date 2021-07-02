<?php
include dirname(__FILE__) . '/includes/header.php';
 
include dirname(__FILE__) . '/includes/header_under.php';

$error = false;

$csrfVariable = 'csrf_' . basename($_SERVER['PHP_SELF']);

if (isset($_POST['submit'])) 
	{
	
	    if($_SESSION[$csrfVariable] != $_POST['csrf'])
        $error = true;
	
		$tracking_code = mres(trim($_POST["tracking_code"]));
		
		$tracking_code = str_replace("'", "<q>", $tracking_code);
		
		if ($_POST["my-checkbox"] == "on")
		$status = 1;
		else
		$status = 0;
		
		if(!$error)
			update_analytics($tracking_code, $status);
		
	}
	
	$key = sha1(microtime());

	$_SESSION[$csrfVariable] = $key;
?>
	<title>Analytics: <?php echo(get_title()) ?></title>
	</head>
	<body>
		<?php include "includes/top_navbar.php"; ?>
		<div id="wrapper">
			<div id="page-wrapper">
				<div class="row page-ttl">
					<div class="col-lg-12">
						<h1 class="hidden-xs">
							<i class="fa fa-code"></i> Analytics Code <small>Update Analytics Code</small>
						</h1>
						<h4 class="visible-xs">
							<i class="fa fa-code"></i> Analytics Code <small>Update Analytics Code</small>
						</h4>
					</div>
				</div>
				<div class="page-content">
					<div class="margin_sides">
						<div class="row">
							<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
								<?php
								if(isset($_POST['submit']))
								{
								?>
								<div class="alert alert-success alert-dismissable">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="fa fa-check-square-o"></i> <?php echo $lang_array['analytics_success']; ?>
								</div>
								<?php 
								} 
								?>
								<form role="form" action="analytics.php" method="post">
									<?php
									$rows=mysql_fetch_array(mysqlQuery("SELECT * FROM analytics"));
									if(isset($_POST['submit']))
									{
										$tracking_code = $_POST["tracking_code"]; ?>
										<div class="form-group">
											<label>Analytics Code</label> 
											<textarea class="form-control" rows="10" name="tracking_code">
											<?php
											echo ($_POST['tracking_code']);?>
											</textarea> 
										</div>
										<div class="form-group">
											<label>Status</label>
											<?php
											if ($rows['status']=='1')
											{ 
											?>
											<div class="form-group">
												<label class="text-center"><input class="my_checkbox" type="checkbox" name="my-checkbox" checked="checked" /></label>
											</div>
											<?php
											} 
											else 
											{ 
											?>
											<div class="form-group">
												<label class="text-center"><input class="my_checkbox" type="checkbox" name="my-checkbox" /></label>
											</div>
											<?php
											}
											?>
										</div>
										<input type="hidden" name="csrf" value="<?php echo $key; ?>" />
										<div class="form-group">
											<button class="btn btn-success" name="submit" type="submit"><i class="fa fa-check"></i> Update</button>
										</div>
										<?php
									} 
									else 
									{ 
										?>
										<div class="form-group">
											<label>Analytics Code</label> 
												<textarea class="form-control min-height" rows="10" name="tracking_code"><?php echo (show_analytics_status1());?>
												</textarea>
										</div>
										<div class="form-group">
											<label>Status</label>
											<?php
											if($rows['status']=='1')
											{ 
											?>
											<div class="form-group">
												<label class="text-center"><input class="my_checkbox" type="checkbox" name="my-checkbox" checked="checked" /></label>
											</div>
											<?php
											} 
											else 
											{ 
											?>
											<div class="form-group">
												<label class="text-center"><input class="my_checkbox" type="checkbox" name="my-checkbox" /></label>
											</div>
											<?php
											} 
											?>
										</div>
										<hr>
										<input type="hidden" name="csrf" value="<?php echo $key; ?>" />
										<div class="form-group">
											<button class="btn btn-success" name="submit" type="submit"><i class="fa fa-check"></i> Update</button>
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