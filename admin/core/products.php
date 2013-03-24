<form id="product_form" method="get" action="">
    <?php
    require_once('class/Category.php');
    require_once('class/Product.php');
    require_once('functions.php');
    $limit = 2;
    $page =0;
    $order_by ='order';
    $order ='asc';
    $cat = new Category();
    $p = new Product();
    $rows = $cat->getAll();
    $id = isset($_GET['category']) ? $_GET['category'] : $rows[0]['id'];
    $page = isset($_GET['page']) ? $_GET['page'] : 0;
    $category = $cat->getCategoryById($id);
    $data = $p->getProductsByCategoryId($id,$limit, $page, $order_by,$order);
    $count = $p->countByCategory($id);
    echo '<select name="category" id="category">';
    foreach ($rows as $r) {
        $selected = '';
        if ($id == $r['id']) {
            $selected = 'selected="selected"';
        }
        echo '<option ' . $selected . ' value="' . $r['id'] . '">' . $r['name'] . '</option>';
    }
    echo '</select>';
    ?>
</form>
<a href="add_product?category=<?php echo $id ?>">Add New Images/Videos</a>
<?php 
     echo '<table>
        <thead>
            <th>Preview</th>
            <th>Name</th>
            <th>Description</th>
            <th>Order</th>
            <th>Action</th>
        </thead>
    ';
     foreach($data as $r){
        echo '<tr>
        <td><img src="../products/'.$category[0]['name'].'/thumb/'.$r['thumb'].'" /></td>
        <td>'.$r['name'].'</td>
        <td>'.$r['description'].'</td>
        <td>'.$r['order'].'</td>
        <td><a href="edit_product?id='.$r['id'].'">Edit</a>-<a href="delete_product?id='.$r['id'].'">Delete</a></td>
        </tr>';
    }
echo '</table>';
get_pagging($limit, $page, $count);
?>