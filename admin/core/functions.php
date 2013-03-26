<?php
 function get_pagging($limit,$page,$count){
     $pages = ceil($count/$limit);
     $q = $_SERVER['REQUEST_URI'];
     echo '<div class="pagging"><ul>';
     for($p=0;$p<$pages;$p++){
        $selected = '';
        if($page == $p)
             $selected ='selected';
        echo '<li class="'.$selected.'"><a href="'.$q.'&page='.$p.'">'.($p+1).'</a></li>';
     }
     echo '</ul></div>';
 }
 
 function get_file_type($filename) {
	$r = strtolower(substr(strrchr($file_name,'.'),1));
    $img_arr = array('jpg','png','gif','jpeg');
    $video_arr = array('mp4','flv');
    if(in_array($r,$img_arr))
        return 'image';
    else if (in_array($r,$video_arr))
        return 'video';
    else 
        return '';
 }
 function show_file($filename) {
    if(get_file_type($filename) == 'image') {
        echo '<img class="product-image" src="'.$filename.'"/>';
    } else if (get_file_type($filename) == 'video') {
        echo '<video class="product-video" preload="none"><sorce src="" type="video/mp4"></video>';
    }
    else
        echo '';
 }
?>
