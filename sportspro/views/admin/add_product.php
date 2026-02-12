<?php
// views/admin/add_product.php
require '../../db/database.php';

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $code = $_POST['code'];
    $name = $_POST['name'];
    $version = $_POST['version'];
    $release_date = $_POST['release_date'];

    if (!empty($code) && !empty($name) && !empty($version) && !empty($release_date)) {
        $query = "INSERT INTO products (productCode, name, version, releaseDate)
                  VALUES (:code, :name, :version, :releaseDate)";
        $statement = $db->prepare($query);
        $statement->bindValue(':code', $code);
        $statement->bindValue(':name', $name);
        $statement->bindValue(':version', $version);
        $statement->bindValue(':releaseDate', $release_date);
        $statement->execute();
        $statement->closeCursor();

        // Redirect back to list
        header("Location: product_manager.php");
        exit();
    } else {
        $error = "Invalid product data. Check all fields.";
    }
}

include '../header.php';
?>

<h2 class="mb-3">Add Product</h2>

<?php if (isset($error)): ?>
    <div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>

<form action="add_product.php" method="post">
    <div class="mb-3">
        <label class="form-label">Code:</label>
        <input type="text" name="code" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Name:</label>
        <input type="text" name="name" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Version:</label>
        <input type="text" name="version" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Release Date:</label>
        <input type="text" name="release_date" class="form-control" placeholder="yyyy-mm-dd" required>
        <div class="form-text">Use 'yyyy-mm-dd' format</div>
    </div>

    <div class="mb-3">
        <input type="submit" value="Add Product" class="btn btn-primary">
        <a href="product_manager.php" class="btn btn-secondary">View Product List</a>
    </div>
</form>

<?php include '../footer.php'; ?>