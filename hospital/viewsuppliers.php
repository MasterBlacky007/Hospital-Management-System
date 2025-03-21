<?php
// Include the database connection
include 'conf.php';

// Fetch the supplier data
$sql = "SELECT * FROM suppliers";
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
    <title>View Supplier Profiles</title>
    <link rel="stylesheet" href="longtable.css">
</head>
<body>
    <div class="container">
        <h3>Supplier Profiles</h3>
        <button class="add-patient" onclick="window.location.href='addsupplier.html'">+ Add Supplier</button>
        <button class="back" onclick="window.location.href='isupplierdash.php'">Back</button>
        
        <input type="text" id="search" placeholder="Search by any field...">
        
        <div class="main-content">
            <table id="supplierProfiles">
                <thead>
                    <tr>
                        <th>Supplier ID</th>
                        <th>Supplier Name</th>
                        <th>Company</th>
                        <th>Contact Number</th>
                        <th>Email</th>
                        <th>Company Address</th>
                        <th>Items Supplied</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result && mysqli_num_rows($result) > 0) {
                        // Loop through and display each record
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['supplier_id'] . "</td>";
                            echo "<td>" . $row['supplier_name'] . "</td>";
                            echo "<td>" . $row['company'] . "</td>";
                            echo "<td>" . $row['contact_no'] . "</td>";
                            echo "<td>" . $row['email'] . "</td>";
                            echo "<td>" . $row['company_address'] . "</td>";
                            echo "<td>" . $row['item_names'] . "</td>";
                            echo "<td>
                                    <a href='view_supplier.php?id=" . $row['supplier_id'] . "'>View</a> | 
                                    <a href='updat_supplier.php?id=" . $row['supplier_id'] . "'>Update</a> | 
                                    <a href='delete_supplier.php?id=" . $row['supplier_id'] . "' onclick='return confirm(\"Are you sure you want to delete this supplier?\");'>Delete</a>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>No suppliers found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
         document.getElementById('search').addEventListener('input', function () {
    const searchValue = this.value.toLowerCase();
    const rows = document.querySelectorAll('#supplierProfiles tbody tr');
    
    rows.forEach(row => {
        const rowText = row.textContent.toLowerCase();
        row.style.display = rowText.includes(searchValue) ? '' : 'none';
    });
});
    </script>
</body>
</html>
