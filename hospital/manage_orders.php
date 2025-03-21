<?php
// database connection
include "conf.php";
// Assuming supplier is logged in (set `supplier_id` via session upon login)
$supplier_id = 1; // Replace with logic to fetch logged-in supplier's ID

// Fetch orders for the logged-in supplier
$sql = "SELECT order_id, item_name, quantity, order_date, status FROM orders WHERE supplier_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $supplier_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier Orders</title>
    <link rel="stylesheet" href="lreq.css"> 
</head>
<body>
    <div class="dashboard">
        <div class="sidebar">
            <div class="logo">
                <img src="logo.jpeg" alt="Hospital Logo">
                <h2>Apollo Hospital</h2>
            </div>
            <h1>Supplier</h1>
            <a href="supplierdashboard.php">Dashboard</a>
            <a href="supprofile.php">My Profile</a>
            <a href="manageorder.php" class="active">New Orders</a>
            <a href="suporderview.php">View Orders</a>
            <a href="supplogin.php">Log Out</a>
        </div>

        <div class="main">
            <div class="header">Supplier Orders</div>
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Order Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['order_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['item_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                            <td><?php echo htmlspecialchars($row['order_date']); ?></td>
                            <td><?php echo htmlspecialchars($row['status']); ?></td>
                            <td>
                                <?php if ($row['status'] == 'pending'): ?>
                                    <!-- Update the status buttons -->
                                    <button onclick="updateOrderStatus(<?php echo $row['order_id']; ?>, 'Give')">Give</button>
                                    <button onclick="updateOrderStatus(<?php echo $row['order_id']; ?>, 'Reject')">Reject</button>
                                    <button onclick="updateOrderStatus(<?php echo $row['order_id']; ?>, 'Accept')">Accept</button>
                                <?php else: ?>
                                    <span>Action Taken</span>
                                <?php endif; ?>
                                <button class="delete-btn" onclick="deleteOrder(<?php echo $row['order_id']; ?>)">Delete</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Update order status
        function updateOrderStatus(order_id, status) {
            const data = {
                order_id: order_id,
                status: status
            };

            fetch('update_order.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Order " + status);
                    location.reload();
                } else {
                    alert("Failed to update order.");
                }
            })
            .catch(error => {
                console.error("Error updating order status:", error);
                alert("An error occurred while updating the order status.");
            });
        }

        // Delete order
        function deleteOrder(order_id) {
            if (confirm("Are you sure you want to delete this order?")) {
                const data = {
                    order_id: order_id
                };

                fetch('delete_order.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("Order deleted.");
                        location.reload();
                    } else {
                        alert("Failed to delete order.");
                    }
                })
                .catch(error => {
                    console.error("Error deleting order:", error);
                    alert("An error occurred while deleting the order.");
                });
            }
        }
    </script>
</body>
</html>
