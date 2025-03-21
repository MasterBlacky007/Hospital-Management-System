<?php
// Database connection settings
include "conf.php";

// SQL query to fetch payment data
$sql = "SELECT payment_id, billID, patientID, paymentType, amount, paymentDate, created_at, updated_at FROM payments";
$result = $conn->query($sql);

// Calculate totals
$totalAmount = 0;
$totalTransactions = 0;

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $totalAmount += $row['amount'];
        $totalTransactions++;
        $data[] = $row;
    }
} else {
    $data = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Payments - Mount Apollo Hospital</title>
    <link rel="stylesheet" href="longtable.css">
</head>
<body>
    <h1>Online Payment Information</h1>

    <button class="back" onclick="window.history.back()">Back</button>
    <input type="text" id="search" placeholder="Search by any field...">
    
    <p>Total Transactions: <?php echo $totalTransactions; ?></p>
    <p>Total Amount Received: <?php echo number_format($totalAmount, 2); ?></p>

    <table id="paymentTable">
        <thead>
            <tr>
                <th>Payment ID</th>
                <th>Bill ID</th>
                <th>Patient ID</th>
                <th>Payment Type</th>
                <th>Amount</th>
                <th>Payment Date</th>
                <th>Created At</th>
                <th>Updated At</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($data)): ?>
                <?php foreach ($data as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row["payment_id"]); ?></td>
                        <td><?php echo htmlspecialchars($row["billID"]); ?></td>
                        <td><?php echo htmlspecialchars($row["patientID"]); ?></td>
                        <td><?php echo htmlspecialchars($row["paymentType"]); ?></td>
                        <td><?php echo htmlspecialchars($row["amount"]); ?></td>
                        <td><?php echo htmlspecialchars($row["paymentDate"]); ?></td>
                        <td><?php echo htmlspecialchars($row["created_at"]); ?></td>
                        <td><?php echo htmlspecialchars($row["updated_at"]); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="8">No payments found</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <script>
        document.getElementById('search').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#paymentTable tbody tr');

            rows.forEach(row => {
                let match = false;
                const cells = row.querySelectorAll('td');
                cells.forEach(cell => {
                    if (cell.textContent.toLowerCase().includes(searchTerm)) {
                        match = true;
                    }
                });

                row.style.display = match ? '' : 'none';
            });
        });
    </script>
</body>
</html>
