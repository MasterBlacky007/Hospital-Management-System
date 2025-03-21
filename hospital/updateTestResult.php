<?php
// Database connection
include "conf.php";

// Fetch the current test result details
if (isset($_GET['id'])) {
    $testID = $_GET['id'];
    $sql = "SELECT * FROM lab_test_results WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $testID);
    $stmt->execute();
    $result = $stmt->get_result();
    $testData = $result->fetch_assoc();
} else {
    echo "Test ID not provided.";
    exit;
}

// Handle form submission for updates
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patientName = $_POST['patientName'];
    $contact = $_POST['contact'];
    $mail = $_POST['mail'];
    $testType = $_POST['testType'];
    $testDate = $_POST['testDate'];
    $resultDetails = $_POST['resultDetails'];
    $filePath = $_FILES['filePath']['name'];

    // Handle file upload if a new file is provided
    if (!empty($filePath)) {
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($_FILES['filePath']['name']);
        move_uploaded_file($_FILES['filePath']['tmp_name'], $targetFile);
    } else {
        // Retain the existing file path if no new file is uploaded
        $filePath = $testData['filePath'];
    }

    // Update the database
    $updateSql = "UPDATE lab_test_results 
                  SET patientName = ?, contact = ?, mail = ?, testType = ?, testDate = ?, resultDetails = ?, filePath = ? 
                  WHERE id = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("sssssssi", $patientName, $contact, $mail, $testType, $testDate, $resultDetails, $filePath, $testID);

    if ($updateStmt->execute()) {
        echo "<script>alert('Test result updated successfully.');window.location.href = 'viewlabtest.php';</script>";
       
        exit;
    } else {
        echo "Error updating test result: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Test Result</title>
    <link rel="stylesheet" href="form.css">
</head>
<body>
    <div class="container">
        <h3>Update Test Result</h3>
        <form action="updateTestResult.php?id=<?php echo $testID; ?>" method="POST" enctype="multipart/form-data">
            <label for="patientName">Patient Name:</label>
            <input type="text" id="patientName" name="patientName" value="<?php echo $testData['patientName']; ?>" required>

            <label for="contact">Contact:</label>
            <input type="text" id="contact" name="contact" value="<?php echo $testData['contact']; ?>" required>

            <label for="mail">Email:</label>
            <input type="email" id="mail" name="mail" value="<?php echo $testData['mail']; ?>" required>

            <label for="testType">Test Type:</label>
            <input type="text" id="testType" name="testType" value="<?php echo $testData['testType']; ?>" required>

            <label for="testDate">Test Date:</label>
            <input type="date" id="testDate" name="testDate" value="<?php echo $testData['testDate']; ?>">

            <label for="resultDetails">Result Details:</label>
            <textarea id="resultDetails" name="resultDetails"><?php echo $testData['resultDetails']; ?></textarea>

            <label for="filePath">Upload File (optional):</label>
            <input type="file" id="filePath" name="filePath">
            <p>Current File: <?php echo $testData['filePath'] ? "<a href='" . $testData['filePath'] . "' target='_blank'>View File</a>" : "None"; ?></p>

            <button type="submit">Update</button>
            <button type="button" onclick="window.location.href='labTestResults.php'">Cancel</button>
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
?>
