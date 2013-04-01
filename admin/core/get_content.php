<?php
require_once('class/Product.php');
require_once('class/Category.php');
require_once('functions.php');
$cat_id = $_POST['category'];
$page = $_POST['page'];
$limit = $_POST['limit'];
$products_folder ='products';
/*$content_dir = dirname(dirname(__FILE__))."/".$products_folder.'/'.$folder;
$content_handle = opendir($content_dir);*/
$result = array();
$result['data']= array();
$result['category']= '';
$result['size']= 0;

$p = new Product();
$cat  = new Category();
$data = $p->getProductsByCategoryId($cat_id,$limit,$page,'order','asc');
$catname = $cat->getCategoryById($cat_id);
$catname = $catname[0];
$result['category'] = $catname['name'];
$count = $p->countByCategory($cat_id);
$result['size'] = $count;
foreach ($data as $d){
    $type = get_file_type($d['file']);
    $thumb = 'thumb';
    if($type == 'video')
        $thumb='';
    $result['data'][] = array('type'=>get_file_type($d['file']),
                                'file'=>'products/'.$catname['name'].'/'.$d['file'],
                                'thumb'=>'products/'.$catname['name'].'/'.$thumb.'/'.$d['thumb'],
							);
}
/*while (false !== ($file = readdir($content_handle))) {
try{
		if(is_file($content_dir.'/'.$file)){
			$ext = pathinfo($content_dir.'/'.$file, PATHINFO_EXTENSION);
			$type='';
			$videos_ext = array('flv','mp4');
			$images_ext = array('jpeg','jpg','png','gif');
		
			
			if(in_array($ext,$videos_ext))
				$type = 'video';
			else if(in_array($ext,$images_ext))
				$type = 'image';
				
			$result['data'][] = array('type'=>$type,
												'file'=>'products/'.$folder.'/'.$file
												);
		$result['size']++;										
		}
		} catch(Exception $e){
			echo $e->getMessage();
		}
}*/
echo json_encode($result);
die();
?>