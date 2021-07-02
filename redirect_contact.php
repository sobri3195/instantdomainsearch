<?php 
if(!isset($_SESSION)) session_start();

include("config/config.php");

include("includes/functions.php");

include "language/lang_array.php";

include 'includes/header.php';
 
include 'includes/session.php';

include 'admin/libs/contact_captcha.php'; 

include 'libs/mail.php';  

$_SESSION['captcha'] = simple_php_captcha(); 
?> 
	<title><?php echo ($lang_array['contact_meta_title']); ?></title>
	<meta name="description" content="<?php echo ($lang_array['contact_meta_description']); ?>" />
	<meta name="keywords" content="<?php echo ($lang_array['contact_meta_keywords']); ?>" />
	
	<!-- Twitter Card data -->
	<meta name="twitter:card" content="<?php echo ($lang_array['contact_meta_title']); ?>"/>
	<meta name="twitter:title" content="<?php echo($lang_array['contact_meta_title']); ?>">
	<meta name="twitter:description" content="<?php echo ($lang_array['contact_meta_description']); ?>">
	<meta name="twitter:image" content="<?php echo(rootPath()); ?>/static/images/cover.jpg?<?php echo(time()); ?>"/>
	
	<!-- Open Graph data -->
	<meta property="og:title" content="<?php echo($lang_array['contact_meta_title']); ?>"/>
	<meta property="og:type" content="article"/>
	<meta property="og:url" content="<?php echo(getAddress()); ?>"/>
	<meta property="og:image" content="<?php echo(rootPath()); ?>/static/images/changelogo.png?<?php echo(time()); ?>"/>
	<meta property="og:description" content="<?php echo($lang_array['contact_meta_description']); ?>"/>
	<meta property="og:site_name" content="<?php echo(get_title()); ?>"/>
    <?php include "includes/header_under.php"; ?>
	<div class="clearfix"></div>
	<div class="more-results">
		<div class="container">
			<?php
			$sql_select=mysqlQuery("SELECT medrec1,medrec1_status FROM ads");
			
			$row=mysql_fetch_array($sql_select);		
			
			if($row['medrec1_status']==1)
			{	?>
			<div class="advert-728 ad-top">			
				<?php	echo $row['medrec1'];	?>			
			</div>
			<?php } ?>
			<div style="display:none"  id="tld_list">
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				   <div class="heading">
						<i class="fa fa-plus"></i> <?php echo $_SESSION['More TLDs']; ?>
					</div>
					<div class="wrapper search-tld">
					<?php include 'includes/list_tld.php'; ?>    
					</div>
				</div> 
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class="heading sgt-dm">
						<i class="fa fa-lightbulb-o"></i> <?php echo $_SESSION['Suggested Domains']; ?>
					</div>
					<div class="wrapper suggesstions-list">						   
					</div>
				</div>
			</div>
			<div id="main_page" class="main">	
				<div id="load-message">
				</div>
				<h1 class="page-head"><?php echo $_SESSION['Contact Us'] ; ?></h1>
				<div style="display:none" id="replace-class"  class="alert alert-default alert-dismissable">
					<button type="button" class="close" aria-hidden="true">&times;</button> 
					<div id="alert-message"></div>
				</div>
				<div class="well">
					<div class="row">
						<div class="contact-input">
							<?php if(layout()) { ?>
							<div class="col-lg-6 col-md-6 col-sm-12 col-md-12 pull-right">
							<?php } else { ?>
							<div class="col-lg-6 col-md-6 col-sm-12 col-md-12">
							<?php } ?>
									<div class="form-group your-name">
										<label for="exampleInputEmail1"><?php echo $_SESSION['Name'] ; ?></label>
									</div>
								<div class="user-input">
									<div class="form-group">
										<input class="form-control" id="name" name="name" placeholder="<?php echo $_SESSION['Enter Your Name'] ; ?>" pattern="[A-Za-z].{3,50}"  type="text">
									</div>   
									<div class="form-group">         
										<label for="exampleInputEmail1"><?php echo $_SESSION['Email Address'] ; ?></label>
										<input class="form-control"  id="email" name="email" placeholder="<?php echo $_SESSION['Enter Your Email'] ; ?>" pattern="[^@]+@[^@]+\.[a-zA-Z]{2,6}"  type="email">
									</div>										
									<div class="form-group">
										<label for="subject"><?php echo $_SESSION['Subject'] ; ?></label>
										<input class="form-control" name="subject" id="subject"  placeholder="<?php echo $_SESSION['Enter a Subject'] ; ?>"   type="text">
									</div>
									<?php 
									if (captcha_contact_status()) 
									{ 
									?>
									<div class="captcha hidden-sm hidden-xs">
										<div class="form-group">
											<div class="col-xs-12 col-sm-12 col-md-6 col-lg-5">
												<img src="<?php echo($_SESSION['captcha']['image_src']) ?>" />
											</div>
										</div>
										<div class="form-group">
											<div class="col-xs-6 col-sm-9 col-md-6 col-lg-7 captcha-input">
												<label><?php echo $_SESSION['Enter Captcha Code'] ; ?></label>
												<input class="form-control" name="captcha_code" id="captcha_code" placeholder="<?php echo $_SESSION['Enter Code'] ; ?>" value=""  type="text">												
											</div>
										</div> 
									</div>
									<?php
									}
									?>
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-12 col-md-12">
								<div class="form-group">
									<label for="exampleInputEmail1"><?php echo $_SESSION['Your Message'] ; ?></label>
									<textarea class="form-control msg-input" id="message_box" rows="9" cols="25" name="message" placeholder="<?php echo $_SESSION['Enter Your Message'] ; ?>"  style="resize:none"></textarea>
								</div>
								
								<?php 
								if (captcha_contact_status()) 
								{ 
								?>
								<div class="captcha visible-sm visible-xs">
									<div class="form-group">
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<img src="<?php echo($_SESSION['captcha']['image_src']) ?>" />
										</div>
									</div>
									<div class="form-group">
										<div class="col-xs-8 col-sm-6 col-md-12 col-lg-12 captcha-input">
											<label><?php echo $_SESSION['Enter Captcha Code'] ; ?></label>
											<input class="form-control" name="captcha_code2" id="captcha_code2" placeholder="<?php echo $_SESSION['Enter Code'] ; ?>" value=""  type="text">												
										</div>
									</div> 
								</div>
								<?php } ?>
							</div>
						</div>
						<div class="clearfix"></div>
						<?php if(layout()) { ?>
						<div class="col-md-2">
						<?php } else { ?>
						<div class="col-md-12">
						<?php } ?>
							<button name="submit" onclick="mailsend();" class="btn btn-submit captcha-btn pull-right" id="submit"><i class="fa fa-paper-plane"></i> <?php echo $_SESSION['Send Message'] ; ?></button>
						</div>
					</div>
				</div>
				<script>
					$('.msg-input').css('height',$('.user-input').css('height'));
				</script>			
			</div>
		</div>
	</div>
    
	<div class="container">
		<?php
		$sql_select=mysqlQuery("SELECT medrec2,medrec2_status FROM ads");
		
		$row=mysql_fetch_array($sql_select);
		
		if($row['medrec2_status'] == 1)
		{ ?>		
		<div class="advert-728 ad-btm">
			<?php echo $row['medrec2'];	?>	
		</div>
		<?php } ?>
	</div>
    
	<div style="display:none;" id="links" class="aff-links">
	<?php 
	include 'includes/affiliates.php';  
	?> 		  
	</div>
<?php include 'includes/footer.php'; ?>