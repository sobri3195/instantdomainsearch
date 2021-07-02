<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />
	<meta name="HandheldFriendly" content="true" /> 
	<link rel="shortcut icon" type="image/png" href="<?php echo (rootpath() ."/style/images/" . get_favicon().'?'.time());?>"/>
	<link href="<?php echo rootpath()?>/static/css/font-awesome.min.css" rel="stylesheet"> 
	<link href="<?php echo rootpath()?>/static/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo rootpath()?>/static/css/style.css" rel="stylesheet">
	<?php if(layout()) { ?>
	<link href="<?php echo rootpath()?>/static/css/styleRTL.css" rel="stylesheet">
	<?php } ?>
    <script src="<?php echo rootpath()?>/style/js/jquery.1.9.1.min.js"></script>	