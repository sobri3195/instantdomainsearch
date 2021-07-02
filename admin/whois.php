<?php
include dirname(__FILE__) . '/includes/header.php'; 

include dirname(__FILE__) . '/includes/header_under.php';
 
$error = false;

$csrfVariable = 'csrf_' . basename($_SERVER['PHP_SELF']);

if(isset($_POST['submit'])) 
{

	if($_SESSION[$csrfVariable] != $_POST['csrf'])
		$error = "Session Expired! Click on Update button again.";
	
	$id = (int)mres(trim($_POST['id']));

    $server = xssClean(mres($_POST["server"]));
    
    $tld = xssClean(trim($_POST["tld"]));
	
    $tld = preg_replace( "/^\.+|\.+$/", "", $tld);
	
    $response = xssClean(trim($_POST["response"]));
	
	$count = mysql_num_rows(mysqlQuery("SELECT tld FROM tlds WHERE tld='$tld'"));
		
	if($count > 0)
		$error = "TLD already exist !";
	
	if($server == "" || $tld == "" || $response == "" && !$error)
		$error = "Please Fill Empty Fields !";
	
	$array = mysql_fetch_array(mysqlQuery("SELECT MAX(display_order) AS disp_order FROM tlds"));

	$total = $array["disp_order"];

	if($total>0)
		$display_order = $total + 1;
	else
		$display_order = 1;
	
	if(!$error)
	{
		$mysql = mysqlQuery("INSERT INTO tlds(tld,server,response,status,display_order) VALUES('$tld','$server','$response','1','$display_order')");
		$alterInstant = mysqlQuery("ALTER TABLE `instant_domain` ADD `$tld` TINYINT(1) NOT NULL");
		$alterInstant = mysqlQuery("ALTER TABLE `affiliates` ADD `$tld` VARCHAR(10) NOT NULL");
		$res = mysql_query("SELECT * FROM tlds");
		$records = array();
		while($obj = mysql_fetch_array($res)) {
			$tld = $obj['tld'];
			$records [$tld][0]= $obj['server'];
			$records [$tld][1]= $obj['response'];
			$i++;
		}
		file_put_contents("../libs/whois.servers.json", json_encode($records));
		unset($_SESSION['TldArray']);
		unset($_SESSION['tlds']);
		unset($_SESSION['set']);
	}
    
}

$key = sha1(microtime());

$_SESSION[$csrfVariable] = $key; 

?>
	<title>Server API Settings: <?php echo(getMetaTitle()) ?></title>
	</head>
	<body>
		<?php 
		include "includes/top_navbar.php"; 
		?>
		<div id="wrapper">
			<div id="page-wrapper">
				<div class="row page-ttl">
					<div class="col-lg-12">
						<h1>
							<i class="fa fa-wrench"></i> Server API Settings <small>ADD Tld Server</small>
						</h1>
					</div>
				</div> <!-- /.row -->
				<div class="page-content">
					<div class="margin_sides">
						<div class="row">
							<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
								<?php 
								if($error!="") 
								{ 
								?>
								<div class="alert alert-danger alert-dismissable">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
									<i class="fa fa-exclamation-triangle"></i>
									<?php 
									echo($error); 
									?>
								</div>
								<?php 
								} 
								else
								{
									if(isset($_POST['submit']))
									{
										?>
										<div class="alert alert-success alert-dismissable">
											<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
											<i class="fa fa-check-square-o"></i> New TLD Added Successfully !
										</div>
										<?php 
									} 
								} 
								?>
								<form action="whois.php" method="POST">
									<div class="form-group">
										<label>Tld Name</label>
										<input class="form-control" name="tld" value="<?php echo($tld); ?>" placeholder="Enter TLD Name" required>
									</div>
									<div class="form-group">
										<label>WHOIS Servers</label>
										<input class="form-control" name="server" value="<?php echo($server); ?>" placeholder="Enter WHOIS Server" required>
									</div>
									<div class="form-group">
										<label>Response</label>
										<input class="form-control" name="response" value="<?php echo($response); ?>" placeholder="Enter Server Response" required title="You Must Enter Valid Email.">
									</div>
									<input type="hidden" name="csrf" value="<?php echo $key; ?>" />
									<input type="hidden" name="id" value="<?php echo $id; ?>" />
									<hr>
									<div class="form-group">
										<a href="tld_sorting.php"><button type="button" class="btn btn-default"><i class="fa fa-chevron-left"></i> Back </button></a> <button type="submit" name="submit" class="btn btn-success"><i class="fa fa-plus"></i>  ADD TLD</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php include dirname(__FILE__) . '/includes/footer.php'; ?>
	</body>
</html>