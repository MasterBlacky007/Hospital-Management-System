<?php
session_start();

// Database connection
include "conf.php";

// Retrieve the logged-in patient's contact number
if (!isset($_SESSION['contact_number'])) {
    header("Location: plogin.html");
    exit();
}

$contact_number = $_SESSION['contact_number'];

// Retrieve appointments with doctor names for the logged-in patient
$sql = "
    SELECT 
        a.patientName As patient_name,
        a.appointmentTime AS time, 
        a.appointmentDate AS date, 
        d.doctor_name AS doctor_name, 
        a.status 
    FROM appointments a
    JOIN doctor d ON a.doctor_id = d.doctor_id
    WHERE a.contactNo = ?
    ORDER BY a.appointmentDate, a.appointmentTime";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $contact_number);
$stmt->execute();
$result = $stmt->get_result();

// Convert data to JSON for JavaScript
$appointments = [];
while ($row = $result->fetch_assoc()) {
    $appointments[] = $row;
}

$stmt->close();
$conn->close();
?>







<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Appointments</title>
    <link rel="stylesheet" href="lreq.css">
</head>
<body>
    <div class="dashboard">
        <div class="sidebar">
            <div class="logo">
                <img src="logo.jpeg" alt="Hospital Logo">
                <h2>Apollo Hospital</h2>
            </div>
            <h1>Patient</h1>
            <a href="patientdash.html">Dashboard</a></li>
                <a href="profilepatient.php">My Profile</a>
                <a href="patientapp.php">Book Appointment</a>
                <a href="pappointment.php">View Appointments</a>
                <a href="patientmedi.php">Medical Records</a>
                <a href="viewpbill.php">Payment</a>
                <a href="feedback.php">Feedback</a>
                <a href="plogin.html">Logout</a>
        </div>

        <div class="main">
            <div class="header">My Appointment Info</div>
            <div class="form-container">
                <label for="date">Select Date:</label>
                <input type="date" id="date">
                <button onclick="loadAppointments()">Search</button>
            </div>
            <table>
    <thead>
        <tr>
            <th>Patient Name</th>
            <th>Time</th>
            <th>Date</th>
            <th>Doctor Name</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody id="appointmentsTable">
        <tr>
            <td colspan="5" class="placeholder">Please enter a date and search to view appointments.</td>
        </tr>
    </tbody>
</table>

<script>
    // Pass PHP data to JavaScript
    const appointments = <?php echo json_encode($appointments); ?>;

    function loadAppointments() {
        const date = document.getElementById('date').value;

        if (!date) {
            alert("Please select a date.");
            return;
        }

        const filteredAppointments = appointments.filter(app => app.date === date);

        const tableBody = document.getElementById('appointmentsTable');
        tableBody.innerHTML = ''; // Clear previous table content

        if (filteredAppointments.length === 0) {
            tableBody.innerHTML = `<tr><td colspan="5" class="placeholder">No appointments found for the selected date.</td></tr>`;
            return;
        }

        filteredAppointments.forEach(app => {
            tableBody.innerHTML += `
                <tr>
                    <td>${app.patient_name}</td>
                    <td>${app.time}</td>
                    <td>${app.date}</td>
                    <td>${app.doctor_name}</td>
                    <td>${app.status}</td>
                </tr>
            `;
        });
    }
</script>

</body>
</html>
