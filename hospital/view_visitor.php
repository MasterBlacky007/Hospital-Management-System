<?php

include "conf.php";

// Check if 'profileid' is passed in the URL
if (isset($_GET['visitor_id'])) {
    $VisitorId = $_GET['visitor_id'];

    // Fetch patient details from the database
    $sql = "SELECT * FROM visitors WHERE visitor_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $VisitorId );
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $Visitor = $result->fetch_assoc();
    } else {
        echo "Appointment not found.";
        exit();
    }
} else {
    echo "No Appointment selected.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Visitor Details</title>
    <link rel="stylesheet" href="formview.css">
</head>
<body>
    <div class="container">
        <h3>Visitor Details</h3>
        <div class="Appointment-details">
            <p><strong>Visitor ID:</strong> <?php echo htmlspecialchars($Visitor['visitor_id']); ?></p>
            <p><strong>Visitor Name:</strong> <?php echo htmlspecialchars($Visitor['visitor_name']); ?></p>
            <p><strong>NIC:</strong> <?php echo htmlspecialchars($Visitor['nic']); ?></p>
            <p><strong>Address:</strong> <?php echo htmlspecialchars($Visitor['address']); ?></p>
            <p><strong>Contact No:</strong> <?php echo htmlspecialchars($Visitor['contact']); ?></p>
            <p><strong>Purpose:</strong> <?php echo htmlspecialchars($Visitor['purpose']); ?></p>
            <p><strong>Date:</strong> <?php echo htmlspecialchars($Visitor['date']); ?></p>
            <p><strong>Time:</strong> <?php echo htmlspecialchars($Visitor['time']); ?></p>
        </div>
        <button class="back-button" onclick="window.location.href='viewvisitor.php'">Back to Patient List</button>
    </div>
</body>
</html>

<?php
// Close database connection
$conn->close();
?>
