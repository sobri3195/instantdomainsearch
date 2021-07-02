<?php
if(!isset($_SESSION))
session_start();
require_once("config/config.php");
require_once("includes/functions.php");
include "language/lang_array.php";
include "libs/whois.php";
$url=$_POST['domain'];
$tld = $_POST['tld'];
$forPrice = str_replace('.', '', $tld);
$tld1 = $_POST['tld1'];
$domain=Text_Box_Validation($url);
if($_SESSION['whoisStatus'] == 1)
	$WhoisLinkName = $_SESSION['WhoIs'];
else
	$WhoisLinkName = $_SESSION['notavailable'];
if(isset($_POST['domain']) && $_POST['domain'] != "")
{
	if(strlen($domain) > 0)
	{
		$data = tld_server($tld,$domain,$WhoisLinkName,$_SESSION[$forPrice],$tld1);	
		echo json_encode($data);
		exit();
	}
} 
?>