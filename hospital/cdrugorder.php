<?php
// Include database connection
include('conf.php');

// Fetch all orders
$sql = "SELECT * FROM drug_orders";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Lab Supply Orders</title>
    <link rel="stylesheet" href="longtable.css">
    
</head>
<body>
    <div class="container">
        <h2>Lab Supply Orders</h2>

        <button class="back" onclick="window.location.href='cinvendash.php'">Back</button>
        
        <table border="1">
            <thead>
                <tr>
                    <th>Drug Name</th>
                    <th>Category</th>
                    <th>Quantity</th>
                    <th>Dosage Form</th>
                    <th>Urgency</th>
                    <th>Requested Date</th>
                    <th>Notes</th>
                    <th>Status</th>
                    <th>Decline Reason</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['drug_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['category']); ?></td>
                        <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                        <td><?php echo htmlspecialchars($row['dosage_form']); ?></td>
                        <td><?php echo htmlspecialchars($row['urgency']); ?></td>
                        <td><?php echo htmlspecialchars($row['request_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['notes']); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                        <td><?php echo htmlspecialchars($row['decline_reason']); ?></td>
                        
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
