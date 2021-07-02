<?php
include dirname(__FILE__) . '/includes/header.php'; 

include dirname(__FILE__) . '/includes/header_under.php';
 
$error = false;

$csrfVariable = 'csrf_' . basename($_SERVER['PHP_SELF']);

if(isset($_POST['submit'])) 
{

	if($_SESSION[$csrfVariable] != $_POST['csrf'])
	$error = true;

    $username = xssClean(mres($_POST["username"]));
    
    $oldpassword = md5(trim($_POST["oldpassword"]));
    
    $match = "SELECT `username` FROM `settings` WHERE `password`='$oldpassword'";
    
    $email = xssClean(mres($_POST["email"]));

    if(!is_alphaNumeric(trim($_POST["username"]))) 
	{
	
        $error = "Username can have only Alphanumeric Characters.";
		
    } 
	else if(strlen(trim($_POST["password"]))<5)
	{
	
		if(trim($_POST["password"])!="")
		$error = "Minimum Password Length is 5 Characters.";
		
    }
    
    if(!checkEmail($email)) 
	{
	
        $error = "You Must Enter Valid Email.";
		
    } 
	else if(mysql_num_rows(mysqlQuery($match))<=0) 
	{
	
        $error = "Invalid Current Password.";
    }
    
    if($error=="")
	{
	
        if(isset($_POST['password']) && trim($_POST['password'])!="")
            $password = md5(trim($_POST["password"]));
        else
            $password = md5(trim($_POST["oldpassword"]));
            updateUser($username,$password,$email);
    }
}

$key = sha1(microtime());

$_SESSION[$csrfVariable] = $key;

$array = mysql_fetch_array(mysqlQuery("SELECT `username`,`email` FROM `settings`")); 

?>
	<title>Account Settings: <?php echo(getMetaTitle()) ?></title>
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
							<i class="fa fa-user"></i> Account Settings <small>Change Administrator login details</small>
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
									if(isset($_POST['username']))
									{
										?>
										<div class="alert alert-success alert-dismissable">
											<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
											<i class="fa fa-check-square-o"></i> Login Details Updated Successfully
										</div>
										<?php 
									} 
								} 
								?>
								<form action="account.php" method="POST">
									<div class="form-group">
										<label>Username</label>
										<input class="form-control" name="username" value="<?php echo($array['username']); ?>" required>
									</div>
									<div class="form-group">
										<label>Email</label>
										<input class="form-control" name="email" value="<?php echo($array['email']); ?>" required title="You Must Enter Valid Email.">
									</div>
									<div class="form-group">
										<label>Current Password</label>
										<input type="password" class="form-control" name="oldpassword" autocomplete="off" placeholder="Current Password" pattern=".{5,}" required title="Minimum Password Length is 5 Characters.">
									</div>
									<div class="form-group">
										<label>New Password (Optional)</label>
										<input type="password" class="form-control" name="password" autocomplete="off" placeholder="New Password (Optional)" pattern=".{5,}" title="Minimum Password Length is 5 Characters.">
									</div>
									<input type="hidden" name="csrf" value="<?php echo $key; ?>" />
									<hr>
									<div class="form-group">
										<button type="submit" name="submit" class="btn btn-success"><i class="fa fa-pencil"></i>  Update</button>
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