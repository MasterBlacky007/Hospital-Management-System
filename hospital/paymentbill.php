<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Bills</title>
    <link rel="stylesheet" href="longtable.css"> 
</head>
<body>
    <div class="main-content">
        <header>
            <h2>Bill Details</h2>
        </header>

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
                b.billID ASC
        ";

        $result = mysqli_query($conn, $query);

        // Initialize variables
        $currentBillID = null;
        ?>

        <!-- Check if there are results -->
        <?php if (mysqli_num_rows($result) > 0): ?>
            <table class="transactions">
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
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <?php if ($row['BillID'] !== $currentBillID): ?>
                            <!-- New bill row -->
                            <tr>
                                <td rowspan="<?php echo mysqli_num_rows(mysqli_query($conn, "SELECT * FROM bill_items WHERE billID = " . $row['BillID'])); ?>">
                                    <?php echo $row['BillID']; ?>
                                </td>
                                <td rowspan="<?php echo mysqli_num_rows(mysqli_query($conn, "SELECT * FROM bill_items WHERE billID = " . $row['BillID'])); ?>">
                                    <?php echo $row['PatientID']; ?>
                                </td>
                                <td rowspan="<?php echo mysqli_num_rows(mysqli_query($conn, "SELECT * FROM bill_items WHERE billID = " . $row['BillID'])); ?>">
                                    <?php echo $row['firstName']; ?>
                                </td>
                                <td rowspan="<?php echo mysqli_num_rows(mysqli_query($conn, "SELECT * FROM bill_items WHERE billID = " . $row['BillID'])); ?>">
                                    <?php echo $row['lastName']; ?>
                                </td>
                                <td rowspan="<?php echo mysqli_num_rows(mysqli_query($conn, "SELECT * FROM bill_items WHERE billID = " . $row['BillID'])); ?>">
                                    <?php echo $row['Address']; ?>
                                </td>
                                <td rowspan="<?php echo mysqli_num_rows(mysqli_query($conn, "SELECT * FROM bill_items WHERE billID = " . $row['BillID'])); ?>">
                                    <?php echo $row['BillDate']; ?>
                                </td>
                                <td rowspan="<?php echo mysqli_num_rows(mysqli_query($conn, "SELECT * FROM bill_items WHERE billID = " . $row['BillID'])); ?>">
                                    <?php echo $row['GrandTotal']; ?>
                                </td>
                                <td rowspan="<?php echo mysqli_num_rows(mysqli_query($conn, "SELECT * FROM bill_items WHERE billID = " . $row['BillID'])); ?>">
                                    <?php echo $row['PaidAmount']; ?>
                                </td>
                                <td rowspan="<?php echo mysqli_num_rows(mysqli_query($conn, "SELECT * FROM bill_items WHERE billID = " . $row['BillID'])); ?>">
                                    <?php echo $row['DueAmount']; ?>
                                </td>
                                <td rowspan="<?php echo mysqli_num_rows(mysqli_query($conn, "SELECT * FROM bill_items WHERE billID = " . $row['BillID'])); ?>">
                                    <?php echo $row['Balance']; ?>
                                </td>
                        <?php $currentBillID = $row['BillID']; ?>
                        <?php endif; ?>
                        <!-- Item row -->
                        <td><?php echo $row['AccountName']; ?></td>
                        <td><?php echo $row['Description']; ?></td>
                        <td><?php echo $row['Quantity']; ?></td>
                        <td><?php echo $row['Price']; ?></td>
                        <td><?php echo $row['Subtotal']; ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No bills found.</p>
        <?php endif; ?>

        <!-- Close the database connection -->
        <?php mysqli_close($conn); ?>
    </div>
</body>
</html>
