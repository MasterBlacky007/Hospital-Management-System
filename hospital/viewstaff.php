<?php
// Include the database connection
include 'conf.php';

if (isset($_GET['id'])) {
    $stockId = mysqli_real_escape_string($conn, $_GET['id']);

    // Query to fetch stock details
    $query = "SELECT * FROM staff WHERE id = '$stockId'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $stock = mysqli_fetch_assoc($result);
    } else {
        echo "<script>alert('Stock record not found!'); window.location.href = 'view_staff.php';</script>";
    }
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Details</title>
    <link rel="stylesheet" href="formview.css">
</head>
<body>
    <div class="container">
        <h3>Stock Details</h3>
        <?php if (isset($stock)): ?>
            <p><strong>Staff ID:</strong> <?php echo $stock['id']; ?></p>
            <p><strong>Name:</strong> <?php echo $stock['name']; ?></p>
            <p><strong>NIC:</strong> <?php echo $stock['nic']; ?></p>
            <p><strong>Position:</strong> <?php echo $stock['role']; ?></p>
            <p><strong>Phone:</strong> <?php echo $stock['phone']; ?></p>
        <?php endif; ?>
        <a href="view_staff.php">Back to List</a>
    </div>
</body>
</html>
