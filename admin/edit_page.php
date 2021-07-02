<?php
include dirname(__FILE__) . '/includes/header.php';
 
include dirname(__FILE__) . '/includes/header_under.php';

$csrfVariable = 'csrf_' . basename($_SERVER['PHP_SELF']);

$error =false;
if (isset($_GET['id']) && is_numeric($_GET['id'])) {

	$id = (int)mres(trim($_GET['id']));
	
	$array = mysql_fetch_array(mysqlQuery("SELECT * FROM `pages` WHERE `id`='$id'"));
	
	if(isset($array['id'])) {	
		$description = $array['description'];
		
		$keywords = $array['keywords'];
		
		$permalink = $array['permalink'];
		
		$status = $array['status'];
		
		$header_status = $array['header_status'];
		
		$footer_status = $array['footer_status'];
	}
	else {
		header("Location: pages.php");
	}
} 
else if(isset($_POST['submit'])) {

	if($_SESSION[$csrfVariable] != $_POST['csrf'])
		$error = "Session Expired! Click on Update button again.";

	$id = (int)mres(trim($_POST['id']));
	
	$title = str_replace(array('"'), '', $_POST['title']);

	$title = xssClean(mres($title));
	
	if(isset($_POST['content']) && $_POST['content'] != "") {
		$content = xssClean(mres($_POST['content']));	
		if($content == "" && !$error)
			$error = $lang_array['empty_content'];
	}
	
	$language = xssClean(mres($_POST['select_language']));
	
	$description = xssClean(mres($_POST['description']));
	
	$keywords = xssClean(mres($_POST['keywords']));
	
	$permalink = gen_permalink($_POST['permalink']);
	
	if($_POST['publish'] == "on")
		$status = 1;
	else
		$status = 0;
		
	if($_POST['header_status'] == "on")
		$header_status = 1;
	else
		$header_status = 0;
		
	if($_POST['footer_status'] == "on")
		$footer_status = 1;
	else
		$footer_status = 0;
	
	if (strlen($permalink) > 70 || strlen($permalink) < 1 && !$error)
		$error = $lang_array['edit_page_error'];
	
	if (!$error) {
	    if($permalink == "home") {
			update_homepage($id,$description, $keywords,$header_status,$footer_status);
		}
		else {
			update_page($id, $permalink,$description, $keywords, $status,$header_status,$footer_status);
		}
		edit_page_language($id,$content,$language,$title); 
	}
	
} 
else {
	header("Location: pages.php");
}

$key = sha1(microtime());

$_SESSION[$csrfVariable] = $key;
?>
	<title>Edit Page Settings: <?php echo(get_title());?></title>
	</head>
	<body>
		<?php include "includes/top_navbar.php"; ?>
		<script type="text/javascript">
			$(function() {$("#keywords").tagsInput({width:"auto"});});	
		</script>
		<div id="wrapper">
			<div id="page-wrapper">
			    <div id="language_preloader"></div>
				<div class="row page-ttl">
					<div class="col-lg-12">
						<h1>
							<i class="fa fa-files-o"></i> Edit Page <small>Edit <?php echo ucfirst($permalink); ?> Page / Language</small>
						</h1>
					</div>
				</div>
				<div class="page-content">
					<div class="margin_sides">
						<div class="row">
							<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
								<?php
								if ($error)
								{ 
								?>
								<div class="alert alert-danger alert-dismissable">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="fa fa-exclamation-triangle"></i> <?php echo ($error); ?>
								</div>
								<?php
								} 
								else if(isset($_POST['submit']))
								{ 
								?>
								<div class="alert alert-success alert-dismissable">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="fa fa-check-square-o"></i> <?php echo $lang_array['edit_page_success']; ?>
								</div>
								<?php
								} 
								?>
								<form role="form" action="edit_page.php" method="post">
									<input type="hidden" name="id" id="id" value="<?php echo $id; ?>" >
									<?php
									if($permalink == "home")
									{
									?>
									<input type="hidden" class="form-control" name="permalink" id="permalink" placeholder="Permalink" value="<?php echo ($permalink); ?>" />
									<?php
									}
									else
									{
									?>
									<div class="form-group">
										<label>Permalink</label> 
										<input type="text" class="form-control" name="permalink" id="permalink" placeholder="Permalink" value="<?php echo ($permalink); ?>" />
									</div>
									<?php
									}
									?>
									<div class="form-group">
										<label>Meta Description</label> 
										<textarea class="form-control" maxlength="160" style="width:100%;height:100px" rows="15" name="description" required><?php echo($description); ?></textarea>
									</div>
									<div class="form-group">
										<label>Meta Keywords</label> 
										<textarea class="form-control" maxlength="60" style="width:100%;height:80px" rows="15" id="keywords" name="keywords" required><?php echo($keywords); ?></textarea>
									</div>
									<div class="form-group">
										<label>Language</label> 
										<?php 
										$mysql = mysqlQuery("SELECT lang_name FROM language");
										
										$id = (int)mres(trim($_GET['id']));
		
										$language = mres(trim($_GET['language']));
										
										$array = mysql_fetch_array(mysqlQuery("SELECT * FROM `page_language` WHERE `id`='$id' AND language = '$language'"));
										
										?>
										<select onchange="add_language()"  class="form-control" id="language" name="language">
										    <?php if(isset($array['id']) && $array['id'] != "" && isset($_GET['language']) && $_GET['language']) { ?>
											<option value=''><?php echo $_GET['language'] ; ?></option>
											<?php 
											} else {
											?>
											<option value=''>Select Language ...</option>
											<?php
											}
											while($rows = mysql_fetch_array($mysql)) {
												if($_GET['language'] != $rows['lang_name']) {
												?>
												<option value="<?php echo $rows['lang_name']; ?>"><?php echo $rows['lang_name']; ?></option>
												<?php 
												}
												$c++;
											}
											?>
										</select>
									</div>
									<?php 
									if(isset($_GET['id']) && $_GET['id'] != "" && isset($_GET['language']) && $_GET['language']) {						
										
										if(isset($array['id']))
										{
										$content = $array['content'];
		
										$title = $array['title'];
										?>
										<input type="hidden" class="form-control" name="select_language" value="<?php echo $_GET['language']; ?>" /> 
										<div class="form-group">
											<label>Page Title</label> 
											<input type="text" class="form-control" name="title"   id="title" placeholder="Page Title" value="<?php echo $title; ?>" /> 
										</div>
										<div class="form-group">
											<label>Content</label>
											<textarea class="form-control" name="content" rows="15" id="content"><?php echo $content; ?>								
											</textarea>
										</div>
										<?php
										}
									}
									if($permalink != "home")
									{
									?>
									<div class="form-group">
									<label>Status</label></br>
										<?php
										if($status)
										{ 
										?>							
											<input class="my_checkbox" name="publish" type="checkbox"   checked="checked" />
										<?php 
										} 
										else 
										{ 
										?>
											<input class="my_checkbox" name="publish"  type="checkbox" name="com_status" /> 
										<?php 
										}  ?>
									</div>
									<?php
									}
									?>
									<div class="form-group">
									<label>Show in Header</label></br>
										<?php
										if($header_status)
										{ 
										?>							
											<input class="my_checkbox" name="header_status" type="checkbox"   checked="checked" />
										<?php 
										} 
										else 
										{ 
										?>
											<input class="my_checkbox" name="header_status"  type="checkbox" name="com_status" /> 
										<?php 
										}  ?>
									</div>
									<div class="form-group">
									<label>Show in footer</label></br>
										<?php
										if($footer_status)
										{ 
										?>							
											<input class="my_checkbox" name="footer_status" type="checkbox"   checked="checked" />
										<?php 
										} 
										else 
										{ 
										?>
											<input class="my_checkbox" name="footer_status"  type="checkbox" name="com_status" /> 
										<?php 
										}  ?>
									</div>
									<input type="hidden" name="csrf" value="<?php echo $key; ?>" />
									<div class="form-group">
										<a href="pages.php"><button type="button" class="btn btn-default"><i class="fa fa-chevron-left"></i> Back </button></a> <button name="submit" type="submit" class="btn btn-success"><i class="fa fa-check"></i> Update</button>
									</div>
								</form>
							</div>	
						</div>	
					</div>
				</div>
			</div>
		</div>
		<?php include dirname(__FILE__) . '/includes/footer.php'; ?>
		<script>
		function add_language()
		{
			var language = document.getElementById("language").value;
			var id = document.getElementById("id").value;
			window.location = "edit_page.php?id="+id+"&language="+language+"";
		}
		</script>
	</body>
</html>