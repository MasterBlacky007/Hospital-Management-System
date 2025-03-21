<?php
// Include database configuration file
include "conf.php";

// Fetch drug stock data
$sql = "SELECT * FROM drug_stock";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drug Stock View</title>
    <link rel="stylesheet" href="longtable.css">
    <script>
        // JavaScript to filter table rows based on search input
        function searchTable() {
            const input = document.getElementById("search");
            const filter = input.value.toLowerCase();
            const table = document.getElementById("drugStockTable");
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
    <h3>Drug Stock Details</h3>

    <!-- Expired Drugs Button -->
    <a href="expired_drugs.php" class="back">View Expired Drugs</a>

    <!-- Back Button -->
    <a href="drugstock.php" class="back">Back</a>

    <!-- Search Bar -->
    <input type="text" id="search" onkeyup="searchTable()" placeholder="Search by drug name or category">

    <!-- Table to display drug stock details -->
    <table id="drugStockTable">
        <thead>
            <tr>
                <th>Drug Name</th>
                <th>Category</th>
                <th>Dosage Form</th>
                <th>Dosage</th>
                <th>Quantity</th>
                <th>Stock Date</th>
                <th>Expiry Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['drug_name']); ?></td>
                        <td><?= htmlspecialchars($row['category']); ?></td>
                        <td><?= htmlspecialchars($row['dosage_form']); ?></td>
                        <td><?= htmlspecialchars($row['dosage']); ?></td>
                        <td><?= htmlspecialchars($row['quantity']); ?></td>
                        <td><?= htmlspecialchars($row['stock_date']); ?></td>
                        <td><?= htmlspecialchars($row['expiry_date']); ?></td>
                        <td>
                            <a href="update_dstock.php?id=<?= $row['stock_id']; ?>" class="view-button">Update</a>
                        </td>
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
