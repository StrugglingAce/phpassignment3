<?php
require('../../db/database.php');

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action == NULL) {
        $action = 'list_technicians';
    }
}

if ($action == 'list_technicians') {
    $technicians = get_technicians();
    include('technician_list.php');
} 
else if ($action == 'delete_technician') {
    $tech_id = filter_input(INPUT_POST, 'tech_id', FILTER_VALIDATE_INT);
    delete_technician($tech_id);
    header("Location: .");
} 
else if ($action == 'show_add_form') {
    include('technician_add.php');
} 
else if ($action == 'add_technician') {
    $first_name = filter_input(INPUT_POST, 'first_name');
    $last_name = filter_input(INPUT_POST, 'last_name');
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $phone = filter_input(INPUT_POST, 'phone');
    $password = filter_input(INPUT_POST, 'password');

    // Validate inputs
    if ($first_name == NULL || $last_name == NULL || $email == NULL || $phone == NULL || $password == NULL) {
        $error = "Invalid technician data. Check all fields.";
        include('../errors/error.php'); // Or simply redisplay form with error
    } else {
        add_technician($first_name, $last_name, $email, $phone, $password);
        header("Location: .");
    }
}

function get_technicians() {
    global $db;
    $query = 'SELECT * FROM technicians ORDER BY techID';
    $statement = $db->prepare($query);
    $statement->execute();
    return $statement;
}

function delete_technician($tech_id) {
    global $db;
    $query = 'DELETE FROM technicians WHERE techID = :tech_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':tech_id', $tech_id);
    $statement->execute();
    $statement->closeCursor();
}

function add_technician($first_name, $last_name, $email, $phone, $password) {
    global $db;
    $query = 'INSERT INTO technicians
                 (firstName, lastName, email, phone, password)
              VALUES
                 (:first_name, :last_name, :email, :phone, :password)';
    $statement = $db->prepare($query);
    $statement->bindValue(':first_name', $first_name);
    $statement->bindValue(':last_name', $last_name);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':phone', $phone);
    $statement->bindValue(':password', $password);
    $statement->execute();
    $statement->closeCursor();
}
include '../header.php'; ?>
<main class="container">
    <h2 class="mt-4">Technician List</h2>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Password</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($technicians as $tech) : ?>
            <tr>
                <td><?php echo htmlspecialchars($tech['firstName']); ?></td>
                <td><?php echo htmlspecialchars($tech['lastName']); ?></td>
                <td><?php echo htmlspecialchars($tech['email']); ?></td>
                <td><?php echo htmlspecialchars($tech['phone']); ?></td>
                <td><?php echo htmlspecialchars($tech['password']); ?></td>
                <td>
                    <form action="." method="post">
                        <input type="hidden" name="action" value="delete_technician">
                        <input type="hidden" name="tech_id" value="<?php echo $tech['techID']; ?>">
                        <input type="submit" value="Delete" class="btn btn-danger btn-sm">
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="technician_add.php">Add Technician</a>
</main>
<?php include '../footer.php'; ?>