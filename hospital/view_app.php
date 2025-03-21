<?php
// Include database connection
include "conf.php";

// Check if 'profileid' is passed in the URL
if (isset($_GET['appointmentid'])) {
    $AppointmentId = $_GET['appointmentid'];

    // Fetch patient details from the database
    $sql = "SELECT * FROM Appointments WHERE appointmentid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $AppointmentId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $Appointment = $result->fetch_assoc();
    } else {
        echo "<script>alert('Appointment not found.');</script>";
        exit();
    }
    
}else {
    echo "<script>alert('No Appointment selected.');</script>";
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Appointment Details</title>
    <link rel="stylesheet" href="formview.css">
</head>
<body>
    <div class="container">
        <h3>Appointment Details</h3>
        <div class="Appointment-details">
            <p><strong>Appointment ID:</strong> <?php echo htmlspecialchars($Appointment['appointmentid']); ?></p>
            <p><strong>Patient Name:</strong> <?php echo htmlspecialchars($Appointment['patientName']); ?></p>
            <p><strong>Age:</strong> <?php echo htmlspecialchars($Appointment['age']); ?></p>
            <p><strong>Doctor id:</strong> <?php echo htmlspecialchars($Appointment['doctor_id']); ?></p>
            <p><strong>Appointment Date:</strong> <?php echo htmlspecialchars($Appointment['appointmentDate']); ?></p>
            <p><strong>Appointment Time:</strong> <?php echo htmlspecialchars($Appointment['appointmentTime']); ?></p>
            <p><strong>Contact No:</strong> <?php echo htmlspecialchars($Appointment['contactNo']); ?></p>
            <p><strong>Status:</strong> <?php echo htmlspecialchars($Appointment['status']); ?></p>
        </div>
        <button class="back-button" onclick="window.location.href='viewapp.php'">Back to Patient List</button>
    </div>
</body>
</html>

<?php
// Close database connection
$conn->close();
?>
