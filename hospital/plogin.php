<?php
// Start session to manage login state
session_start();
include "conf.php";

// Get the submitted email and password
$email = $_POST['email'];
$password = $_POST['password'];

// Prepare SQL query to check if the email and password match in the patientprofile table
$sql = "SELECT id, email, contact FROM patientprofile WHERE email = ? AND password = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo "Error preparing statement: " . $conn->error;
    exit();
}

$stmt->bind_param("ss", $email, $password);
$stmt->execute();
$result = $stmt->get_result();

// Check if any row matches the email and password
if ($result->num_rows > 0) {
    // Fetch the user data
    $user = $result->fetch_assoc();

    // Store the email, patient ID, and contact number in session
    $_SESSION['email'] = $user['email'];
    $_SESSION['patient_id'] = $user['id'];
    $_SESSION['contact_number'] = $user['contact'];

    // Redirect to patient dashboard
    header("Location: patientdash.html");
    exit();
} else {
    // If login fails, display an error message
    echo "<script>alert('Invalid email or password.'); window.location.href = 'plogin.html';</script>";
}

// Close the database connection
$stmt->close();
$conn->close();
?>
