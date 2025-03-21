<?php
// Include the database connection file
include "conf.php";

// Fetch orders with the status column
$sql = "SELECT o.order_id, o.supplier_id, s.supplier_name, o.item_name, o.quantity, o.order_date, o.status 
        FROM orders o 
        JOIN suppliers s ON o.supplier_id = s.supplier_id";
$result = mysqli_query($conn, $sql);

// Check if the query was successful
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Orders</title>
    <link rel="stylesheet" href="longtable.css">
</head>
<body>
    <div class="container">
        <h3>Supplier Orders List</h3>
        
        <button class="back" onclick="window.location.href='suporder.php'">Back</button>
        
        <input type="text" id="search" placeholder="Search by any field...">
        
        <div class="main-content">
            <table id="orders">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Supplier Name</th>
                        <th>Item Name</th>
                        <th>Quantity</th>
                        <th>Order Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result && mysqli_num_rows($result) > 0) {
                        // Loop through and display record
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['order_id'] . "</td>";
                            echo "<td>" . $row['supplier_name'] . "</td>";
                            echo "<td>" . $row['item_name'] . "</td>";
                            echo "<td>" . $row['quantity'] . "</td>";
                            echo "<td>" . $row['order_date'] . "</td>";
                            echo "<td>" . $row['status'] . "</td>";
                            echo "<td>
                                    <a href='edit_order.php?order_id=" . $row['order_id'] . "'>Edit</a> | 
                                    <a href='deletesuporder.php?order_id=" . $row['order_id'] . "' onclick='return confirm(\"Are you sure you want to delete this order?\");'>Delete</a>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No orders available</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <script>
    document.getElementById('search').addEventListener('input', function () {
    const searchValue = this.value.toLowerCase();
    const rows = document.querySelectorAll('#orders tbody tr');
    
    rows.forEach(row => {
        const rowText = row.textContent.toLowerCase();
        row.style.display = rowText.includes(searchValue) ? '' : 'none';
    });
});
</script>
</body>
</html>
