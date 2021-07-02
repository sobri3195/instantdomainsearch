<?php
include dirname(__FILE__) . '/includes/header.php';
 
include dirname(__FILE__) . '/includes/header_under.php';

$error = false;

$csrfVariable = 'csrf_' . basename($_SERVER['PHP_SELF']);

if(isset($_POST['submit']))
{
    if($_SESSION[$csrfVariable] != $_POST['csrf'])
    $error = "Session Expired! Click on Update button again.";
	
	$name=strip_tags(htmlspecialchars(mres($_POST['name'])));
	
	$title       = strip_tags(htmlspecialchars(mres($_POST["title"])));
	
	$description = strip_tags(htmlspecialchars(mres($_POST["description"])));
	
	$keywords    = strip_tags(htmlspecialchars(mres($_POST["keywords"]))); 
	
	$whois_link    = strip_tags(htmlspecialchars(mres($_POST["whois_link"]))); 
	
	$rootpath    = rtrim(trim($_POST["rootpath"]), "/");
	
	$urlStructure = ($_POST['www']=="on") ? 1 : 0;
	
	$https = ($_POST['https']=="on") ? 1 : 0;
	
	$f_loader = ($_POST['f_loader']=="on") ? 1 : 0;
	
	$p_loader = ($_POST['p_loader']=="on") ? 1 : 0;
	
	$whoisStatus = ($_POST['whoisStatus']=="on") ? 1 : 0;
	
	if($https) {
		$code = httpStatusCode("https://" . $rootpath);
		if(!$code) {
			$sslError = true;
		}
	}
	if($sslError)
		$https = 0;
	
	if(isset($_POST['name']) && $_POST["name"]!="" && !$error)
	{
	
		if(is_alpha($_POST["name"]))
		$name = $_POST["name"];
		else
		$error =$lang_array['invalid_website_name']."<br />";
		
	}
	if(isset($_POST['title']) && $_POST["title"]!="" && !$error)
	{
	
		if(valid_title($_POST["title"]))
		$title = $_POST["title"];
		else
		$error =$lang_array['title_invalid']."<br />";
		
	}
	if(isset($_POST['description']) && $_POST["description"]!="" && !$error)
	{
	
		if(valid_desc($_POST["description"]))
		$description = $_POST["description"];
		else
		$error =$lang_array['website_length_description']."<br />";
	
	}
	if(isset($_POST['keywords']) && $_POST["keywords"]!="" && !$error)
	{
	
		if(valid_keyword($_POST["keywords"]))
		$keywords = $_POST["keywords"];
		else
		$error =$lang_array['website_length_keyword']."<br />";
		
	}
	if (trim($_FILES["mylogo"]["name"]) != "" && !$error)
	{
	
		$base = explode(".", strtolower(basename($_FILES["mylogo"]["name"]))); 
		
		$ext  = end($base);       
		
		if (valid_file_extension($ext))
		{
		
			$logo = "logo." . $ext; 
			
			unlink("../style/images/" . get_logo());           
			
			move_uploaded_file($_FILES["mylogo"]["tmp_name"], "../style/images/" . $logo);
			
		}
		else
		{
		
		$logo = get_logo();
		
		$error =$lang_array['invalid_logo']."<br />";
		
		}
		
	}
	else
	{
	
		$logo = get_logo();
	
	}
	if (trim($_FILES["myfavicon"]["name"]) != "" && !$error)
	{
		$base = explode(".", strtolower(basename($_FILES["myfavicon"]["name"])));
		
		$ext  = end($base);
		
		if (valid_favicon_extension($ext)) 
		{
		
			$favicon = "favicon." . $ext;
			
			unlink("../style/images/" . get_favicon()); 
			
			move_uploaded_file($_FILES["myfavicon"]["tmp_name"], "../style/images/" . $favicon);
			
		}
		else
		{
		
		$favicon = get_favicon();
		
		$error =$lang_array['invalid_favicon']."<br />"; 
		
		}  
		
	}
	else
	{
	
		$favicon = get_favicon(); 
	
	}
	if(!$error)
	{
	   
		update_settings($name,$title, $description, $keywords, $rootpath, $logo, $favicon,$urlStructure,$https,$f_loader,$p_loader,$whois_link,$whoisStatus); 
		unset($_SESSION['whois_link']);
	
	}
	
}

$key = sha1(microtime());

$_SESSION[$csrfVariable] = $key;

?>
	<title>Website Settings: <?php echo(getMetaTitle()) ?></title>
	</head>
	<body>
	<script type="text/javascript">
		$(function() {$("#keywords").tagsInput({width:"auto"});});	
    </script>
		<div id="wrapper">
		<?php 
			include "includes/top_navbar.php";
		?>
		<div id="page-wrapper">
			<div class="row page-ttl">
				<div class="col-lg-12">
					<h1><i class="fa fa-cogs"></i> Website Settings <small>Manage your website</small></h1>
				</div>
			</div><!-- /.row -->
			<ol class="page-content">
				<div class="margin_sides">
					<div class="row">
						<div class="col-md-12">
							<div class="widget">
								<?php
								if($error)	
								{ 
								
									?>
									<div class="alert alert-danger alert-dismissable col-lg-8 col-md-8 col-sm-8 col-xs-12">
										<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="fa fa-exclamation-triangle"></i> <?php echo($error); ?>
									</div>	
									<?php 
									
								} 
								else 
								{
								
									if((is_alpha($_POST['name'])) && valid_title($_POST["title"]) && valid_desc($_POST["description"]) && valid_keyword($_POST["keywords"]))
									{
									
										?>
										<div class="alert alert-success alert-dismissablecol-lg-8 col-md-8 col-sm-8 col-xs-12">
											<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
											<i class="fa fa-check-square-o"></i> <?php echo $lang_array['website_success_message']; ?>
										</div>
										<?php 
										
									} 
									
								}
								?>	  
								<form class="form-horizontal col-lg-8 col-md-8 col-sm-12 col-xs-12" role="form" action="settings.php" method="post" enctype="multipart/form-data">
									<?php 
									if(isset($_POST['submit']))
									{
										?>
										<div class="form-group">
										</div>
										<div class="form-group">
											<label>Website Name</label>
												<input type="text" class="form-control" id="name" name="name" value="<?php echo ($_POST['name']); ?>" required="">
												<?php
												if (!is_alpha($_POST['name']))
												{
												
													?>
													<span class="label label-danger"><?php echo $lang_array['name_letter']; ?></span>
													<?php 
													
												}
												?>
										</div>
										<div class="form-group">
											<label>Website Title</label>
												<input type="text" class="form-control" id="gettitle" maxlength="70" name="title" value="<?php echo($_POST['title']); ?>" required="">
												<?php
												if (!valid_title($_POST["title"]) && trim($_POST["title"]) != "")
												{
												    ?>
													<span class="label label-danger"><?php echo $lang_array['website_title_length']; ?></span>
													<?php
												
												}
												?>
										</div>
										<div class="form-group">
											<label>Description</label>
												<textarea class="form-control" id="des" rows="5" required="" maxlength="160"  name="description"><?php echo($_POST['description']); ?></textarea>
												<?php
												if (!valid_desc($_POST["description"]) && trim($_POST["description"]) != "")
												{
												
													?>
													<span class="label label-danger"><?php echo $lang_array['website_description_length']; ?></span>
													<?php
													
												}
												?>
										</div>
										<div class="form-group">
											<label>Keywords</label>
												<textarea class="form-control" rows="5" id="keywords" maxlength="160" name="keywords" required=""/><?php echo($_POST['keywords']); ?></textarea>																		
												<?php
												if (!valid_keyword($_POST["keywords"]) && trim($_POST["keywords"]) != "")
												{
												
												    ?>
													<span class="label label-danger"><?php echo $lang_array['website_keyword_length']; ?></span>
												    <?php
													
												}
												?>
										</div>
										<div class="form-group">
											<label>Installation Path</label>
												<input type="text" class="form-control" name="rootpath" value="<?php echo($_POST['rootpath']);?>" required=""/>
												<?php
												if (!valid_url($_POST["rootpath"]))
												{
												
												?>
												<span class="label label-danger"><?php echo $lang_array['invalid_rootpath']; ?></span>
												
												<?php
												}
												?>
										</div>
										<div class="form-group">
											<label>Whois <strong>Allow</strong> ?</label>
											<div class="switch res-switch">
												<?php if (whoisStatus()) { ?>												
													<input class="my_checkbox" type="checkbox" name="whoisStatus" checked>
													<label><i></i></label>												
												<?php } else { ?>												
													<input class="my_checkbox" type="checkbox" name="whoisStatus">
													<label><i></i></label>												
												<?php } ?>
											</div>
										</div>
										<div class="form-group">
											<label>WhoIs Link</label>
											<input type="text" class="form-control" name="whois_link" value="<?php echo($_POST['whois_link']);?>" required=""/>
											<a target="_blank" href="http://j.mp/buy-whois" class="btn btn-primary btn-xs mrg-10-top">BUY WhoIs Script</a>
										</div>
										<div class="form-group">
											<label>Force <strong>WWW</strong> ?</label>
											<div class="switch res-switch">
												<?php if (urlStructure()) { ?>												
													<input class="my_checkbox" type="checkbox" name="www" checked>
													<label><i></i></label>												
												<?php } else { ?>												
													<input class="my_checkbox" type="checkbox" name="www">
													<label><i></i></label>												
												<?php } ?>
											</div>
										</div>										
										<div class="form-group">
											<label>Force https:// ?</label>
											<div class="switch res-switch">
												<?php if (httpsStatus()) { ?>												
													<input class="my_checkbox" type="checkbox" name="https" checked>
													<label><i></i></label>												
												<?php } else { ?>												
													<input class="my_checkbox" type="checkbox" name="https">
													<label><i></i></label>												
												<?php } ?>
											</div>
										</div>
										<div class="form-group">
											<label>Front-end Preloader</label>
											<div class="switch res-switch">
												<?php if (f_loader()) { ?>												
													<input class="my_checkbox" type="checkbox" name="f_loader" checked>
													<label><i></i></label>												
												<?php } else { ?>												
													<input class="my_checkbox" type="checkbox" name="f_loader">
													<label><i></i></label>												
												<?php } ?>
											</div>
										</div>	
										<div class="form-group">
											<label>Admin-Panel Preloader</label>
											<div class="switch res-switch">
												<?php if (p_loader() ) { ?>												
													<input class="my_checkbox" type="checkbox" name="p_loader" checked>
													<label><i></i></label>												
												<?php } else { ?>												
													<input class="my_checkbox" type="checkbox" name="p_loader">
													<label><i></i></label>												
												<?php } ?>
											</div>
										</div>
										<div class="form-group">
											<label>Logo</label><br>
												<img class="logo_web" id="upload_img" src="<?php echo (rootpath() ."/style/images/" . get_logo().'?'.time());?>" />
										</div>
										<div class="form-group">
											<input class="hide show-large-logo" type="file" id="mylogo" name="mylogo" onchange="showlogo(this);" style="display:none;" />
												<a class="btn btn-info btn-sm click-large-logo"><i class="fa fa-upload"></i>  Change Logo </a>
										</div>
										<div class="form-group">
											<label>Favicon</label><br>
												<img class="favicon_web" id="upload_fav" src="<?php echo (rootpath() ."/style/images/" . get_favicon().'?'.time());?>" />
										</div>
										<div class="form-group">
											<input class="hide show-logo" type="file" id="myfavicon" name="myfavicon" onchange="showfav(this);" style="display:none;" />
												<a class="btn btn-info btn-sm click-logo"><i class="fa fa-upload"></i>  Change Favicon </a>
										</div>
										<hr>
										<input type="hidden" name="csrf" value="<?php echo $key; ?>" />
										<div class="form-group">
											<button class="btn btn-success" name="submit" type="submit"><i class="fa fa-check"></i> Update</button>
										</div>
										<?php 
									} 
									else
									{ 
										?>
										<div class="form-group">
										</div>
										<div class="form-group">
											<label>Website Name</label>
												<input type="text" class="form-control" id="name" name="name" value="<?php echo (get_name()); ?>" required="">
										</div>
										<div class="form-group">
											<label>Website Title</label>    
												<input type="text" class="form-control" id="gettitle" maxlength="70" name="title" value="<?php echo(get_title()); ?>" required="">
										</div>
										<div class="form-group">
											<label>Description</label>
												<textarea class="form-control" id="des" rows="5" required="" maxlength="160"  name="description"><?php echo(get_description()); ?></textarea>
										</div>
										<div class="form-group">
											<label>Keywords</label>
												<textarea class="form-control" rows="5" maxlength="160" id="keywords" name="keywords" required=""><?php echo(get_tags()); ?></textarea>
										</div>
										<div class="form-group">
											<label>Installation Path</label>
												<input type="text" class="form-control" name="rootpath" value="<?php echo rootpath();?>" required="">
										</div> 
										<div class="form-group">
											<label>Whois <strong>Allow</strong> ?</label>
											<div class="switch res-switch">
												<?php if (whoisStatus()) { ?>												
													<input class="my_checkbox" type="checkbox" name="whoisStatus" checked>
													<label><i></i></label>												
												<?php } else { ?>												
													<input class="my_checkbox" type="checkbox" name="whoisStatus">
													<label><i></i></label>												
												<?php } ?>
											</div>
										</div>
										<div class="form-group">
											<label>WhoIs Link</label>
											<input type="text" class="form-control" name="whois_link" value="<?php echo(get_whois()); ?>" required=""/>
											<a target="_blank" href="http://j.mp/buy-whois" class="btn btn-primary btn-xs mrg-10-top">BUY WhoIs Script</a>
										</div>
                                        <div class="form-group">
											<label>Force <strong>WWW</strong> ?</label>
											<div class="switch res-switch">
												<?php if (urlStructure()) { ?>												
													<input class="my_checkbox" type="checkbox" name="www" checked>
													<label><i></i></label>												
												<?php } else { ?>												
													<input class="my_checkbox" type="checkbox" name="www">
													<label><i></i></label>												
												<?php } ?>
											</div>
										</div>										
										<div class="form-group">
											<label>Force https:// ?</label>
											<div class="switch res-switch">
												<?php if (httpsStatus()) { ?>												
													<input class="my_checkbox" type="checkbox" name="https" checked>
													<label><i></i></label>												
												<?php } else { ?>												
													<input class="my_checkbox" type="checkbox" name="https">
													<label><i></i></label>												
												<?php } ?>
											</div>
										</div>
										<div class="form-group">
											<label>Front-end Preloader</label>
											<div class="switch res-switch">
												<?php if (f_loader()) { ?>												
													<input class="my_checkbox" type="checkbox" name="f_loader" checked>
													<label><i></i></label>												
												<?php } else { ?>												
													<input class="my_checkbox" type="checkbox" name="f_loader">
													<label><i></i></label>												
												<?php } ?>
											</div>
										</div>	
										<div class="form-group">
											<label>Admin-Panel Preloader</label>
											<div class="switch res-switch">
												<?php if (p_loader()) { ?>												
													<input class="my_checkbox" type="checkbox" name="p_loader" checked>
													<label><i></i></label>												
												<?php } else { ?>												
													<input class="my_checkbox" type="checkbox" name="p_loader">
													<label><i></i></label>												
												<?php } ?>
											</div>
										</div>										
										<div class="form-group">
											<label>Logo</label><br>
												<img class="logo_web" id="upload_img" src="<?php echo (rootpath() ."/style/images/" . get_logo().'?'.time());?>" />
										</div>
										<div class="form-group">
											<input class="hide show-large-logo" type="file" id="mylogo" name="mylogo" onchange="showlogo(this);" style="display:none;" />
												<a class="btn btn-info btn-sm click-large-logo"><i class="fa fa-upload"></i>  Change Logo </a>
										</div>
										<div class="form-group">
											<label>Favicon</label><br>
												<img class="favicon_web" id="upload_fav" src="<?php echo (rootpath() ."/style/images/" . get_favicon().'?'.time());?>" />
										</div>
										<div class="form-group">
											<input class="hide show-logo" type="file" id="myfavicon" name="myfavicon" onchange="showfav(this);" style="display:none;" />
												<a class="btn btn-info btn-sm click-logo"><i class="fa fa-upload"></i>  Change Favicon </a>
										</div>
										<hr>
										<input type="hidden" name="csrf" value="<?php echo $key; ?>" />
										<div class="form-group">
												<button class="btn btn-success" name="submit" type="submit"><i class="fa fa-check"></i> Update</button>
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
			</ol>
			</div>
		</div>
	<?php include dirname(__FILE__) . '/includes/footer.php'; ?>
	<script src="<?php echo rootpath()?>/admin/style/js/jquery.tagsinput.js"></script>
	<script type="text/javascript">		
		function onAddTag(tag) 
		{
		
			alert("Added a tag: " + tag);
		
		}
		function onRemoveTag(tag) 
		{
		
			alert("Removed a tag: " + tag);
		
		}

		function onChangeTag(input,tag) 
		{
		
			alert("Changed a tag: " + tag);
		
		}
		$(function() {

			$('#keyword').tagsInput({width:'auto'});
		
		});
		
	</script>
	<script>
		$(".click-large-logo").click(function(){
			$("#mylogo").trigger('click');
		});
		function showlogo(input) 
		{
			if(input.files && input.files[0]) 
			{
				var reader = new FileReader();
				reader.onload = function (e) {
					 $('#upload_img')
					.attr('src', e.target.result)
				};
				reader.readAsDataURL(input.files[0]);
			}
		}
	</script>
	<script>
		$(".click-logo").click(function(){
			$("#myfavicon").trigger('click');
		});
		function showfav(input) {
			if (input.files && input.files[0]) 
			{
				var reader = new FileReader();
				reader.onload = function (e) {
					$('#upload_fav')
					.attr('src', e.target.result)
					.width(64)
					.height(64);
				};
				reader.readAsDataURL(input.files[0]);
			}
		}
	</script>
	</body>
</html>