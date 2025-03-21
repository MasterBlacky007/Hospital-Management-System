<?php
// Database connection
include "conf.php";

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $nic = $_POST['nic'];
    $address = $_POST['address'];
    $contactNo = $_POST['contactNo'];

    // Sanitize the input
    $firstName = $conn->real_escape_string($firstName);
    $lastName = $conn->real_escape_string($lastName);
    $gender = $conn->real_escape_string($gender);
    $dob = $conn->real_escape_string($dob);
    $nic = $conn->real_escape_string($nic);
    $address = $conn->real_escape_string($address);
    $contactNo = $conn->real_escape_string($contactNo);

    // Check if NIC or contact number already exists in the database
    $checkQuery = "SELECT * FROM patient WHERE nic = '$nic' OR contact = '$contactNo'";
    $result = $conn->query($checkQuery);

    if ($result->num_rows > 0) {
        // If a record with the same NIC or contact number exists, display an error
        echo "<script>alert('This NIC or Contact Number already exists. Please enter a unique NIC and Contact Number.'); window.location.href='patientRegister.php';</script>";
    } else {
        // Calculate age from the date of birth
        $birthDate = new DateTime($dob);
        $currentDate = new DateTime();
        $age = $currentDate->diff($birthDate)->y;

        // SQL query to insert the patient data into the database
        $sql = "INSERT INTO patient (firstName, lastName, gender, dob, age, nic, address, contact) 
                VALUES ('$firstName', '$lastName', '$gender', '$dob', '$age', '$nic', '$address', '$contactNo')";

        // Execute the query
        if ($conn->query($sql) === TRUE) {
            // Redirect to the patient details page or show a success message
            echo "<script>alert('Patient registered successfully.'); window.location.href='receppatdet.php';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Close the database connection
$conn->close();
?>
