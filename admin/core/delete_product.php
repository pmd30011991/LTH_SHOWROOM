<?php
require_once('class/Product.php');
require_once('class/Category.php');

if(isset($_GET['id'])){
    $id = $_GET['id'];
	$cat_id = $_GET['category'];
    $p = new Product();
	$cat = new Category();
    $row = $p->getProductById($id);
    $row = $row[0];
    $result = $p->delete($id);
	$catname = $cat->getCategoryById($row['category_id']);
	$catname = $catname[0]['name'];
	if(file_exists('../products/'.$catname.'/thumb/'.$row['thumb']))
		unlink('../products/'.$catname.'/thumb/'.$row['thumb']);
	if(file_exists('../products/'.$catname.'/'.$row['file']))
		unlink('../products/'.$catname.'/'.$row['file']);
	if($result>0){
		echo '1';
	} else {
		echo '-1';
	}
    
header('Location: products?category='.$cat_id);
}
?>