<?php 
    require_once('class/Category.php');
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $cat = new Category();
        $name = $_POST['name'];
        $description = $_POST['description'];
        $order = $_POST['order'];
        
        $result = $cat->insert(array(
            'name'=>$name,
            'description'=>$description,
            'order'=>$order
        ));
        if($result){
            if (!is_dir('../products/'.$name)) {
                mkdir('../products/'.$name);
                chmod('../products/'.$name,0777);
            }
            echo 'insert Success';
        } else {
            echo 'insert fail';
        }
    header('Location: categories.php');    
    }
?>
<form method="post" action="">
    <p>Name</p>
    <input name="name" type="text" />
    <p>Description</p>
    <input name="description" type="text" />
    <p>Order</p>
    <input name="order" type="text" />
    <input type="submit" value="Add" />
</form>