<?php
// Include the database connection
include 'conf.php';

// Check if the 'id' is set in the URL
if (isset($_GET['id'])) {
    $supplier_id = $_GET['id'];

    // Query to fetch supplier data based on the supplier ID
    $sql = "SELECT * FROM suppliers WHERE supplier_id = $supplier_id";
    $result = mysqli_query($conn, $sql);

    // Check if the supplier was found
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        echo "<script>alert('Supplier not found!'); window.location.href = 'viewsuppliers.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('No supplier ID provided!'); window.location.href = 'viewsuppliers.php';</script>";
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $supplier_name = mysqli_real_escape_string($conn, $_POST['supplier_name']);
    $company = mysqli_real_escape_string($conn, $_POST['company']);
    $contact_no = mysqli_real_escape_string($conn, $_POST['contact_no']);
    $user_email = mysqli_real_escape_string($conn, $_POST['user_email']);
    $company_address = mysqli_real_escape_string($conn, $_POST['company_address']);
    $item_names = mysqli_real_escape_string($conn, $_POST['item_names']);

    // Update query
    $update_sql = "UPDATE suppliers SET 
                    supplier_name = '$supplier_name',
                    company = '$company',
                    contact_no = '$contact_no',
                    email = '$user_email',
                    company_address = '$company_address',
                    item_names = '$item_names'
                    WHERE supplier_id = $supplier_id";

    if (mysqli_query($conn, $update_sql)) {
        echo "<script>alert('Supplier updated successfully!'); window.location.href = 'viewsuppliers.php';</script>";
    } else {
        echo "<script>alert('Error updating supplier: " . mysqli_error($conn) . "'); window.location.href = 'viewsuppliers.php';</script>";
    }
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Supplier Profile</title>
    <link rel="stylesheet" href="viewupdate.css">
</head>
<body>
    <div class="container">
        <h3>Update Supplier Profile</h3>
        <button class="back" onclick="window.location.href='viewsuppliers.php'">Back to Supplier List</button>

        <form action="updat_supplier.php?id=<?php echo $supplier_id; ?>" method="POST">
            <div class="form-group">
                <label for="supplier-name">Supplier Name</label>
                <input type="text" id="supplier-name" name="supplier_name" value="<?php echo htmlspecialchars($row['supplier_name']); ?>" required>

                <label for="company">Company</label>
                <input type="text" id="company" name="company" value="<?php echo htmlspecialchars($row['company']); ?>" required>

                <label for="contact-no">Contact Number</label>
                <input type="tel" id="contact-no" name="contact_no" value="<?php echo htmlspecialchars($row['contact_no']); ?>" required>

                <label for="user-email">User Email</label>
                <input type="email" id="user-email" name="user_email" value="<?php echo htmlspecialchars($row['email']); ?>" required>

                <label for="company-address">Company Address</label>
                <textarea id="company-address" name="company_address" required><?php echo htmlspecialchars($row['company_address']); ?></textarea>

                <label for="item-names">Items Supplied</label>
                <textarea id="item-names" name="item_names" required><?php echo htmlspecialchars($row['item_names']); ?></textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-update" name="action" value="update">Update Supplier</button>
            </div>
        </form>
    </div>
</body>
</html>
