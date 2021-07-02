<?php
include dirname(__FILE__) . '/includes/header.php';
 
include dirname(__FILE__) . '/includes/header_under.php';

$csrfVariable = 'csrf_' . basename($_SERVER['PHP_SELF']);

function updateCacheSettings($tldCacheEnable, $tldCacheExpireTime, $suggestCacheEnable, $suggestCacheExpireTime) {

	$rows = mysql_num_rows(mysqlQuery("SELECT * FROM `cache_settings`"));
	
	if($rows>0) {
	
	mysqlQuery("UPDATE `cache_settings` SET `tld_status`='$tldCacheEnable', `tld_time`='$tldCacheExpireTime',`suggest_status`='$suggestCacheEnable', `suggest_time`='$suggestCacheExpireTime'");
	
	} else {
		
	mysqlQuery("INSERT INTO `cache_settings` (tld_status,tld_time,suggest_status,suggest_time) VALUES ('$tldCacheEnable','$tldCacheExpireTime','$suggestCacheEnable','$suggestCacheExpireTime')");
	
	}

}
	
$error = false;
	
if (isset($_POST['submit'])) {

	if($_SESSION[$csrfVariable] != $_POST['csrf'])
        $error = true;
	
	$tldCacheEnable = ($_POST['tldCacheEnable'] == 'on') ? 1 : 0;
	
	$tldCacheExpireTime = mres($_POST['tldCacheExpireTime']);
	
	$suggestCacheEnable = ($_POST['suggestCacheEnable'] == 'on') ? 1 : 0;
	
	$suggestCacheExpireTime = mres($_POST['suggestCacheExpireTime']);
	
	if(!is_numeric($tldCacheExpireTime) || !is_numeric($suggestCacheExpireTime))
		$error=true;
	  
	if(!$error)
		updateCacheSettings($tldCacheEnable, $tldCacheExpireTime, $suggestCacheEnable, $suggestCacheExpireTime);
	unset($_SESSION['cache_time']);

}

$query = mysqlQuery("SELECT * FROM `cache_settings`");

$array = mysql_fetch_array($query);

$tldCacheEnable = $array['tld_status']; 

$tldCacheExpireTime = $array['tld_time']; 

$suggestCacheEnable = $array['suggest_status']; 

$suggestCacheExpireTime = $array['suggest_time']; 

$key = sha1(microtime());

$_SESSION[$csrfVariable] = $key;
?>
	<title>
	Cache Settings: <?php echo(get_title()) ?>
	</title>
	</head>
	<body>
	<?php include "includes/top_navbar.php"; ?>
		<div id="wrapper">
			<div id="page-wrapper">
				<div class="row page-ttl">
					<div class="col-lg-12">
						<h1>
							<i class="fa fa-recycle"></i> Cache Settings <small>Change Website Cache </small>
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
									<form role="form" action="cache_settings.php" method="post">
										<div class="form-group">
											<label>TLDS Cache</label>
											<div class="switch res-switch">
												<?php if ($tldCacheEnable) { ?>
												<input class="my_checkbox" type="checkbox" name="tldCacheEnable" checked>
												<label><i></i></label>
												<?php } else { ?>
												<input class="my_checkbox" type="checkbox" name="tldCacheEnable">
												<label><i></i></label>
												<?php } ?>
											</div>
										</div>
										<div class="form-group">
											<label>TLDS Cache Expire Time</label>
											<input type="number" class="form-control" value="<?php echo($tldCacheExpireTime); ?>" name="tldCacheExpireTime" placeholder="Enter Time in Seconds" required/>
										</div>
										<div class="form-group">
											<label>Suggestion Cache</label>
											<div class="switch res-switch">
												<?php if ($suggestCacheEnable) { ?>
												<input class="my_checkbox" type="checkbox" name="suggestCacheEnable" checked>
												<label><i></i></label>
												<?php } else { ?>
												<input class="my_checkbox" type="checkbox" name="suggestCacheEnable">
												<label><i></i></label>
												<?php } ?>
											</div>
										</div>
										<div class="form-group">
											<label>Suggestion Cache Expire Time</label>
											<input type="number" class="form-control" value="<?php echo($suggestCacheExpireTime); ?>" name="suggestCacheExpireTime" placeholder="Enter Time in Seconds" required/>
										</div>
										<input type="hidden" name="csrf" value="<?php echo $key; ?>" />
										<hr>
										<div class="form-group">
											<button type="submit" name="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> Update</button>
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