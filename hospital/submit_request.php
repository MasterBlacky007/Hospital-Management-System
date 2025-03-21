<?php
// Database connection
include "conf.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $patientName = $_POST['patientName'];
    $contact = $_POST['contact'];
    $testType = $_POST['testType'];
    $status = $_POST['status'];

    // Validate input
    if (empty($patientName) || empty($contact) || empty($testType)) {
        echo "All fields are required!";
        exit;
    }

    // Insert data into the database
    $sql = "INSERT INTO lab_requests (patient_name, contact, test_type, request_date, status)
            VALUES ('$patientName', '$contact', '$testType', NOW(), '$status')";

    if ($conn->query($sql) === TRUE) {
        // Redirect to a success page
        echo "<script>
                alert('Lab request submitted successfully!');
                window.location.href = 'labdash.php'; // Redirect to Lab Dashboard or another page
              </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the connection
$conn->close();
?>
