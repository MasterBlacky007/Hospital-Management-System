<?php
// Include database connection
include('conf.php');

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    
    $admission_reason = $_POST['admission_reason'];
    $room_number = $_POST['room_number'];
    $admit_date = $_POST['admit_date'];
    $discharge_date = $_POST['discharge_date'];
    $patient_name = $_POST['patient_name'];
    $contact_number = $_POST['contact_number'];

    // Validate input (basic validation)
    if ( empty($admission_reason) || empty($room_number) || empty($admit_date) || empty($discharge_date) || empty($patient_name) || empty($contact_number)) {
        echo "<script>alert('All fields are required.');</script>";
    } else {
        // Prepare SQL query to insert data into the database
        $query = "INSERT INTO admissions (reason, roomNumber, admit_date, discharge_date, patient_name, contact_number) 
                  VALUES ('$admission_reason', '$room_number', '$admit_date', '$discharge_date', '$patient_name', '$contact_number')";

        // Execute query
        if (mysqli_query($conn, $query)) {
            echo "<script>
            alert('Admission added successfully!');
            window.location.href = 'addmission.html'; 
        </script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}

// Close the database connection
mysqli_close($conn);
?>
