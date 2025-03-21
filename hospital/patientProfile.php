<?php
// Connect to the database
include "conf.php";

// Get form data
$nic = $_POST['nic'];
$email = $_POST['email'];
$password = $_POST['password'];
$special_notes = $_POST['special_notes'];
$contact = $_POST['contact'];  // Added contact number input

if ($nic && $email && $password && $contact) {
    // Check if a profile already exists with the same NIC or contact number
    $stmt = $conn->prepare("SELECT id FROM patientprofile WHERE nic = ? OR contact = ?");
    $stmt->bind_param("ss", $nic, $contact);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('A profile already exists with this NIC or contact number.');window.location.href = 'patientProfile.html';</script>";
    } else {
        // Fetch the patient ID using the NIC
        $stmt = $conn->prepare("SELECT id, firstName, lastName, gender, age, dob, address, contact FROM patient WHERE nic = ?");
        $stmt->bind_param("s", $nic);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $patient = $result->fetch_assoc();
            $reg_id = $patient['id'];

            // Insert data into the patientprofile table
            $stmt = $conn->prepare("
                INSERT INTO patientprofile (
                    reg_id, firstname, lastname, gender, age, dob, nic, contact, address, email, password, special_notes
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->bind_param(
                "isssisssssss",
                $reg_id,
                $patient['firstName'],
                $patient['lastName'],
                $patient['gender'],
                $patient['age'],
                $patient['dob'],
                $nic,
                $contact,
                $patient['address'],
                $email,
                $password,
                $special_notes
            );

            if ($stmt->execute()) {
                echo "<script>alert('Patient profile saved successfully!');window.location.href = 'patientProfile.html';</script>";
            } else {
                echo "<script>alert('Error: " . $stmt->error . "');</script>";
            }

            $stmt->close();
        } else {
            echo "<script>alert('No patient found with this NIC.');window.location.href = 'patientProfile.html';</script>";
        }
    }

    $stmt->close();
} else {
    echo "<script>alert('Please fill out all required fields.');window.location.href = 'patientProfile.html';</script>";
}

$conn->close();
?>
