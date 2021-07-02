<?php
include dirname(__FILE__) . '/includes/header.php';
 
include dirname(__FILE__) . '/includes/header_under.php'; 

$error = false;

$csrfVariable = 'csrf_' . basename($_SERVER['PHP_SELF']);

if(isset($_POST['submit']))
{

	if($_SESSION[$csrfVariable] != $_POST['csrf'])
	$error = true;

	$cr_name = mres(trim($_POST['dollor']));
	
	$price_dollor= mres(trim($_POST['currency']));
	
	if(!is_numeric($price_dollor) && !$error)
	$error .= $lang_array['currency_invalid'];
	
	$show= mres($_POST['show_place']);
	
	if(strlen($cr_name) > 50 && !$error)
    {
	
		$error.= $lang_array['currency_length'];
	
	}
	if(strlen($price_dollor) > 15 && !$error)
    {
	
		$error.= $lang_array['currency_price_length'];
	
	}
	if(!$error) 
	{
	
	    unset($_SESSION['currency']);
	    unset($_SESSION['set']);
		unset($_SESSION['affiliate_links']);
		update_currency($cr_name,$price_dollor,$show);
	
	}
	
} 

$row=mysql_fetch_array(mysqlQuery("SELECT show_place FROM currency_settings"));

$show_place=$row['show_place'];

$key = sha1(microtime());

$_SESSION[$csrfVariable] = $key;

?>
	<title>Currency Settings: <?php echo(get_title());?></title>
	</head>
	<body>
		<?php include "includes/top_navbar.php"; ?>
		<div id="wrapper">
			<div id="page-wrapper">
				<div class="row page-ttl">
					<div class="col-lg-12">
						<h1>
							<i class="fa fa-usd"></i> Currency Settings <small>Update Currency Settings</small>
						</h1>
					</div>
				</div><!-- /.row -->
				<div  class="page-content">
					<div class="margin_sides">
						<div class="row">
							<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
								<?php
								if($error)
								{ 
								?>
								<div class="alert alert-danger alert-dismissable">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="fa fa-exclamation-triangle"></i> <?php echo $error ; ?>
								</div>
								<?php 
								} 
								else if(isset($_POST['submit']))
								{ 
								?>
								<div class="alert alert-success alert-dismissable">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="fa fa-check-square-o"></i> <?php echo $lang_array['currency_success']; ?>
								</div>
								<?php 
								} 
								?>
								<form class="form-horizontal col-lg-12 col-md-12 col-sm-12 col-xs-12" role="form" action="currency.php" method="post">
									<?php
									if(isset($_POST['dollor']))
									{ 
										?>
										<div class="form-group">
											<label>Currency Symbol</label>
												<input type="text" required="" class="form-control" id="doll" name="dollor" value="<?php echo ($_POST['dollor']); ?>" placeholder="Enter Your Currency Name/Symbol" /> 
										</div>
										<div class="form-group">
											<label>One US Dollar = ??</label>
												<input type="text" class="form-control" required="" id="rs" placeholder="Your Currency equal to how many dollors." name="currency" value="<?php echo ($_POST['currency']); ?>" /> 
										</div>
										<?php
										if($show_place==1)
										{
											?>
											<div class="form-group">
												<label>Where to Show Currency Symbol</label>
													<div class="radio">
														<label><input type="radio" name="show_place" value="1" checked="checked" />Before</label>
													</div>
													<div class="radio">
														<label><input type="radio" name="show_place" value="0" />After</label>
													</div>
												</div>
											<hr />   
											<?php
										} 
										else
										{ 
											?>
											<div class="form-group">
												<label>Where to Show Currency Symbol</label>
													<div class="radio">
														<label><input type="radio" name="show_place" value="1" />Before</label>
													</div>
													<div class="radio">
														<label><input type="radio" name="show_place" value="0" checked="checked" />After</label>
													</div>
											</div>
											<?php 
										} 
										?>
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
											<label>Currency Symbol</label>
												<input type="text" required="" class="form-control" id="doll" name="dollor" value="<?php echo (get_cr_name()); ?>" placeholder="Enter Your Currency Name/Symbol" />
										</div>
										<div class="form-group">
											<label>One US Dollar = ??</label>
												<input type="text" class="form-control" required="" id="rs" placeholder="Your Currency equal to how many dollors." name="currency" value="<?php echo (get_price()); ?>" />
										</div><?php
										if($show_place==1)
										{ 
											?>
											<div class="form-group">
												<label>Where to Show Currency Symbol</label>
													<div class="radio">
														<label><input type="radio" name="show_place" value="1" checked="checked" />Before</label>
													</div>
													<div class="radio">
														<label><input type="radio" name="show_place" value="0" />After</label>
													</div>
											</div>
											<hr />
											<?php 
										} 
										else
										{
										?>
										<div class="form-group">
											<label>Where to Show Currency Symbol</label>
												<div class="radio">
													<label><input type="radio" name="show_place" value="1" />Before</label>
												</div>
												<div class="radio">
													<label><input type="radio" name="show_place" value="0" checked="checked" />After</label>
												</div>
										</div>
										<?php
										} 
										?>
										<hr>
										<input type="hidden" name="csrf" value="<?php echo $key; ?>" />
										<div class="form-group">
											<button type="submit" name="submit" class="btn btn-success" value="Add"><i class="fa fa-check"></i> Update</button>
										</div>
										<?php
									}
									?>
								</form>
								<button class="notify-without-image" id="settings" style="display:none;"></button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php include dirname(__FILE__) . '/includes/footer.php'; ?>
	</body>
</html>
