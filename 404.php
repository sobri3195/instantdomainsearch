<?php 
if(!isset($_SESSION)) session_start();

include("config/config.php");

include("includes/functions.php");

include "language/lang_array.php";

include 'includes/header.php';
 
include 'includes/session.php';
  
?> 

<title><?php echo($lang_array['404_page_not_found']); ?></title>
<meta name="description" content="<?php echo($lang_array['404_meta_description']); ?>">
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
				<?php echo $row['medrec1'];	?>			
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
					<div  class="wrapper suggesstions-list">
					</div>
				</div>
			</div>
			<div id="main_page" class="main">
				<div class="not-found-page">
					<h1>
						<?php echo $_SESSION['oops'];?>
					</h1>
					<h3>
						<?php echo $_SESSION['404-page-not-found'];?>
					</h3>
					<div class="btns">
						<button class="btn btn-md btn-home" type="button" onclick="change_pages('home','Home');">
							<li class="fa fa-home"></li> <span><?php echo $_SESSION['take-me-home'];?></span>
						</button>
						<button class="btn btn-md btn-contact" type="button" onclick="contact_page('contact');">
							<li class="fa fa-envelope"></li> <span><?php echo $_SESSION['Contact Us'];?></span>
						</button>
					</div>
				</div>
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
	</div>  
	<div style="display:none;" id="links" class="aff-links">
		<?php 
		include 'includes/affiliates.php';  
		?> 		  
	</div>
<?php include 'includes/footer.php'; ?>