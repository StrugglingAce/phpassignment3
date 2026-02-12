<?php include '../header.php'; ?>
<main class="container">
    <h2 class="mt-4">View/Update Customer</h2>
    
    <form action="." method="post">
        <input type="hidden" name="action" value="update_customer">
        <input type="hidden" name="customer_id" value="<?php echo $customer['customerID']; ?>">

        <div class="mb-3">
            <label class="form-label">First Name:</label>
            <input type="text" name="first_name" class="form-control" 
                   value="<?php echo htmlspecialchars($customer['firstName']); ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Last Name:</label>
            <input type="text" name="last_name" class="form-control" 
                   value="<?php echo htmlspecialchars($customer['lastName']); ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Address:</label>
            <input type="text" name="address" class="form-control" 
                   value="<?php echo htmlspecialchars($customer['address']); ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">City:</label>
            <input type="text" name="city" class="form-control" 
                   value="<?php echo htmlspecialchars($customer['city']); ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">State:</label>
            <input type="text" name="state" class="form-control" 
                   value="<?php echo htmlspecialchars($customer['state']); ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Postal Code:</label>
            <input type="text" name="postal_code" class="form-control" 
                   value="<?php echo htmlspecialchars($customer['postalCode']); ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Country Code:</label>
            <input type="text" name="country_code" class="form-control" 
                   value="<?php echo htmlspecialchars($customer['countryCode']); ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Phone:</label>
            <input type="text" name="phone" class="form-control" 
                   value="<?php echo htmlspecialchars($customer['phone']); ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Email:</label>
            <input type="text" name="email" class="form-control" 
                   value="<?php echo htmlspecialchars($customer['email']); ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Password:</label>
            <input type="text" name="password" class="form-control" 
                   value="<?php echo htmlspecialchars($customer['password']); ?>">
        </div>

        <div class="mb-3">
            <input type="submit" value="Update Customer" class="btn btn-primary">
        </div>
    </form>
</main>
<?php include '../footer.php'; ?>