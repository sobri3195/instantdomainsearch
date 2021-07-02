<?php
if(!isset($_SESSION)) session_start();

include("../config/config.php");

include("../includes/functions.php");

if(isset($_POST['uniqueHits']) && $_POST['uniqueHits']='1' && !isset($_SESSION['uniqueHit'])) {

	increment_unique_hits();
	
	$_SESSION['uniqueHit'] = true;
	
} else if(isset($_POST['pageViews']) && $_POST['pageViews']='1') {

	increment_page_views();

}
else if(isset($_POST['affiliate_name']) && $_POST['affiliates_clicks']='1')
{
	$_SESSION['affiliate_name']=$_POST['affiliate_name'];
	increment_affiliates_hits();
	if(isset($_SESSION['affiliate_name']))
	{
		$rows=mysql_fetch_array(mysql_query("SELECT * FROM affiliates WHERE affiliate_name='".$_SESSION['affiliate_name']."'"));
		$i = 0;
		$countArray = count($_SESSION['TldArray']);
		while($i < $countArray)
		{
			$tld = $_SESSION['TldArray'][$i];
			$variable = str_replace('.', '', $_SESSION['TldArray'][$i]);
			$_SESSION[$variable]=$rows[$tld] * $_SESSION['price_dollor'];
			$i++;
		}		
		$_SESSION['url']=$rows['url'];	
		$_SESSION['affiliate_name']=$rows['affiliate_name'];	
		$_SESSION['set'] = 1;
	}	
}
?>