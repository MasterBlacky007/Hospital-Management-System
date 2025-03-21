<?php
// Include the database connection
include 'conf.php';

if (isset($_GET['id'])) {
    $stockId = mysqli_real_escape_string($conn, $_GET['id']);

    // Query to fetch stock details
    $query = "SELECT * FROM stock_details WHERE stock_id = '$stockId'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $stock = mysqli_fetch_assoc($result);
    } else {
        echo "<script>alert('Stock record not found!'); window.location.href = 'stocktable.php';</script>";
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
            <p><strong>Stock ID:</strong> <?php echo $stock['stock_id']; ?></p>
            <p><strong>Item Name:</strong> <?php echo $stock['item_name']; ?></p>
            <p><strong>Quantity:</strong> <?php echo $stock['quantity']; ?></p>
            <p><strong>Expiration Date:</strong> <?php echo $stock['ex_date']; ?></p>
            <p><strong>Department:</strong> <?php echo $stock['department']; ?></p>
        <?php endif; ?>
        <a href="stocktable.php">Back to List</a>
    </div>
</body>
</html>
