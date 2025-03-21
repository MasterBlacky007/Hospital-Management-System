<?php
// Include the database connection file
include 'conf.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    // Get form input values
    $patient_name = mysqli_real_escape_string($conn, $_POST['patient_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $contact_no = mysqli_real_escape_string($conn, $_POST['contactNo']);
    $bp = mysqli_real_escape_string($conn, $_POST['bp']);
    $height = mysqli_real_escape_string($conn, $_POST['height']);
    $weight = mysqli_real_escape_string($conn, $_POST['weight']);
    $staff_id = mysqli_real_escape_string($conn, $_POST['staff_id']);
    $staff_name = mysqli_real_escape_string($conn, $_POST['name']);
    $bmi = 0;

    // Calculate BMI (Body Mass Index)
    if ($height > 0) {
        $bmi = round($weight / (($height / 100) * ($height / 100)), 2);
    }

    // SQL query to insert the vital signs data into the database
    $sql = "INSERT INTO vital_signs (patientName, email, contact_no, bloodp, height, weight, bmi, staffid, staffname) 
            VALUES ('$patient_name','$email', '$contact_no', '$bp', '$height', '$weight', '$bmi', '$staff_id', '$staff_name')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Vital signs added successfully!'); window.location.href = 'vitalsign.html';</script>";
    } else {
        echo "<script>alert('Error adding vital signs: " . mysqli_error($conn) . "'); window.location.href = 'vitalsign.html';</script>";
    }
}

// Close the database connection
mysqli_close($conn);
?>
