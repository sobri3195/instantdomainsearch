<?php
if (!isset($_SESSION)) session_start();

error_reporting(E_ALL ^ E_NOTICE);

if (!isset($_SESSION['admin_vd_secure'])) header('Location: ./index.php');

include "../config/config.php";

include "../includes/functions.php";
?>