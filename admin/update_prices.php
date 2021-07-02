<?php 
if(!isset($_SESSION)) 
session_start();

include "../config/config.php";

include "../includes/functions.php";

$data = array();

function is_digits($element) {
	return !preg_match ("/[^0-9.]/", $element);
}

if(isset($_POST['affiliate_name']) && $_POST['affiliate_name'] != "")
{
	$url=$_POST['url'];
	
	$affiliate_name=$_POST['affiliate_name'];
	
	$image=$_POST['image'];
	
	$sql = "UPDATE affiliates set url='$url' WHERE affiliate_name='$affiliate_name'";
    
	mysqlQuery($sql) or die(mysql_error());
	
	unset($_SESSION['set']);

	unset($_SESSION['affiliate_links']);
}
else if(isset($_POST['TldPrice']) && $_POST['TldPrice'] != "")
{
	$Tld=$_POST['Tld'];
	
	$TldPrice=$_POST['TldPrice'];
	
	$affiliate=$_POST['affiliate'];
	
	$sql = "UPDATE affiliates set `$Tld`='$TldPrice' WHERE affiliate_name='$affiliate'";
    
	mysqlQuery($sql) or die(mysql_error());
	
	unset($_SESSION['set']);

	unset($_SESSION['affiliate_links']);
}
?>