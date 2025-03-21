<?php

include "conf.php";

// Fetch lab supplies request data
$sql = "SELECT * FROM lab_supplies_request";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab Supplies Requests</title>
    <link rel="stylesheet" href="longtable.css">
    <script>
        // JavaScript to filter table rows based on search input
        function searchTable() {
            const input = document.getElementById("search");
            const filter = input.value.toLowerCase();
            const table = document.getElementById("labSuppliesTable");
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
    <h3>Lab Supplies Requests</h3>

    
    <a href="labsuprdash.php" class="back">Back to Dashboard</a>

    
    <input type="text" id="search" onkeyup="searchTable()" placeholder="Search by item name or category">


    <table id="labSuppliesTable">
        <thead>
            <tr>
                <th>Item Name</th>
                <th>Category</th>
                <th>Quantity</th>
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
                        <td><?= htmlspecialchars($row['item_name']); ?></td>
                        <td><?= htmlspecialchars($row['category']); ?></td>
                        <td><?= htmlspecialchars($row['quantity']); ?></td>
                        <td><?= htmlspecialchars($row['urgency']); ?></td>
                        <td><?= htmlspecialchars($row['request_date']); ?></td>
                        <td><?= htmlspecialchars($row['notes']); ?></td>
                        <td><?= htmlspecialchars($row['status']); ?></td>
                        <td><?= htmlspecialchars($row['decline_reason']); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8">No records found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
