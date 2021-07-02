<?php
include dirname(__FILE__) . '/includes/header.php';
 
include dirname(__FILE__) . '/includes/header_under.php';

$error = false;

$csrfVariable = 'csrf_' . basename($_SERVER['PHP_SELF']);
if(isset($_POST['submit']))
{
    if($_SESSION[$csrfVariable] != $_POST['csrf'])
    $error = true;
	$array = array();
	if($_POST['rtl_status']=="on") 
	$RTL_status =1;
	else
	$RTL_status =0;
	$language_name = str_replace(array('"'), '', $_POST['language_name']);
	$language_name=xssClean(mres($language_name));
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
	$fetch_id = mysql_fetch_array(mysqlQuery("SELECT MAX(id) AS id FROM language"));				
	$id = $fetch_id["id"];				
	$id=$id+1;
	if($language_name != 'lang_array')
	{
		$encode=json_encode($array);
		file_put_contents("../language/".$language_name.".php",$encode); 
		$lang_file = $language_name.".php";
		$sql_insert = mysqlQuery("INSERT INTO `language`(`lang_name`, `lang_file`, `status`,`display_order`,`RTL_status`) VALUES ('$language_name','$lang_file',1,'$id','$RTL_status')");
		$sql = mysql_fetch_array(mysql_query("SELECT lang_name FROM `language` WHERE status = 1 ORDER BY display_order"));
		$default_langauge = $sql['lang_name'];
		$in_db = mysql_query("SELECT DISTINCT(permalink),title,content,id FROM `page_language` WHERE language = '$default_langauge'");
		while($rows = mysql_fetch_array($in_db))
		{
			$id = $rows['id'];
			$permalink = $rows['permalink'];
			$title = $rows['title'];
			$content = $rows['content'];
			mysqlQuery("INSERT INTO page_language(id,title,permalink,content,language) VALUES('$id','$title','$permalink','$content','$language_name')");
		
		} 
		header("Location: language_setting.php?id=$id");
    }
	else
    $error = true;
}

$key = sha1(microtime());

$_SESSION[$csrfVariable] = $key;	
?>
	<title>Add Language: <?php echo(get_title());?></title>
	</head>
	<body>
	<?php include "includes/top_navbar.php"; ?>
	<div id="wrapper">		
		<div id="page-wrapper">
			<div class="row page-ttl">
				<div class="col-lg-12">
					<h1>
					<i class="fa fa-language"></i> Language Settings <small>Add New Language</small>
					</h1>
				</div>
			</div>
			<div class="page-content">
				<div class="margin_sides">
					<div class="row">
					<?php 
					if($error)
					{ 
					?>
					<div id="tld_updated" class="alert alert-danger alert-dismissable col-lg-8 col-md-8 col-sm-8 col-xs-12">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="fa fa-exclamation-triangle"></i>  This language name is restricted for some reason !
					</div>
					<?php 
					} 
					?> 
						<div class="col-lg-8 col-md-10 col-sm-12 col-xs-12">
							<form method="post" action="add_language.php" enctype="multipart/form-data">								
								<div class="table-responsive">
									<table id="example" class="table table-striped table-bordered table-hover table-striped tablesorter" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th >Language</th>
												<th >Add Language</th>
											</tr>
										</thead>
										<tbody id="list_language">
											<tr>
												<th >Language Name</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" placeholder="Enter Language Name" required name="language_name"  required=""></td>
											</tr>
											<tr>
												<th >Contact Us</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" name="contact_us"  required=""></td>
											</tr>
											<tr>
												<th >Contact</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" name="contact"  required=""></td>
											</tr>
											<tr>
												<th >Search</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" name="search"  required=""></td>
											</tr>
											<tr>
												<th >Enter Your Domain Name</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" name="placeholder"  required=""></td>
											</tr>
											<tr>
												<th >Buy</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" name="buy"  required=""></td>
											</tr>
											<tr>
												<th >WhoIs</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" name="whois"  required=""></td>
											</tr>
											<tr>
												<th >More TLDs</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" name="more_tld"  required=""></td>
											</tr>
											<tr>
												<th >Suggested Domains</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" name="suggessted_domain" required=""></td>
											</tr>
											<tr>
												<th >Buy Now</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" name="buynow"  required=""></td>
											</tr>
											<tr>
												<th >Name</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" name="name"  required=""></td>
											</tr>
											<tr>
												<th >Enter Your Name</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" name="enter_your_name"  required=""></td>
											</tr>
											<tr>
												<th >Email Address</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" name="email_address"  required=""></td>
											</tr>
											<tr>
												<th >Enter Your Email</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" name="email_your_email"  required=""></td>
											</tr>
											<tr>
												<th >Subject</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" name="subject"  required=""></td>
											</tr>
											<tr>
												<th >Enter a Subject</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" name="enter_subject"  required=""></td>
											</tr>
											<tr>
												<th >Enter Captcha Code</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" name="enter_captcha_code"  required=""></td>
											</tr>
											<tr>
												<th >Enter Code</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" name="enter_code"  required=""></td>
											</tr>
											<tr>
												<th >Your Message</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" name="your_message"  required=""></td>
											</tr>
											<tr>
												<th >Enter Your Message</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" name="enter_your_message"  required=""></td>
											</tr>
											<tr>
												<th >Send Message</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" name="send_message"  required=""></td>
											</tr>
											<tr>
												<th width="130px">Powered By</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" name="powered_by"  required=""></td>
											</tr>
											<tr>
												<th >All Rights Reserved</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" name="right_reserved"  required=""></td>
											</tr>
											<tr>
												<th width="130px">Language</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" name="language" value="<?php echo $data['Language']; ?>" required=""></td>
											</tr>
											<tr>
												<th >Incorrect Information</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" name="incorrect_information"  required=""></td>
											</tr>
											<tr>
												<th >Invalid Captcha</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" name="invalid_captcha" required=""></td>
											</tr>
											<tr>
												<th width="130px">Empty Captcha</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" name="empty_captcha"  required=""></td>
											</tr>
											<tr>
												<th width="130px">Email Send Successfully</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" name="success_contact"  required=""></td>
											</tr>
											<tr>
												<th >Invalid Email</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" name="invalid_email" required=""></td>
											</tr>
											<tr>
												<th >Invalid Name</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" name="invalid_name"  required=""></td>
											</tr>
											<tr>
												<th>Never miss a single update!</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" name="social_message"  required=""></td>
											</tr>
												<tr>
												<th>Oops!</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" name="oops"  required=""></td>
											</tr>
											<tr>
												<th>404 Page Not Found</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" name="404-page-not-found"  required=""></td>
											</tr>
											<tr>
												<th>Take Me Home</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" name="take-me-home"  required=""></td>
											</tr>
												<tr>
												<th>Email is Required</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control"  name="email_required"  required=""></td>
											</tr>
											<tr>
												<th>Message Required</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control"  name="message_required"  required=""></td>
											</tr>
											<tr>
												<th>Name is Required</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control"  name="name_required"  required=""></td>
											</tr>
											<tr>
												<th>You left Some Fields empty</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" name="field_empty"  required="field_empty"></td>
											</tr>
											<tr>
												<th>Not Available</th>
												<td id="remove" class="ellipsis"><input type="text" class="form-control" name="notavailable"  required="field_empty"></td>
											</tr>
										</tbody>
									</table>
								</div>
								<div class="form-group">
									<label>RTL</label></br>
									<input class="my_checkbox" name="rtl_status" type="checkbox" />
								</div>
								<input type="hidden" name="csrf" value="<?php echo $key; ?>" />
								<div class="form-group">
								<div class="col-lg-12">
								<a class="btn btn-default" href="language_setting.php"><i class="fa fa-chevron-left"></i> Back</a>
								<button class="btn btn-success" name="submit" type="submit"><i class="fa fa-plus"></i> Add Language</button>
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