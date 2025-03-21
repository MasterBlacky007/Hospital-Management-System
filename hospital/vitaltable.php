<?php
// Include the database connection
include 'conf.php';

// Query to fetch all vital signs
$sql = "SELECT * FROM vital_signs";
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
    <title>View Vital Signs</title>
    <link rel="stylesheet" href="longtables.css">
</head>
<body>
    <div class="container">
        <h3>Vital Signs List</h3>
        <button class="add-patient" onclick="window.location.href='vitalsign.html'">+ Add Vital Signs</button>
        <button class="back" onclick="window.location.href='vitalsigndash.php'">Back</button>
        
        <input type="text" id="search" placeholder="Search by any field...">
        
        <div class="main-content">
            <!-- Vital Signs Table -->
            <table id="vitalsignstable">
                <thead>
                    <tr>
                        <th>Record ID</th>
                        <th>Patient Name</th>
                        <th>Email</th>
                        <th>Contact No</th>
                        <th>Blood Pressure</th>
                        <th>Height (cm)</th>
                        <th>Weight (kg)</th>
                        <th>BMI</th>
                        <th>Staff ID</th>
                        <th>Staff Name</th>
                        <th>Time</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result && mysqli_num_rows($result) > 0) {
                        // Loop through and display each vital sign record
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['vitalId'] . "</td>";
                            echo "<td>" . $row['patientName'] . "</td>";
                            echo "<td>" . $row['email'] . "</td>";
                            echo "<td>" . $row['contact_no'] . "</td>";
                            echo "<td>" . $row['bloodp'] . "</td>";
                            echo "<td>" . $row['height'] . "</td>";
                            echo "<td>" . $row['weight'] . "</td>";
                            echo "<td>" . $row['bmi'] . "</td>";
                            echo "<td>" . $row['staffid'] . "</td>";
                            echo "<td>" . $row['staffname'] . "</td>";
                            echo "<td>" . $row['time'] . "</td>";
                            echo "<td>
                                    <a href='view_vital.php?id=" . $row['vitalId'] . "'>View</a> | 
                                    <a href='updatevital.php?id=" . $row['vitalId'] . "'>Update</a> | 
                                    <a href='deletevital.php?id=" . $row['vitalId'] . "' onclick='return confirm(\"Are you sure you want to delete this record?\");'>Delete</a>
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
    <script>
        // Search functionality
document.getElementById('search').addEventListener('input', function () {
    const filter = this.value.toLowerCase();
    const rows = document.querySelectorAll('#vitalsignstable tbody tr');
    
    rows.forEach(row => {
        const cells = row.querySelectorAll('td');
        const match = Array.from(cells).some(cell => 
            cell.textContent.toLowerCase().includes(filter)
        );
        row.style.display = match ? '' : 'none';
    });
});


const table = document.getElementById('vitalsignstable');
if (table) {
    table.addEventListener('mouseover', function (event) {
        const row = event.target.closest('tr');
        if (row) row.style.backgroundColor = '#f0f8ff';
    });

    table.addEventListener('mouseout', function (event) {
        const row = event.target.closest('tr');
        if (row) row.style.backgroundColor = '';
    });
}

    </script>
</body>
</html>
