<?php
include dirname(__FILE__) . '/includes/header.php';
 
include dirname(__FILE__) . '/includes/header_under.php';

$error = false;

$regenerated = false;

$csrfVariable = 'csrf_' . basename($_SERVER['PHP_SELF']);

if (isset($_POST['submit'])) 
{

	if($_SESSION[$csrfVariable] != $_POST['csrf'])
	$error = true;

	$pagesStatus = $_POST["pagesStatus"];

	$contactStatus = $_POST["contactStatus"];

	$filename = xssClean(mres(trim($_POST["filename"])));

	if($filename!=sitemapFileName() && $filename!="")
	{

		$file = fopen("../" . $filename, "w+");

		fwrite($file, "");

		fclose($file);

	}

	$pagesStatus = ($pagesStatus == "on") ? 1 : 0;

	$contactStatus = ($contactStatus == "on") ? 1 : 0;

	if($filename == "")
	$error = true;

	if (!$error)
		updateSitemapsStatus($pagesStatus, $contactStatus,$filename);
	
}

$key = sha1(microtime());

$_SESSION[$csrfVariable] = $key;

if (isset($_GET['rg']) && trim($_GET['rg']) == "true") 
{

	$sitemaps = "";
	
	$filename = sitemapFileName();
	
	$sitemaps.= '<?xml version="1.0" encoding="utf-8"?>' . PHP_EOL;
	
	$sitemaps.= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;
	
	$sitemaps.= generateRootSitemap();
	
	if (sitemapContactStatus()) 
	$sitemaps .= generateContactSitemap();
	
	if (sitemapPagesStatus())
	$sitemaps .= generatePagesSitemap();
	
	$sitemaps.= '</urlset>';
	
	if (is_writable("../" . $filename)) 
	{
	
		$file = fopen("../" . $filename, "w+");
		
		fwrite($file, $sitemaps);
		
		fclose($file);
		
		mysqlQuery("UPDATE `sitemaps` SET dateUpdated='" . date('Y-m-d') . "'");
		
		$regenerated = true;
		
		$sitemapURL = rootPath() . "/" . $filename;
		
		$regenerateMSG = "Sitemap Generated Click <a href='http://www.sitemapwriter.com/notify.php?crawler=all&url=" . $sitemapURL . "' target='blank'><strong>Here</strong></a> To Notify Search Engines";
		
	}
	
}  

?>
	<title>
	Sitemap Settings: <?php echo(get_title());?>
	</title>
	</head>
	<body>
	    <?php include "includes/top_navbar.php"; ?>
		<div id="wrapper">
			<div id="page-wrapper">
				<div class="row page-ttl">
					<div class="col-lg-12">
						<h1>
							<i class="fa fa-sitemap"></i> Sitemap Settings <small>Manage Sitemaps</small>
						</h1>
					</div>
				</div><!-- /.row -->
				<div class="page-content">
					<div class="margin_sides">
						<div class="row">
							<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
								<?php 
								if (!is_writable("../" . sitemapFileName()))
								{ 
								?>
								<div class="alert alert-danger">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
									<i class="fa fa-times-circle"></i> 
									<strong><?php echo (sitemapFileName()) ?></strong> is not writeable Please CHMOD 777
								</div>
								<?php 
								} 
								else if (isset($_POST['filename']) && !$error)
								{ 
								?>
								<div class="alert alert-success">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
									<i class="fa fa-check-square-o"></i> 
									<?php echo $lang_array['sitemap_success'];?>
								</div>
								<?php 
								}
								else if (isset($_GET['rg']) && trim($_GET['rg']) == "true" && $regenerated)
								{ 
								?>
								<div class="alert alert-success"><i class="fa fa-check"></i> 
									<?php echo($regenerateMSG); ?>
								</div>
								<?php
								} 
								?>
								<form role="form" action="sitemap.php" method="post">
									<div class="input-group col-xs-8 col-sm-11 col-sm-10 col-lg-8">
										<span class="input-group-addon"><span class="visible-xs"><i class="fa fa-sitemap"></i></span><span class="hidden-xs"><?php echo(rootPath()); ?>/</span></span>
										<input type="text" class="form-control" name="filename" placeholder="e.g: sitemap.xml" value="<?php echo (sitemapFileName()); ?>" required />
									</div>
									<a href="<?php echo(rootPath() . "/" . sitemapFileName().'?'.time()); ?>" class="btn btn-primary btn-xs mrg-10-top">View Sitemap</a>
                                    </br></br>
									<div class="form-group">
										<label>Include Pages</label>
										<?php 
										if(sitemapPagesStatus()) 
										{ 
										?>
										<div class="switch res-switch">
											<input class="my_checkbox" type="checkbox" name="pagesStatus" checked>
											<label><i></i></label>
										</div>
										<?php
										}
										else
										{
										?>
										<div class="switch res-switch">
											<input class="my_checkbox" type="checkbox" name="pagesStatus">
											<label><i></i></label>
										</div>
										<?php 
										} 
										?>
									</div>
									<div class="form-group">
										<label>Include Contact Form</label>
										<?php 
										if(sitemapContactStatus()) 
										{ 
										?>
										<div class="switch res-switch">
											<input class="my_checkbox" type="checkbox" name="contactStatus" checked>
											<label><i></i></label>
										</div>
										<?php 
										} 
										else
										{ 
										?>
										<div class="switch res-switch">
											<input class="my_checkbox" type="checkbox" name="contactStatus">
											<label><i></i></label>
										</div>
										<?php 
										}
										?>
									</div>
									<div class="form-group">
										<label>Last Generated</label>
										<h4>
											<span class="label label-info">
												<?php echo (sitemapDateUpdated()); ?>
												<i class="icon-time"></i>
											</span>
										</h4>
									</div>
									<input type="hidden" name="csrf" value="<?php echo $key; ?>" />
									<hr>
									<div class="form-group">
										<a href="./sitemap.php?rg=true" class="btn btn-primary"> <i class="fa fa-retweet"></i> Generate Sitemap</a>
										<button type="submit" name="submit" class="btn btn-success" ><i class="fa fa-check"></i> Update</button>
									</div>
								</form>
								<button class="notify-without-image" style="display:none" id="sitemaps_update"></button> 
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php include dirname(__FILE__) . '/includes/footer.php'; ?>
	</body>
</html>