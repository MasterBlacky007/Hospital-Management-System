<?php
// Include database connection
include('conf.php');

// Fetch all orders
$sql = "SELECT * FROM lab_supplies_request";
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
                    <th>Item Name</th>
                    <th>Category</th>
                    <th>Quantity</th>
                    <th>Urgency</th>
                    <th>Notes</th>
                    <th>Requested Date</th>
                    <th>Status</th>
                    <th>Decline Reason</th>
                    
                    
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['item_name']; ?></td>
                        <td><?php echo $row['category']; ?></td>
                        <td><?php echo $row['quantity']; ?></td>
                        <td><?php echo $row['urgency']; ?></td>
                        <td><?php echo $row['notes']; ?></td>
                        <td><?php echo $row['request_date']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                        <td><?php echo $row['decline_reason']; ?></td>
                       
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
