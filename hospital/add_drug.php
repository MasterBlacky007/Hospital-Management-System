<?php
// Database connection
include "conf.php";

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $drug_name = $conn->real_escape_string($_POST['drug_name']);
    $category = $conn->real_escape_string($_POST['category']);
    $dosage_form = $conn->real_escape_string($_POST['dosage_form']);
    $dosage = $conn->real_escape_string($_POST['dosage']);

    // Insert data into the database
    $sql = "INSERT INTO drugs (drug_name, category, dosage_form, dosage) 
            VALUES ('$drug_name', '$category', '$dosage_form', '$dosage')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Drug added successfully!'); window.location.href='drugdash.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close connection
$conn->close();
?>
