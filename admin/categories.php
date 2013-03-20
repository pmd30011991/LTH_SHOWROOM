<a href="add_category.php">Add New Category</a>
<?php 
    require_once('class/Category.php');
    $cat = new Category();
    $rows = $cat->getAll();
    echo '<table>
        <thead>
            <th>Name</th>
            <th>Description</th>
            <th>Order</th>
            <th>Action</th>
        </thead>
    ';
    foreach($rows as $r){
        echo '<tr>
        <td>'.$r['name'].'</td>
        <td>'.$r['description'].'</td>
        <td>'.$r['order'].'</td>
        <td><a href="edit_category.php?id='.$r['id'].'">Edit</a>-<a href="delete_category.php?id='.$r['id'].'">Delete</a></td>
        </tr>';
    }
echo '</table>';
 ?>