<?php
ob_start();
require_once('class/Category.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cat = new Category();
    $name = $_POST['name'];
    $description = $_POST['description'];
    $order = $_POST['order'];

    $result = $cat->insert(array(
        'name' => $name,
        'description' => $description,
        'order' => $order
    ));
    if ($result) {
        if (!is_dir('../products/' . $name)) {
            mkdir('../products/' . $name);
            chmod('../products/' . $name, 0777);
            if (!is_dir('../products/' . $name . '/thumb')) {
                mkdir('../products/' . $name . '/thumb');
                chmod('../products/' . $name . '/thumb', 0777);
            }
             if (!is_dir('../products/tmp')) {
                mkdir('../products/tmp');
                chmod('../products/tmp', 0777);
            }
        }
        echo 'insert Success';
    } else {
        echo 'insert fail';
    }
    header('Location: categories');
    ob_flush();
}
?>
<form method="post" action="">
    <p>Name</p>
    <input name="name" type="text" />
    <p>Description</p>
    <input name="description" type="text" />
    <p>Order</p>
    <input name="order" type="text" />
    <input class="ml-button-1" type="submit" value="Add" />
</form>