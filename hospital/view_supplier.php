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
        echo "Supplier not found!";
        exit;
    }
} else {
    echo "No supplier ID provided!";
    exit;
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Supplier Profile</title>
    <link rel="stylesheet" href="formview.css">
    <style>

a {
    display: inline-block;
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    font-size: 1em;
    text-align: center;
    margin-top: 20px;
}

a:hover {
    background-color: #0056b3;
}
        </style>
</head>
<body>
    <div class="container">
        <h3>Supplier Profile</h3>
        
        <div class="supplier-details">
            <p><strong>Supplier ID:</strong> <?php echo $row['supplier_id']; ?></p>
            <p><strong>Supplier Name:</strong> <?php echo $row['supplier_name']; ?></p>
            <p><strong>Company:</strong> <?php echo $row['company']; ?></p>
            <p><strong>Contact Number:</strong> <?php echo $row['contact_no']; ?></p>
            <p><strong>Email:</strong> <?php echo $row['email']; ?></p>
            <p><strong>Company Address:</strong> <?php echo $row['company_address']; ?></p>
            <p><strong>Items Supplied:</strong> <?php echo $row['item_names']; ?></p>
        </div>

        <a href="viewsuppliers.php">Back to List</a>
    </div>
</body>
</html>
