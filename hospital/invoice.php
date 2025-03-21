<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Bills - Mount Apollo Hospital</title>
    <link rel="stylesheet" href="longtable.css"> <!-- Link to your CSS file -->
</head>
<body>
    <!-- Main Content -->
    <div class="main-content">
        <header>
            <h2>Bill Details</h2>
        </header>

        <button class="back" onclick="window.location.href='cashierdash.php'">Back</button>
        <input type="text" id="search" placeholder="Search by any field...">

        <!-- PHP for fetching data -->
        <?php
        // Include database connection
        include('conf.php');

        // Fetch all bills with their items
        $query = "
            SELECT 
                b.billID AS BillID,
                b.patientid AS PatientID,
                b.firstName AS firstName,
                b.lastName AS lastName,
                b.address AS Address,
                b.date AS BillDate,
                b.grandTotal AS GrandTotal,
                b.paidAmount AS PaidAmount,
                b.dueAmount AS DueAmount,
                b.balance AS Balance,
                bi.accountName AS AccountName,
                bi.description AS Description,
                bi.quantity AS Quantity,
                bi.price AS Price,
                bi.subtotal AS Subtotal
            FROM 
                bills b
            LEFT JOIN 
                bill_items bi
            ON 
                b.billID = bi.billID
            ORDER BY 
                b.date DESC, b.billID ASC
        ";

        $result = mysqli_query($conn, $query);

        // Fetch total counts and sums
        $totalQuery = "SELECT COUNT(DISTINCT billID) AS TotalBills, SUM(grandTotal) AS TotalReceived FROM bills";
        $totalResult = mysqli_query($conn, $totalQuery);
        $totalRow = mysqli_fetch_assoc($totalResult);
        
        $todayDate = date('Y-m-d');
        $todayQuery = "SELECT COUNT(DISTINCT billID) AS TodayBills FROM bills WHERE date = '$todayDate'";
        $todayResult = mysqli_query($conn, $todayQuery);
        $todayRow = mysqli_fetch_assoc($todayResult);
        ?>

        <div class="summary">
            <p>Total Bills: <?php echo $totalRow['TotalBills']; ?></p>
            <p>Total Amount Received: <?php echo number_format($totalRow['TotalReceived'], 2); ?></p>
            <p>Bills Generated Today: <?php echo $todayRow['TodayBills']; ?></p>
        </div>

        <table class="transactions" id="patientTable">
            <thead>
                <tr>
                    <th>Bill ID</th>
                    <th>Patient ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Address</th>
                    <th>Bill Date</th>
                    <th>Grand Total</th>
                    <th>Paid Amount</th>
                    <th>Due Amount</th>
                    <th>Balance</th>
                    <th>Account Name</th>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <!-- Loop through the result set -->
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo $row['BillID']; ?></td>
                            <td><?php echo $row['PatientID']; ?></td>
                            <td><?php echo $row['firstName']; ?></td>
                            <td><?php echo $row['lastName']; ?></td>
                            <td><?php echo $row['Address']; ?></td>
                            <td><?php echo $row['BillDate']; ?></td>
                            <td><?php echo $row['GrandTotal']; ?></td>
                            <td><?php echo $row['PaidAmount']; ?></td>
                            <td><?php echo $row['DueAmount']; ?></td>
                            <td><?php echo $row['Balance']; ?></td>
                            <td><?php echo $row['AccountName']; ?></td>
                            <td><?php echo $row['Description']; ?></td>
                            <td><?php echo $row['Quantity']; ?></td>
                            <td><?php echo $row['Price']; ?></td>
                            <td><?php echo $row['Subtotal']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan='15'>No bills found</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

        <?php mysqli_close($conn); ?>
    </div>

    <script>
        document.getElementById('search').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#patientTable tbody tr');

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
