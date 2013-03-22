<form method="post" action="">
<?php 
    require_once('class/Category.php');
    $cat = new Category();
    $rows = $cat->getAll();
    
    $id = isset($_POST['category']) ? $_POST['category'] : '';
    echo '<select name="category" id="category">';
    foreach($rows as $r){
    	$selected = '';
    	if($id == $r['id']){
    		$selected = 'selected="selected"';
    	} 
        echo '<option '.$selected.' value="'.$r['id'].'">'.$r['name'].'</option>';
    }
echo '</select>';
 ?>
 <input type="submit" value="View" />
 </form>
 <a href="add_product.php?category=<?php echo $id ?>">Add New Images/Videos</a>