<!DOCTYPE html>
	<html lang="en">
		<head>
			<meta charset="UTF-8" />
			<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />
			<meta name="HandheldFriendly" content="true" />
			<meta name="robots" content="noindex, nofollow">
			<link rel="shortcut icon" type="image/png" href="<?php echo (rootpath() ."/style/images/" . get_favicon().'?'.time());?>"/>
			<link href="<?php echo rootpath()?>/admin/style/css/bootstrap.css" rel="stylesheet">
			<link href="<?php echo rootpath()?>/admin/style/css/admin.css" rel="stylesheet">
			<link  href="<?php echo rootpath()?>/admin/style/font-awesome/css/font-awesome.css" rel="stylesheet">
			<link href="<?php echo rootpath()?>/admin/style/switch/switch/css/bootstrap3/bootstrap-switch.css" rel="stylesheet">
			<script src="<?php echo rootpath()?>/admin/style/js/jquery.min.js"></script>	
			<script src="<?php echo rootpath()?>/admin/style/js/bootstrap.js"></script>
			<script src="//tinymce.cachefly.net/4.0/tinymce.min.js" type="text/javascript"></script>
			<script type="text/javascript" src="<?php echo rootpath()?>/style/js/jquery.js"></script>
			<link rel="stylesheet" type="text/css" href="<?php echo rootpath()?>/admin/style/css/jquery.tagsinput.css" />
			<link rel="stylesheet" type="text/css" href="<?php echo rootpath()?>/admin/style/css/froala_editor.min.css" />
			<link rel="stylesheet" type="text/css" href="<?php echo rootpath()?>/admin/style/css/froala_style.min.css" />
			<script src="<?php echo rootpath()?>/admin/style/js/sweet-alert.min.js"></script>
			<script type="text/javascript" src="<?php echo rootpath()?>/admin/style/js/jquery-ui.js"></script>
			<script type="text/javascript">
			jQuery(document).ready(function($) {
				$(window).load(function(){
					$('#preloader').fadeOut('slow',function(){$(this).remove();});
				});
			});
			</script>
			<?php 
			if(!isset($_SESSION['admin_loader_session']))
			{
				if(p_loader()) 
				$_SESSION['admin_loader_session'] = 1; 
			}
			if (isset($_SESSION['admin_loader_session'])) 
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
			<?php 
			}
			?>