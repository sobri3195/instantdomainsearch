<?php
if(!isset($_SESSION)) 
session_start();

include 'config/config.php';

include 'includes/functions.php';

$date=date("Y-m-d");

$domain=$_POST['domain'];

$domain=Text_Box_Validation($domain); 

$language = $_SESSION['suggesstion_language'];

$rows = mysql_num_rows(mysqlQuery("SELECT total_searches FROM `stats` WHERE `date`='$date'"));

if ($rows > 0)
{

	 $sql_update = mysqlQuery("UPDATE `stats` SET `total_searches`=`total_searches`+1 WHERE `date`='$date'");

}
else
{

	 $sql_insert = mysqlQuery("INSERT INTO `stats`(`total_searches`, `unique_hits`, `date`) VALUES ('1','0','$date')");

}

$cache = phpFastCache();

$data = $cache->get($domain.'_suggestion');

if($data!=null && isset($_SESSION['suggest_status']) && $_SESSION['suggest_status'] == 1)
	echo $data;
else
{
	$data = file_get_contents("http://naming.verisign-grs.com/ns-api/1.0/suggest?key=".$domain."&maxresults=100&&tlds=com|net|cc|tv&language=".$language);

	$json = json_decode(json_encode($data),true);

	$json = json_decode($json, true);

	$count=count($json['data']['table']['rows']);

	$json = $json['data']['table']['rows'];

	$i=0;

	$available = 0;

	$suggestion = '';
	
	while($i < $count)
	{
		if($json[$i]['status'] == 'available')
		{
			if($_SESSION['suggesstion_limit'] == $available) break;
			$array = explode('.',$json[$i]['name'], 2);
			$domain=$array[0];
			$ext=$array[1];
			$suggestion .= '<div class="extra">
				<a data-toggle="tooltip" data-placement="left" title="'.strtolower($json[$i]['name']).'" target="_blank" id="suggest_href_'.$available.'" href='.return_affiliate_url($json[$i]['name']).'>
					<div class="col-lg-8 col-md-8 col-sm-7 col-xs-7 domain-name">
						<span>'.strtolower($domain).'</span><span class="domain-ext">.'.strtolower($ext).'</span>
						<input type="hidden" id="suggesstedDomain'.$available.'" value="'.strtolower($domain).'">
						<input type="hidden" id="suggesstedExt'.$available.'" value="'.strtolower($ext).'">
					</div>
					<div class="col-lg-4 col-md-4 col-sm-5 col-xs-5 domain-button">
						<div id="suggest_tld_'.$ext.'" class="btn-dmn btn-green">'.convert_currency($_SESSION[$ext]).'</div>
					</div>
				</a>
			</div>';
			$available++;
		}
		$i++;
	}
	
	$cache->set($domain.'_suggestion',$suggestion,$_SESSION['suggest_time']);
	
	echo $suggestion;
	
}
?>    