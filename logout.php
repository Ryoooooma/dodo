<?php

session_start();

require_once('assets/config.php');
require_once('assets/functions.php');

$_SESSION = array();

if (isset($_COOKIE[session_name()])) {
	setcookie(session_name(), '', time()-86400, '/dodo/');
}

session_destroy();

header('Location: '.SITE_URL.'login.php');

?>