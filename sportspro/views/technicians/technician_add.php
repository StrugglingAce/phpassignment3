<?php include '../header.php'; ?>
<main class="container">ß
    <h2 class="mt-4">Add Technician</h2>
    
    <form action="." method="post" id="aligned">
        <input type="hidden" name="action" value="add_technician">

        <div class="mb-3">
            <label class="form-label">First Name:</label>
            <input type="text" name="first_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Last Name:</label>
            <input type="text" name="last_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email:</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Phone:</label>
            <input type="text" name="phone" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Password:</label>
            <input type="text" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <input type="submit" value="Add Technician" class="btn btn-primary">
        </div>
    </form>
    <p><a href="index.php">View Technician List</a></p>
</main>
<?php include '../footer.php'; ?>