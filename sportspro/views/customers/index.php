<?php

require('../../db/database.php');

function get_customers_by_lastname($last_name) {
    global $db;
    $query = 'SELECT * FROM customers
              WHERE lastName = :last_name
              ORDER BY lastName';
    $statement = $db->prepare($query);
    $statement->bindValue(':last_name', $last_name);
    $statement->execute();
    $customers = $statement->fetchAll();
    $statement->closeCursor();
    return $customers;
}

function get_customer($customer_id) {
    global $db;
    $query = 'SELECT * FROM customers
              WHERE customerID = :customer_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':customer_id', $customer_id);
    $statement->execute();
    $customer = $statement->fetch();
    $statement->closeCursor();
    return $customer;
}

function update_customer($customer_id, $first_name, $last_name,
                         $address, $city, $state, $postal_code,
                         $country_code, $phone, $email, $password) {
    global $db;
    $query = 'UPDATE customers
              SET firstName = :first_name,
                  lastName = :last_name,
                  address = :address,
                  city = :city,
                  state = :state,
                  postalCode = :postal_code,
                  countryCode = :country_code,
                  phone = :phone,
                  email = :email,
                  password = :password
              WHERE customerID = :customer_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':first_name', $first_name);
    $statement->bindValue(':last_name', $last_name);
    $statement->bindValue(':address', $address);
    $statement->bindValue(':city', $city);
    $statement->bindValue(':state', $state);
    $statement->bindValue(':postal_code', $postal_code);
    $statement->bindValue(':country_code', $country_code);
    $statement->bindValue(':phone', $phone);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':password', $password);
    $statement->bindValue(':customer_id', $customer_id);
    $statement->execute();
    $statement->closeCursor();
}


$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action == NULL) {
        $action = 'search_customers';
    }
}

if ($action == 'search_customers') {
    $last_name = filter_input(INPUT_POST, 'last_name');
    if ($last_name == NULL) {
        $customers = []; // Empty array if no search yet
    } else {
        $customers = get_customers_by_lastname($last_name);
    }

}
else if ($action == 'display_customer') {
    $customer_id = filter_input(INPUT_POST, 'customer_id', FILTER_VALIDATE_INT);
    $customer = get_customer($customer_id);
    include('customer_display.php');
}
else if ($action == 'update_customer') {
    $customer_id = filter_input(INPUT_POST, 'customer_id', FILTER_VALIDATE_INT);
    $first_name = filter_input(INPUT_POST, 'first_name');
    $last_name = filter_input(INPUT_POST, 'last_name');
    $address = filter_input(INPUT_POST, 'address');
    $city = filter_input(INPUT_POST, 'city');
    $state = filter_input(INPUT_POST, 'state');
    $postal_code = filter_input(INPUT_POST, 'postal_code');
    $country_code = filter_input(INPUT_POST, 'country_code');
    $phone = filter_input(INPUT_POST, 'phone');
    $email = filter_input(INPUT_POST, 'email');
    $password = filter_input(INPUT_POST, 'password');

    update_customer($customer_id, $first_name, $last_name, $address, $city, $state, $postal_code, $country_code, $phone, $email, $password);

    // Redirect to search page after update
    header("Location: .");
}
include '../header.php'; ?>
<main class="container">
    <h2 class="mt-4">Customer Search</h2>
    
    <form action="." method="post" class="row g-3 align-items-center mb-4">
        <input type="hidden" name="action" value="search_customers">
        <div class="col-auto">
            <label class="col-form-label">Last Name:</label>
        </div>
        <div class="col-auto">
            <input type="text" name="last_name" class="form-control" 
                   value="<?php echo htmlspecialchars($last_name ?? ''); ?>">
        </div>
        <div class="col-auto">
            <input type="submit" value="Search" class="btn btn-secondary">
        </div>
    </form>

    <?php if (!empty($customers)) : ?>
        <h3>Results</h3>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email Address</th>
                    <th>City</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($customers as $customer) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($customer['firstName'] . ' ' . $customer['lastName']); ?></td>
                    <td><?php echo htmlspecialchars($customer['email']); ?></td>
                    <td><?php echo htmlspecialchars($customer['city']); ?></td>
                    <td>
                        <form action="customer_display.php" method="post">
                            <input type="hidden" name="action" value="display_customer">
                            <input type="hidden" name="customer_id" value="<?php echo $customer['customerID']; ?>">
                            <input type="submit" value="Select" class="btn btn-primary btn-sm">
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</main>
<?php include '../footer.php'; ?>