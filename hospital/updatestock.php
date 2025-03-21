<?php
// Include database connection
include 'conf.php';

// Check if ID is provided in the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $stock_id = intval($_GET['id']);

    // Fetch the existing stock record
    $sql = "SELECT * FROM stock_details WHERE stock_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $stock_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        echo "<script>alert('Stock record not found!'); window.location.href = 'stocktable.php';</script>";
        exit;
    }

    // Update logic when the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $item_name = mysqli_real_escape_string($conn, $_POST['item_name']);
        $additional_quantity = intval($_POST['additional_quantity']); // Quantity to add
        $ex_date = mysqli_real_escape_string($conn, $_POST['ex_date']);
        $department = mysqli_real_escape_string($conn, $_POST['department']);

        // Calculate new quantity
        $new_quantity = $row['quantity'] + $additional_quantity;

        // Update query
        $update_sql = "UPDATE stock_details 
                       SET item_name = ?, quantity = ?, ex_date = ?, department = ? 
                       WHERE stock_id = ?";
        $update_stmt = mysqli_prepare($conn, $update_sql);
        mysqli_stmt_bind_param($update_stmt, "sissi", $item_name, $new_quantity, $ex_date, $department, $stock_id);

        if (mysqli_stmt_execute($update_stmt)) {
            echo "<script>alert('Stock updated successfully!'); window.location.href = 'stocktable.php';</script>";
        } else {
            echo "<script>alert('Error updating stock: " . mysqli_error($conn) . "');</script>";
        }
    }
} else {
    echo "<script>alert('Invalid Stock ID!'); window.location.href = 'stocktable.php';</script>";
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
    <title>Update Stock</title>
    <link rel="stylesheet" href="viewupdate.css">
</head>
<body>
    <div class="container">
        <h3>Update Stock Details</h3>
        <button class="back" onclick="window.location.href='stocktable.php'">Back to List</button>

        <div class="main-content">
            <form action="updatestock.php?id=<?php echo $stock_id; ?>" method="POST">
                <input type="hidden" name="action" value="update">

                <label for="item_name">Item Name</label>
                <input type="text" id="item_name" name="item_name" value="<?php echo $row['item_name']; ?>" required>

                <label for="additional_quantity">Additional Quantity</label>
                <input type="number" id="additional_quantity" name="additional_quantity" placeholder="Enter quantity to add">


                <label for="ex_date">Expiry Date</label>
                <input type="date" id="ex_date" name="ex_date" value="<?php echo $row['ex_date']; ?>" required>

                <label for="department">Department</label>
                <input type="text" id="department" name="department" value="<?php echo $row['department']; ?>" required>

                <div class="form-actions">
                    <button type="submit" class="btn btn-update" name="action" value="update">Update</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
