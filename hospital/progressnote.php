<?php
// Include database connection file
include('conf.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'add') {

    // Collect form data
    $patient_name = $_POST['patient_name'];
    $dob = $_POST['dob'];
    $email=$_POST['email'];
    $contactNo = $_POST['contactNo'];
    $chief_complaint = $_POST['chief_complaint'];
    $assessment = $_POST['assessment'];
    $plan = $_POST['plan'];
    $diagnosis = $_POST['diagnosis'];
    $staff_id = $_POST['staff_id'];
    $staff_name = $_POST['staff_name'];
    $date_of_entry = $_POST['date_of_entry'];

    // Prepare SQL query to insert the data into the database
    $sql = "INSERT INTO progressNotes (patientName, dob,email, contactNo, c_complaint, assessment, plan, diagnosis,  staffid, staffName, date) 
            VALUES ('$patient_name', '$dob', '$email','$contactNo', '$chief_complaint', '$assessment', '$plan', '$diagnosis', '$staff_id', '$staff_name', '$date_of_entry')";

    // Execute the query
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Vital signs added successfully!'); window.location.href = 'progressnote.html';</script>";
    } else {
        echo "<script>alert('Error adding vital signs: " . mysqli_error($conn) . "'); window.location.href = 'progressnote.html';</script>";
    }

    // Close the database connection
    mysqli_close($conn);
}
?>

