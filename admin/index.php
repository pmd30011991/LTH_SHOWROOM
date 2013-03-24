<?php
define('PRODUCTS_DIR',dirname(dirname(__FILE__)).'/products/');
require_once 'core/config/config.php';
require_once 'core/class/Database.php';
$redirect_query = $_SERVER['REDIRECT_QUERY_STRING'];
//echo '<pre>';
//print_r($_SERVER);
//echo '</pre>';
$query = explode('&', $redirect_query);
$qfile = explode('=',$query[0]);
$file = $qfile[1].'.php';
if(count($query)>1){
    
}
if ($qfile[1]=='') {
    $file = 'categories.php';
}
if ($_SERVER['HTTP_X_REQUESTED_WITH']!='XMLHttpRequest'){
    include('core/header.php');
}
require ('core/'.$file);
?>