<?php 
if(!isset($_SESSION)) session_start();

include("config/config.php");

include("includes/functions.php");

include "language/lang_array.php";

include 'includes/session.php';

include 'includes/header.php';
 
?> 
    <title><?php echo get_title(); ?></title>		
    <meta name="description" content="<?php echo(get_description()); ?>"/>
    <meta name="keywords" content="<?php echo(get_tags()); ?>"/>
    
    <!-- Twitter Card data -->
    <meta name="twitter:card" content="<?php echo(get_title()); ?>"/>
    <meta name="twitter:title" content="<?php echo(get_title()); ?>">
    <meta name="twitter:description" content="<?php echo(get_description()); ?>">
    <meta name="twitter:image" content="<?php echo(rootPath()); ?>/style/images/changelogo.png?<?php echo(time()); ?>"/>
    
    <!-- Open Graph data -->
    <meta property="og:title" content="<?php echo(get_title()); ?>"/>
    <meta property="og:type" content="article"/>
    <meta property="og:url" content="<?php echo(getAddress()); ?>"/>
    <meta property="og:image" content="<?php echo(rootPath()); ?>/static/images/changelogo.png?<?php echo(time()); ?>"/>
    <meta property="og:description" content="<?php echo(get_description()); ?>"/>
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
			<?php 
			if(isset($_SESSION['reset_lang_name']))
			{
			
				$language = $_SESSION['reset_lang_name'];
				$sql = mysqlQuery("SELECT content FROM page_language WHERE permalink = 'home' AND language = '$language'");
				$mysql = mysql_fetch_array($sql);
				$count_page = mysql_num_rows($sql);
				if($count_page == 0)
				{			
                    $default = mysql_fetch_array(mysql_query("SELECT lang_name FROM `language` WHERE status = 1 AND lang_name != '$language' ORDER BY display_order"));
					$language = $default['lang_name'];				
					$mysql = mysql_fetch_array(mysql_query("SELECT content FROM `page_language` WHERE permalink='home' AND language = '$language'"));
				}

			}
				echo $content = db_decode($mysql['content']);
			?>				
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