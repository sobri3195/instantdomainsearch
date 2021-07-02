<?php 
include dirname(__FILE__) . '/includes/header.php';
 
include dirname(__FILE__) . '/includes/header_under.php';
 
$error = false;

$csrfVariable = 'csrf_' . basename($_SERVER['PHP_SELF']);

if (isset($_POST["submit"])) 
{

	if($_SESSION[$csrfVariable] != $_POST['csrf'])
	$error = true;

	$title = str_replace(array('"'), '', $_POST["title"]);
		
	$title = xssClean(mres(trim($title)));
	
	$content = xssClean(mres(trim($_POST["content"])));
	
	$description = xssClean(mres(trim($_POST["description"])));
	
	$keywords = xssClean(mres(trim($_POST["keywords"])));
	
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
	
	if (isset($_POST["permalink"]) && trim($_POST["permalink"]) != "")
		$permalink = gen_permalink($_POST["permalink"]);
	else
		$permalink = gen_permalink($_POST["title"]);
		
	$permalink = str_replace(array('"'), '', $permalink);
		
	$display_order = getDisplayOrder();
	
	if (strlen($title) > 70 || strlen($title) <1)
		$error = $lang_array['add_page_error'];
		
	$array = mysql_fetch_array(mysqlQuery("SELECT MAX(id) AS id FROM pages"));
				
	$id = $array["id"];
				
	$id=$id+1;
	
	if(!$error)
	{
		add_page($id,$permalink,$description, $keywords, $status, $display_order,$header_status,$footer_status);
		add_page_language($id, $permalink, $title,$content);
		header("Location: pages.php?id=$id");
	}
	
}

$key = sha1(microtime());

$_SESSION[$csrfVariable] = $key;

?>
	<title>Page Settings:<?php echo (get_title());?></title>
	</head>
	<body>
	<?php include "includes/top_navbar.php";?>
	<script type="text/javascript">
		$(function() {$("#keywords").tagsInput({width:"auto"});});	
    </script>
	<div id="wrapper">
		<div id="page-wrapper">
			<div class="row page-ttl">
				<div class="col-lg-12">
					<h1 class="hidden-xs">
						<i class="fa fa-files-o"></i> Add Page <small>Add new page</small>
					</h1>
					<h4 class="visible-xs">
						<i class="fa fa-files-o"></i> Add Page <small>Add new page</small>
					</h4>
				</div>
			</div>
			<div class="page-content">
				<div class="margin_sides">
					<div class="row">
						<div class="col-lg-8 col-md-10 col-sm-12 col-xs-12">
							<?php 
							if($error)
							{ 
							$error = "<b>Error : </b> " . $error; 
							?>
							<div class="alert alert-danger alert-dismissable">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="fa fa-exclamation-triangle"></i> <?php echo ($error); ?>
							</div>
							<?php
							} 
							if(isset($_POST['submit']))
							{ 
							?>
							<form role="form" action="add_page.php" method="post">
								<div class="form-group">
									<label>Title</label> 
									<input class="form-control" name="title" value="<?php echo ($_POST['title']);?>" required="required" />
								</div>
								<div class="form-group">
									<label>Permalink</label> 
									<input class="form-control" name="permalink" value="<?php echo ($_POST['permalink']);?>" />
								</div>
								<div class="form-group">
									<label>Content</label> 
									<textarea id="content" class="form-control" rows="8" name="content">
										<?php echo ($_POST['content']);?>
									</textarea>
								</div>
								<div class="form-group">
									<label>Meta Description</label> 
									<textarea class="form-control" maxlength="160" style="width:100%;height:100px" rows="15" name="description"><?php echo($_POST['description']); ?></textarea>
								</div>
								<div class="form-group">
									<label>Meta Keywords</label> 
									<textarea class="form-control" maxlength="60" style="width:100%;height:80px" rows="15" id="keywords" name="keywords"><?php echo($_POST['keywords']); ?></textarea>
								</div>
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
								} 
								?>
								</div>
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
								<hr>
								<input type="hidden" name="csrf" value="<?php echo $key; ?>" />
								<div class="form-group">
									<a href="pages.php"><button type="button" class="btn btn-default"><i class="fa fa-chevron-left"></i> Back</button>  <button name="submit" type="submit" class="btn btn-success"><i class="fa fa-check"></i> Add Page</button>
								</div>
							</form>
							<?php
							} 
							else
							{ 
							?>
							<form role="form" action="add_page.php" method="post">
								<div class="form-group">
									<label>Title</label> <input class="form-control" name="title" placeholder="Enter page title" required="required" />
								</div>
								<div class="form-group">
									<label>Permalink</label> <input class="form-control" name="permalink" placeholder="Enter page permalink" />
								</div>
								<div class="form-group">
									<label>Content</label> 
										<textarea id="content" class="form-control" rows="15" name="content" placeholder="Enter page content">
										</textarea>
								</div>
								<div class="form-group">
									<label>Meta Description</label> 
									<textarea class="form-control" maxlength="160" style="width:100%;height:100px" rows="15" name="description" placeholder="Enter Meta Description up to 160 Characters"></textarea>
								</div>
								<div class="form-group">
									<label>Meta Keywords</label> 
									<textarea class="form-control" maxlength="60" style="width:100%;height:80px" rows="15" id="keywords" name="keywords" placeholder="Enter Max 6 Words Comma Separated up to 60 Characters"></textarea>
								</div>
								<div class="form-group">
									<label>Status</label></br>
									<input class="my_checkbox" name="publish" type="checkbox"   checked="checked" />
								</div>
								<div class="form-group">
									<label>Show in Header</label></br>
									<input class="my_checkbox" name="header_status" type="checkbox"   checked="checked" />
								</div>
								<div class="form-group">
								<label>Show in footer</label></br>
									<input class="my_checkbox" name="footer_status" type="checkbox"   checked="checked" />
								</div>								
								<hr>
								<input type="hidden" name="csrf" value="<?php echo $key; ?>" />
								<div class="form-group">
									<a href="pages.php"><button type="button" class="btn btn-default"><i class="fa fa-chevron-left"></i> Back</button>  <button name="submit" type="submit" class="btn btn-success"><i class="fa fa-check"></i> Add Page</button>
								</div>
							</form>
							<?php
							}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	</body>
	<?php include dirname(__FILE__) . '/includes/footer.php'; ?>
</html>