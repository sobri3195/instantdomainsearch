<?php
error_reporting(E_ERROR);

require "cache/phpfastcache.php";
phpFastCache::setup("storage","auto");

function xssClean($data) 
{

	return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
	
}

function mres($var) 
{

    if (get_magic_quotes_gpc()) 
	{
	
        $var = stripslashes(trim($var));
		
    }

return mysql_real_escape_string(trim($var));

}
if(get_magic_quotes_gpc()) 
{

	$process = array(&$_GET, &$_POST, &$_COOKIE, &$_REQUEST);
	
	while (list($key, $val) = each($process)) 
	{
	
		foreach ($val as $k => $v) 
		{
		
			unset($process[$key][$k]);
			
			if (is_array($v)) 
			{
			
				$process[$key][stripslashes($k)] = $v;
				$process[] = &$process[$key][stripslashes($k)];
				
			}
			else 
			{
			
				$process[$key][stripslashes($k)] = stripslashes($v);
			
			}
			
		}
		
	}

	unset($process);
	
}
function isValidDate($date)
{

	if (preg_match("/^(\d{4})-(\d{2})-(\d{2})$/", $date, $matches))
	{
	
	if (checkdate($matches[2], $matches[3], $matches[1])) 
	return true;
	
	}
	
	return false;
}
function add_page($id,$permalink,$description, $keywords, $status, $display_order, $header_status, $footer_status)
{

	mysqlQuery("INSERT INTO pages(id,permalink,description,keywords,status,display_order,header_status,footer_status) VALUES('$id','$permalink','$description','$keywords','$status','$display_order','$header_status','$footer_status')");

}

function getDisplayOrder() 
{

	$array = mysql_fetch_array(mysqlQuery("SELECT MAX(display_order) AS disp_order FROM pages"));

	$total = $array["disp_order"];

	if($total>0)
	$display_order = $total + 1;
	else
	$display_order = 1;

	return $display_order;
	
}

function update_page($id, $permalink,$description,$keywords,$status,$header_status,$footer_status)
{
	
	mysqlQuery("UPDATE `pages` SET permalink='$permalink',description='$description',keywords='$keywords',status='$status',header_status='$header_status',footer_status='$footer_status' WHERE id='$id'");
	mysqlQuery("UPDATE `page_language` SET permalink='$permalink' WHERE id='$id'");
	
}
function update_homepage($id,$description,$keywords,$header_status,$footer_status)
{
	
	mysqlQuery("UPDATE `pages` SET description='$description',keywords='$keywords',header_status='$header_status',footer_status='$footer_status' WHERE id='$id'");
	
}
function delete_page($id)
{

    $id = (int)mres($id);

    $sql_delete = mysqlQuery("DELETE FROM pages WHERE id='$id'");

}
function clean_permalink($permalink)
{

	$to_clean = array(
	"#",
	"%",
	"&",
	"$",
	"*",
	"{",
	"}",
	"(",
	")",
	"@",
	"^",
	"|",
	"/",
	";",
	".",
	",",
	"`",
	"!",
	"\\",
	":",
	"<",
	">",
	"?",
	"/",
	"+",
	'"',
	"'"
	);
	
	$permalink = str_replace(" ", "-", $permalink);
	
	foreach($to_clean as $symbol)
	{
	
	$permalink = str_replace($symbol, "", $permalink);
	
	}
	
	while (strpos($permalink, '--') !== FALSE)
	$permalink = str_replace("--", "-", $permalink);
	
	$permalink = rtrim($permalink, "-");
	
	$permalink = ltrim($permalink, "-");
	
	if ($permalink != "-") 
	return $permalink;
	else 
	return "";
	
}

function gen_permalink($title)
{

	$permalink = strtolower(strip_tags($title));
	
	$permalink = trim($title);
	
	$permalink = str_replace(" ", "-", $permalink);
	
	$permalink = clean_permalink($permalink);
	
	$final = $permalink;
	
	return strtolower($final);
	
}
function already_exists($permalink)
{

	$rows=mysql_fetch_array(mysqlQuery("SELECT * FROM pages WHERE permalink='$permalink'"));
	
	$id=$rows['id'];
	
	if($id) 
	return true;
	else 
	return false;
	
}
function gen_page_permalink($title)
{

	$permalink = string_limit_words($title, 9);
	
	$permalink = preg_replace('/[^a-z0-9]/i', ' ', $permalink);
	
	$permalink = trim(preg_replace("/[[:blank:]]+/", " ", $permalink));
	
	$permalink = strtolower(str_replace(" ", "-", $permalink));
	
	$count = 1;
	
	$temppermalink = $permalink;
	
	while (is_valid_page($permalink))
	{
		
		$permalink = $temppermalink . '-' . $count;
		
		$count++;
		
	}
	
	return $permalink;
	
}
function rootpath()
{
	
	//if(!isset($_SESSION['root_path'])) {

	$_SESSION['root_path'] = regenRootPath();
	
 //}

return $_SESSION['root_path'];
	
}
function cleanUrl($url) 
{

	$url = preg_replace('#^https?://#', '', $url);

	$url = preg_replace('/^www\./', '', $url);

	return $url;
}
function regenRootPath()
{

	$query = mysqlQuery("SELECT `rootPath` FROM `settings`");
	
	$fetch = mysql_fetch_array($query);
	
	if ($fetch['rootPath'] != "")
	{
	
		$www = (urlStructure()) ? 'www.':'';
		$https = (httpsStatus()) ? 'https://':'http://';
		$_SESSION['root_path'] = $https . $www . cleanUrl($fetch['rootPath']);
		
	}

	return $_SESSION['root_path'];

}
function update_settings($name,$title, $description, $keywords, $rootpath, $logo, $favicon,$urlStructure,$https,$f_loader,$p_loader,$whois_link,$whoisStatus)
{ 

    $title = strip_tags(htmlspecialchars(mres($title)));
	
	$description = strip_tags(htmlspecialchars(mres($description)));
	
	$keywords = strip_tags(htmlspecialchars(mres($keywords)));
	
    $rows = mysql_num_rows(mysqlQuery("SELECT * FROM `settings`"));
	
	if($rows>0) 
	{
		$sql_update = mysqlQuery("UPDATE `settings` SET `name`='$name',`title`='$title',`description`='$description',`keywords`='$keywords',`rootpath`='$rootpath',`logo`='$logo',`favicon`='$favicon',urlStructure='$urlStructure', httpsStatus='$https', f_loader='$f_loader', p_loader='$p_loader', whois_url='$whois_link', whoisStatus='$whoisStatus'");
	}
	else
	{
		$sql_update = mysqlQuery("INSERT INTO settings(title,description, keywords,rootpath, urlStructure, httpsStatus, logo,favicon,f_loader,p_loader,whoisStatus) VALUES('$title','$description','$keywords','$rootpath','$urlStructure','$https','$logo','$favicon','$f_loader','$p_loader','$whoisStatus')");
	}
	unset($_SESSION['root_path']);
	unset($_SESSION['loader_session']);
	unset($_SESSION['admin_loader_session']);

}
function valid_facebook_url($field)
{

	if (!preg_match('/^[a-z\d.]{5,}$/i', $field))
	{
	
		return false;
	
	}
	
	return true;
	
}
function valid_twitter_username($field)
{

	if (!preg_match('/^[A-Za-z0-9_]+$/', $field))
	{
	
		return false;
	
	}
	
	return true;
	
}
function valid_google_url($field)
{

	if (!preg_match('/^([0-9]{1,21})$/', $field))
	{
	
	    return false;
	
	}
	
	return true;
	
}
function valid_title($field)
{

	if (strlen($field) > 70 || strlen($field) < 10)
	{
	
		return false;

	}
	
	return true;
	
}
function valid_desc($field)
{

	if (strlen($field) > 160 || strlen($field) < 20)
	{
	
		return false;
	
	}
	
	return true;
	
}


function valid_keyword($field)
{

	if (strlen($field) > 160 || strlen($field) < 20)
	{
	
		return false;
	
	}
	
	return true;
	
}
function get_cr_name()
{

	$rows=mysql_fetch_array(mysqlQuery("SELECT cr_name FROM currency_settings"));
	
	return $rows['cr_name'];
	
}
function get_price()
{

	$rows=mysql_fetch_array(mysqlQuery("SELECT price_dollor FROM currency_settings"));
	
	return $rows['price_dollor'];
	
}
function get_twitter()
{

	$row=mysql_fetch_array(mysqlQuery("SELECT twitter FROM `social_profiles`"));
	
	return $row['twitter'];
	
}
function get_facebook()
{

	$row=mysql_fetch_array(mysqlQuery("SELECT facebook FROM `social_profiles`"));
	
	return $row['facebook'];
	
}
function get_google()
{

	$row=mysql_fetch_array(mysqlQuery("SELECT google_plus FROM `social_profiles`"));
	
	return $row['google_plus'];
	
}
function reset_pass($email)
{

	$rows=mysql_fetch_array(mysqlQuery("SELECT username FROM settings WHERE email = '$email'"));
	
	$username = $rows['username'];
	
	$password = genPassword();
	
	send_email(get_admin_email(), "noreply@" . getDomain(rootPath()), "Password Received", "Your Login Details Updated - " . getMetaTitle() , "Your Login Details Updated<br/>Username: " . $username . "<br/>Your new password is: " . $password . "<br/>Login Here: " . rootPath() . '/admin/login.php');
	
	//$sql_update = mysqlQuery("UPDATE settings SET password='" . md5($password) . "' WHERE email='" . $email . "'");
	
}
function getdomain($url)
{

	if(preg_match("#https?://#", $url) === 0)
	$url = 'http://' . $url;
	
	return strtolower(str_ireplace('www.', '', parse_url($url, PHP_URL_HOST)));
	
}
function get_name()
{

	$rows=mysql_fetch_array(mysqlQuery("SELECT name FROM settings"));
	
	return  $rows['name'];
	
}
function get_title()
{

	$rows=mysql_fetch_array(mysqlQuery("SELECT title FROM settings"));
	
	return  $rows['title'];
	
}
function get_whois()
{

	$rows=mysql_fetch_array(mysqlQuery("SELECT whois_url FROM settings"));
	
	return  $rows['whois_url'];
	
}
function get_admin_email()
{

	$rows=mysql_fetch_array(mysqlQuery("SELECT email FROM settings"));
	
	return  $rows['email'];
	
}
function sencrypt($text)
{

	return strtr(base64_encode($text) , '+/=', '-_,');

}
function sdecrypt($text)
{

	return base64_decode(strtr($text, '-_,', '+/='));
	
}
function get_admin_username()
{

	$sql_select=mysqlQuery("SELECT username FROM settings");
	
	$rows=mysql_fetch_array($sql_select);
	
	$count=mysql_num_rows($sql_select);
	
	if ($count > 0)
	return  $rows['username'];
	
}
function get_tracking_code()
{

	$fetch = mysql_fetch_Array(mysqlQuery("SELECT status from analytics"));
	
	if ($fetch['status'])
	{
		
		$row = mysql_fetch_array(mysqlQuery("select tracking_code from analytics"));
		
		$code = str_replace("<q>", "'", $row["tracking_code"]);
		
		$code = htmlspecialchars_decode($code);
		
		return ($code);
	}
	
	return "";
	
}
function get_description()
{

	$array = mysql_fetch_array(mysqlQuery('SELECT `description` FROM settings'));

	if (trim($array['description']))
		return trim($array['description']);

	return '';

}
function get_tags()
{
	
	$array = mysql_fetch_array(mysqlQuery('SELECT `keywords` FROM settings'));

	if (trim($array['keywords']) != "")
		return trim($array['keywords']);
		
	return '';
	
}

function valid_url($url)
{

	$validation = filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_HOST_REQUIRED) && (preg_match("#^http(s)?://[a-z0-9-_.]+\.[a-z]{2,4}#i", $url));
	
	if ($validation) 
	return true;
	else 
	return false;
	
}
function send_email($to, $from, $name, $subject, $body)
{

	$admin = getUser();
	
	$mail = new SimpleMail();
   
    $mail->setTo($to, 'Admin');
	
    $mail->setSubject($subject);
	
    $mail ->setFrom('no-reply@fullwebstats.com',$name);
	
	$mail->addMailHeader('Reply-To', $from, $name);
	
    $mail->addGenericHeader('X-Mailer', 'PHP/' . phpversion());
	
    $mail->addGenericHeader('Content-Type', 'text/html; charset="utf-8"');
	
    $mail->setMessage("<html><body><p face='Georgia, Times' color='red'><p>Hello! <b>" . ucwords($admin) . "</b>,</p> <p>" . $body . "</p><br /><br /><p>Sent Via <a href='" . rootPath() . "'>" . getMetaTitle() . "</a></p>");
	
    $mail->setWrap(100);
	  
	$send = $mail->send();
	
}
function genPassword()
{

	$chars = "abcdefghijkmnopqrstuvwxyz023456789";
	
	srand((double)microtime() * 1000000);
	
	$i = 0;
	
	$pass = '';
	
	while ($i <= 8)
	{
	
		$num = rand() % 33;
		
		$tmp = substr($chars, $num, 1);
		
		$pass = $pass . $tmp;
		
		$i++;
		
	}
	
	return $pass;
	
}
function is_alpha($val)
{

	return (bool)preg_match("/^([0-9a-zA-Z ])+$/i", $val);

}
function checkEmail($email)
{

	return preg_match('/^\S+@[\w\d.-]{2,}\.[\w]{2,6}$/iU', $email) ? TRUE : FALSE;

}
function is_valid_page($permalink)
{

	$match = "select title from pages where permalink='" . $permalink . "'";
	
	$qry = mysqlQuery($match);
	
	$num_rows = mysql_num_rows($qry);
	
	if ($num_rows > 0) 
	return true;
	else
	return false;
	
}
function email_exists($val)
{

	$sql_select=mysqlQuery("SELECT username FROM settings WHERE email ='$val'");
	
	$rows=mysql_fetch_array($sql_select);
	
	$count=mysql_num_rows($sql_select);
	
	if($count > 0)			
	return true;
	else 
	return false;
	
}
function get_logo()
{

	$rows=mysql_fetch_array(mysqlQuery("SELECT logo FROM settings"));
	return  $rows['logo'];
	
}
function get_favicon()
{

	$rows=mysql_fetch_array(mysqlQuery("SELECT favicon FROM settings"));
	
	return  $rows['favicon'];
	
}
function valid_file_extension($ext)
{

	$allowedExts = array(
	"gif",
	"jpeg",
	"jpg",
	"png"
	);
	
	if (!in_array($ext, $allowedExts))
	{
	
	return false;
	
	}
	
	return true;
	
}
function valid_favicon_extension($ext)
{

	$allowedExts = array(
	"ico",
	"png"
	);
	
	if (!in_array($ext, $allowedExts))
	{
	
		return false;
	
	}
	
		return true;
}
function valid_language_extension($ext)
{

	$allowedExts = array(
	"txt",
	"docx",
	"php",
	"html",
	"pdf"
	);
	
	if (!in_array($ext, $allowedExts))
	{
	
		return false;
	
	}
	
		return true;
}
function show_med_rec1_ad()
{

	$rows=mysql_fetch_array(mysqlQuery("SELECT medrec1 FROM ads"));
	
	$code = str_replace("<q>", "'", $rows['medrec1']);
	
	$code = htmlspecialchars_decode($code);
	
	return ($code);
	
}
function show_med_rec2_ad()
{

	$rows=mysql_fetch_array(mysqlQuery("SELECT medrec2 FROM ads"));
	
	$code = str_replace("<q>", "'", $rows['medrec2']);
	
	$code = htmlspecialchars_decode($code);
	
	return ($code);	
	
}
function analyticsEnabled() {

	$array = mysql_fetch_array(mysqlQuery("SELECT `status` FROM `analytics`"));
	
	if ($array['status'])
		return true;
	
	return false;

}
function show_analytics_status()
{

	$rows=mysql_fetch_array(mysqlQuery("SELECT tracking_code FROM analytics"));
	
	$code = str_replace("<q>", "'", $rows['tracking_code']);
	
	$code = htmlspecialchars_decode($code);
	
	return ($code);	
	
}
function increment_page_views()
{

	$sql = mysqlQuery("SELECT pageviews FROM `stats` WHERE `date` = CURDATE()");
	
	$rows = mysql_num_rows($sql);
	
	if ($rows > 0)
	{
	
		$sql_update = mysqlQuery("UPDATE `stats` SET `pageviews`=`pageviews`+1 WHERE `date`=CURDATE()");

	}
	else
	{
	
		$sql_insert = mysqlQuery("INSERT INTO `stats`(`pageviews`, `unique_hits`, `date`) VALUES ('1','0',CURDATE())");
	
	}
	
}
function increment_unique_hits()
{

	$sql = mysqlQuery("SELECT unique_hits FROM `stats` WHERE `date`=CURDATE()");
	
	$rows = mysql_num_rows($sql);
	
	if ($rows > 0)
	{
	
		$sql_update = mysqlQuery("UPDATE `stats` SET `unique_hits`=`unique_hits`+1 WHERE `date`=CURDATE()");
	
	}
	else
	{
	
		$sql_insert = mysqlQuery("INSERT INTO `stats`(`pageviews`, `unique_hits`, `date`) VALUES ('0','1',CURDATE())");
	
	}
	
}
function increment_affiliates_hits()
{

	$sql = mysqlQuery("SELECT affiliates_hits FROM `stats` WHERE `date` = CURDATE()");
	
	$rows = mysql_num_rows($sql);
	
	if ($rows > 0)
	{
	
		$sql_update = mysqlQuery("UPDATE `stats` SET `affiliates_hits`=`affiliates_hits`+1 WHERE `date`=CURDATE()");

	}
	else
	{
	
		$sql_insert = mysqlQuery("INSERT INTO `stats`(`pageviews`, `unique_hits`,`affiliates_hits`, `date`) VALUES ('1','1','1',CURDATE())");
	
	}
	
}
function db_decode($str)
{

	$str = trim(str_replace("<q>", "'", $str));
	
	$str = htmlspecialchars_decode($str);
	
	return $str;
	
}
function authenticate($email, $password)
{

	$email = mres($email);
	
	$password = md5($password);
	
	$sql      = "select email from settings WHERE (email='$email' AND password='$password') OR (username='$email' AND password='$password')";
	
	$query    = mysqlQuery($sql);
	
	if (mysql_num_rows($query) > 0)
	{
	
		return true;
		
	}
	else
	{
	
		return false;
		
	}
	
}
function show_medrec1()
{

	$row=mysql_fetch_array(mysqlQuery("SELECT medrec1,medrec1_status FROM ads"));
	
	if($row['medrec1_status']==1)
	return $row['medrec1'];
	
}
function show_medrec2()
{

	$row=mysql_fetch_array(mysqlQuery("SELECT medrec2,medrec2_status FROM ads"));
	
	if($row['medrec2_status']==1)
	return $row['medrec2'];
	
}
function show_medrec3()
{

	$row=mysql_fetch_array(mysqlQuery("SELECT medrec3,medrec3_status FROM ads"));
	
	if($row['medrec3_status']==1)
	return $row['medrec3'];
	
}
function captcha_admin_login_status() 
{

	$array  = mysql_fetch_array(mysqlQuery("SELECT captcha_admin_login_status FROM captcha_settings"));
	
	if($array['captcha_admin_login_status'])
	return true;
	return false;
	
}
function captcha_contact_status() 
{

	$array  = mysql_fetch_array(mysqlQuery("SELECT captcha_contact_status FROM captcha_settings"));
	
	if($array['captcha_contact_status'])
	return true;
	return false;
	
}
function getMetaTitle() 
{

	$array = mysql_fetch_array(mysqlQuery("SELECT `title` FROM `settings`"));
	
	if ($array['title'] != "")
	return $array['title'];		
    return "Instant Domain Search";

}
function getUser() 
{

	$array = mysql_fetch_array(mysqlQuery("SELECT `username` FROM `settings`"));
	
	if($array['username'])
	return $array['username'];
	
}
function send_contact_email($to, $from, $name, $subject, $body) 
{

	$admin = getUser();
	
	$mail = new SimpleMail();
   
    $mail->setTo($to, 'Admin');
	
    $mail->setSubject($subject);
	
    $mail ->setFrom('no-reply@fullwebstats.com',$name);
	
	$mail->addMailHeader('Reply-To', $from, $name);
	
    $mail->addGenericHeader('X-Mailer', 'PHP/' . phpversion());
	
    $mail->addGenericHeader('Content-Type', 'text/html; charset="utf-8"');
	
    $mail->setMessage("<html><body><p face='Georgia, Times' color='red'><p>Hello! <b>" . ucwords($admin) . "</b>,</p> <p>" . $body . "</p><br /><br /><p>Sent Via <a href='" . rootPath() . "'>" . getMetaTitle() . "</a></p>");
	
    $mail->setWrap(100);
	  
	$send = $mail->send();
	
}
function captcha_enable_settings($contact_enable,$login_enable) 
{

    $sql_update = mysqlQuery("UPDATE `captcha_settings` SET `captcha_contact_status`='$contact_enable',`captcha_admin_login_status`='$login_enable'");

}
function captcha_contact_enable() 
{

	$show  = "select captcha_contact_status from captcha_settings";
	
	$qry   = mysqlQuery($show);
	
	$array = mysql_fetch_array($qry);
	
	return $array['captcha_contact_status'];
	
}
function captcha_login_enable() 
{

	$show  = "select captcha_admin_login_status from captcha_settings";
	
	$qry   = mysqlQuery($show);
	
	$array = mysql_fetch_array($qry);
	
	return $array['captcha_admin_login_status'];
	
}
function return_downloads_this_month()
{

	$sql="SELECT SUM(total_searches) AS total_searches from stats WHERE YEAR(date) = YEAR(CURDATE()) AND MONTH(date) = MONTH(CURDATE()) ";
	
	$query=@mysqlQuery($sql);
	
	$fetch_array = @mysql_fetch_array($query);
	
	if ($fetch_array['total_searches'])
	return $fetch_array['total_searches'];
	return "0";
	
}
function return_total_searches($date)
{

	$sql = "select sum(total_searches) as total_searches from stats where date='$date'";
	
	$query = @mysqlQuery($sql);
	
	$fetch_array = @mysql_fetch_array($query);
	
	if ($fetch_array['total_searches']) return $fetch_array['total_searches'];
	return "0";
	
}
function return_downloads_all_time()
{

	$sql="SELECT SUM(total_searches) AS total_searches from stats";
	
	$query=@mysqlQuery($sql);
	
	$fetch_array = @mysql_fetch_array($query); 
	
	if ($fetch_array['total_searches'])
	return $fetch_array['total_searches'];	
	return "0";
	
}
function update_social($facebook,$twitter,$google,$f_status,$t_status,$g_status,$all_status)
{

	$sql_update = mysqlQuery("UPDATE `social_profiles` SET `facebook`='$facebook',`twitter`='$twitter',`google_plus`='$google',`f_status`='$f_status',`t_status`='$t_status',`g_status`='$g_status',`social_buttons`='$all_status'");

}
function update_currency($cr_name,$price_dollor,$show) 
{
	
	$sql_update = mysqlQuery("UPDATE currency_settings SET cr_name='$cr_name', price_dollor='$price_dollor', show_place='$show'");
	
}
function update_ads($medrec1,$medrec1_status,$medrec2,$medrec2_status)
{
	
	$sql_update = mysqlQuery("UPDATE `ads` SET `medrec1`='$medrec1',`medrec1_status`='$medrec1_status',`medrec2`='$medrec2',`medrec2_status`='$medrec2_status'");
	
}
function show_analytics_status1() 
{ 
	
	$rows=mysql_fetch_array(mysqlQuery("SELECT tracking_code FROM analytics"));
	
	$code = str_replace("<q>", "'", $rows['tracking_code']);
	
	$code = htmlspecialchars_decode($code);
	
	return ($code);
	
}
function update_analytics($tracking_code, $status)
{

	$sql_update = mysqlQuery("UPDATE `analytics` SET `tracking_code`='$tracking_code',`status`='$status'");
	
}
function update_license($username, $code)
{

	$rows = mysql_num_rows(mysqlQuery("SELECT * FROM `license`"));
	
	if($rows>0) {

	mysqlQuery("UPDATE `license`  SET `username`='$username',`purchase_code`='$code'");
	
	} else {
	
	mysqlQuery("INSERT INTO `license`(username,purchase_code) VALUES('$username','$code')");;
	
	}
	
}
function change_affiliates_status($godaddy,$wantname,$media,$namecheap,$one_a_one,$register,$united,$yahoo,$hover)
{

    $sql_update = mysqlQuery("UPDATE `affiliates` SET `status`='$godaddy' WHERE `affiliate_name`='godaddy'");
	
	$sql_update = mysqlQuery("UPDATE `affiliates` SET `status`='$wantname' WHERE `affiliate_name`='iwant_my_name'");
	
	$sql_update = mysqlQuery("UPDATE `affiliates` SET `status`='$media' WHERE `affiliate_name`='media_temple'");
	
	$sql_update = mysqlQuery("UPDATE `affiliates` SET `status`='$namecheap' WHERE `affiliate_name`='name_cheap'");
	
	$sql_update = mysqlQuery("UPDATE `affiliates` SET `status`='$one_a_one' WHERE `affiliate_name`='one_one'");
	
	$sql_update = mysqlQuery("UPDATE `affiliates` SET `status`='$register' WHERE `affiliate_name`='register'");
	
	$sql_update = mysqlQuery("UPDATE `affiliates` SET `status`='$united' WHERE `affiliate_name`='united_domains'");
	
	$sql_update = mysqlQuery("UPDATE `affiliates` SET `status`='$yahoo' WHERE `affiliate_name`='yahoo'");
	
	$sql_update = mysqlQuery("UPDATE `affiliates` SET `status`='$hover' WHERE `affiliate_name`='hover'");
	
	
}
function update_domains($tld,$domain)
{
    $date=date("Y-m-d");
	
	$sld = $domain.'.'.$tld;

	$obj = new Whois($sld);

	if ($obj->isAvailable()) 
	{
		$sql_update = mysqlQuery("UPDATE `instant_domain` SET `$tld` = '1',last_date_check='$date'  WHERE `domain`='$domain'");
	} 
	else
	{
		$sql_update = mysqlQuery("UPDATE `instant_domain` SET `$tld` = '2',last_date_check='$date'  WHERE `domain`='$domain'");
	}
	
}
function Text_Box_Validation($url)
{

	if(trim(substr($url,0,7))=="http://")
		$url = trim(substr($url,7,strlen($url)-7));
	
	if(trim(substr($url,0,8))=="https://")
		$url = trim(substr($url,8,strlen($url)-8));
	
	if(trim(substr($url,0,4))=="www.")
		$url = trim(substr($url,4,strlen($url)-4));
	
	$data = clean($url);

	while(strpos(trim($data),"---")!==false)
	{
	
	     $data = str_replace("---","--",$data);
	
	}
	
	while(trim(substr($data,0,1))=="." || trim(substr($data,strlen($data)-1,1))=="." || trim(substr($data,0,1))=="-" || trim(substr($data,strlen($data)-1,1))=="-")
	{
	
		$data = ltrim($data,"-");
		
		$data = rtrim($data,"-");
		
		$data = ltrim($data,".");
		
		$data = rtrim($data,".");
	
	}
	if(strpos($data,".")!==false)
	{
	
		$data = strrev($data);
		
		$data = explode(".",$data);
		
		$i = count($data);
		
		$url = "";
		
		for($i;$i>0;$i--)
		{
		
		     $url .=strrev($data[$i]);
		
		}
		
	}
	else
		$url = $data;
	
	$url = ltrim($url,"-");
	
	$url = rtrim($url,"-");
	
	return substr($url, 0,60);
	
}
function clean($string)
{

	$string = str_replace(' ', '', $string); 
	
	$string = preg_replace('/[^A-Za-z.0-9\-]/', '', $string);
	
	return $string;
	
}
function return_affiliate_url($domain,$tld)
{

		if($_SESSION['affiliate_name']=="godaddy")	
			$affiliate_url = $_SESSION['url']."?sid=1673601704.1419598115&url=https://www.godaddy.com/domains/search.aspx?domainToCheck="  . $domain  . "." . $tld . "&checkAvail=1";
		else if($_SESSION['affiliate_name']=="iwant_my_name")
			$affiliate_url = $_SESSION['url']."&afftrack=&urllink=iwantmyname.com%2Fsearch%2Fadd%2F"  . $domain  . "." . $tld . "%3Fr%3DInstantDomainSearch%26_r%3DInstantDomainSearch%26_p%3Dsession%253Dunused%2526user%253Dunused";
		else if($_SESSION['affiliate_name']=="media_temple")
			$affiliate_url = $_SESSION['url'];
		else if($_SESSION['affiliate_name']=="united_domains")
			$affiliate_url = $_SESSION['url'];
		else if($_SESSION['affiliate_name']=="yahoo")
			$affiliate_url = $_SESSION['url'];
		else if($_SESSION['affiliate_name']=="one_one")
		{
		    $explode = explode('-',$_SESSION['url'],2);
			$PID = explode('-',$explode [1],2);
			$affiliate_url = "https://www.dpbolvw.net/interactive?sid=80072381.1420179601&domain="  . $domain  . "&tld="  . $tld  . "&aid=10933941&pid=" . $PID[0] . "&url=http://order.1and1.com/dcjump?ac=OM.US.US469K02463T2103a&ovm_kp=wh&ovm_wm=s_ch_360x50";
		}
		else if($_SESSION['affiliate_name']=="name_cheap")
			$affiliate_url = $_SESSION['url']."?sid=1673601704.1419598115&url=https://www.namecheap.com/domains/registration/results.aspx?domain=" . $domain . "." . $tld;
		else if($_SESSION['affiliate_name']=="register")
			$affiliate_url = $_SESSION['url'];
		else if($_SESSION['affiliate_name']=="hover")
			$affiliate_url = $_SESSION['url']. "?p.domain=".$domain.".".$tld;
		else 
		{
		
			$rows=mysql_fetch_array(mysqlQuery("SELECT * FROM affiliates WHERE status = '1' ORDER BY precedence ASC"));
			if($rows['affiliate_name'] == 'godaddy')
				$affiliate_url = $_SESSION['url']."?sid=1673601704.1419598115&url=https://www.godaddy.com/domains/search.aspx?domainToCheck="  . $domain  . "." . $tld . "&checkAvail=1";
			else if($rows['affiliate_name'] == 'iwant_my_name')
				$affiliate_url = $_SESSION['url']."&afftrack=&urllink=iwantmyname.com%2Fsearch%2Fadd%2F"  . $domain  . "." . $tld . "%3Fr%3DInstantDomainSearch%26_r%3DInstantDomainSearch%26_p%3Dsession%253Dunused%2526user%253Dunused";
			else if($rows['affiliate_name'] == 'media_temple')
				$affiliate_url = $_SESSION['url'];
			else if($rows['affiliate_name'] == 'name_cheap')
				$affiliate_url = $_SESSION['url']."?sid=1673601704.1419598115&url=https://www.namecheap.com/domains/registration/results.aspx?domain=" . $domain . "." . $tld;
			else if($rows['affiliate_name'] == 'one_one')
			{
			    $explode = explode('-',$_SESSION['url'],2);
				$PID = explode('-',$explode [1],2);
				$affiliate_url = "https://www.dpbolvw.net/interactive?sid=80072381.1420179601&domain="  . $domain  . "&tld="  . $tld  . "&aid=10933941&pid=" . $PID[0] . "&url=http://order.1and1.com/dcjump?ac=OM.US.US469K02463T2103a&ovm_kp=wh&ovm_wm=s_ch_360x50";
			}
			else if($rows['affiliate_name'] == 'register')
				$affiliate_url = $_SESSION['url'];
			else if($rows['affiliate_name'] == 'united_domains')
				$affiliate_url = $_SESSION['url'];
			else if($rows['affiliate_name'] == 'yahoo')
				$affiliate_url = $_SESSION['url'];
			else if($_SESSION['affiliate_name']=="hover")
				$affiliate_url = $_SESSION['url']. "?p.domain=".$domain.".".$tld;
			else
			$affiliate_url = $_SESSION['url']."?sid=1673601704.1419598115&url=https://www.godaddy.com/domains/search.aspx?domainToCheck="  . $domain  . "." . $tld . "&checkAvail=1";
			
		}
		return $affiliate_url;
} 
function tld_server($ext,$dom,$who,$price,$tld1)
{
    $data = array();
	$date=date("Y-m-d");
	$sld = $dom.'.'.$ext;
	$cache = phpFastCache();
	$existense = $cache->get($sld);
	if($existense==null || $_SESSION['tld_status'] != 1) 
	{
		$obj = new Whois($sld);
		if($obj->isAvailable()) 
			$existense = 1;
		else
			$existense = 0;
		if($existense == 1)
		{
			$contains = mysql_num_rows(mysqlQuery("SELECT `$ext` FROM instant_domain WHERE domain='$dom'"));
			if($contains>0)
				mysqlQuery("UPDATE instant_domain SET `$ext`='1',last_date_check='$date' WHERE domain='$dom'");
			else
				mysqlQuery("INSERT INTO instant_domain(domain,`$ext`,last_date_check) VALUES('$dom','1','$date')");
		}
		else
		{
			$contains = mysql_num_rows(mysqlQuery("SELECT `$ext` FROM instant_domain WHERE domain='$dom'"));
			if($contains>0)
				mysqlQuery("UPDATE instant_domain SET `$ext`='2' WHERE domain='$dom'");
			else
				mysqlQuery("INSERT INTO instant_domain(domain,`$ext`,last_date_check) VALUES('$dom','2','$date')");	
		}
		$cache->set($sld,$existense,$_SESSION['tld_time']);	
	}	
	if($existense == 1)
	{	
        if($tld1 == 'main_div')
	    {
			$data[0] = '<div id="change-background" class="com-rslt green-rslt">
				<div class="wrapper">
					<a data-toggle="tooltip" data-placement="left" title="'.strtolower($dom.'.'.$ext).'" id="top_domain_href" target="_blank" href="'.return_affiliate_url($dom,$ext).'">
						<div class="com-wrap">
							<div class="com-wrap"><span class="live-domain-name">'.$dom.'.'.$ext.'</span> <div id="top_'.$ext.'_domain" class="com-btn">'.convert_currency($price).'</div></div>
						</div>
					</a>
				</div>
			</div>';				
		}
		else
		{
			$data[0] = '<a data-toggle="tooltip" data-placement="left" title="'.strtolower($dom.'.'.$ext).'" target="_blank" id="href_'.str_replace('.', '', $ext).'" href="'.return_affiliate_url($dom,$ext).'">
				<div  class="col-lg-8 col-md-8 col-sm-7 col-xs-7 domain-name">
					<span class="InstantDomainShow">'.$dom.'</span><span class="domain-ext">.'.$ext.'</span>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-5 col-xs-5 domain-button">
					<div id="tld_'.str_replace('.', '', $ext).'"  class="btn-dmn btn-green" href='.return_affiliate_url($dom,$ext).'">'.convert_currency($price).'                                  
					</div>
				</div>
			</a>';						
		}		
	}
	else
	{
		$whois_link = str_replace("{domain}",$dom.'.'.$ext,$_SESSION['whois_link']);
        if($tld1 == 'main_div')
	    {
			if($_SESSION['whoisStatus'] == 1)
				$DefinedWhoisUrl = '<a data-toggle="tooltip" data-placement="left" title="'.strtolower($dom.'.'.$ext).'" target="_blank" href="'.$whois_link.'">';
			else 
				$DefinedWhoisUrl = '<a style="cursor:pointer" data-toggle="tooltip" data-placement="left" title="'.strtolower($dom.'.'.$ext).'">';
			$data[0] = '<div id="change-background" class="com-rslt red-rslt">
				<div class="wrapper">
					'.$DefinedWhoisUrl.'
						<div class="com-wrap">
							<div class="com-wrap"><span class="live-domain-name">'.$dom.'.'.$ext.'</span> <div id="top_'.$who.'_domain" class="com-btn">'.$who.'</div></div>
						</div>
					</a>
				</div>
			</div>';	
		}
		else
		{	
			if($_SESSION['whoisStatus'] == 1)
				$DefinedWhoisUrl = '<a data-toggle="tooltip" data-placement="left" title="'.strtolower($dom.'.'.$ext).'" target="_blank" href="'.$whois_link.'">';
			else 
				$DefinedWhoisUrl = '<a data-toggle="tooltip" data-placement="left" title="'.strtolower($dom.'.'.$ext).'">';
				
			$data[0] = ''.$DefinedWhoisUrl.'
				<div  class="col-lg-8 col-md-8 col-sm-7 col-xs-7 domain-name">
					<span class="InstantDomainShow">'.$dom.'</span><span class="domain-ext">.'.$ext.'</span>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-5 col-xs-5 domain-button">
					<div id="tld_whois" class="btn-dmn btn-red" href="'.return_affiliate_url($dom,$ext).'">'.$who.'                                  
					</div>
				</div>
			</a>';							
		}	
	}
	return $data;
}
function generatePagesSitemap()
{

	$sitemap = "";

	$query = mysqlQuery("SELECT `permalink` FROM `pages` WHERE status = 1 ORDER BY `id` DESC");

	while ($array = mysql_fetch_array($query)) 
	{

		$sitemap .='<url>' . PHP_EOL;

		$sitemap .="<loc>" . rootpath() . "/page/" . $array['permalink'] . "</loc>" . PHP_EOL;

		$sitemap .="<priority>0.6</priority>" . PHP_EOL;

		$sitemap .='</url>' . PHP_EOL;

	}

	return $sitemap;

}
function generateRootSitemap() 
{

	$sitemap = "";

	$sitemap .='<url>' . PHP_EOL;

	$sitemap .="<loc>" . rootPath() . "/</loc>" . PHP_EOL;

	$sitemap .="<priority>1.0</priority>" . PHP_EOL;

	$sitemap .='</url>' . PHP_EOL;

	return $sitemap;
	
}
function generateContactSitemap() 
{

	$sitemap = "";

	$sitemap .='<url>' . PHP_EOL;

	$sitemap .="<loc>" . rootPath() . "/contact</loc>" . PHP_EOL;

	$sitemap .="<priority>0.7</priority>" . PHP_EOL;

	$sitemap .='</url>' . PHP_EOL;

	return $sitemap;
	
}
function sitemapPagesStatus() 
{

	$array = mysql_fetch_array(mysqlQuery("SELECT `pagesStatus` FROM `sitemaps`"));

	return $array["pagesStatus"];

}

function sitemapContactStatus() 
{

	$array = mysql_fetch_array(mysqlQuery("SELECT `contactStatus` FROM `sitemaps`"));

	return $array["contactStatus"];

}

function sitemapDateUpdated() 
{

	$array = mysql_fetch_array(mysqlQuery("SELECT `dateUpdated` FROM `sitemaps`"));

	return date('d M Y', strtotime($array['dateUpdated']));

}
function sitemapFileName() 
{

	$array = mysql_fetch_array(mysqlQuery("SELECT `filename` FROM `sitemaps`"));
	
	return $array["filename"];

}
function updateSitemapsStatus($pagesStatus, $contactStatus,$filename)
{

	$rows = mysql_num_rows(mysqlQuery("SELECT * FROM `sitemaps`"));

	if($rows>0) 
	{

		mysqlQuery("UPDATE `sitemaps` SET `pagesStatus`='$pagesStatus',`contactStatus`='$contactStatus',`filename`='$filename'");

	}
	else 
	{

		mysqlQuery("INSERT INTO `sitemaps`(pagesStatus,contactStatus,filename) VALUES('$pagesStatus','$contactStatus','$filename')");

	}

}
function urlStructure() 
{

	$array = mysql_fetch_array(mysqlQuery("SELECT `urlStructure` FROM `settings`"));

	return $array['urlStructure'];

}
function whoisStatus() 
{

	$array = mysql_fetch_array(mysqlQuery("SELECT `whoisStatus` FROM `settings`"));

	return $array['whoisStatus'];

}
function httpsStatus() 
{

	$array = mysql_fetch_array(mysqlQuery("SELECT `httpsStatus` FROM `settings`"));

	return $array['httpsStatus'];

}
function f_loader() 
{

	$array = mysql_fetch_array(mysqlQuery("SELECT `f_loader` FROM `settings`"));

	return $array['f_loader'];

}
function p_loader() 
{

	$array = mysql_fetch_array(mysqlQuery("SELECT `p_loader` FROM `settings`"));

	return $array['p_loader'];

}
function is_alphaNumeric($string) 
{

	if(preg_match('/^[a-zA-Z]+[a-zA-Z0-9._]+$/', $string))
	return true;
	
	return false;

}
function updateUser($username, $password, $email) 
{
	
	$rows = mysql_num_rows(mysqlQuery("SELECT * FROM `settings`"));
	
	if($rows>0) 
	{
	
		if ($password != "") 
		{
		
			mysqlQuery("UPDATE `settings` SET `username`='$username',password='$password',email='$email'");
		
		}
		
		else 
		{
		
			mysqlQuery("UPDATE settings SET username='$username',email='$email'");
		
		} 
	} 
	else 
	{
	
		if ($password != "") 
		{
		
			mysqlQuery("INSERT INTO `settings`(username,password,email) VALUES('$username','$password','$email')");
		
		}
		
		else 
		{
		
			mysqlQuery("INSERT INTO `settings`(username,email) VALUES('$username','$email')");
		
		}
	
	}
    
    return true;
	
}
function getAddress()
{

	$pageURL = 'http';
	
	if ($_SERVER["HTTPS"] == "on") {
	
		$pageURL .= "s";
	
	}
	$pageURL .= "://";
	
	if ($_SERVER["SERVER_PORT"] != "80") {
	
		$pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
		
	} else {
	
		$pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
	
	}
	
	return htmlentities($pageURL);

}
function convert_currency($val)
{  
	
	if(!isset($_SESSION['currency']))
	{
	
		$rows=mysql_fetch_array(mysqlQuery("SELECT * FROM currency_settings"));
		
		$_SESSION['currency']=$rows['cr_name'];	
		
		$_SESSION['show_place']=$rows['show_place'];
		
	}
	if($val == 0)
	{
		return $_SESSION['Buy'];
	}
	else
	{
	    if($_SESSION['currency'] && $_SESSION['show_place']==1)
		return ($_SESSION['Buy'].' '.$_SESSION['currency'] . ' ' . $val);
		else
		return ($_SESSION['Buy'].' '.$val. ' ' . $_SESSION['currency']);
	}
}
function suggessted_limit()
{ 

	$rows=mysql_fetch_array(mysqlQuery("SELECT * FROM suggessted_limit"));
	
	$limit = $rows['limit'];
	
	return $limit;
	
}
function preserve_days()
{ 

	$rows=mysql_fetch_array(mysqlQuery("SELECT preserve_days FROM suggessted_limit"));
	
	$days = $rows['preserve_days'];
	
	return $days;
	
}
function instantDomainLimit()
{ 

	$rows=mysql_fetch_array(mysqlQuery("SELECT instantLimit FROM suggessted_limit"));
	
	$limit = $rows['instantLimit'];
	
	return $limit;
	
}
function edit_page_language($id,$content,$language,$title)
{

	mysqlQuery("UPDATE `page_language` SET content='$content',title='$title' WHERE `id`='$id' AND language = '$language'");

}
function add_page_language($id, $permalink, $title,$content)
{
	$sql = mysqlQuery("SELECT * FROM language");
	
	while($rows = mysql_fetch_Array($sql))
	{
		$language = $rows['lang_name'];
		mysqlQuery("INSERT INTO `page_language`(id,title,permalink,content,language) VALUES('$id','$title','$permalink','$content','$language')");
	}
}
function layout() {
 
    if($_SESSION['reset_RTL_session'] == 1)
	return true;
	else 
	return false;
	
}
function httpStatusCode($url) {
	
	$handle = curl_init($url);
	
	$USER_AGENT = $_SERVER['HTTP_USER_AGENT'];
	
	curl_setopt($handle,  CURLOPT_RETURNTRANSFER, true);
	
	curl_setopt($handle, CURLOPT_USERAGENT, $USER_AGENT);
	
	curl_setopt($handle, CURLOPT_TIMEOUT, 5);
			
	curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
		
	curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
		
	curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
	
	curl_setopt($handle,CURLOPT_HEADER,true);
    
	curl_setopt($handle,CURLOPT_NOBODY,true);
	
	curl_setopt($handle, CURLOPT_FOLLOWLOCATION, true);
	
	$response = curl_exec($handle);
	
	$httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
	
	curl_close($handle);
	
	return $httpCode;
	
	}
if(!urlStructure() && substr($_SERVER['HTTP_HOST'], 0, 4) === 'www.') {

	$https = (httpsStatus() && isset($_SERVER['HTTPS'])) ? 'https://':'http://';

	if (substr($_SERVER['HTTP_HOST'], 0, 4) === 'www.') {

		header("HTTP/1.1 301 Moved Permanently");

		header('Location: ' . $https . substr($_SERVER['HTTP_HOST'], 4).$_SERVER['REQUEST_URI']);

		exit();

	}

} else if(urlStructure() && (strpos($_SERVER['HTTP_HOST'], 'www.') === false)) {

	$https = (httpsStatus() && isset($_SERVER['HTTPS'])) ? 'https://':'http://';

	if ((strpos($_SERVER['HTTP_HOST'], 'www.') === false)) {
	
		header("HTTP/1.1 301 Moved Permanently");
		
		header('Location: ' . $https . 'www.'.$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]);
		
		exit();
	
	}

}
if($_SERVER["HTTPS"] != "on" && httpsStatus())
{
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    exit();
} else if($_SERVER["HTTPS"] == "on" && !httpsStatus()) {
	header("Location: http://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    exit();
}
?>