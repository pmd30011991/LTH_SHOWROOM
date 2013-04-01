<?php
session_start();
define('PRODUCTS_DIR',dirname(dirname(__FILE__)).'/products/');
require_once 'core/config/config.php';
require_once 'core/class/Database.php';
$redirect_query = $_SERVER['QUERY_STRING'];
//echo '<pre>';
//print_r($_SESSION);
//echo '</pre>';


if(isset($_SESSION['username']) && $_SESSION['username'] == 'admin' && isset($_SESSION['password']) && $_SESSION['password'] == '123456') {
	$query = explode('&', $redirect_query);
	$qfile = explode('=',$query[0]);
	$file = $qfile[1].'.php';
	if(count($query)>1){
		
	}
	if($qfile[1] == 'getContent'){
		require('core/get_content.php');
	} else {
		if ($qfile[1]=='' || $qfile[1]=='index') {
			$file = 'categories.php';
		}
		if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH']!='XMLHttpRequest'){
			include('core/header.php');
		}
		if(file_exists('core/'.$file))
			require ('core/'.$file);
		else
			require ('core/404.php');
	}
} else {
	require ('login.php');
}
?>