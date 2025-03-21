<?php
session_start();
include "conf.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Query to fetch user details
    $sql = "SELECT supplier_id, email, password FROM suppliers WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $supplier = $result->fetch_assoc();

        // Compare plain text password
        if ($password === $supplier['password']) {
            // Store supplier_id and email in session
            $_SESSION['supplier_id'] = $supplier['supplier_id'];
            $_SESSION['email'] = $supplier['email'];  // Add email to session
            header("Location: supplierdashboard.php");
            exit;
        } else {
            $_SESSION['error_message'] = "Invalid email or password.";
            header("Location: supplogin.php");
            exit;
        }
    } else {
        $_SESSION['error_message'] = "Invalid email or password.";
        header("Location: supplogin.php");
        exit;
    }
}

$conn->close();

?>
