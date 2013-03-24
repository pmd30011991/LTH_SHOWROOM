<?php
require_once('class/Category.php');
function delete_dir($src) { 
    $dir = opendir($src);
    while(false !== ( $file = readdir($dir)) ) { 
        if (( $file != '.' ) && ( $file != '..' )) { 
            if ( is_dir($src . '/' . $file) ) { 
                delete_dir($src . '/' . $file); 
            } 
            else { 
                unlink($src . '/' . $file); 
            } 
        } 
    } 
    rmdir($src);
    closedir($dir); 
}
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $cat = new Category();
    $row = $cat->getCategoryById($id);
    $row = $row[0];
    $result = $cat->delete($id);
    if($result){
        if (is_dir('../products/'.$row['name'])) {
            delete_dir('../products/'.$row['name']);
            //rmdir('../products/'.$row['name']);
        }
        echo 'Update Success';
    } else {
        echo 'Update Fail';
    }
    
header('Location: categories.php');
}
?>