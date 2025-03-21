<?php
// Include database configuration file
include "conf.php";

// Fetch drug orders data
$sql = "SELECT * FROM drug_orders";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drug Orders View</title>
    <link rel="stylesheet" href="longtable.css">
    <script>
        
        function searchTable() {
            const input = document.getElementById("search");
            const filter = input.value.toLowerCase();
            const table = document.getElementById("drugOrdersTable");
            const rows = table.getElementsByTagName("tr");

            for (let i = 1; i < rows.length; i++) {
                const cells = rows[i].getElementsByTagName("td");
                let match = false;
                for (let j = 0; j < cells.length; j++) {
                    if (cells[j].innerText.toLowerCase().includes(filter)) {
                        match = true;
                        break;
                    }
                }
                rows[i].style.display = match ? "" : "none";
            }
        }
    </script>
</head>
<body>
<div class="container">
    <h3>Drug Orders</h3>

    <!-- Back Button -->
    <a href="phdrugorderdash.php" class="back">Back to Dashboard</a>

    <!-- Search Bar -->
    <input type="text" id="search" onkeyup="searchTable()" placeholder="Search by drug name or category">

    <!-- Table to display drug orders -->
    <table id="drugOrdersTable">
        <thead>
            <tr>
                <th>Drug Name</th>
                <th>Category</th>
                <th>Quantity</th>
                <th>Dosage Form</th>
                <th>Urgency</th>
                <th>Request Date</th>
                <th>Notes</th>
                <th>Status</th>
                <th>Decline Reason</th>
                
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['drug_name']); ?></td>
                        <td><?= htmlspecialchars($row['category']); ?></td>
                        <td><?= htmlspecialchars($row['quantity']); ?></td>
                        <td><?= htmlspecialchars($row['dosage_form']); ?></td>
                        <td><?= htmlspecialchars($row['urgency']); ?></td>
                        <td><?= htmlspecialchars($row['request_date']); ?></td>
                        <td><?= htmlspecialchars($row['notes']); ?></td>
                        <td><?= htmlspecialchars($row['status']); ?></td>
                        <td><?= htmlspecialchars($row['decline_reason']); ?></td>
                        
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="10">No records found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
