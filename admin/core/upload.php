<?php// e.g. url:"page.php?upload=true" as handler property//print_r($_SERVER);define("IMAGEHASH", 'as98dasd2b23f32fu21gf8712gf');require_once 'ext/thumb/ThumbLib.inc.php';require_once 'class/Category.php';require_once 'class/Product.php';$act = $_GET['act'];$p = new Product();if (// basic checks        isset(                $_SERVER['CONTENT_TYPE'],                 $_SERVER['CONTENT_LENGTH'],                 $_SERVER['HTTP_X_FILE_NAME']) &&        $_SERVER['CONTENT_TYPE'] == 'multipart/form-data' &&        (isset($_GET['category']) && $_GET['category'] != '') &&        $act == 'upload') {    // create the object and assign property    /* $file = new stdClass;      $file->name = basename($_SERVER['HTTP_X_FILE_NAME']);      $file->size = $_SERVER['HTTP_X_FILE_SIZE'];      $file->content = file_get_contents("php://input");      // if everything is ok, save the file somewhere      if(file_put_contents('files/'.$file->name, $file->content))      echo "OK"; */    $cat_id = $_GET['category'];    $cat = new Category();    $data = $cat->getCategoryById($cat_id);    $upload_dir = '../products/'.$data[0]['name'].'/';    $fileName = basename($_SERVER['HTTP_X_FILE_NAME']);    if (file_exists($upload_dir . $fileName)) {        $fileName = uniqid() . $fileName;    }    $input = fopen('php://input', 'rb');    $file = fopen($upload_dir . $fileName, 'wb');    stream_copy_to_stream($input, $file);    fclose($input);    fclose($file);    // Make thumb    $thumb_width = 200;    $file_dir = $upload_dir . $fileName;    try     {          $thumb_name = sha1(IMAGEHASH.$fileName).$fileName;          $thumb = PhpThumbFactory::create($file_dir);          $thumb->resize($thumb_width);          $thumb->save($upload_dir.'thumb/'.$thumb_name);          $result = array(              'file'=>$upload_dir . $fileName,              'thumb'=>$upload_dir.'thumb/'.$thumb_name,              'filename'=>$fileName,              'thumbname'=>$thumb_name          );          echo json_encode($result);     }     catch (Exception $e)     {          // handle error here however you'd like     }   // echo $upload_dir . $fileName;} else if($act=='add') {    $id = (isset($_GET['id'])?$_GET['id']:0);    $name = $_GET['name'];    $des = $_GET['description'];    $order =$_GET['order'];    $file = $_GET['file'];    $thumb = $_GET['thumb'];    $result = null;    $data = $p->getProductById($id);    if(isset($data[0])){         $result= $p->updateProductById($id,array(            'name'=>$name,            'description'=>$des,            'order'=>$order,            'file'=>$file,            'thumb'=>$thumb        ));    } else {        $result= $p->insert(array(            'name'=>$name,            'description'=>$des,            'order'=>$order,            'file'=>$file,            'thumb'=>$thumb        ));    }       if($result>=0){        if($id==0)            echo $p->lastId();        else            echo $id;    } else {        echo '-1';    }    } else if($act=='edit') {    } else if($act=='delete') {     $id = (isset($_GET['id'])?$_GET['id']:0);    echo $p->delete($id);    } else {    // if there is an error this will be the output instead of "OK"    echo "Error";}die();?>