<?php
// Include the database connection
include 'conf.php';

// Query to fetch all stock details
$sql = "SELECT * FROM stock_details";
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
    <title>View Stock Details</title>
    <link rel="stylesheet" href="longtables.css">
</head>
<body>
    <div class="container">
        <h3>Stock Details List</h3>
        <button class="add-patient" onclick="window.location.href='addstock.html'">+ Add Stock</button>
        <button class="back" onclick="window.location.href='stockdash.php'">Back</button>
        
        <input type="text" id="search" placeholder="Search by any field...">
        
        <div class="main-content">
            <table id="stockdetails">
                <thead>
                    <tr>
                        <th>Stock ID</th>
                        <th>Item Name</th>
                        <th>Quantity</th>
                        <th>Expiration Date</th>
                        <th>Department</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result && mysqli_num_rows($result) > 0) {
                        // Loop through and display each stock record
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['stock_id'] . "</td>";
                            echo "<td>" . $row['item_name'] . "</td>";
                            echo "<td>" . $row['quantity'] . "</td>";
                            echo "<td>" . $row['ex_date'] . "</td>";
                            echo "<td>" . $row['department'] . "</td>";
                            echo "<td>
                                    <a href='view_stock.php?id=" . $row['stock_id'] . "'onclick=\viewStock('".$row['stock_id']."')\">View</a> | 
                                    <a href='updatestock.php?id=" . $row['stock_id'] . "'>Update</a> | 
                                    <a href='delete_stock.php?id=" . $row['stock_id'] . "' onclick='return confirm(\"Are you sure you want to delete this stock record?\");'>Delete</a>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No stock records available</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('search');
    const tableRows = document.querySelectorAll('#stockdetails tbody tr');

    // Search functionality
    searchInput.addEventListener('input', () => {
        const filter = searchInput.value.toLowerCase();
        tableRows.forEach(row => {
            const rowText = row.textContent.toLowerCase();
            if (rowText.includes(filter)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
});

    </script>
</body>
</html>
