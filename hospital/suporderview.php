<?php
// database connection
include "conf.php";

// Assuming supplier is logged in (set `supplier_id` via session upon login)
$supplier_id = 1; // Replace with logic to fetch logged-in supplier's ID

// Fetch orders for the logged-in supplier
$sql = "SELECT id, product_name, quantity, order_date, status FROM orders WHERE supplier_id = ?";
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
    <script>
        // Function to print the printable content
        function printDiv() {
            const printContents = document.getElementById('printable-content').innerHTML;
            const originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents; // Show only the printable content
            window.print();
            document.body.innerHTML = originalContents; // Restore original content
        }

        // Function to display order details in a modal
        function viewOrder(order_id) {
            fetch('get_order_details.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ order_id: order_id })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const modal = document.getElementById('orderModal');
                    const modalContent = document.getElementById('modalContent');
                    modalContent.innerHTML = `
                        <h2>Order Details</h2>
                        <p><strong>Order ID:</strong> ${data.order.id}</p>
                        <p><strong>Product Name:</strong> ${data.order.product_name}</p>
                        <p><strong>Quantity:</strong> ${data.order.quantity}</p>
                        <p><strong>Order Date:</strong> ${data.order.order_date}</p>
                        <p><strong>Status:</strong> ${data.order.status}</p>
                        <button onclick="closeModal()">Close</button>
                        <button onclick="printOrder()">Print</button>
                    `;
                    modal.style.display = 'block';
                } else {
                    alert('Failed to fetch order details.');
                }
            })
            .catch(error => {
                console.error('Error fetching order details:', error);
                alert('An error occurred.');
            });
        }

        // Function to print the modal content
        function printOrder() {
            const printContent = document.getElementById('modalContent').innerHTML;
            const printWindow = window.open('', '_blank', 'width=800,height=600');
            printWindow.document.open();
            printWindow.document.write(`
                <html>
                    <head>
                        <title>Print Order</title>
                        <style>
                            body { font-family: Arial, sans-serif; margin: 20px; }
                            h2 { text-align: center; }
                        </style>
                    </head>
                    <body>${printContent}</body>
                </html>
            `);
            printWindow.document.close();
            printWindow.print();
            printWindow.close(); // Automatically close the print window after printing
        }

        // Function to close the modal
        function closeModal() {
            document.getElementById('orderModal').style.display = 'none';
        }

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
                    alert("Order status updated to " + status);
                    location.reload();
                } else {
                    alert("Failed to update order status.");
                }
            })
            .catch(error => {
                console.error('Error updating order status:', error);
                alert('An error occurred.');
            });
        }
    </script>
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
            <a href="manageorder.php">New Orders</a>
            <a href="suporderview.php" class="active">View Orders</a>
            <a href="supplogin.php">Log Out</a>
        </div>
      
        <div class="main">
        <div class="header">Supplier Orders</div>
           
            <table border="1">
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
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                            <td><?php echo htmlspecialchars($row['order_date']); ?></td>
                            <td><?php echo htmlspecialchars($row['status']); ?></td>
                            <td>
                                <?php if ($row['status'] == 'pending'): ?>
                                    <button onclick="updateOrderStatus(<?php echo $row['id']; ?>, 'Give')">Give</button>
                                    <button onclick="updateOrderStatus(<?php echo $row['id']; ?>, 'Reject')">Reject</button>
                                    <button onclick="updateOrderStatus(<?php echo $row['id']; ?>, 'Accept')">Accept</button>
                                <?php else: ?>
                                    <span>Action Taken</span>
                                <?php endif; ?>
                                <button onclick="viewOrder(<?php echo $row['id']; ?>)">View</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            
        </div>
    </div>

    <!-- Modal for displaying order details -->
    <div id="orderModal" style="display:none; position:fixed; top:10%; left:10%; background:#fff; border:1px solid #ccc; padding:20px; width:80%; height:70%; overflow:auto;">
        <div id="modalContent"></div>
    </div>
</body>
</html>
