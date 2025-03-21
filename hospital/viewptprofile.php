<?php
// Database connection
include "conf.php";

// Fetch patient data
$sql = "SELECT * FROM patientprofile";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient List</title>
    <link rel="stylesheet" href="viewtable.css">
</head>
<body>
    <div class="container">
        <h3>Patient List</h3>
        <button class="add-patient" onclick="window.location.href='patientProfile.html'">+ Add Patient</button>
        <button class="back" onclick="window.location.href='patientProfiledash.php'">Back</button>
        
        <input type="text" id="search" placeholder="Search by any field...">
        
        <table id="patientTable">
            <thead>
                <tr>
                    <th>Profile ID</th>
                    <th>Full Name</th>
                    <th>Gender</th>
                    <th>Age</th>
                    <th>DOB</th>
                    <th>NIC</th>
                    <th>Mobile No</th>
                    <th>Address</th>
                    <th>Email</th>
                    <th>Special Notes</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td>" . $row['gender'] . "</td>";
                        echo "<td>" . $row['age'] . "</td>";
                        echo "<td>" . $row['dob'] . "</td>";
                        echo "<td>" . $row['nic'] . "</td>";
                        echo "<td>" . $row['contact'] . "</td>";
                        echo "<td>" . $row['address'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>" . $row['special_notes'] . "</td>";
                        echo "<td>
                            <button class='view-button' onclick=\"viewPatient('" . $row['id'] . "')\">View</button>
                        </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='11'>No patients found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Link to external JavaScript -->
    <script src="script.js"></script>
</body>
</html>

<?php
$conn->close();
?>
