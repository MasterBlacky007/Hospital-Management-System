<?php

include('conf.php');

// Initialize variables
$appointmentData = [];
$errorMessage = "";

// Step 1: Load Appointment Details
if (isset($_POST['load_details'])) {
    // Get the contact number from the form
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);

    // Query to fetch the appointment details
    $query = "SELECT * FROM appointments WHERE contactNo = '$contact' AND appointmentDate = '$date'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        // Fetch appointment details
        $appointmentData = mysqli_fetch_assoc($result);
    } else {
        $errorMessage = "No appointment found with this contact number and date!";
    }
}

// Step 2: Delete Appointment
if (isset($_POST['delete_appointment'])) {
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);

    // Query to delete the appointment
    $deleteQuery = "DELETE FROM appointments WHERE contactNo = '$contact'";
    if (mysqli_query($conn, $deleteQuery)) {
        echo "<script>
            alert('Appointment deleted successfully!');
            window.location.href = 'appointmentdash.php'; 
        </script>";
        exit;
    } else {
        echo "Error deleting appointment: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Appointment</title>
    <link rel="stylesheet" href="style.css">

    <script>
       
        function confirmDelete() {
            return confirm('Are you sure you want to delete this appointment?');
        }
    </script>
</head>
<body>
    <h2>Delete Appointment</h2>
    <div class="form-container">
        <!-- Step 1: Load Appointment Details -->
        <form action="deleteApp.php" method="POST">
            <div class="form-row">
                <label for="contact">Enter Contact No:</label>
                <input type="text" id="contact" name="contact" required>
            </div>
            <div class="form-row">
                <label for="date">Enter Date:</label>
                <input type="date" id="date" name="date" required>
            </div>
            <div class="form-row">
                <button type="submit" name="load_details" class="form-btn">Load Details</button>
            </div>
        </form>

        <?php if (!empty($appointmentData)): ?>
            <h3>Appointment Details</h3>
            <p><strong>Patient Name:</strong> <?= $appointmentData['patientName'] ?></p>
            <p><strong>Age:</strong> <?= $appointmentData['age'] ?></p>
            <p><strong>Doctor ID:</strong> <?= $appointmentData['doctor_id'] ?></p>
            <p><strong>Appointment Date:</strong> <?= $appointmentData['appointmentDate'] ?></p>
            <p><strong>Appointment Time:</strong> <?= $appointmentData['appointmentTime'] ?></p>

            <!-- Step 2: Confirm and Delete Appointment -->
            <form action="deleteApp.php" method="POST" onsubmit="return confirmDelete();">
                <input type="hidden" name="contact" value="<?= $appointmentData['contactNo'] ?>">
                <button type="submit" name="delete_appointment" class="form-btn" onclick="return confirmDelete() ">Delete Appointment</button>
            </form>
        <?php endif; ?>

        <?php if (!empty($errorMessage)): ?>
            <p class="error-message"><?= $errorMessage ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
