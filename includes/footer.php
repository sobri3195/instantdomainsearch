<div class="footer">
	<nav class="container">
		<div class="navbar-nav navbar-left links">
			<?php				
			$i=1;
			$language = $_SESSION['reset_lang_name'];
			$sql_select = mysql_query("SELECT permalink FROM `pages` WHERE status = 1 AND footer_status = 1  ORDER BY display_order");
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
				if($rows['permalink'] != "home")
				{
					if($rows['permalink'] == $_SESSION['active_page'] || !isset($_SESSION['active_page']) && $i == 1)
					{
						?>
						<span class="page">
							<a href="<?php echo rootpath() ; ?>/page/<?php echo ($rows['permalink']) ?>" onclick='return change_pages("<?php echo ($rows['permalink']) ?>","<?php echo ($rows['title']) ?>",event);'>
							<?php echo ($rows['title'])?>
							</a>
						</span>
						<?php 	
					}	
					else
					{
						?>
						<span class="page">
							<a href="<?php echo rootpath() ; ?>/page/<?php echo ($rows['permalink']) ?>" onclick='return change_pages("<?php echo ($rows['permalink']) ?>","<?php echo ($rows['title']) ?>",event);'>
							<?php echo ($rows['title'])?>
							</a>
						</span>
						<?php 
					}
				}
				$i++;
			}
			?>
			<span>
				<a href="<?php echo rootpath() ; ?>/contact" onclick="return contact_page('contact',event);">
					<?php echo $_SESSION['Contact Us'] ;?>
				</a>
			</span>
			<?php 
			
			$mysql = mysql_query("SELECT * FROM language WHERE status = 1");
			
			$count = mysql_num_rows($mysql);
			if($count > 1)			
			{
				?>	
				<div class="nav-navbar flt-nn lang">
					<div class="btn-group dropup">
						<button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><?php echo $_SESSION['Language']; ?> <span class="caret"></span>
							<span class="sr-only">Toggle Dropdown</span>
						</button>
						<ul class="dropdown-menu" role="menu">
							<?php 
							$i = 1;
							while($rows = mysql_fetch_array($mysql))
							{
								if($_SESSION['reset_lang_name'] == $rows['lang_name'])
								{
									?>
									<li class="active"><a href="<?php echo(getAddress()); ?>" onclick="return change_language('<?php echo $rows['lang_name'] ; ?>',event);"><?php echo $rows['lang_name'] ;?></a></li>
									<?php
								}
								else
								{
									?>
									<li><a href="<?php echo(getAddress()); ?>" onclick="return change_language('<?php echo $rows['lang_name'] ; ?>',event);"><?php echo $rows['lang_name'] ;?></a></li>
									<?php
								}
								$i++;
							}
							?>
						</ul>
					</div>
				</div>	
				<?php 
			}
			?>			
		</div>
		<div class="navbar-nav navbar-right">
			<?php if(layout()) { ?>
			<span>
				&#169; <?php echo date('Y') ?> <?php echo $_SESSION['All Rights Reserved'] ;?><a href="<?php echo rootpath() ; ?>">, <?php echo(get_title()); ?></a>.
			</span>
			<div class="navbar-nav flt-nn">
				<span>
					<a href="http://nexthon.com">Nexthon.com</a>
				</span>
				<span>
					<?php echo $_SESSION['Powered By'] ;?>
				</span>
			</div>
			<?php } else { ?>
			<span>
				&#169; <?php echo date('Y') ?> <a href="<?php  echo rootpath(); ?>"><?php echo(get_title()); ?></a>, <?php echo $_SESSION['All Rights Reserved'] ;?>.
			</span>
			<div class="navbar-nav flt-nn">
				<span>
					<?php echo $_SESSION['Powered By'] ;?>
				</span>
				<span>
					<a href="http://nexthon.com">Nexthon.com</a>
				</span>
			</div>
			<?php } ?>
		</div>
	</nav>
</div>
<footer>
	<!--JAVASCRIPT FILES-->
	<script src="<?php echo rootpath()?>/static/js/bootstrap.min.js" defer="defer" ></script>
	<script src="<?php echo rootpath()?>/static/js/app.js"></script>
	<script type="text/javascript" src="<?php echo(rootPath()); ?>/style/js/javascript.php"></script>
	<script type="text/javascript">
	jQuery(document).ready(function($) {
		$(document).ready(function()
		{
			$('#preloader').fadeOut('slow',function(){$(this).remove();});
		});
	});
	</script>
	<?php if(basename($_SERVER['PHP_SELF'])=="index.php") { ?>
	<script>
		$(document).ready(function()
		{
			$(".page").removeClass("active");		
			$("#home").addClass('active');
		});
	</script>
	<?php } if(basename($_SERVER['PHP_SELF'])=="redirect_page.php") { ?>
	<script>
		$(document).ready(function()
		{
			$(".page").removeClass("active");		
			$("#<?php echo $_GET["permalink"] ; ?>").addClass('active');
		});
	</script>
	<?php } if(basename($_SERVER['PHP_SELF'])=="redirect_contact.php") { ?>
	<script>
		$(document).ready(function()
		{
			$(".page").removeClass("active");		
			$("#contact").addClass('active');
		});
	</script>
	<?php } ?>
</footer>
</body>
</html>