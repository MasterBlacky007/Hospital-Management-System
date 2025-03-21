<?php
$servername = "localhost"; // Your server name
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "mountapollo"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$testData = []; // Array to store test data
$totalTests = 0;
$totalPatients = 0;
$testsLast30Days = 0;
$mostCommonTest = "N/A";
$testsWithoutResults = 0;

// Fetch total lab tests
$totalTestsQuery = "SELECT COUNT(*) AS total FROM lab_test_results";
$totalTestsResult = $conn->query($totalTestsQuery);
if ($totalTestsResult->num_rows > 0) {
    $totalTests = $totalTestsResult->fetch_assoc()['total'];
}

// Fetch total unique patients
$totalPatientsQuery = "SELECT COUNT(DISTINCT patientName) AS total_patients FROM lab_test_results";
$totalPatientsResult = $conn->query($totalPatientsQuery);
if ($totalPatientsResult->num_rows > 0) {
    $totalPatients = $totalPatientsResult->fetch_assoc()['total_patients'];
}

// Fetch tests in the last 30 days
$testsLast30DaysQuery = "SELECT COUNT(*) AS total_last_30_days FROM lab_test_results WHERE testDate >= CURDATE() - INTERVAL 30 DAY";
$testsLast30DaysResult = $conn->query($testsLast30DaysQuery);
if ($testsLast30DaysResult->num_rows > 0) {
    $testsLast30Days = $testsLast30DaysResult->fetch_assoc()['total_last_30_days'];
}

// Fetch most common test type
$mostCommonTestQuery = "SELECT testType, COUNT(*) AS count FROM lab_test_results GROUP BY testType ORDER BY count DESC LIMIT 1";
$mostCommonTestResult = $conn->query($mostCommonTestQuery);
if ($mostCommonTestResult->num_rows > 0) {
    $mostCommonTestRow = $mostCommonTestResult->fetch_assoc();
    $mostCommonTest = $mostCommonTestRow['testType'];
}

// Fetch tests without results
$testsWithoutResultsQuery = "SELECT COUNT(*) AS total_without_results FROM lab_test_results WHERE resultDetails IS NULL OR resultDetails = ''";
$testsWithoutResultsResult = $conn->query($testsWithoutResultsQuery);
if ($testsWithoutResultsResult->num_rows > 0) {
    $testsWithoutResults = $testsWithoutResultsResult->fetch_assoc()['total_without_results'];
}

// Fetch breakdown by test type
$testTypeQuery = "SELECT testType, COUNT(*) AS count FROM lab_test_results GROUP BY testType";
$testTypeResult = $conn->query($testTypeQuery);
if ($testTypeResult->num_rows > 0) {
    while ($row = $testTypeResult->fetch_assoc()) {
        $testData[] = [
            'testType' => $row['testType'],
            'total_tests' => $row['count'],
            'percentage' => ($row['count'] / $totalTests) * 100
        ];
    }
}

// Timezone for Sri Lanka
date_default_timezone_set("Asia/Colombo");
$createdBy = "Center Manager"; // Replace with the actual creator's name
$createdTime = date("Y-m-d H:i:s");


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab Test Analytics Report</title>
    <link rel="stylesheet" href="patientreport1.css"> <!-- Link to your CSS file -->
</head>
<body>
    <div class="container report">
        <div class="letterhead">
            <img src="logo.jpeg" alt="Logo" class="logo"> <!-- Replace with your logo path -->
            <div class="details">
                <h1>MOUNT APOLLO HOSPITALS (PVT) LTD</h1>
                <p>No. 355, Maharagama Road, Boralesgamuwa</p>
                <p>Tel: 077 20 20 261, 077 20 20 578, 011 2 150 150</p>
                <p>Email: info@mountapollohospitals.com | Web: www.mountapollohospitals.com</p>
            </div>
        </div>
        <div class="header-details">
    <div class="left">
        <p><strong>Created By:</strong> <?php echo $createdBy; ?></p>
    </div>
    <div class="right">
        <p><strong>Created Date & Time:</strong> <?php echo $createdTime; ?></p>
    </div>
</div>

        <h2>Lab Test Analytics Report</h2>
       
        <!-- Summary Section -->
       

        <!-- Test Type Table -->
        <table>
            <thead>
                <tr>
                    <th>Test Type</th>
                    <th>Total Tests</th>
                    <th>Percentage</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if (!empty($testData)) {
                    foreach ($testData as $data): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($data['testType']); ?></td>
                        <td><?php echo htmlspecialchars($data['total_tests']); ?></td>
                        <td><?php echo number_format($data['percentage'], 2) . '%'; ?></td>
                    </tr>
                    <?php endforeach; 
                } else {
                    echo "<tr><td colspan='3'>No data available</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <div class="summary">
            <h2>Summary</h2>
            <p><strong>Total Lab Tests Performed:</strong> <?php echo $totalTests; ?></p>
            
            <p><strong>Tests Performed in Last 30 Days:</strong> <?php echo $testsLast30Days; ?></p>
            <p><strong>Most Common Test Type:</strong> <?php echo htmlspecialchars($mostCommonTest); ?></p>
            <p><strong>Tests Without Results:</strong> <?php echo $testsWithoutResults; ?></p>
            
         
        </div>

        <button onclick="window.print()" class="print-btn">Print Report</button>
    </div>
</body>
</html>
