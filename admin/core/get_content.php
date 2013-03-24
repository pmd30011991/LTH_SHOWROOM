<?php
$folder = $_POST['type'];
$from = $_POST['from'];
$to = $_POST['to'];
$products_folder ='products';
$content_dir = dirname(dirname(__FILE__))."/".$products_folder.'/'.$folder;
$content_handle = opendir($content_dir);
$result = array();
$result['data']= array();
$result['size']= 0;
while (false !== ($file = readdir($content_handle))) {
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
}
echo json_encode($result);
die();
?>