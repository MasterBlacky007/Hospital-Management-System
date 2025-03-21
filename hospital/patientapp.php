<?php
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

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve the form data
    $patientName = mysqli_real_escape_string($conn, $_POST['patientName']);
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $doctorId = mysqli_real_escape_string($conn, $_POST['doctorId']);
    $appointmentDate = mysqli_real_escape_string($conn, $_POST['appointmentDate']);
    $appointmentTime = mysqli_real_escape_string($conn, $_POST['appointmentTime']);
    $contactNo = mysqli_real_escape_string($conn, $_POST['contactNo']);

    // Insert the appointment details into the database
    $query = "INSERT INTO appointments (patientName, age, doctor_id, appointmentDate, appointmentTime, contactNo) 
              VALUES ('$patientName', '$age', '$doctorId', '$appointmentDate', '$appointmentTime', '$contactNo')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Appointment booked successfully!'); window.location.href='patientapp.php';</script>";
    } else {
        echo "<script>alert('Error adding appointment: " . mysqli_error($conn) . "'); window.location.href='patientapp.php';</script>";
    }

    // Close the database connection
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment</title>
    <link rel="stylesheet" href="styleslb.css">
</head>
<body>
    <div class="container">
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

        <div class="main-content">
            
            <div class="form-container">
            <h2>Book Appointment</h2>
                <form method="POST" action="patientapp.php">
                    <div class="form-row">
                        <label for="patientName">Patient Name</label>
                        <input type="text" id="patientName" name="patientName" required>
                    </div>
                    <div class="form-row">
                        <label for="age">Age</label>
                        <input type="number" id="age" name="age" required>
                    </div>
                    <div class="form-row">
                        <label for="doctorId">Doctor Name</label>
                        <select id="doctorId" name="doctorId" required>
                            <option value="">-- Select Doctor --</option>
                            <?php foreach ($doctors as $doctor): ?>
                                <option value="<?= $doctor['doctor_id'] ?>"><?= $doctor['doctor_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-row">
                        <label for="appointmentDate">Date</label>
                        <input type="date" id="appointmentDate" name="appointmentDate" required>
                    </div>
                    <div class="form-row">
                        <label for="appointmentTime">Time</label>
                        <input type="time" id="appointmentTime" name="appointmentTime" required>
                    </div>
                    <div class="form-row">
                        <label for="contactNo">Contact No</label>
                        <input type="text" id="contactNo" name="contactNo" required>
                    </div>
                    <div class="form-row">
                        <button type="submit" class="register-btn">Book Appointment</button>
                        <button type="reset" class="cancel-btn">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
