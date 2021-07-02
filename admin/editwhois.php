<?php
include dirname(__FILE__) . '/includes/header.php'; 

include dirname(__FILE__) . '/includes/header_under.php';
 
$error = false;

$csrfVariable = 'csrf_' . basename($_SERVER['PHP_SELF']);

if (isset($_GET['id']) && is_numeric($_GET['id'])) {

	$id = (int)mres(trim($_GET['id']));
	
	$array = mysql_fetch_array(mysqlQuery("SELECT * FROM `tlds` WHERE `id`='$id'"));
	
	if(isset($array['id'])) {	
	
		$tld = $array['tld'];
		
		$server = $array['server'];
		
		$response = $array['response'];

	}
	else {
		header("Location: tld_sorting.php");
	}
} 
else if(isset($_POST['submit'])) 
{

	if($_SESSION[$csrfVariable] != $_POST['csrf'])
		$error = "Session Expired! Click on Update button again.";
	
	$id = (int)mres(trim($_POST['id']));

    $server = xssClean(mres($_POST["server"]));
    
    $tld = xssClean(trim($_POST["tld"]));
	
	$tld = preg_replace( "/^\.+|\.+$/", "", $tld);
	
    $response = xssClean(trim($_POST["response"]));
	
	if($server == "" || $response == "" || $tld == "" && !$error)
		$error = "Please Fill Empty Fields !";
	
	if(!$error)
	{
		$rows = mysql_fetch_array(mysql_query("SELECT * FROM tlds WHERE id='$id'"));
		
		if(isset($rows['tld']))
		{
			$WhoisTld = $rows['tld'];
			
			$alterInstant = mysqlQuery("ALTER TABLE `affiliates` CHANGE `$WhoisTld` `$tld` VARCHAR(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL");
			
			$alteraffiliates = mysqlQuery("ALTER TABLE `instant_domain` CHANGE `$WhoisTld` `$tld` TINYINT(1) NOT NULL;");
			
			$mysql = mysqlQuery("UPDATE `tlds` SET `server`='$server',`tld`='$tld',`response`='$response' WHERE id='$id'");
		}
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
else
{
	header("Location: tld_sorting.php");
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
							<i class="fa fa-wrench"></i> Server API Settings <small>Update <?php echo $tld ;?> Tld Server</small>
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
											<i class="fa fa-check-square-o"></i> TLD Settings Updated Successfully !
										</div>
										<?php 
									} 
								} 
								?>
								<form action="editwhois.php" method="POST">
									<div class="form-group">
										<label>TLD Name</label>
										<input class="form-control" name="tld" placeholder="Enter TLD Name" value="<?php echo($tld); ?>" required>
									</div>
									<div class="form-group">
										<label>WHOIS Servers</label>
										<input class="form-control" name="server" placeholder="Enter WHOIS Server" value="<?php echo($server); ?>" required>
									</div>
									<div class="form-group">
										<label>Response</label>
										<input class="form-control" name="response" placeholder="Enter Server Response" value="<?php echo($response); ?>" required title="You Must Enter Valid Email.">
									</div>
									<input type="hidden" name="csrf" value="<?php echo $key; ?>" />
									<input type="hidden" name="id" value="<?php echo $id; ?>" />
									<hr>
									<div class="form-group">
										<a href="tld_sorting.php"><button type="button" class="btn btn-default"><i class="fa fa-chevron-left"></i> Back </button></a> <button type="submit" name="submit" class="btn btn-success"><i class="fa fa-pencil"></i>  Update</button>
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