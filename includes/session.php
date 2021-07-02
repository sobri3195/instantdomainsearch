<?php 
if(!isset($_SESSION['tlds']))
{
	$_SESSION['TldArray']=array();
	
	$fetch=mysql_fetch_array(mysql_query("SELECT `tld` FROM main_tld"));
	
	if(isset($fetch['tld']))
		$_SESSION['main_tld'] = $fetch['tld'];
	else
		$_SESSION['main_tld'] = 'com';
	
	$count=1;
	
	$query=mysql_query("SELECT * FROM tlds WHERE status=1 ORDER BY display_order");
	
	while($rows=mysql_fetch_array($query))
	{
	
		$_SESSION['value'.$count.'']=$rows['tld']; 
		
		$_SESSION['tld'.$count.'']=$rows['status']; 
		
		array_push($_SESSION['TldArray'],$rows['tld']);
		
		$count++;
	
	}
	
	$rows = mysql_fetch_array(mysqlQuery("SELECT * FROM suggessted_limit"));

	$_SESSION['suggesstion_limit'] = $rows['limit'];

	$_SESSION['preserve_day'] = $days['preserve_days'];
	
	$rows = mysql_fetch_array(mysqlQuery("SELECT `language` FROM suggested_language"));

	$_SESSION['suggesstion_language'] = $rows['language'];
	
	$_SESSION['tlds'] = 1;
	
}
if(!isset($_SESSION['reset_language']))
{	
	$sql = mysql_fetch_array(mysql_query("SELECT * FROM language WHERE status=1 ORDER BY display_order"));
	$_SESSION['reset_lang_file'] = $sql['lang_file'];	
	$_SESSION['reset_lang_name'] = $sql['lang_name'];
	$_SESSION['reset_RTL_session'] = $sql['RTL_status'];
	$_SESSION['reset_language'] = 1;	
}
if(!isset($_SESSION['loader_session']))
{
	if(f_loader()) 
		$_SESSION['loader_session'] = 1 ; 
}

if(!isset($_SESSION['language_set']))
{
	$json = file_get_contents('language/'.$_SESSION['reset_lang_file']);
	$data=json_decode($json, true);
	$_SESSION['Contact Us'] = $data['Contact Us'];
	$_SESSION['Contact'] = $data['Contact'];
	$_SESSION['Search'] = $data['Search'];
	$_SESSION['Placeholder'] = $data['Placeholder'];
	$_SESSION['Buy'] = $data['Buy'];
	$_SESSION['WhoIs'] = $data['WhoIs'];
	$_SESSION['More TLDs'] = $data['More TLDs'];
	$_SESSION['Suggested Domains'] = $data['Suggested Domains'];
	$_SESSION['Buy Now'] = $data['Buy Now'];
	$_SESSION['Name'] = $data['Name'];
	$_SESSION['Enter Your Name'] = $data['Enter Your Name'];
	$_SESSION['Email Address'] = $data['Email Address'];
	$_SESSION['Enter Your Email'] = $data['Enter Your Email'];
	$_SESSION['Subject'] = $data['Subject'];
	$_SESSION['Enter a Subject'] = $data['Enter a Subject'];
	$_SESSION['Enter Captcha Code'] = $data['Enter Captcha Code'];
	$_SESSION['Enter Code'] = $data['Enter Code'];
	$_SESSION['Your Message'] = $data['Your Message'];
	$_SESSION['Enter Your Message'] = $data['Enter Your Message'];
	$_SESSION['Send Message'] = $data['Send Message'];
	$_SESSION['Powered By'] = $data['Powered By'];
	$_SESSION['All Rights Reserved'] = $data['All Rights Reserved'];
	$_SESSION['Incorrect Information'] = $data['Incorrect Information'];
	$_SESSION['Invalid Captcha'] = $data['Invalid Captcha'];
	$_SESSION['Invalid Email'] = $data['Invalid Email'];
	$_SESSION['Invalid Name'] = $data['Invalid Name'];	
	$_SESSION['Success Contact Message'] = $data['Success Contact Message'];
	$_SESSION['Empty Captcha'] = $data['Empty Captcha'];
	$_SESSION['Language'] = $data['Language'];
	$_SESSION['social_message'] = $data['social_message'];
	$_SESSION['oops'] = $data['oops'];
	$_SESSION['404-page-not-found'] = $data['404-page-not-found'];
	$_SESSION['take-me-home'] = $data['take-me-home'];
	$_SESSION['email_required'] = $data['email_required'];
	$_SESSION['name_required'] = $data['name_required'];
	$_SESSION['message_required'] = $data['message_required'];
	$_SESSION['field_empty'] = $data['field_empty'];
	$_SESSION['notavailable'] = $data['notavailable'];
	$_SESSION['language_set'] = 1;
}
if(!isset($_SESSION['set']))
{
	$multiply=mysql_fetch_array(mysql_query("SELECT * FROM currency_settings"));
	$_SESSION['price_dollor'] = $multiply['price_dollor'];
	$rows=mysql_fetch_array(mysql_query("SELECT * FROM affiliates WHERE status = '1' ORDER BY precedence ASC"));
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
if(!isset($_SESSION['contact_captcha_status']))
{

	$rows = mysql_fetch_array(mysqlQuery("SELECT `captcha_contact_status` FROM captcha_settings"));

	$_SESSION['contact_captcha_status'] = $rows['captcha_contact_status'];

}
if(!isset($_SESSION['affiliate_links']))
{
	$multiply=mysql_fetch_array(mysql_query("SELECT price_dollor FROM currency_settings"));
	
	$mysql=mysql_query("SELECT * FROM affiliates");
	
	$i=1;
	
	while($rows=mysql_fetch_array($mysql))
	{
	    if($rows['affiliate_name'] == 'godaddy')
		{
			$i = 0;
			$countArray = count($_SESSION['TldArray']);
			while($i < $countArray)
			{
				$tld = $_SESSION['TldArray'][$i];
				$variable = str_replace('.', '', $_SESSION['TldArray'][$i]);
				$affiliateTld = 'godaddy_'.$variable;
				$_SESSION[$affiliateTld]=$rows[$tld] * $multiply['price_dollor'];	
				$i++;
			}
			$_SESSION['godaddy_url']=$rows['url'];	
		}
		else if($rows['affiliate_name'] == 'iwant_my_name')
		{			
			$i = 0;
			$countArray = count($_SESSION['TldArray']);
			while($i < $countArray)
			{
				$tld = $_SESSION['TldArray'][$i];
				$variable = str_replace('.', '', $_SESSION['TldArray'][$i]);
				$affiliateTld = 'iwant_'.$variable;
				$_SESSION[$affiliateTld]=$rows[$tld] * $multiply['price_dollor'];	
				$i++;
			}					
			$_SESSION['iwant_url']=$rows['url'];		 
		}
		else if($rows['affiliate_name'] == 'media_temple')
		{			
			$i = 0;
			$countArray = count($_SESSION['TldArray']);
			while($i < $countArray)
			{
				$tld = $_SESSION['TldArray'][$i];
				$variable = str_replace('.', '', $_SESSION['TldArray'][$i]);
				$affiliateTld = 'media_'.$variable;
				$_SESSION[$affiliateTld]=$rows[$tld] * $multiply['price_dollor'];	
				$i++;
			}			
			$_SESSION['media_url']=$rows['url'];
		}
		else if($rows['affiliate_name'] == 'name_cheap')
		{			
			$i = 0;
			$countArray = count($_SESSION['TldArray']);
			while($i < $countArray)
			{
				$tld = $_SESSION['TldArray'][$i];
				$variable = str_replace('.', '', $_SESSION['TldArray'][$i]);
				$affiliateTld = 'namecheap_'.$variable;
				$_SESSION[$affiliateTld]=$rows[$tld] * $multiply['price_dollor'];	
				$i++;
			}			
			$_SESSION['namecheap_url']=$rows['url'];		
		}
		else if($rows['affiliate_name'] == 'one_one')
		{			
			$i = 0;
			$countArray = count($_SESSION['TldArray']);
			while($i < $countArray)
			{
				$tld = $_SESSION['TldArray'][$i];
				$variable = str_replace('.', '', $_SESSION['TldArray'][$i]);
				$affiliateTld = 'one_'.$variable;
				$_SESSION[$affiliateTld]=$rows[$tld] * $multiply['price_dollor'];	
				$i++;
			}				
			$_SESSION['one_url']=$rows['url'];
			$explode = explode('-',$_SESSION['one_url'],2);
			$PID = explode('-',$explode [1],2);
			$_SESSION['one_PID'] = $PID[0];
		
		}
		else if($rows['affiliate_name'] == 'register')
		{		
			$i = 0;
			$countArray = count($_SESSION['TldArray']);
			while($i < $countArray)
			{
				$tld = $_SESSION['TldArray'][$i];
				$variable = str_replace('.', '', $_SESSION['TldArray'][$i]);
				$affiliateTld = 'register_'.$variable;
				$_SESSION[$affiliateTld]=$rows[$tld] * $multiply['price_dollor'];	
				$i++;
			}		
			$_SESSION['register_url']=$rows['url'];	
		}
		else if($rows['affiliate_name'] == 'united_domains')
		{			
			$i = 0;
			$countArray = count($_SESSION['TldArray']);
			while($i < $countArray)
			{
				$tld = $_SESSION['TldArray'][$i];
				$variable = str_replace('.', '', $_SESSION['TldArray'][$i]);
				$affiliateTld = 'united_'.$variable;
				$_SESSION[$affiliateTld]=$rows[$tld] * $multiply['price_dollor'];	
				$i++;
			}		
			$_SESSION['united_url']=$rows['url'];	
		}
		else if($rows['affiliate_name'] == 'yahoo')
		{			
			$i = 0;
			$countArray = count($_SESSION['TldArray']);
			while($i < $countArray)
			{
				$tld = $_SESSION['TldArray'][$i];
				$variable = str_replace('.', '', $_SESSION['TldArray'][$i]);
				$affiliateTld = 'yahoo_'.$variable;
				$_SESSION[$affiliateTld]=$rows[$tld] * $multiply['price_dollor'];	
				$i++;
			}		
			$_SESSION['yahoo_url']=$rows['url'];	
		}
		else if($rows['affiliate_name'] == 'hover')
		{			
			$i = 0;
			$countArray = count($_SESSION['TldArray']);
			while($i < $countArray)
			{
				$tld = $_SESSION['TldArray'][$i];
				$variable = str_replace('.', '', $_SESSION['TldArray'][$i]);
				$affiliateTld = 'hover_'.$variable;
				$_SESSION[$affiliateTld]=$rows[$tld] * $multiply['price_dollor'];	
				$i++;
			}			
			$_SESSION['hover_url']=$rows['url'];	
		}	
		$i++;	
	}  
	$_SESSION['affiliate_links'] = 1; 
}
if(!isset($_SESSION['cache_time']))
{
	$rows = mysql_fetch_array(mysqlQuery("SELECT * FROM cache_settings"));
	$_SESSION['tld_time'] = $rows['tld_time'];
	$_SESSION['tld_status'] = $rows['tld_status'];
	$_SESSION['suggest_time'] = $rows['suggest_time'];
	$_SESSION['suggest_status'] = $rows['suggest_status'];
	$_SESSION['cache_time'] = 1;
}
if(!isset($_SESSION['whois_link']))
{	
	$rows = mysql_fetch_array(mysqlQuery("SELECT whois_url,whoisStatus FROM settings"));
	$_SESSION['whois_link']=$rows['whois_url'];
	$_SESSION['whoisStatus']=$rows['whoisStatus'];
}
?> 