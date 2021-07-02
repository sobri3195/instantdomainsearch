<?php 
if(!isset($_SESSION)) 
session_start();

include("config/config.php");

require_once("includes/functions.php");

if(isset($_POST['language']))
{

	$language = trim($_POST['language']);
	
	$sql = mysql_fetch_array(mysql_query("SELECT * FROM language WHERE lang_name ='$language'"));
	
	$lang_name = $sql['lang_name'];
	
	$lang_file = $sql['lang_file'];
	
	$rtl_status = $sql['RTL_status'];
	
	if(isset($lang_name) && isset($lang_file))
	{
	
		unset($_SESSION['language_set']);
		
		$_SESSION['reset_lang_file'] = $lang_file ;
		
		$_SESSION['reset_lang_name'] = $lang_name;
		
		$_SESSION['reset_RTL_session'] = $rtl_status;
	
	}
	
}
?>