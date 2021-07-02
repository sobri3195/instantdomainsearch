<?php
include dirname(__FILE__) . '/includes/header.php';
 
include dirname(__FILE__) . '/includes/header_under.php'; 

$error = false;

$csrfVariable = 'csrf_' . basename($_SERVER['PHP_SELF']);

if(isset($_POST['submit']))
{
		
	if($_SESSION[$csrfVariable] != $_POST['csrf'])
    $error = true;	
		
 	if($_POST['godaddy'] == "on")
	$godaddy = 1;   
	else
	$godaddy = 0;
	
	if($_POST['wantname'] == "on")
	$wantname = 1;
	else
	$wantname = 0;
	
	if($_POST['media'] == "on")
	$media = 1;
	else
	$media = 0;
	
	if($_POST["namecheap"] == "on")
	$namecheap = 1;
	else
	$namecheap = 0;
	
	if($_POST["one_a_one"] == "on")
	$one_a_one = 1;
	else
	$one_a_one = 0;
	
	if($_POST["register"] == "on")
	$register = 1;
	else
	$register = 0;
	
	if($_POST["united"] == "on")
	$united = 1;
	else
	$united = 0;
	
	if($_POST["yahoo"] == "on")
	$yahoo = 1;
	else
	$yahoo = 0;
	
	if($_POST["hover"] == "on")
	$hover = 1;
	else
	$hover = 0;
	
	if(!$error)
		change_affiliates_status($godaddy,$wantname,$media,$namecheap,$one_a_one,$register,$united,$yahoo,$hover);
}

$key = sha1(microtime());

$_SESSION[$csrfVariable] = $key;
?>
	<title>Affiliates Settings: <?php echo(get_title()) ?></title>
    </head>
    <body>
		<?php include "includes/top_navbar.php"; ?>
		<div id="wrapper">
			<div id="page-wrapper">
				<div class="row">
					<div class="col-lg-12 page-ttl">
					<h1>
						<i class="fa fa-sign-in"></i> Affiliates Settings <small>Update Affiliates</small>
					</h1>
					</div>
				</div>
				<div class="page-content mrg-20-top">
					<div class="margin_side">
						<div class="col-lg-8 col-md-10 col-sm-12 col-xs-12">
							<div class="row">
								<div id="update_status">
								<?php 
								if(isset($_POST['submit']))
								{ 
									?>
									<div class="alert alert-success alert-dismissable">
										<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="fa fa-check-square-o"></i> <?php echo $lang_array['tld_status_success'];?>
									</div>
									<?php 
								} 
								?>
									<form method="post" action="affiliates_setting.php" enctype="multipart/form-data">
										<input type="hidden" name="hidden"/>
										<div class="panel panel-success">
											<div class="panel-heading">
												<div class="col-lg-6 col-lg-6 col-md-6 col-sm-6 col-xs-6 col-sm-6 col-xs-6">
												<h3 class="panel-title">Name</h3>
												</div>
												<div class="col-lg-6 col-lg-6 col-md-6 col-sm-6 col-xs-6 col-sm-6 col-xs-6">
												<h3 class="panel-title">Options</h3>
												</div>
											</div>
											
											<div class="panel-body page-list-setting">
										<?php 
										$i=1;

										$sql_select=mysqlQuery("SELECT status,affiliate_name FROM affiliates");

										while($rows=mysql_fetch_array($sql_select))
										{
											if($rows['affiliate_name'] == 'godaddy')
											{
												if($rows['status'] == 1)
												{
												?>
												<div class="col-md-12 list">
													<div class="row">
													<div class="col-lg-6 col-lg-6 col-md-6 col-sm-6 col-xs-6 col-sm-6 col-xs-6">
														<img width="20" height="auto" id="<?php echo $rows['affiliate_name']; ?>_image" src="style/images/1.png"/> <b>Godaddy</b>
													</div>
													<div class="col-lg-6 col-lg-6 col-md-6 col-sm-6 col-xs-6 col-sm-6 col-xs-6">
														<input class="my_checkbox" name="godaddy" type="checkbox"   checked="checked" />							    
														<a class="btn btn-primary btn-sm" onclick="domain_prices('<?php echo $rows['affiliate_name']; ?>');"  type="submit"><i class="fa fa-edit"></i> Modify</a>
													</div>
													</div>
												</div>
												<?php 
												}
												else
												{
												?>
												<div class="col-md-12 list">
													<div class="row">
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
														<img width="20" height="auto" id="<?php echo $rows['affiliate_name']; ?>_image" src="style/images/1.png"/> <b>Godaddy.com</b>
													</div>
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
														<input class="my_checkbox" name="godaddy" type="checkbox"/>							    
														<a class="btn btn-primary btn-sm" onclick="domain_prices('<?php echo $rows['affiliate_name']; ?>');"  type="submit"><i class="fa fa-edit"></i> Modify</a>
													</div>
													</div>
												</div>
												<?php
												}
											}
											else if($rows['affiliate_name'] == 'iwant_my_name')
											{
												if($rows['status'] == 1)
												{
												?>
												<div class="col-md-12 list">
													<div class="row">
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
														<img width="20" height="auto" id="<?php echo $rows['affiliate_name']; ?>_image" src="style/images/6.png"/> <b>IWantMyName</b>
													</div>
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
														<input class="my_checkbox" name="wantname" type="checkbox"   checked="checked" />	    
														<a class="btn btn-primary btn-sm" onclick="domain_prices('<?php echo $rows['affiliate_name']; ?>');"  type="submit"><i class="fa fa-edit"></i> Modify</a>
													</div>
													</div>
												</div>
												<?php 
												}
												else 
												{
												?>
												<div class="col-md-12 list">
													<div class="row">
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
														<img width="20" height="auto" id="<?php echo $rows['affiliate_name']; ?>_image" src="style/images/6.png"/> <b>IWantMyName</b>
													</div>
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
														<input class="my_checkbox" name="wantname" type="checkbox" />	    
														<a class="btn btn-primary btn-sm" onclick="domain_prices('<?php echo $rows['affiliate_name']; ?>');"  type="submit"><i class="fa fa-edit"></i> Modify</a>
													</div>
													</div>
												</div>
												<?php 
												}
											}
											else if($rows['affiliate_name'] == 'media_temple')
											{
												if($rows['status'] == 1)
												{
												?>
												<div class="col-md-12 list">
													<div class="row">
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 aff-name">
														<img width="20" height="auto" id="<?php echo $rows['affiliate_name']; ?>_image" src="style/images/5.jpg"/> <b>Media Temple</b>
													</div>
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
														<input class="my_checkbox" name="media" type="checkbox"   checked="checked" />							    
														<a class="btn btn-primary btn-sm" onclick="domain_prices('<?php echo $rows['affiliate_name']; ?>');"  type="submit"><i class="fa fa-edit"></i> Modify</a>
													</div>
													</div>
												</div>
												<?php 
												}
												else
												{
												?>
												<div class="col-md-12 list">
													<div class="row">
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
														<img width="20" height="auto" id="<?php echo $rows['affiliate_name']; ?>_image" src="style/images/5.jpg"/> <b>Media Temple</b>
													</div>
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
														<input class="my_checkbox" name="media" type="checkbox"/>							    
														<a class="btn btn-primary btn-sm" onclick="domain_prices('<?php echo $rows['affiliate_name']; ?>');"  type="submit"><i class="fa fa-edit"></i> Modify</a>
													</div>
													</div>
												</div>
												<?php 
												}
											}
											else if($rows['affiliate_name'] == 'name_cheap')
											{
												if($rows['status'] == 1)
												{
												?>
												<div class="col-md-12 list">
													<div class="row">
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
														<img width="20" height="auto" id="<?php echo $rows['affiliate_name']; ?>_image" src="style/images/4.ico"/> <b>Namecheap</b>
													</div>
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
														<input class="my_checkbox" name="namecheap" type="checkbox"   checked="checked" />
														<a class="btn btn-primary btn-sm" onclick="domain_prices('<?php echo $rows['affiliate_name']; ?>');"  type="submit"><i class="fa fa-edit"></i> Modify</a>
													</div>
													</div>
												</div>
												<?php 
												}
												else
												{
												?>
												<div class="col-md-12 list">
													<div class="row">
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
														<img width="20" height="auto" id="<?php echo $rows['affiliate_name']; ?>_image" src="style/images/4.ico"/> <b>Namecheap</b>
													</div>
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
														<input class="my_checkbox" name="namecheap" type="checkbox"/>
														<a class="btn btn-primary btn-sm" onclick="domain_prices('<?php echo $rows['affiliate_name']; ?>');"  type="submit"><i class="fa fa-edit"></i> Modify</a>
													</div>
													</div>
												</div>
												<?php 
												}
											}
											else if($rows['affiliate_name'] == 'one_one')
											{
												if($rows['status'] == 1)
												{
												?>
												<div class="col-md-12 list">
													<div class="row">
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
														<img width="20" height="auto" id="<?php echo $rows['affiliate_name']; ?>_image" src="style/images/8.png"/> <b>1&amp;1</b>
													</div>
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
														<input class="my_checkbox" name="one_a_one" type="checkbox"   checked="checked" />					    
														<a class="btn btn-primary btn-sm" onclick="domain_prices('<?php echo $rows['affiliate_name']; ?>');"  type="submit"><i class="fa fa-edit"></i> Modify</a>
													</div>
													</div>
												</div>
												<?php 
												}
												else
												{
												?>
												<div class="col-md-12 list">
													<div class="row">
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
														<img width="20" height="auto" id="<?php echo $rows['affiliate_name']; ?>_image" src="style/images/8.png"/> <b>1&amp;1</b>
													</div>
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
														<input class="my_checkbox" name="one_a_one" type="checkbox"/>					    
														<a class="btn btn-primary btn-sm" onclick="domain_prices('<?php echo $rows['affiliate_name']; ?>');"  type="submit"><i class="fa fa-edit"></i> Modify</a>
													</div>
													</div>
												</div>
												<?php 
												}
											}
											else if($rows['affiliate_name'] == 'register')
											{
												if($rows['status'] == 1)
												{
												?>
												<div class="col-md-12 list">
													<div class="row">
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
														<img width="20" height="auto" id="<?php echo $rows['affiliate_name']; ?>_image" src="style/images/3.ico"/> <b>Register.com</b>
													</div>
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
														<input class="my_checkbox" name="register" type="checkbox"   checked="checked" />						    
														<a class="btn btn-primary btn-sm" onclick="domain_prices('<?php echo $rows['affiliate_name']; ?>');"  type="submit"><i class="fa fa-edit"></i> Modify</a>
													</div>
													</div>
												</div>
												<?php 
												}
												else
												{
												?>
												<div class="col-md-12 list">
													<div class="row">
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
														<img width="20" height="auto" id="<?php echo $rows['affiliate_name']; ?>_image" src="style/images/3.ico"/> <b>Register.com</b>
													</div>
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
														<input class="my_checkbox" name="register" type="checkbox"/>						    
														<a class="btn btn-primary btn-sm" onclick="domain_prices('<?php echo $rows['affiliate_name']; ?>');"  type="submit"><i class="fa fa-edit"></i> Modify</a>
													</div>
													</div>
												</div>
												<?php 
												}
											}
											else if($rows['affiliate_name'] == 'united_domains')
											{
												if($rows['status'] == 1)
												{
												?>
												<div class="col-md-12 list">
													<div class="row">
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
														<img width="20" height="auto" id="<?php echo $rows['affiliate_name']; ?>_image" src="style/images/7.ico"/> <b>United Domains</b>
													</div>
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
														<input class="my_checkbox" name="united" type="checkbox"   checked="checked" />							    
														<a class="btn btn-primary btn-sm" onclick="domain_prices('<?php echo $rows['affiliate_name']; ?>');"  type="submit"><i class="fa fa-edit"></i> Modify</a>
													</div>
													</div>
												</div>
												<?php 
												}
												else
												{
												?>
												<div class="col-md-12 list">
													<div class="row">
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
														<img width="20" height="auto" id="<?php echo $rows['affiliate_name']; ?>_image" src="style/images/7.ico"/> <b>United Domains</b>
													</div>
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
														<input class="my_checkbox" name="united" type="checkbox"/>							    
														<a class="btn btn-primary btn-sm" onclick="domain_prices('<?php echo $rows['affiliate_name']; ?>');"  type="submit"><i class="fa fa-edit"></i> Modify</a>
													</div>
													</div>
												</div>
												<?php 
												}
											}
											else if($rows['affiliate_name'] == 'yahoo')
											{
												if($rows['status'] == 1)
												{
												?>
												<div class="col-md-12 list">
													<div class="row">
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
														<img width="20" height="auto" id="<?php echo $rows['affiliate_name']; ?>_image" src="style/images/2.ico"/> <b>Yahoo</b>
													</div>
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
														<input class="my_checkbox" name="yahoo" type="checkbox"   checked="checked" />						    
														<a class="btn btn-primary btn-sm" onclick="domain_prices('<?php echo $rows['affiliate_name']; ?>');"  type="submit"><i class="fa fa-edit"></i> Modify</a>
													</div>
													</div>
												</div>
												<?php 
												}
												else 
												{
												?>
												<div class="col-md-12 list">
													<div class="row">
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
														<img width="20" height="auto" id="<?php echo $rows['affiliate_name']; ?>_image"  src="style/images/2.ico"/> <b>Yahoo</b>
													</div>
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
														<input class="my_checkbox" name="yahoo" type="checkbox"/>						    
														<a class="btn btn-primary btn-sm" onclick="domain_prices('<?php echo $rows['affiliate_name']; ?>');"  type="submit"><i class="fa fa-edit"></i> Modify</a>
													</div>
													</div>
												</div>
												<?php 
												}
											}
											else if($rows['affiliate_name'] == 'hover')
											{
												if($rows['status'] == 1)
												{
												?>
												<div class="col-md-12 list">
													<div class="row">
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
														<img width="20" height="auto" id="<?php echo $rows['affiliate_name']; ?>_image" src="style/images/hover.png"/> <b>Hover</b>
													</div>
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
														<input class="my_checkbox" name="hover" type="checkbox"   checked="checked" />						    
														<a class="btn btn-primary btn-sm" onclick="domain_prices('<?php echo $rows['affiliate_name']; ?>');"  type="submit"><i class="fa fa-edit"></i> Modify</a>
													</div>
													</div>
												</div>
												<?php 
												}
												else 
												{
												?>
												<div class="col-md-12 list">
													<div class="row">
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
														<img width="20" height="auto" id="<?php echo $rows['affiliate_name']; ?>_image"  src="style/images/hover.png"/> <b>Hover</b>
													</div>
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
														<input class="my_checkbox" name="hover" type="checkbox"/>						    
														<a class="btn btn-primary btn-sm" onclick="domain_prices('<?php echo $rows['affiliate_name']; ?>');"  type="submit"><i class="fa fa-edit"></i> Modify</a>
													</div>
													</div>
												</div>
												<?php 
												}
											}
											$i++;
										}							
										?>
											</div>
										</div>
										<div class="clearfix"></div>
										<input type="hidden" name="csrf" value="<?php echo $key; ?>" />
										<div class="form-group">
											<div class="col-lg-6">
												<button class="btn btn-success" name="submit"  type="submit"><i class="fa fa-check"></i> Update</button>
											</div>
										</div>
									</form>
								</div>
								<div class="form-horizontal" style="display:none" id="update_prices">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php include dirname(__FILE__) . '/includes/footer.php'; ?>
		<script>
		function domain_prices(affiliate)
		{
			var image = document.getElementById(affiliate+'_image').src;
			document.getElementById('update_status').style.display='none'; 
			document.getElementById('update_prices').style.display='block';
			var status_of_loader = '<?php echo($_SESSION['admin_loader_session']); ?>';
			if(status_of_loader == 1)
			$('#update_prices').html('<div id="preloader"><div id="facebookG"><div id="blockG_1" class="facebook_blockG"></div><div id="blockG_2" class="facebook_blockG"></div><div id="blockG_3" class="facebook_blockG"></div></div></div>').fadeIn('fast');
			$.ajax({
				type: "POST",
				url: "update_affiliates.php",
				data: { image: image,affiliate:affiliate},
				cache: false,
				success: function(result)
				{		
					$('#update_prices').html(result);		
					$("#sidebar-nav").removeClass("nav navbar-nav side-nav").addClass("nav navbar-nav side-nav aff-page");
				}
			}); 
		}
		function back_front()
		{
			var status_of_loader = '<?php echo($_SESSION['admin_loader_session']); ?>';
			if(status_of_loader == 1)
			$('#update_prices').html('<div id="preloader"><div id="facebookG"><div id="blockG_1" class="facebook_blockG"></div><div id="blockG_2" class="facebook_blockG"></div><div id="blockG_3" class="facebook_blockG"></div></div></div>').fadeIn('fast');
			document.getElementById('update_prices').style.display='none';
			document.getElementById('update_status').style.display='block'; 
			$('body').scrollTop(0);
		}
		function update_prices(affiliate)
		{	
			document.getElementById('update_success').style.display='none';
			var image = document.getElementById(affiliate+'_image').src; 
			var url = document.getElementById('gurl').value;
			var affiliate_name = document.getElementById('affiliate_name').value;			
			$.ajax({
				type: "POST",
				url: "update_prices.php",
				data: {'url':url,'affiliate_name':affiliate_name,'image':image},
				cache: false,
				success: function(result)
				{	
				}
			}); 
			<?php 
			$sql=mysqlQuery("SELECT * FROM tlds");
			while($result=mysql_fetch_array($sql))
			{
				$tld = $result['tld'];
				?>
				var Tld = '<?php echo $tld; ?>'; 
				var TldPrice = document.getElementById('g'+Tld).value;
				$.ajax({
					type: "POST",
					url: "update_prices.php",
					data: {'Tld':Tld,'TldPrice':TldPrice,'affiliate':affiliate_name},
					cache: false,
					success: function(result)
					{	
					}
				}); 
				<?php
			}
			?>		
			document.getElementById('update_success').style.display='block';
			$('body').scrollTop(0);

		}
		</script>
    </body>
</html>