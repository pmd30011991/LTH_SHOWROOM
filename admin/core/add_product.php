<?php
if (isset($_GET['category'])) {
    require_once('core/class/Category.php');
    $cat_id = $_GET['category'];
    $cat = new Category();
    $data = $cat->getCategoryById($cat_id);
    $data = $data[0];
?>
    <h1>Category: <?php echo $data['name']; ?></h1>
    <canvas id="img_tmp"></canvas>	
    <form>
        <input id="category_id" name="category" type="hidden" value="<?php echo $data['id'] ?>" />
        <input type="file" multiple id="file" name="file" /><label for="file"></label>
        <button id="sub">Cancel</button>
    </form>

    <div id="result">
    </div>
<?php } ?>