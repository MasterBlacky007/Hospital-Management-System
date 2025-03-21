<?php
// Include database configuration file
include "conf.php";

// Fetch expired drug stock data
$sql = "SELECT * FROM drug_stock WHERE expiry_date < CURDATE()";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expired Drug Stock</title>
    <link rel="stylesheet" href="longtable.css">
</head>
<body>
<div class="container">
    <h3>Expired Drug Stock</h3>

    <!-- Back Button -->
    <a href="show.php" class="back">Back to Drug Stock</a>

    <!-- Table to display expired drug stock details -->
    <table id="expiredDrugStockTable">
        <thead>
            <tr>
                <th>Drug Name</th>
                <th>Category</th>
                <th>Dosage Form</th>
                <th>Dosage</th>
                <th>Quantity</th>
                <th>Stock Date</th>
                <th>Expiry Date</th>
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
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">No expired drugs found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
