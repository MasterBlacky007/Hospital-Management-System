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
        
        <button class="back" onclick="window.location.href='cinvendash.php'">Back</button>
        
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
       
            document.getElementById('search').addEventListener('input', function () {
            const searchValue = this.value.toLowerCase();
            const rows = document.querySelectorAll('#stockdetails tbody tr');
            
            rows.forEach(row => {
                const rowText = row.textContent.toLowerCase();
                row.style.display = rowText.includes(searchValue) ? '' : 'none';
            });
        });
</script>
    </script>
</body>
</html>
