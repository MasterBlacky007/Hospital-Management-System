<?php
// Include the database configuration file
include('conf.php');

// Fetch doctors from the doctor table
$doctors = [];
$doctorQuery = "SELECT doctor_id, doctor_name FROM doctor";
$result = mysqli_query($conn, $doctorQuery);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $doctors[] = $row;
    }
}

// Initialize appointment data variables
$appointments = [];

// Check if the form is submitted for searching or updating
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Search by contact number
    if (isset($_POST['search'])) {
        $contactNo = mysqli_real_escape_string($conn, $_POST['contactNo']);
        
        // Retrieve all appointments associated with the given contact number
        $searchQuery = "SELECT * FROM appointments WHERE contactNo = '$contactNo'";
        $searchResult = mysqli_query($conn, $searchQuery);
        
        if ($searchResult && mysqli_num_rows($searchResult) > 0) {
            while ($row = mysqli_fetch_assoc($searchResult)) {
                $appointments[] = $row;
            }
        } else {
            echo "<script>alert('No appointments found with this contact number!');</script>";
        }
    }

    // Search by contact number and appointment date
    if (isset($_POST['searchByDate'])) {
        $contactNo = mysqli_real_escape_string($conn, $_POST['contactNo']);
        $appointmentDate = mysqli_real_escape_string($conn, $_POST['appointmentDate']);

        // Retrieve appointments for the given contact number and date
        $searchByDateQuery = "SELECT * FROM appointments WHERE contactNo = '$contactNo' AND appointmentDate = '$appointmentDate'";
        $searchByDateResult = mysqli_query($conn, $searchByDateQuery);
        
        if ($searchByDateResult && mysqli_num_rows($searchByDateResult) > 0) {
            while ($row = mysqli_fetch_assoc($searchByDateResult)) {
                $appointments[] = $row;
            }
        } else {
            echo "<script>alert('No appointments found for this date!');</script>";
        }
    }

    // Update the appointment
    if (isset($_POST['update'])) {
        $contactNo = mysqli_real_escape_string($conn, $_POST['contactNo']);
        $patientName = mysqli_real_escape_string($conn, $_POST['patientName']);
        $age = mysqli_real_escape_string($conn, $_POST['age']);
        $doctorId = mysqli_real_escape_string($conn, $_POST['doctorId']);
        $appointmentDate = mysqli_real_escape_string($conn, $_POST['appointmentDate']);
        $appointmentTime = mysqli_real_escape_string($conn, $_POST['appointmentTime']);

        // Update the appointment details in the database
        $updateQuery = "UPDATE appointments
                        SET patientName = '$patientName', 
                            age = '$age', 
                            doctor_id = '$doctorId', 
                            appointmentDate = '$appointmentDate', 
                            appointmentTime = '$appointmentTime'
                        WHERE contactNo = '$contactNo'";

        if (mysqli_query($conn, $updateQuery)) {
            echo "<script>alert('Appointment updated successfully!');</script>";
        } else {
            echo "<script>alert('Error updating appointment: " . mysqli_error($conn) . "');</script>";
        }
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Appointment</title>
    <link rel="stylesheet" href="dashboard1.css">
    <style>
        #doctorId {
            width: 100%;
            padding: 12px;
            border: 1px solid #1A4650;
            border-radius: 8px;
            font-size: 1rem;
            background-color: #EDF7F7;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <div class="logo">
                <img src="logo.jpeg" alt="Hospital Logo">
                <h2>Apollo Hospital</h2>
            </div>
            <h1>Receptionist</h1>
            <a href="receptionistdashboard.html">Dashboard</a>
            <a href="profilerec.php">My Profile</a>
            <a href="patientRegister.html">Patient Registration</a>
            <a href="patientprofile.html">Patient Profile</a>
            <a href="receppatdet.php">Patient Details</a>
            <a href="appointmentdash.php">Appointment</a>
            <a href="visitordash.php">Visitors</a>
            <a href="stlogin.html">Logout</a>
        </div>

        <div class="main-content">
            <h2>Update Appointment</h2>
            <div class="form-container">
                <form method="POST" action="updateAppointment.php">
                    <!-- Search by contact number -->
                    <div class="form-row">
                        <label for="contactNo">Contact No</label>
                        <input type="text" id="contactNo" name="contactNo" required value="<?= isset($appointments[0]['contactNo']) ? $appointments[0]['contactNo'] : '' ?>">
                    </div>
                    <div class="form-row">
                        <button type="submit" name="search" class="form-btn">Search Appointment</button>
                    </div>

                    <!-- Search by Date -->
                    <div class="form-row">
                        <label for="appointmentDate">Appointment Date</label>
                        <input type="date" id="appointmentDate" name="appointmentDate">
                    </div>
                    <div class="form-row">
                        <button type="submit" name="searchByDate" class="form-btn">Search by Date</button>
                    </div>

                    <?php if (!empty($appointments)): ?>
                        <!-- Only show these fields if appointments are found -->
                        <?php foreach ($appointments as $appointment): ?>
                        <div class="form-row">
                            <label for="patientName">Patient Name</label>
                            <input type="text" id="patientName" name="patientName" required value="<?= $appointment['patientName'] ?>">
                        </div>
                        <div class="form-row">
                            <label for="age">Age</label>
                            <input type="number" id="age" name="age" required value="<?= $appointment['age'] ?>">
                        </div>
                        <div class="form-row">
                            <label for="doctorId">Doctor Name</label>
                            <select id="doctorId" name="doctorId" required>
                                <option value="">-- Select Doctor --</option>
                                <?php foreach ($doctors as $doctor): ?>
                                    <option value="<?= $doctor['doctor_id'] ?>" <?= ($doctor['doctor_id'] == $appointment['doctor_id']) ? 'selected' : '' ?>>
                                        <?= $doctor['doctor_name'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-row">
                            <label for="appointmentDate">Date</label>
                            <input type="date" id="appointmentDate" name="appointmentDate" required value="<?= $appointment['appointmentDate'] ?>">
                        </div>
                        <div class="form-row">
                            <label for="appointmentTime">Time</label>
                            <input type="time" id="appointmentTime" name="appointmentTime" required value="<?= $appointment['appointmentTime'] ?>">
                        </div>
                        <div class="form-row">
                            <button type="submit" name="update" class="form-btn">Update Appointment</button>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
