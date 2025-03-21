<?php
// Start session to manage login state
session_start();
include "conf.php";

// Check if the patient is logged in
if (!isset($_SESSION['contact_number'])) {
    header("Location: plogin.html");
    exit();
}

// Retrieve the logged-in patient's contact number
$contact_number = $_SESSION['contact_number'];

// Fetch bills for the logged-in patient
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
        b.balance AS Balance
    FROM 
        bills b
    WHERE 
        b.contact = ?
    ORDER BY 
        b.date DESC, b.billID ASC
";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $contact_number);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Bills</title>
    <link rel="stylesheet" href="longtables.css"> <!-- Link to your CSS file -->
</head>
<body>
    <div class="main-content">
        <header>
            <h2>My Bills</h2>
            <button class="back" onclick="window.location.href='patientdash.html'">Back</button>
        </header>

        <!-- Check if there are results -->
        <?php if ($result->num_rows > 0): ?>
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
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Loop through the result set -->
                    <?php while ($row = $result->fetch_assoc()): ?>
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
                            <td>
                                <form action="viewp_bill.php" method="GET" style="display:inline;">
                                    <input type="hidden" name="billID" value="<?php echo $row['BillID']; ?>">
                                    <button type="submit">View</button>
                                </form>
                                <form action="pay.php" method="GET" style="display:inline;">
                                    <input type="hidden" name="billID" value="<?php echo $row['BillID']; ?>">
                                    <button type="submit">Pay</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No bills found.</p>
        <?php endif; ?>

        <!-- Close the database connection -->
        <?php
        $stmt->close();
        $conn->close();
        ?>
    </div>
</body>
</html>
