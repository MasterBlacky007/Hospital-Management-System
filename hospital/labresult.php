<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve common form data
    $patientMail = $_POST['patientMail'];
    $contact = $_POST['contact'];
    $patientName = $_POST['patientName'];
    $testType = $_POST['testType'];

    // Database connection
  include "conf.php";

    if (isset($_FILES['testFile']) && $_FILES['testFile']['error'] == UPLOAD_ERR_OK) {
        // Handle file upload
        $uploadDir = "uploads/";
        $fileName = basename($_FILES['testFile']['name']);
        $targetFilePath = $uploadDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        // Allowed file types
        $allowedTypes = ['doc', 'docx'];
        if (in_array($fileType, $allowedTypes)) {
            // Upload the file
            if (move_uploaded_file($_FILES['testFile']['tmp_name'], $targetFilePath)) {
                // Insert file details into database
                $sql = "INSERT INTO lab_test_results (mail,patientName, contact, testType, filePath) 
                        VALUES ('$patientMail','$patientName', '$contact','$testType', '$targetFilePath')";

                if ($conn->query($sql) === TRUE) {
                    echo "<script>alert('File uploaded and data saved successfully.'); window.location.href = 'labtestresult.html';</script>";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                echo "File upload failed.";
            }
        } else {
            echo "Invalid file type. Only .doc and .docx files are allowed.";
        }
    } else {
        // Handle manual entry
        $testDate = $_POST['testDate'];
        $resultDetails = $_POST['resultDetails'];

        // Insert manual entry data into database
        $sql = "INSERT INTO lab_test_results (mail, patientName, contact, testType, testDate, resultDetails) 
                VALUES ('$$patientMail','$patientName', '$contact','$testType', '$testDate', '$resultDetails')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Lab test details saved successfully.');window.location.href = 'labtestresult.html';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Close the database connection
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
