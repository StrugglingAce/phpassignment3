<?php
// list_products.php
require '../../db/database.php';

/*
 Expected database columns:
 productCode (VARCHAR)
 name        (VARCHAR)
 version     (DECIMAL or VARCHAR)
 releaseDate (DATE)
*/

//Handle the Delete Action
if (isset($_POST['action']) && $_POST['action'] == 'delete_product') {
    $product_code = $_POST['product_code'];
    $query = "DELETE FROM products WHERE productCode = :productCode";
    $statement = $db->prepare($query);
    $statement->bindValue(':productCode', $product_code);
    $statement->execute();
    $statement->closeCursor();
}

// Fetch all products
$sql = "SELECT productCode, name, version, releaseDate FROM products ORDER BY productCode";
$products = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);

include '../header.php';
?>

<h2 class="mb-3">Product List</h2>

<table class="table table-striped table-bordered">
    <thead class="table-dark">
        <tr>
            <th>Code</th>
            <th>Name</th>
            <th>Version</th>
            <th>Release Date</th>
            <th>&nbsp;</th> </tr>
    </thead>
    <tbody>
        <?php foreach ($products as $product): ?>
            <tr>
                <td><?= htmlspecialchars($product['productCode']) ?></td>
                <td><?= htmlspecialchars($product['name']) ?></td>
                <td><?= htmlspecialchars($product['version']) ?></td>
                <td>
                    <?= date('Y-m-d', strtotime($product['releaseDate'])) ?>
                </td>
                <td>
                    <form action="product_manager.php" method="post">
                        <input type="hidden" name="action" value="delete_product">
                        <input type="hidden" name="product_code"
                               value="<?= htmlspecialchars($product['productCode']) ?>">
                        <input type="submit" value="Delete" class="btn btn-danger btn-sm"
                               onclick="return confirm('Are you sure?');">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a href="add_product.php" class="btn btn-primary">Add Product</a>

<?php include '../footer.php'; ?>