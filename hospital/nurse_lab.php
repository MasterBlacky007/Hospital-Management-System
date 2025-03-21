<?php
// Database connection
include "conf.php";

// Fetch lab test data
$sql = "SELECT * FROM lab_test_results";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab Test Results</title>
    <link rel="stylesheet" href="viewtable.css">
</head>
<body>
    <div class="container">
        <h3>Lab Test Results</h3>

        <button class="back" onclick="window.location.href='nursedashboard.html'">Back</button>
        
        <input type="text" id="search" placeholder="Search by any field...">
        
        <table id="labResultsTable">
            <thead>
                <tr>
                    <th>Test ID</th>
                    <th>Patient Name</th>
                    <th>Contact</th>
                    <th>Email</th>
                    <th>Test Type</th>
                    <th>Test Date</th>
                    <th>Result Details</th>
                    <th>File Link</th>
                    <th>Added Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['patientName'] . "</td>";
                        echo "<td>" . $row['contact'] . "</td>";
                        echo "<td>" . $row['mail'] . "</td>";
                        echo "<td>" . $row['testType'] . "</td>";
                        echo "<td>" . ($row['testDate'] ?? 'N/A') . "</td>";
                        echo "<td>" . ($row['resultDetails'] ?? 'N/A') . "</td>";
                        echo "<td>" . ($row['filePath'] ? "<a href='" . $row['filePath'] . "' target='_blank'>View File</a>" : 'N/A') . "</td>";
                        echo "<td>" . $row['created_at'] . "</td>";
                        
                        // Conditional buttons for actions
                        echo "<td>";
                        if (empty($row['filePath']) && !empty($row['resultDetails'])) {
                            echo "<button class='view-button' onclick=\"viewTestResults('" . $row['id'] . "')\">View</button> ";
                        }
                        echo "</td>";

                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='10'>No lab test results found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Link to external JavaScript -->
    <script src="labscript.js"></script>
</body>
</html>

<?php
$conn->close();
?>
