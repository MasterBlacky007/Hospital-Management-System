<?php
session_start();
$host = 'localhost';
$user = 'root';
$password = '';  // Replace with your database password if needed
$database = 'mountapollo';

// Create connection
$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure the user is logged in
if (!isset($_SESSION['patient_id'])) {
    die("You must be logged in to view this result.");
}

$patient_id = $_SESSION['patient_id'];
$result_id = $_GET['result_id'] ?? null;

if (!$result_id) {
    die("Invalid result ID.");
}

// Fetching full details of the selected lab result for the logged-in patient
$sql = "SELECT lr.result_id, t.test_name, lr.test_date, lr.result_details, lr.status 
        FROM lab_results lr
        JOIN tests t ON lr.test_id = t.id
        WHERE lr.result_id = ? AND lr.patient_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $result_id, $patient_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab Result Details</title>
    <link rel="stylesheet" href="result.css">
</head>
<body>
<div class="container">
    <h1>Lab Result Details</h1>
    <?php if ($row): ?>
        <div class="result-details">
            <p><strong>Test Name:</strong> <?php echo htmlspecialchars($row['test_name']); ?></p>
            <p><strong>Test Date:</strong> <?php echo htmlspecialchars($row['test_date']); ?></p>
            <p><strong>Result Details:</strong> <?php echo htmlspecialchars($row['result_details']); ?></p>
            <p><strong>Status:</strong> <?php echo htmlspecialchars($row['status']); ?></p>
        </div>
      <!-- Ensure the button is wrapped with the no-print class -->
      <button class="no-print" onclick="window.print()">Print</button>
    <?php else: ?>
        <p>No details found for this result.</p>
    <?php endif; ?>
   <!-- Apply no-print class to the Back to Results link -->
   <a href="lab_results_view.php" class="no-print">Back to Results</a>
</div>
</body>
</html>
