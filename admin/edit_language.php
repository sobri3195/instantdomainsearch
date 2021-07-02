<?php
include dirname(__FILE__) . '/includes/header.php';
 
include dirname(__FILE__) . '/includes/header_under.php';

$error = false;

$csrfVariable = 'csrf_' . basename($_SERVER['PHP_SELF']);

if(isset($_GET['id']) && $_GET['id'] != '') 
{
	
	$id = mres(trim($_GET['id']));
	
	$array = mysql_fetch_array(mysqlQuery("SELECT * FROM `language` WHERE id = '$id'"));
	
	$lang_status = $array['status'];
	
	$language_name = $array['lang_name'];
	
	$RTL_status = $array['RTL_status'];
	
	if(!isset($array['id']))
	{	
	    header("Location: language_setting.php");
	}

} 
else if(isset($_POST['submit']))
{
    if($_SESSION[$csrfVariable] != $_POST['csrf'])
    $error = true;
	$array = array();	
	$array['Contact Us']=xssClean(mres($_POST['contact_us']));
	$array['Contact']=xssClean(mres($_POST['contact']));
	$array['Search']=xssClean(mres($_POST['search']));
	$array['Placeholder']=xssClean(mres($_POST['placeholder']));
	$array['Buy']=xssClean(mres($_POST['buy']));
	$array['WhoIs']=xssClean(mres($_POST['whois']));
	$array['More TLDs']=xssClean(mres($_POST['more_tld']));
	$array['Suggested Domains']=xssClean(mres($_POST['suggessted_domain']));
	$array['Buy Now']=xssClean(mres($_POST['buynow']));
	$array['Name']=xssClean(mres($_POST['name']));
	$array['Enter Your Name']=xssClean(mres($_POST['enter_your_name']));
	$array['Email Address']=xssClean(mres($_POST['email_address']));
	$array['Enter Your Email']=xssClean(mres($_POST['email_your_email']));
	$array['Subject']=xssClean(mres($_POST['subject']));
	$array['Enter a Subject']=xssClean(mres($_POST['enter_subject']));
	$array['Enter Captcha Code']=xssClean(mres($_POST['enter_captcha_code']));
	$array['Enter Code']=xssClean(mres($_POST['enter_code']));
	$array['Your Message']=xssClean(mres($_POST['your_message']));
	$array['Enter Your Message']=xssClean(mres($_POST['enter_your_message']));
	$array['Send Message']=xssClean(mres($_POST['send_message']));
	$array['Powered By']=xssClean(mres($_POST['powered_by']));
	$array['All Rights Reserved']=xssClean(mres($_POST['right_reserved']));
	$array['Incorrect Information']=xssClean(mres($_POST['incorrect_information']));
	$array['Invalid Captcha']=xssClean(mres($_POST['invalid_captcha']));
	$array['Empty Captcha']=xssClean(mres($_POST['empty_captcha']));
	$array['Success Contact Message']=xssClean(mres($_POST['success_contact']));
	$array['Invalid Email']=xssClean(mres($_POST['invalid_email']));
	$array['Invalid Name']=xssClean(mres($_POST['invalid_name']));
	$array['Language']=xssClean(mres($_POST['language']));
	$array['social_message']=xssClean(mres($_POST['social_message']));
	$array['oops']=xssClean(mres($_POST['oops']));
	$array['404-page-not-found']=xssClean(mres($_POST['404-page-not-found']));
	$array['take-me-home']=xssClean(mres($_POST['take-me-home']));
	$array['email_required']=xssClean(mres($_POST['email_required']));
	$array['name_required']=xssClean(mres($_POST['name_required']));
	$array['message_required']=xssClean(mres($_POST['message_required']));
	$array['field_empty']=xssClean(mres($_POST['field_empty']));
	$array['notavailable']=xssClean(mres($_POST['notavailable']));
	$language_name = str_replace(array('"'), '', $_POST['language_name']);
	$language_name=xssClean(mres($language_name));
	$edit_file=xssClean(mres($_POST['edit_file']));	
	if($_POST['lang_status']=="on") 
	$lang_status =1;
	else
	$lang_status =0;
	if($_POST['rtl_status']=="on") 
	$RTL_status =1;
	else
	$RTL_status =0;	
	$_SESSION['language_status'] = $lang_status;	
	$query=mysql_fetch_array(mysql_query("SELECT `lang_name` FROM language WHERE lang_file='$edit_file'"));
	$old_language = $query['lang_name'];
	if(!$error && $language_name != 'lang_array')
	{
		mysqlQuery("UPDATE `language` SET status='$lang_status',lang_name='$language_name',RTL_status='$RTL_status' WHERE lang_file='$edit_file'");	
		mysqlQuery("UPDATE `page_language` SET language='$language_name' WHERE language='$old_language'");	
		$encode=json_encode($array);
		file_put_contents("../language/".$edit_file,$encode); 
		unset($_SESSION['language_set']);
		unset($_SESSION['reset_language']);
	}
	else
    $error = true;
}
else
{
	header("Location: language_setting.php");
}

$key = sha1(microtime());

$_SESSION[$csrfVariable] = $key;	
?>
	<title>Edit Language: <?php echo(get_title());?></title>
	</head>
	<body>
	<?php include "includes/top_navbar.php"; ?>
	<div id="wrapper">		
		<div id="page-wrapper">
			<div class="row page-ttl">
				<div class="col-lg-12">
					<h1>
					<i class="fa fa-language"></i> <?php echo ucfirst($language_name); ?> Language Settings <small>Edit <?php echo ucfirst($language_name); ?> Language</small>
					</h1>
				</div>
			</div>
			<div class="page-content">
				<div class="margin_sides">
					<div class="row">
						<?php 
						if(isset($_POST['submit']) && !$error)
						{ 
						?>
						<div class="alert alert-success alert-dismissable col-lg-8 col-md-8 col-sm-8 col-xs-12">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="fa fa-check-square-o"></i> <?php echo $lang_array['language_update_success'];?>
						</div>
						<?php 
						} 
						?> 
						<div class="col-lg-8 col-md-10 col-sm-12 col-xs-12">
							<form method="post" action="edit_language.php" enctype="multipart/form-data">								
								<div class="table-responsive">
									<table id="example" class="table table-striped table-bordered table-hover table-striped tablesorter" cellspacing="0" width="100%">
									<?php 
									if(isset($_GET['id']))
									{
										$id = trim($_GET['id']);
										$sql = mysql_fetch_array(mysqlQuery("SELECT lang_file,status FROM language WHERE id = '$id'"));
										if(isset($sql['lang_file']))
										{
										
											$_SESSION['file'] = $sql['lang_file'];									
											
											$json = file_get_contents('../language/'.$_SESSION['file']);
											
											$data=json_decode($json, true);
											
										}	
										
									}
									else
									{
									    $json = file_get_contents('../language/'.$_SESSION['file']);
											
										$data=json_decode($json, true);
									}
									
									?>
									    <thead>
											<tr>
												<th >Language</th>
												<th >Edit Language</th>
											</tr>
										</thead>
										<tbody id="list_language">
										    <input name="edit_file" value="<?php echo $_SESSION['file'] ;?>" type="hidden" />
											<tr>
												<th >Language Name</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" value="<?php echo $language_name;?>" placeholder="Enter Language Name" required name="language_name"  required=""></td>
											</tr>
											<tr>
												<th width="130px">Contact Us</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" name="contact_us" value="<?php echo $data['Contact Us']; ?>" required=""></td>
											</tr>
											<tr>
												<th width="130px">Contact</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" name="contact" value="<?php echo $data['Contact']; ?>" required=""></td>
											</tr>
											<tr>
												<th width="130px">Search</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" name="search" value="<?php echo $data['Search']; ?>" required=""></td>
											</tr>
											<tr>
												<th width="130px">Enter Your Domain Name</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" name="placeholder" value="<?php echo $data['Placeholder']; ?>" required=""></td>
											</tr>
											<tr>
												<th width="130px">Buy</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" name="buy" value="<?php echo $data['Buy']; ?>" required=""></td>
											</tr>
											<tr>
												<th width="130px">WhoIs</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" name="whois" value="<?php echo $data['WhoIs']; ?>" required=""></td>
											</tr>
											<tr>
												<th width="130px">More TLDs</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" name="more_tld" value="<?php echo $data['More TLDs']; ?>" required=""></td>
											</tr>
											<tr>
												<th width="130px">Suggested Domains</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" name="suggessted_domain" value="<?php echo $data['Suggested Domains']; ?>" required=""></td>
											</tr>
											<tr>
												<th width="130px">Buy Now</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" name="buynow" value="<?php echo $data['Buy Now']; ?>" required=""></td>
											</tr>
											<tr>
												<th width="130px">Name</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" name="name" value="<?php echo $data['Name']; ?>" required=""></td>
											</tr>
											<tr>
												<th width="130px">Enter Your Name</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" name="enter_your_name" value="<?php echo $data['Enter Your Name']; ?>" required=""></td>
											</tr>
											<tr>
												<th width="130px">Email Address</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" name="email_address" value="<?php echo $data['Email Address']; ?>" required=""></td>
											</tr>
											<tr>
												<th width="130px">Enter Your Email</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" name="email_your_email" value="<?php echo $data['Enter Your Email']; ?>" required=""></td>
											</tr>
											<tr>
												<th width="130px">Subject</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" name="subject" value="<?php echo $data['Subject']; ?>" required=""></td>
											</tr>
											<tr>
												<th width="130px">Enter a Subject</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" name="enter_subject" value="<?php echo $data['Enter a Subject']; ?>" required=""></td>
											</tr>
											<tr>
												<th width="130px">Enter Captcha Code</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" name="enter_captcha_code" value="<?php echo $data['Enter Captcha Code']; ?>" required=""></td>
											</tr>
											<tr>
												<th width="130px">Enter Code</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" name="enter_code" value="<?php echo $data['Enter Code']; ?>" required=""></td>
											</tr>
											<tr>
												<th width="130px">Your Message</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" name="your_message" value="<?php echo $data['Your Message']; ?>" required=""></td>
											</tr>
											<tr>
												<th width="130px">Enter Your Message</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" name="enter_your_message" value="<?php echo $data['Enter Your Message']; ?>" required=""></td>
											</tr>
											<tr>
												<th width="130px">Send Message</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" name="send_message" value="<?php echo $data['Send Message']; ?>" required=""></td>
											</tr>
											<tr>
												<th width="130px">Powered By</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" name="powered_by" value="<?php echo $data['Powered By']; ?>" required=""></td>
											</tr>
											<tr>
												<th width="130px">All Rights Reserved</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" name="right_reserved" value="<?php echo $data['All Rights Reserved']; ?>" required=""></td>
											</tr>
											<tr>
												<th width="130px">Language</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" name="language" value="<?php echo $data['Language']; ?>" required=""></td>
											</tr>
											<tr>
												<th width="130px">Incorrect Information</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" name="incorrect_information" value="<?php echo $data['Incorrect Information']; ?>" required=""></td>
											</tr>
											<tr>
												<th width="130px">Invalid Captcha</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" name="invalid_captcha" value="<?php echo $data['Invalid Captcha']; ?>" required=""></td>
											</tr>
											<tr>
												<th width="130px">Empty Captcha</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" name="empty_captcha" value="<?php echo $data['Empty Captcha']; ?>" required=""></td>
											</tr>
											<tr>
												<th width="130px">Email Send Successfully</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" name="success_contact" value="<?php echo $data['Success Contact Message']; ?>" required=""></td>
											</tr>
											<tr>
												<th width="130px">Invalid Email</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" name="invalid_email" value="<?php echo $data['Invalid Email']; ?>" required=""></td>
											</tr>
											<tr>
												<th width="130px">Invalid Name</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" name="invalid_name" value="<?php echo $data['Invalid Name']; ?>" required=""></td>
											</tr>
											<tr>
												<th>Never miss a single update!</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" value="<?php echo $data['social_message']; ?>" name="social_message"  required=""></td>
											</tr>
											<tr>
												<th>Oops!</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" value="<?php echo $data['oops']; ?>" name="oops"  required=""></td>
											</tr>
											<tr>
												<th>404 Page Not Found</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" value="<?php echo $data['404-page-not-found']; ?>" name="404-page-not-found"  required=""></td>
											</tr>
											<tr>
												<th>Take Me Home</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" value="<?php echo $data['take-me-home']; ?>" name="take-me-home"  required=""></td>
											</tr>
											<tr>
												<th>Email is Required</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" value="<?php echo $data['email_required']; ?>" name="email_required"  required=""></td>
											</tr>
											<tr>
												<th>Message Required</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" value="<?php echo $data['message_required']; ?>" name="message_required"  required=""></td>
											</tr>
											<tr>
												<th>Name is Required</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" value="<?php echo $data['name_required']; ?>" name="name_required"  required=""></td>
											</tr>
											<tr>
												<th>You left Some Fields empty</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" value="<?php echo $data['field_empty']; ?>" name="field_empty"  required=""></td>
											</tr>
											<tr>
												<th>Not Available</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" value="<?php echo $data['notavailable']; ?>" name="notavailable"  required=""></td>
											</tr>
										</tbody>
									</table>
								</div>
								<div class="form-group">
									<label>Status</label></br>
									<?php
									if($lang_status == 1)
									{
									?>
									<input class="my_checkbox"  name="lang_status" type="checkbox"   checked="checked" />
									<?php 
									}
									else
									{
									?>
									<input class="my_checkbox" name="lang_status" type="checkbox" />
									<?php 
									}
									?>
								</div>
								<div class="form-group">
									<label>RTL</label></br>
									<?php
									if($RTL_status == 1)
									{
									?>
									<input class="my_checkbox"  name="rtl_status" type="checkbox"   checked="checked" />
									<?php 
									}
									else
									{
									?>
									<input class="my_checkbox" name="rtl_status" type="checkbox" />
									<?php 
									}
									?>
								</div>
								<div class="clearfix"></div>
								<input type="hidden" name="csrf" value="<?php echo $key; ?>" />
								<div class="form-group">
									<div class="col-lg-6">
										<a class="btn btn-default" href="language_setting.php"><i class="fa fa-chevron-left"></i> Back</a>
										<button class="btn btn-success" name="submit" type="submit"><i class="fa fa-check"></i> Update</button>
									</div>
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