<?php
// Include the database connection
include 'conf.php';


$sql = "SELECT * FROM progressnotes";
$result = mysqli_query($conn, $sql);

// Check if the query was successful
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Progress Notes</title>
    <link rel="stylesheet" href="longtables.css">
</head>
<body>
    <div class="container">
        <h3>Progress Notes List</h3>
        
        <button class="back" onclick="window.location.href='doctordash.html'">Back</button>
        
        <input type="text" id="search" placeholder="Search by any field...">
        
        <div class="main-content">
           
            <table id="progressnotes">
                <thead>
                    <tr>
                        <th>Record ID</th>
                        <th>Patient Name</th>
                        <th>dob</th>
                        <th>Email</th>
                        <th>Contact No</th>
                        <th>Chief Complaint</th>
                        <th>Assessment</th>
                        <th>plan</th>
                        <th>Diagnosis</th>
                        <th>Added By</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result && mysqli_num_rows($result) > 0) {
                        // Loop through and display record
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['progressNId'] . "</td>";
                            echo "<td>" . $row['patientName'] . "</td>";
                            echo "<td>" . $row['dob'] . "</td>";
                            echo "<td>" . $row['email'] . "</td>";
                            echo "<td>" . $row['contactNo'] . "</td>";
                            echo "<td>" . $row['c_complaint'] . "</td>";
                            echo "<td>" . $row['assessment'] . "</td>";
                            echo "<td>" . $row['plan'] . "</td>";
                            echo "<td>" . $row['diagnosis'] . "</td>";
                            echo "<td>" . $row['staffName'] . "</td>";
                            echo "<td>" . $row['date'] . "</td>";
                            echo "<td>" . $row['time'] . "</td>";
                            echo "<td>
                                    <a href='view_progress.php?id=" . $row['progressNId'] . "'onclick=\viewProgress('".$row['progressNId']."')\">View</a> | 
                                   
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='12'>No records available</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>
