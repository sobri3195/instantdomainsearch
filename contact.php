<?php 
if(!isset($_SESSION)) 
session_start();

include("config/config.php");

include("includes/functions.php");

include "language/lang_array.php";

include 'admin/libs/contact_captcha.php'; 

include 'libs/mail.php';

$data = array();

$error = false;
		
$subject = trim(mres($_POST["subject"]));

$email = trim(mres($_POST["email"]));

$name = trim(mres($_POST["name"]));

$message = trim(mres($_POST["message_box"]));

if(is_alpha($_POST["name"]) && !$error)
	$name = trim(mres($_POST["name"]));
else if($_POST["name"] == '' && !$error)
	$error = $_SESSION['name_required'];
else if(!$error)
	$error = $_SESSION['Invalid Name'];	

if($_POST['email'] == '' && !$error)
	$error = $_SESSION['email_required'];
if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !$error) 
	$error = $_SESSION['Invalid Email']; 
else if(!$error)
	$email = trim(mres($_POST["email"]));	
	
if($_POST['message_box'] == '' && !$error)
	$error = $_SESSION['message_required'];
else
	$message = trim(mres($_POST["message_box"]));

if(captcha_contact_status() && !$error) 
{
	if(isset($_POST["captcha_code"]) && trim($_POST["captcha_code"])!="" || isset($_POST["captcha_code2"]) && trim($_POST["captcha_code2"])!="") 
	{
		if(trim($_POST["captcha_code"])!=$_SESSION['captcha']['code'] && trim($_POST["captcha_code2"])!=$_SESSION['captcha']['code'])
		$error = $_SESSION['Invalid Captcha'];
		else
		send_contact_email(get_admin_email(), $email, $name, $subject, $message);
	} 
	else 
	{
	
		$error = $_SESSION['Empty Captcha'];
	
	} 		
}
else 
{

	if (!$error)
	{
	
		 send_contact_email(get_admin_email(), $email, $name, $subject, $message);
	
	}

} 

if (!$error)
{

	$data[0] = '<i class="fa fa-check-square-o"></i> '.$_SESSION['Success Contact Message'];
	$data[1] = 'success';

}
else
{

	$data[0] = '<i class="fa fa-exclamation-triangle"></i> '.$error;
	$data[1] = 'danger';

}
	
echo json_encode($data);
?>