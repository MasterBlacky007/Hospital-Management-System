<?php
// Database connection
include "conf.php";

// Fetch all admissions
$sql = "SELECT * FROM admissions";
$result = $conn->query($sql);

// Get today's date
$today = date("Y-m-d");

// Query to fetch today's discharges
$discharge_sql = "SELECT * FROM admissions WHERE discharge_date = '$today'";
$discharge_result = $conn->query($discharge_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Admissions</title>
    <link rel="stylesheet" href="longtable.css">
</head>
<body>
    <div class="container">
        <h2>Admissions</h2>

        <!-- Back button -->
        <button class="back" onclick="window.location.href='admissiondash.php'">Back</button>

        <!-- Search field -->
        <input type="text" id="search" onkeyup="filterTable()" placeholder="Search by any field...">

        <!-- Admissions table -->
        <table id="admissionsTable">
            <thead>
                <tr>
                    <th>Admission ID</th>
                    <th>Reason</th>
                    <th>Room Number</th>
                    <th>Admit Date</th>
                    <th>Discharge Date</th>
                    <th>Patient Name</th>
                    <th>Contact</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['admission_id'] . "</td>";
                        echo "<td>" . $row['reason'] . "</td>";
                        echo "<td>" . $row['roomNumber'] . "</td>";
                        echo "<td>" . $row['admit_date'] . "</td>";
                        echo "<td>" . $row['discharge_date'] . "</td>";
                        echo "<td>" . $row['patient_name'] . "</td>";
                        echo "<td>" . $row['contact_number'] . "</td>";
                        echo "<td>";
                        echo "<button class='accept' onclick=\"updateAdmission('" . $row['admission_id'] . "')\">Update</button> ";
                        echo "<button class='reject' onclick=\"deleteAdmission('" . $row['admission_id'] . "')\">Delete</button>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No admissions found</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <h3>Today's Discharges</h3>
        <!-- Today's discharges table -->
        <table id="dischargesTable">
            <thead>
                <tr>
                    <th>Admission ID</th>
                    <th>Reason</th>
                    <th>Room Number</th>
                    <th>Admit Date</th>
                    <th>Discharge Date</th>
                    <th>Patient Name</th>
                    <th>Contact</th>
                    <th>Additional Record</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($discharge_result->num_rows > 0) {
                    while ($row = $discharge_result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['admission_id'] . "</td>";
                        echo "<td>" . $row['reason'] . "</td>";
                        echo "<td>" . $row['roomNumber'] . "</td>";
                        echo "<td>" . $row['admit_date'] . "</td>";
                        echo "<td>" . $row['discharge_date'] . "</td>";
                        echo "<td>" . $row['patient_name'] . "</td>";
                        echo "<td>" . $row['contact_number'] . "</td>";
                        echo "<td>" . $row['additional_record'] . "</td>";
                        echo "<td>" . $row['status'] . "</td>";
                        echo "<td>";
                        echo "<button class='reject' onclick=\"dischargePatient('" . $row['admission_id'] . "')\">Discharge</button>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='10'>No discharges found for today</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script>
        // Function to filter the table rows
        function filterTable() {
            const input = document.getElementById('search');
            const filter = input.value.toLowerCase();
            const table = document.getElementById('admissionsTable');
            const rows = table.getElementsByTagName('tr');

            for (let i = 1; i < rows.length; i++) {
                let row = rows[i];
                let match = false;
                const cells = row.getElementsByTagName('td');

                for (let j = 0; j < cells.length; j++) {
                    if (cells[j].innerText.toLowerCase().includes(filter)) {
                        match = true;
                        break;
                    }
                }

                row.style.display = match ? '' : 'none';
            }
        }

        // Discharge patient function
        function dischargePatient(id) {
            if (confirm('Are you sure you want to discharge this patient?')) {
                window.location.href = `dischargeadmission.php?id=${id}`;
            }
        }

         // Delete admission function
         function deleteAdmission(id) {
            if (confirm('Are you sure you want to delete this admission?')) {
                window.location.href = `deleteAdmission.php?id=${id}`;
            }
        }

        // Update admission function
        function updateAdmission(id) {
            window.location.href = `updateAdmission.php?id=${id}`;
        }
    </script>
</body>
</html>
