<?php 
require_once('class/Category.php');
    if(isset($_GET['id'])){
        $cat = new Category();
        $id = $_GET['id'];
        $result = $cat->getCategoryById($id);
        $result = $result[0];
    }
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $cat = new Category();
        $name = $_POST['name'];
        $description = $_POST['description'];
        $order = $_POST['order'];
        $old = $cat->getCategoryById($id);
        $old =$old[0];
        $result = $cat->updateCategoryById($id,array(
            'name'=>$name,
            'description'=>$description,
            'order'=>$order
        ));
        if($result){
            rename('../products/'.$old['name'],'../products/'.$name);
            chmod('../products/'.$name,0777);
            echo 'Update Success';
        } else {
            echo 'Update Fail';
        }
        
    header('Location: categories');
    }
?>
<form method="post" action="">
    <p>Name</p>
    <input name="name" type="text" value="<?php echo $result['name'] ?>" />
    <p>Description</p>
    <input name="description" type="text" value="<?php echo $result['description'] ?>" />
    <p>Order</p>
    <input name="order" type="text" value="<?php echo $result['order'] ?>" />
    <input type="submit" value="Save" />
</form>