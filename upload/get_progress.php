<?php// e.g. url:"page.php?upload=true" as handler property//print_r($_SERVER);if(    // basic checks    isset(        $_SERVER['CONTENT_TYPE'],        $_SERVER['CONTENT_LENGTH'],        $_SERVER['HTTP_X_FILE_NAME']    ) &&    $_SERVER['CONTENT_TYPE'] == 'multipart/form-data'){    // create the object and assign property    /*$file = new stdClass;    $file->name = basename($_SERVER['HTTP_X_FILE_NAME']);    $file->size = $_SERVER['HTTP_X_FILE_SIZE'];    $file->content = file_get_contents("php://input");    // if everything is ok, save the file somewhere    if(file_put_contents('files/'.$file->name, $file->content))        echo "OK";*/        $fileName = basename($_SERVER['HTTP_X_FILE_NAME']);        $input = fopen('php://input', 'rb');$file = fopen('uploads/'.$fileName, 'wb');stream_copy_to_stream($input, $file);fclose($input);fclose($file);echo '<img src="'.'uploads/'.$fileName.'"/>';} else {    // if there is an error this will be the output instead of "OK"    echo "Error";}?>