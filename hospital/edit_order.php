<?php
// Include the database connection file
include "conf.php";

// Check if the order ID is provided
if (isset($_GET['order_id'])) {
    $order_id = intval($_GET['order_id']); // Sanitize the order ID

    // Fetch the order details
    $sql = "SELECT o.*, s.supplier_name FROM orders o 
            JOIN suppliers s ON o.supplier_id = s.supplier_id 
            WHERE o.order_id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $order_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $order = mysqli_fetch_assoc($result);

        if (!$order) {
            echo "<script>
                alert('Order not found!');
                window.location.href = 'viewsuporder.php';
            </script>";
            exit;
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "<script>
            alert('Error fetching order details: " . mysqli_error($conn) . "');
            window.location.href = 'viewsuporder.php';
        </script>";
        exit;
    }
} else {
    echo "<script>
        alert('Invalid order ID!');
        window.location.href = 'viewsuporder.php';
    </script>";
    exit;
}

// Handle form submission to update the order
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $supplier_id = intval($_POST['supplier_id']);
    $item_name = $_POST['item_name'];
    $quantity = intval($_POST['quantity']);
    $order_date = $_POST['order_date'];
    

    // Update the order in the database
    $update_sql = "UPDATE orders 
                   SET supplier_id = ?, item_name = ?, quantity = ?, order_date = ? 
                   WHERE order_id = ?";
    $update_stmt = mysqli_prepare($conn, $update_sql);

    if ($update_stmt) {
        mysqli_stmt_bind_param($update_stmt, "isisi", $supplier_id, $item_name, $quantity, $order_date,$order_id);
        if (mysqli_stmt_execute($update_stmt)) {
            echo "<script>
                alert('Order updated successfully!');
                window.location.href = 'viewsuporder.php';
            </script>";
        } else {
            echo "<script>
                alert('Error updating order: " . mysqli_error($conn) . "');
            </script>";
        }

        mysqli_stmt_close($update_stmt);
    } else {
        echo "<script>
            alert('Error preparing update query: " . mysqli_error($conn) . "');
        </script>";
    }
}

// Fetch suppliers for the dropdown
$sql_suppliers = "SELECT supplier_id, supplier_name FROM suppliers";
$result_suppliers = mysqli_query($conn, $sql_suppliers);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Order</title>
    <link rel="stylesheet" href="sup.css">
</head>
<body>
<div class="form-container">
    <h2>Edit Order</h2>
    <form method="POST" action="">
        <div class="form-group">
            <label for="supplier_id">Supplier:</label>
            <select name="supplier_id" id="supplier_id" required>
                <option value="">-- Select Supplier --</option>
                <?php
                if ($result_suppliers && mysqli_num_rows($result_suppliers) > 0) {
                    while ($supplier = mysqli_fetch_assoc($result_suppliers)) {
                        $selected = ($supplier['supplier_id'] == $order['supplier_id']) ? 'selected' : '';
                        echo "<option value='{$supplier['supplier_id']}' $selected>{$supplier['supplier_name']}</option>";
                    }
                } else {
                    echo "<option value=''>No suppliers available</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="item_name">Item Name:</label>
            <input type="text" name="item_name" id="item_name" value="<?php echo htmlspecialchars($order['item_name']); ?>" required>
        </div>

        <div class="form-group">
            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" id="quantity" value="<?php echo $order['quantity']; ?>" required>
        </div>

        <div class="form-group">
            <label for="order_date">Order Date:</label>
            <input type="date" name="order_date" id="order_date" value="<?php echo $order['order_date']; ?>" required>
        </div>


        <button type="submit">Update Order</button>
        <button type="button" onclick="window.location.href='viewsuporder.php';">Cancel</button>
    </form>
</div>
</body>
</html>
