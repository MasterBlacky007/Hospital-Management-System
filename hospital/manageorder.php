<?php
session_start();
include('conf.php'); // Replace with your database connection file

// Check if supplier is logged in
if (!isset($_SESSION['supplier_id'])) {
    header('Location: suplogin.php'); // Redirect to login page
    exit();
}

$supplier_id = $_SESSION['supplier_id'];

// Fetch orders for the logged-in supplier
$sql = "SELECT order_id, item_name, quantity, order_date, status FROM orders WHERE supplier_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $supplier_id);
$stmt->execute();
$result = $stmt->get_result();

// Check and display success or error messages
if (isset($_SESSION['success_message'])) {
    echo "<script>alert('" . $_SESSION['success_message'] . "');</script>";
    unset($_SESSION['success_message']);  // Clear message after displaying
}

if (isset($_SESSION['error_message'])) {
    echo "<script>alert('" . $_SESSION['error_message'] . "');</script>";
    unset($_SESSION['error_message']);  // Clear message after displaying
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>View Orders</title>
    <!-- Link to external CSS -->
    <link rel="stylesheet" type="text/css" href="longtable.css">
</head>
<body>
    <h1>Orders for Supplier</h1>

    <!-- Back Button -->
    <button class="back" onclick="window.location.href='supplierdashboard.php';">Back to Dashboard</button>

    <table border="1">
        <tr>
            <th>Order ID</th>
            <th>Item Name</th>
            <th>Quantity</th>
            <th>Order Date</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['order_id']; ?></td>
                <td><?php echo $row['item_name']; ?></td>
                <td><?php echo $row['quantity']; ?></td>
                <td><?php echo $row['order_date']; ?></td>
                <td><?php echo $row['status']; ?></td>
                <td>
                    <?php if ($row['status'] == 'Pending') { ?>
                        <form method="post" action="update_order.php" style="display:inline;">
                            <input type="hidden" name="order_id" value="<?php echo $row['order_id']; ?>">
                            <button type="submit" name="action" value="Accept">Accept</button>
                            <button type="submit" name="action" value="Reject">Reject</button>
                        </form>
                    <?php } else {
                        echo $row['status'];
                    } ?>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
