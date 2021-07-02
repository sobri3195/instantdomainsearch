<?php
if (!isset($_SESSION))
session_start();

if (isset($_SESSION['admin_vd_secure'])){

	unset($_SESSION['admin_vd_secure']);
	
}

header("location:./index.php");
?>