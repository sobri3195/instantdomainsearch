<?php
ini_set('mysql.connect_timeout', 60);

ini_set('default_socket_timeout', 60);

$root = 'http://' . $_SERVER['SERVER_NAME'] . dirname($_SERVER['SCRIPT_NAME']);

if (substr($root, -1) == "/")    $root = 'http://' . $_SERVER['SERVER_NAME'];

define("database", "dbname");
define("databaseServer", "dbhost");
define("databaseUser", "dbuser");
define("databasePass", "dbpass");
define("displayMySqlErrors",false);

error_reporting(E_ERROR);

$link  = mysql_connect(databaseServer, databaseUser, databasePass, true);

$check = mysql_select_db(database, $link);

function mysqlQuery($query) 
{	
	$error = "";	
	$results = mysql_query($query) or ($error = mysql_error());	
	if($error!="" && displayMySqlErrors) {
		echo "Error: " . $error . "<br />Query : " . $query . "<br />File : " . $_SERVER['PHP_SELF'];
	}	
return $results;
} 

if (!$check) header("location: " . $root . "/install/");
?>