<?php 
if(!isset($_SESSION)) session_start();

include("config/config.php");

include("includes/functions.php");

include "language/lang_array.php";

include 'includes/header.php';
 
include 'includes/session.php';  

if (isset($_GET["permalink"]) && trim($_GET["permalink"]) != "") {

	$permalink = trim($_GET["permalink"]);
	$language = $_SESSION['reset_lang_name'];
	$array =  mysql_fetch_array(mysqlQuery("SELECT v.*,t.title AS page_title ,t.content AS page_content FROM `pages` v,`page_language` t WHERE v.permalink = t.permalink AND v.permalink='$permalink' AND t.language = '$language' AND v.status='1'"));
	if(!isset($array['id']))
	{
	    $default = mysql_fetch_array(mysql_query("SELECT lang_name FROM `language` WHERE status = 1 AND lang_name != '$language' ORDER BY display_order"));
	    $language = $default['lang_name'];
		$array =  mysql_fetch_array(mysqlQuery("SELECT v.*,t.title AS page_title ,t.content AS page_content FROM `pages` v,`page_language` t WHERE v.permalink = t.permalink AND v.permalink='$permalink' AND t.language = '$language'"));
	    if(!isset($array['id']))
	    $array =  mysql_fetch_array(mysqlQuery("SELECT v.*,t.title AS page_title ,t.content AS page_content FROM `pages` v,`page_language` t WHERE v.permalink = t.permalink AND v.permalink='$permalink'"));
	}
	if ($array['id']) {
	
		$title = $array['page_title'];
		$content = $array['page_content'];
		$description = $array['description'];
		$keywords = $array['keywords'];
		
	} else {	
	
		header('HTTP/1.0 404 Not Found');
		header("Location: ".rootpath()."/404.php");
		exit();
		
	} 
}
 
else {

	header("HTTP/1.1 301 Moved Permanently");
	header("Location: " . rootpath());
	exit();
} 
?> 
	<title><?php echo $title; ?></title>		
	<meta name="description" content="<?php echo($description); ?>"/>
	<meta name="keywords" content="<?php echo($keywords); ?>"/>
	
	<!-- Twitter Card data -->
	<meta name="twitter:card" content="<?php echo($title); ?>"/>
	<meta name="twitter:title" content="<?php echo($title); ?>">
	<meta name="twitter:description" content="<?php echo($description); ?>">
	<meta name="twitter:image" content="<?php echo(rootPath()); ?>/style/images/changelogo.png?<?php echo(time()); ?>"/>
	
	<!-- Open Graph data -->
	<meta property="og:title" content="<?php echo($title); ?>"/>
	<meta property="og:type" content="article"/>
	<meta property="og:url" content="<?php echo(getAddress()); ?>"/>
	<meta property="og:image" content="<?php echo(rootPath()); ?>/static/images/changelogo.png?<?php echo(time()); ?>"/>
	<meta property="og:description" content="<?php echo($description); ?>"/>
	<meta property="og:site_name" content="<?php echo($title); ?>"/>
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
				<?php echo htmlspecialchars_decode($content); ?>
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