<?php
// Database connection
include('conf.php');

// Check if patientID is provided
if (isset($_GET['patientID'])) {
    $patientID = $_GET['patientID'];

    // Sanitize input to prevent SQL injection
    $patientID = mysqli_real_escape_string($conn, $patientID);

    // Query to fetch patient details
    $query = "SELECT firstName, lastName, Address, contact FROM patient WHERE id = '$patientID' LIMIT 1";

    // Execute the query
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        // Fetch the patient data
        $patient = mysqli_fetch_assoc($result);

        // Send data as JSON
        echo json_encode([
            'firstName' => $patient['firstName'],
            'lastName' => $patient['lastName'],
            'address' => $patient['Address'],
            'contact' => $patient['contact']
        ]);
    } else {
        // Return error if no patient is found
        echo json_encode(['error' => 'Patient not found']);
    }
} else {
    // Return error if patientID is not provided
    echo json_encode(['error' => 'No patient ID provided']);
}

// Close the database connection
mysqli_close($conn);
?>
