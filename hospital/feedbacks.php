<?php
session_start(); // Start the session to store messages

// Database connection settings
include "conf.php";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and escape form input to prevent SQL injection
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $message = $conn->real_escape_string($_POST['message']);

    // SQL query to insert the feedback into the database
    $sql = "INSERT INTO feedback (name, email, message) VALUES ('$name', '$email', '$message')";

    // Execute the query and check if it was successful
    if ($conn->query($sql) === TRUE) {
        // On successful submission, set session variables
        $_SESSION['feedback_message'] = "Feedback submitted successfully!";
        $_SESSION['feedback_status'] = 'success';
    } else {
        // On error, set session variables for error
        $_SESSION['feedback_message'] = "There was an error submitting your feedback. Please try again.";
        $_SESSION['feedback_status'] = 'error';
    }

    // Redirect back to the feedback form
    header("Location: feedback.php");
    exit();
}

// Close the database connection
$conn->close();
?>
