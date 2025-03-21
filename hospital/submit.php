<?php

include "conf.php";

// Retrieve form data
$testID = $_POST['testID'];
$patientID = $_POST['patientID'];
$patientName = $_POST['patientName'];
$testType = $_POST['testType'];
$testDate = $_POST['testDate'];
$status = $_POST['status'];
$resultDetails = $_POST['resultDetails'];

// Insert into database
$sql = "INSERT INTO lab_tests (test_id, patient_id, patient_name, test_type, test_date, status, result_details)
        VALUES ('$testID', '$patientID', '$patientName', '$testType', '$testDate', '$status', '$resultDetails')";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Test Result added successfully!'); window.location.href = 'labtestl.html';</script>";
} else {
    echo "<script>alert('Error adding Test Result: " . mysqli_error($conn) . "'); window.location.href = 'labtestl.html';</script>";
}

$conn->close();
?>