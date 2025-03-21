<?php
$host = 'localhost';
$user = 'root';
$password = '';  // Replace with your database password if needed
$database = 'mountapollo';

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['result_id'])) {
    $result_id = $_GET['result_id'];

    // Fetch full details of the selected lab result
    $sql = "SELECT lr.result_id, p.patientName, p.contact, lr.test_id, t.test_name, lr.test_date, lr.result_details, lr.status 
            FROM lab_results lr
            JOIN patients p ON lr.patient_id = p.id
            JOIN tests t ON lr.test_id = t.id
            WHERE lr.result_id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $result_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Lab Result</title>
    <link rel="stylesheet" href="result.css">
</head>
<body>

<div class="container">
    <div class="logo">
        <img src="logo.jpeg" alt="Logo" style="float: left; margin-right: 15px;">
    </div>
    <h1>MOUNT APOLLO HOSPITALS (PVT) LTD</h1>
    <h4><center>NO.355, Maharagama Road, Boralasgamuwa</center></h4>
    <h4><center>Tel : 077 20 20 261, 077 20 20 578, 011 2 150 150</center></h4>
    <h4><center>Email: info@mountapollohospitals.com | Web: www.mountapolohospitals.com</center></h4>
    <hr>  
    <h2><center>Lab Result Details</center></h2>
    
    <?php if ($row): ?>
        <div class="result-details">
            <p><strong>Patient Name:</strong> <?php echo htmlspecialchars($row['patientName']); ?></p>
            <p><strong>Phone:</strong> <?php echo htmlspecialchars($row['contact']); ?></p>
            <p><strong>Test Name:</strong> <?php echo htmlspecialchars($row['test_name']); ?></p>
            <p><strong>Test ID:</strong> <?php echo htmlspecialchars($row['test_id']); ?></p>
            <p><strong>Test Date:</strong> <?php echo htmlspecialchars($row['test_date']); ?></p>
            <p><strong>Result Details:</strong> <?php echo htmlspecialchars($row['result_details']); ?></p>
            <p><strong>Status:</strong> <?php echo htmlspecialchars($row['status']); ?></p>
        </div>
    <?php else: ?>
        <p>No details found for this result.</p>
    <?php endif; ?>

    <a href="lab_results_view.php" class="back-btn">Back to Results</a>
    <button class="print-btn" onclick="window.print()">Print Report</button>
</div>

</body>
</html>
