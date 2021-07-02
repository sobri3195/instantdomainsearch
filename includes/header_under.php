<?php
if(analyticsEnabled()) {

	echo(show_analytics_status());
	
}
?>
</head>
<body>
	<header>
	<div class="navbar navbar-default navbar-static-top" role="navigation">
		<div class="navbar-header">
			<button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target=".nexthon-navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		</div>
		<nav class="collapse navbar-collapse nexthon-navbar-collapse">
			<div class="container">
				<?php 
				$language = $_SESSION['reset_lang_name'];
				$sql_select = mysql_query("SELECT permalink FROM `pages` WHERE status = 1 AND header_status = 1 ORDER BY display_order");
				?>
				<?php if(layout()) { ?>
				<ul class="nav navbar-nav navbar-right">
				<?php } else { ?>
				<ul class="nav navbar-nav navbar-left">
				<?php } ?>
					<?php				
					$i=1;				
					while($get=mysql_fetch_array($sql_select))
					{
						$get_permalink = $get['permalink'];
						$rows = mysql_fetch_array(mysql_query("SELECT permalink,title FROM `page_language` WHERE permalink='$get_permalink' AND language='$language'"));
						if(!isset($rows['permalink']))
						{
							$default = mysql_fetch_array(mysql_query("SELECT lang_name FROM `language` WHERE status = 1 AND lang_name != '$language' ORDER BY display_order"));
							$get_language = $default['lang_name'];
								$rows = mysql_fetch_array(mysql_query("SELECT permalink,title FROM `page_language` WHERE permalink='$get_permalink' AND language='$get_language'"));
							if(!isset($rows['permalink']))
								$rows = mysql_fetch_array(mysql_query("SELECT permalink,title FROM `page_language` WHERE permalink='$get_permalink'"));
						}
						if($rows['permalink'] == $_SESSION['active_page'] || !isset($_SESSION['active_page']) && $i == 1)
						{
							if($rows['permalink'] == "home")
							{
							?>
							<li id="<?php echo $rows['permalink'];?>" class="page active">
								<a href="<?php echo rootpath() ; ?>" onclick='return change_pages("<?php echo ($rows['permalink']) ?>","<?php echo ($rows['title']) ?>",event);'><?php echo ($rows['title'])?></a>
							</li>
							<?php 
							}
							else
							{
							?>
							<li id="<?php echo $rows['permalink'];?>" class="page active">
								<a href="<?php echo rootpath() ; ?>/page/<?php echo ($rows['permalink']) ?>" onclick='return change_pages("<?php echo ($rows['permalink']) ?>","<?php echo ($rows['title']) ?>",event);'><?php echo ($rows['title'])?></a>
							</li>
							<?php 
							}
						}	
						else
						{
							if($rows['permalink'] == "home")
							{
							?>
							<li id="<?php echo $rows['permalink'];?>" class="page">
								<a href="<?php echo rootpath() ; ?>" onclick='return change_pages("<?php echo ($rows['permalink']) ?>","<?php echo ($rows['title']) ?>",event);'><?php echo ($rows['title'])?></a>
							</li>
							<?php 
							}
							else
							{
							?>
							<li id="<?php echo $rows['permalink'];?>" class="page">
								<a href="<?php echo rootpath() ; ?>/page/<?php echo ($rows['permalink']) ?>" onclick='return change_pages("<?php echo ($rows['permalink']) ?>","<?php echo ($rows['title']) ?>",event);'><?php echo ($rows['title'])?></a>
							</li>
							<?php 
							}
						}					
						$i++;
					}
					?>
				</ul>
				<?php if(layout()) { ?>
				<ul class="nav navbar-nav navbar-left">
				<?php } else { ?>
				<ul class="nav navbar-nav navbar-right">
				<?php } ?>
					<li class="page" id="contact">
						<a  href="<?php echo rootpath() ; ?>/contact" onclick="return contact_page('contact',event);"><?php echo $_SESSION['Contact Us'] ; ?></a>
					</li>
				</ul>
			</div>
		</nav>
	</div> 
	</header>
<?php 
if(isset($_SESSION['loader_session'])) 
{ 
?>
	    <div id="preloader">
		    <div id="facebookG">
			    <div id="blockG_1" class="facebook_blockG">
			    </div>
			    <div id="blockG_2" class="facebook_blockG">
			    </div>
			    <div id="blockG_3" class="facebook_blockG">
			    </div>
		    </div>
	    </div>
<?php } 
?>
<!--Search Box-->
<div id="search-box" class="box">
	<div class="container">
		<div class="clearfix hidden-xs"></div>
		<div class="logo">
			<a style="cursor: pointer;" onclick="change_pages('home','Home');">
				<img alt="<?php echo $_SERVER['HTTP_HOST'] ; ?>" src="<?php echo rootpath()?>/style/images/<?php echo get_logo().'?'.time() ; ?>">
			</a>
		</div>
		<div class="search">
			<?php if(layout()) { ?>
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 search-btn">
				<span id="btn_background" class="input-group">
					<button class="domain-btn btn btn-info btn-lg Search" value="Search">
						<i class="fa fa-search"></i> <span class="hidden-xs"><?php echo $_SESSION['Search'] ; ?></span>
					</button>
				</span>
			</div>
			<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 search-input">
				<div class="input-group">
					<span class="input-group-addon"></span>
					<input class="form-control input-lg Search" autofocus="autofocus" type="text" autocomplete="off" id="Search"  name="domain" maxlength="60"  placeholder="<?php echo $_SESSION['Placeholder'] ; ?>">						
				</div>
			</div>
			<?php } else { ?>
			<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 search-input">
				<div class="input-group">
					<span class="input-group-addon"></span>
					<input class="form-control input-lg Search" autofocus="autofocus" type="text" autocomplete="off" id="Search"  name="domain" maxlength="60"  placeholder="<?php echo $_SESSION['Placeholder'] ; ?>">						
				</div>
			</div>
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 search-btn">
				<span id="btn_background" class="input-group">
					<button class="domain-btn btn btn-info btn-lg Search" value="Search">
						<i class="fa fa-search"></i> <span class="hidden-xs"><?php echo $_SESSION['Search'] ; ?></span>
					</button>
				</span>
			</div>
			<?php } ?>
		</div>
	</div>
</div>
<?php 
$rows=mysql_fetch_array(mysqlQuery("SELECT * FROM social_profiles"));
$f_status = $rows['f_status'];
$t_status = $rows['t_status'];
$g_status = $rows['g_status'];
$social_status = $rows['social_buttons'];
if($social_status == 1)
{
	if($f_status == 1 || $t_status == 1 || $g_status == 1)
	{
	?>
	<div id="social-button" class="social hidden-xs">
		<div class="container">
			<div class="text"><?php echo $_SESSION['social_message'] ; ?></div>
			<div class="social-holder">
				<?php if($f_status) { ?>
				<div class="fb">
					<div id="fb-root"></div>
					<script>(function(d, s, id) {
						var js, fjs = d.getElementsByTagName(s)[0];
						if (d.getElementById(id)) return;
						js = d.createElement(s); js.id = id;
						js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.0";
						fjs.parentNode.insertBefore(js, fjs);
						  }(document, 'script', 'facebook-jssdk'));
					</script>
					<div class="fb-like" data-href="https://www.facebook.com/<?php echo $rows['facebook'];?>" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
				</div>
				<?php } if($t_status) { ?>
				<div class="twitter">
					<a href="https://twitter.com/<?php echo $rows['twitter'];?>" class="twitter-follow-button" data-show-count="false">Follow @nexthon</a> <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>	
				</div>
				<?php } if($g_status) { ?>
				<div class="google-plus">
					<script src="https://apis.google.com/js/platform.js" async defer></script>
					<div class="g-plusone" data-size="medium" data-href="https://plus.google.com/<?php echo $rows['google_plus'];?>"></div>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
	<?php 
	} 
}
?>
<div id="top-header-domain" style="display:none">
	<div id="change-background" class="com-rslt grey-rslt">
		<div class="wrapper">
			<a id="top_domain_href" target="_blank" href="#">
				<div id="top_domain" class="com-wrap">
					<div class="com-wrap"><span class="live-domain-name"></span> <div class="com-btn top-price"><div class="spinner main-tld-loader"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div></div></div>
				</div>
			</a>
		</div>
	</div>
</div>