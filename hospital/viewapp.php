<?php
// Database connection
include "conf.php";

// Fetch patient data
$sql = "SELECT * FROM appointments";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Appointments List</title>
    <link rel="stylesheet" href="viewtable.css">
</head>
<body>
    <div class="container">
        <h3>Patient Apointments List</h3>
        <button class="add-patient" onclick="window.location.href='appointment.php'">+ Add Appointment</button>
        <button class="back" onclick="window.location.href='appointmentdash.php'">Back</button>
        
        <input type="text" id="search" placeholder="Search by any field...">
        
        <table id="AppointmentTable">
            <thead>
                <tr>
                    <th>Appointment ID</th>
                    <th>Patient Name</th>
                    <th>Age</th>
                    <th>Doctor id</th>
                    <th>Appointment Date</th>
                    <th>Appointment Time</th>
                    <th>Conttact No</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['appointmentid'] . "</td>";
                        echo "<td>" . $row['patientName'] . "</td>";
                        echo "<td>" . $row['age'] . "</td>";
                        echo "<td>" . $row['doctor_id'] . "</td>";
                        echo "<td>" . $row['appointmentDate'] . "</td>";
                        echo "<td>" . $row['appointmentTime'] . "</td>";
                        echo "<td>" . $row['contactNo'] . "</td>";
                        echo "<td>" . $row['status'] . "</td>";
                        echo "<td>
                            <button class='view-button' onclick=\"viewAppointment('" . $row['appointmentid'] . "')\">View</button>
                        </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='11'>No appointment found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Link to external JavaScript -->
    <script>
        // Search functionality
  document.getElementById('search').addEventListener('input', function() {
    let filter = this.value.toLowerCase(); // Get search term
    let table = document.getElementById('AppointmentTable');
    let rows = table.getElementsByTagName('tr');

    // Loop through all rows (skip header row)
    for (let i = 1; i < rows.length; i++) {
        let cells = rows[i].getElementsByTagName('td');
        let rowText = '';
        
        // Concatenate text from each cell of the row
        for (let j = 0; j < cells.length; j++) {
            rowText += cells[j].innerText.toLowerCase() + ' ';
        }

        // If any cell text matches the search term, display the row
        if (rowText.includes(filter)) {
            rows[i].style.display = '';
        } else {
            rows[i].style.display = 'none';
        }
    }
});
function viewAppointment(appointmentId){
    window.location.href = "view_app.php?appointmentid=" + appointmentId;
}


    </script>
</body>
</html>

<?php
$conn->close();
?>
