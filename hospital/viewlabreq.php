<?php
// Database connection
include "conf.php";

// Fetch lab requests
$sql = "SELECT request_id, patient_name, contact, test_type, request_date, status FROM lab_requests ORDER BY request_date DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Lab Requests</title>
    <link rel="stylesheet" href="viewtable.css"> 
    <style>
        /* Style for Edit and Delete buttons */
            td a {
                text-decoration: none;
                padding: 8px 15px;
                margin: 2px;
                border-radius: 4px;
                display: inline-block;
                font-weight: bold;
                color: white;
            }

            td a:hover {
                opacity: 0.8;
            }

            /* Edit Button Style */
            td a[href*="editlabreq.php"] {
                background-color: #4CAF50; /* Green */
            }

            /* Delete Button Style */
            td a[href*="deletelabreq.php"] {
                background-color: #f44336; /* Red */
            }

    </style>
</head>
<body>
    <h1>Lab Requests</h1>
    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>Request ID</th>
                <th>Patient Name</th>
                <th>Contact</th>
                <th>Test Type</th>
                <th>Request Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['request_id'] . "</td>";
                    echo "<td>" . $row['patient_name'] . "</td>";
                    echo "<td>" . $row['contact'] . "</td>";
                    echo "<td>" . $row['test_type'] . "</td>";
                    echo "<td>" . $row['request_date'] . "</td>";
                    echo "<td>" . $row['status'] . "</td>";
                    echo "<td>
                            <a href='editlabreq.php?id=" . $row['request_id'] . "'class='edit-btn'>Edit</a> | 
                            <a href='deletelabreq.php?id=" . $row['request_id'] . "'class='delete-btn' onclick=\"return confirm('Are you sure you want to delete this request?')\">Delete</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No lab requests found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
<?php
// Close the connection
$conn->close();
?>
