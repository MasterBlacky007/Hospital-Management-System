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
    <title>View Drug Orders</title>
    <link rel="stylesheet" href="longtable.css">
    <script>
        function declineOrder(orderId) {
            // Ask for decline reason using a prompt
            let declineReason = prompt("Please enter the decline reason:");

            if (declineReason) {
                // Create a form and submit it with the order ID and decline reason
                let form = document.createElement('form');
                form.method = 'POST';
                form.action = 'update_drugorder.php';

                let inputId = document.createElement('input');
                inputId.type = 'hidden';
                inputId.name = 'id';
                inputId.value = orderId;

                let inputReason = document.createElement('input');
                inputReason.type = 'hidden';
                inputReason.name = 'decline_reason';
                inputReason.value = declineReason;

                let inputAction = document.createElement('input');
                inputAction.type = 'hidden';
                inputAction.name = 'action';
                inputAction.value = 'decline';

                form.appendChild(inputId);
                form.appendChild(inputReason);
                form.appendChild(inputAction);

                document.body.appendChild(form);
                form.submit();
            } else {
                alert("Decline reason is required.");
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Drug Orders</h2>

        <button class="back" onclick="window.location.href='orders.php'">Back</button>
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
                    <th>Actions</th>
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
                        <td>
                            <?php if ($row['status'] === 'Pending') { ?>
                                <form method="POST" action="update_drugorder.php" style="display: inline-block;">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" class="accept" name="action" value="approve">Approve</button>
                                </form>
                                <button type="submit" class="reject" onclick="declineOrder(<?php echo $row['id']; ?>)">Decline</button>
                            <?php } else { ?>
                                <em>Completed</em>
                            <?php } ?>
                        </td>
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
