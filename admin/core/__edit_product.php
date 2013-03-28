<?php
require_once ('class/Category.php');
require_once ('class/Product.php');
require_once ('functions.php');
$cat = new Category();
$p = new Product();
$pid = $_GET['pid'];
$data = $p->getProductById($pid);
if (count($data) > 0) {
    $data = $data[0];
    $cat_data = $cat->getCategoryById($data['category_id']);
    $cat_data = $cat_data[0];
?>
<div class="form">
    <p>Name</p>
    <input value="<?php echo $data['name'] ?>" />
    <p>Description</p>
    <input value="<?php echo $data['description'] ?>" />
    <p>Category</p>
    <input value="<?php echo $cat_data['name'] ?>" />
    <p>File</p>
    <input value="<?php show_file($data['thumb']); ?>" />
    <p>Name</p>
    <input value="<?php echo $data['name'] ?>" />
    <input id="thumb" value="<?php echo $data['name'] ?>" />
</div>
<?php
}
?>