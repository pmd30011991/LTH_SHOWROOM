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
?>
