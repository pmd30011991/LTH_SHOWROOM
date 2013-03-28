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
<input id="category_id" type="hidden" value="<?php echo $id; ?>" />
</form>
<a href="add_product?category=<?php echo $id ?>">Add New Images/Videos</a>
<?php 
     echo '<table class="product-table">
        <thead>
            <th>Preview</th>
            <th>Name</th>
            <th>Description</th>
            <th>Order</th>
            <th>Action</th>
        </thead>
    ';
     foreach($data as $r){
        $elem = '';
        if(get_file_type($r['thumb']) == 'image') {
           $elem = show_file('../products/'.$category[0]['name'].'/thumb/'.$r['thumb']);
        } else if (get_file_type($r['thumb']) == 'video') {
            $elem = show_file('../products/'.$category[0]['name'].'/'.$r['thumb']);
        }
        echo '<tr>
        <td class="product-td"><div style="display:none" class="progressbarWrapper"><div class="progressbar"></div></div><input type="file" style="display:none" class="input_file_hidden" /><div class="bt_change_product">Change</div><div class="product-wrapper">'.$elem.'</div></td>
        <td class="product-td-editable"><div class="editable" target="name">'.$r['name'].'</div><input style="display:none" class="name editablePlacehold" value="'.$r['name'].'" /></td>
        <td class="product-td-editable"><div class="editable" target="description">'.$r['description'].'</div><input style="display:none" class="description editablePlacehold" value="'.$r['description'].'" /></td>
        <td class="product-td-editable"><div class="editable" target="order">'.$r['order'].'</div><input style="display:none" class="order editablePlacehold" value="'.$r['order'].'" /></td>
        <td><div style="display:none" class="bt_save">Save</div>-<a class="bt-delete" href="delete_product?category='.$r['category_id'].'&id='.$r['id'].'">Delete</a></td>
        <input type="hidden" class="file" value="'.$r['file'].'"/>
        <input type="hidden" class="thumb" value="'.$r['thumb'].'"/>
        <input type="hidden" class="id" value="'.$r['id'].'"/>
        </tr>';
    }
echo '</table>';
get_pagging($limit, $page, $count);
?>