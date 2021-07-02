<?php
if(!isset($_SESSION)) 
session_start();

include "../config/config.php";

include "../includes/functions.php";

include "../libs/whois.php";

if(isset($_POST['update']) && $_POST['update'] == 'update_all')
{
	
	$id = (int)mres($_POST['id']);  
	
	$mysql = mysqlQuery("SELECT domain FROM instant_domain WHERE id='$id'");  
	
	$rows = mysql_fetch_array($mysql);
	
	$domain = $rows['domain'];  
	
	$result = mysqlQuery("SELECT tld FROM tlds"); 
	
	$i=1;
	
	while($fetch=mysql_fetch_array($result))
	{
		
		$tld = $fetch['tld'];
		
		update_domains($tld,$domain);
		
	}
}
else if(isset($_POST['delete']) && $_POST['delete'] == 'delete_all')
{

	$id = (int)mres($_POST['id']);   

    $page = (int)mres($_POST['page']); 

	$page -= 1;

	$per_page = 8;
	
	$start = $page * $per_page;	
	
	if($id)
	{
		
		$q = mysqlQuery("SELECT * FROM instant_domain WHERE id='$id'");
		
		$n = mysql_num_rows($q);
		
		if($n)
		mysqlQuery("DELETE FROM instant_domain WHERE id='$id'"); 

		$q = mysqlQuery("SELECT * FROM instant_domain LIMIT $start, $per_page");		
		$n = mysql_num_rows($q);
		
		if($n)
		echo $n;

	}
}
else if(isset($_POST['main_domain']) && $_POST['main_domain'] != '')
{	
	$tld = mres($_POST["main_domain"]); 
	
	$q = mysqlQuery("UPDATE main_tld SET tld = '$tld'");
	
	unset($_SESSION['tlds']);
	unset($_SESSION['set']);
	
}
else if(isset($_POST['delete_page']) && $_POST['delete_page'] == 'delete_page')
{

	$id = (int)mres($_POST['id']);

	$sql_delete = mysqlQuery("DELETE FROM pages WHERE id='$id'");
	
	$sql_delete = mysqlQuery("DELETE FROM page_language WHERE `id`='$id'");
 
}
else if(isset($_POST['language']) && $_POST['language'] != '')
{

	$id = (int)mres($_POST['id']);
	
	$language = mres($_POST['language']);

	$sql_delete = mysqlQuery("DELETE FROM page_language WHERE `id`='$id' AND language = '$language'");
	
}
else if(isset($_POST['language_file']) && $_POST['language_file'] != '')
{
    unset($_SESSION['language_set']);
	
    unset($_SESSION['reset_language']);
	
	$file = mres($_POST['language_file']);
	
	$language = mres($_POST['language_name']);
	
	$sql_delete = mysqlQuery("DELETE FROM page_language WHERE language = '$language'");
	
	$sql_delete = mysqlQuery("DELETE FROM language WHERE lang_name = '$language'");
	
	unlink('../language/'.$file);
	
}
else if(isset($_POST['suggest_language']) && $_POST['suggest_language'] != '')
{
	
	$language = mres($_POST['suggest_language']);
	
    $rows = mysql_num_rows(mysqlQuery("SELECT * FROM `suggested_language`"));
	
	if($rows>0) 
	{
		$sql_update = mysqlQuery("UPDATE `suggested_language` SET `language`='$language'");
	}
	else
	{
		$sql_update = mysqlQuery("INSERT INTO suggested_language(language) VALUES('$language')");
	}
	unset($_SESSION['tlds']);
	unset($_SESSION['set']);
}
else if(is_numeric($_POST['SuggesstedLimit']) && $_POST['SuggesstedLimit'] != '' && is_numeric($_POST['PreserveDatabase']) && $_POST['PreserveDatabase'] != '' && is_numeric($_POST['instantLimit']) && $_POST['instantLimit'] != '')
{
	$limit = trim($_POST['SuggesstedLimit']);
	
	$days = trim($_POST['PreserveDatabase']);
	
	$instantLimit = trim($_POST['instantLimit']);
	
	$mysql = mysqlQuery("UPDATE `suggessted_limit` SET `limit`='$limit',`preserve_days`='$days',`instantLimit`='$instantLimit' WHERE 1");
	
	unset($_SESSION['tlds']);
	unset($_SESSION['set']);
}
else if(isset($_POST['TldName']) && $_POST['TldName'] != '')
{
	$TldName = trim($_POST['TldName']);
	
	$status = trim($_POST['status_tld']);
	
	$mysql = mysqlQuery("UPDATE `tlds` SET `status`='$status' WHERE tld = '$TldName'");
	
	unset($_SESSION['TldArray']);
	unset($_SESSION['tlds']);
	unset($_SESSION['set']);
}
else if(isset($_POST['deleteTld']) && $_POST['deleteTld'] != '')
{
	$id = $_POST['id'];

	$rows = mysql_fetch_array(mysql_query("SELECT * FROM tlds WHERE id='$id'"));
		
	if(isset($rows['tld']))
	{
		$tld = $rows['tld'];
		
		$alterInstant = mysqlQuery("ALTER TABLE `instant_domain` DROP `$tld`;");

		$alterInstant = mysqlQuery("ALTER TABLE `affiliates` DROP `$tld`;");
		
		$sql_delete = mysqlQuery("DELETE FROM tlds WHERE id='$id'");
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
?>