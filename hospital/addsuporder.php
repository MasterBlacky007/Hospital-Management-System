<?php
include 'conf.php';

// Fetch suppliers data
$query_suppliers = "SELECT supplier_id, supplier_name FROM suppliers";
$result_suppliers = mysqli_query($conn, $query_suppliers);
if (!$result_suppliers) {
    die("Query failed: " . mysqli_error($conn));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $supplier_id = $_POST['supplier_id'];
    $item_name = $_POST['item_name'];
    $quantity = $_POST['quantity'];
    $order_date = $_POST['order_date'];
    $status = 'Pending'; // Default status for new orders

    $insert_order_query = "INSERT INTO orders (supplier_id, item_name, quantity, order_date, status) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $insert_order_query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'isiss', $supplier_id, $item_name, $quantity, $order_date, $status);
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Order placed successfully!'); window.location.href = 'viewsuporder.php';</script>";
        } else {
            echo "<script>alert('Error placing order: " . mysqli_stmt_error($stmt) . "');</script>";
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "<script>alert('Failed to prepare statement: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Place Order for Supplier</title>
    <link rel="stylesheet" href="sup.css">
</head>
<body>

<div class="form-container">
    <h2>Place Order for Supplier</h2>
    <form method="POST" action="">
        <div class="form-group">
            <label for="supplier_id">Select Supplier:</label>
            <select name="supplier_id" id="supplier_id" required>
                <option value="">-- Select Supplier --</option>
                <?php
                if ($result_suppliers && mysqli_num_rows($result_suppliers) > 0) {
                    while ($row = mysqli_fetch_assoc($result_suppliers)) {
                        echo "<option value='" . $row['supplier_id'] . "'>" . $row['supplier_name'] . "</option>";
                    }
                } else {
                    echo "<option value=''>No suppliers available</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="item_name">Item Name:</label>
            <input type="text" name="item_name" id="item_name" required>
        </div>

        <div class="form-group">
            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" id="quantity" required>
        </div>

        <div class="form-group">
            <label for="order_date">Order Date:</label>
            <input type="date" name="order_date" id="order_date" value="<?php echo date('Y-m-d'); ?>" required>
        </div>

        <button type="submit">Place Order</button>
        <button class="back" onclick="window.location.href='suporder.php'">Back</button>
    </form>
</div>

</body>
</html>
