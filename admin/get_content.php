<?php 
$folder = $_POST['type'];
$products_folder ='products';
$content_dir = dirname(dirname(__FILE__))."/".$products_folder.'/'.$folder;
$content_handle = opendir($content_dir);
$result = array();
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
				
			$result[] = array('type'=>$type,
												'file'=>$content_dir.'/'.$file
												);
												
		}
		} catch(Exception $e){
			echo $e->getMessage();
		}
}
echo json_encode($result);
die();
?>