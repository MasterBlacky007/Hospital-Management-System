<?php
// Database connection
include "conf.php";

// Get the result ID from the URL
$resultID = $_GET['result_id'];

// Fetch detailed lab test result
$sql = "SELECT * FROM lab_test_results WHERE id = '$resultID'";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Lab Test Details</title>
        <link rel="stylesheet" href="labprint.css">
    </head>
    <body>
        <div class="container">
            <div class="header">
                <img src="logo.jpeg" alt="Hospital Logo" class="logo">
                <div class="header-content">
                    <h1>MOUNT APOLLO HOSPITALS (PVT) LTD</h1>
                    <p>No. 355, Maharagama Road, Boralesgamuwa</p>
                    <p>
                        Tel: 077 20 20 261, 077 20 20 578, 011 2 150 150<br>
                        Email: info@mountapollohospitals.com<br>
                        Web: www.mountapollohospitals.com
                    </p>
                </div>
            </div>

            <h3>Lab Test Details</h3>

            <!-- Patient Details Section -->
            <div class="patient-details">
                <h4>Patient Details</h4>
                <p><strong>Patient Name:</strong> <?php echo htmlspecialchars($row['patientName']); ?></p>
                <p><strong>Contact:</strong> <?php echo htmlspecialchars($row['contact']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($row['mail'] ?? 'N/A'); ?></p>
            </div>

            <!-- Test Details Section -->
            <div class="test-details">
                <h4>Test Details</h4>
                <p><strong>Test ID:</strong> <?php echo htmlspecialchars($row['id']); ?></p>
                <p><strong>Test Type:</strong> <?php echo htmlspecialchars($row['testType']); ?></p>
                <p><strong>Test Date:</strong> <?php echo htmlspecialchars($row['testDate'] ?? 'N/A'); ?></p>
                <p><strong>Result Details:</strong> <?php echo nl2br(htmlspecialchars($row['resultDetails'] ?? 'N/A')); ?></p>
                <p><strong>Added Date:</strong> <?php echo htmlspecialchars($row['created_at']); ?></p>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <button class="back-button" onclick="window.history.back()">Back to Results</button>
                <button class="print-button" onclick="window.print()">Print Report</button>
            </div>
        </div>
    </body>
    </html>
    <?php
} else {
    echo "<p>No test details found for the specified ID.</p>";
}

// Close the database connection
$conn->close();
?>
