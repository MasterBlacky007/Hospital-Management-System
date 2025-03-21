<?php
// Include database connection
include "conf.php";

// Initialize variables
$request_id = "";
$patientName = "";
$contact = "";
$testType = "";

// Fetch the lab request details when the page is loaded with the request ID
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $request_id = $_GET['id'];

    // Prepare and execute SQL query to fetch the record
    $sql = "SELECT * FROM lab_requests WHERE request_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $request_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // If record exists, populate the form fields
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $patientName = $row['patient_name'];
            $contact = $row['contact'];
            $testType = $row['test_type'];
        } else {
            echo "<script>alert('No record found!'); window.location.href='viewlabreq.php';</script>";
            exit;
        }
    } else {
        echo "Error preparing statement: " . $conn->error;
        exit;
    }
}

// Handle form submission to update the lab request record
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $request_id = $_POST['request_id'];
    $patientName = $_POST['patientName'];
    $contact = $_POST['contact'];
    $testType = $_POST['testType'];

    // Prepare and execute SQL query to update the record
    $sql = "UPDATE lab_requests SET patient_name = ?, contact = ?, test_type = ? WHERE request_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sssi", $patientName, $contact, $testType, $request_id);

        // Check if the update is successful
        if ($stmt->execute()) {
            echo "<script>
                    alert('Lab request updated successfully!');
                    window.location.href = 'viewlabreq.php'; // Redirect after successful update
                  </script>";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
}

// Close the connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Lab Request</title>
    <link rel="stylesheet" href="dashboard1.css"> 
</head>
<body>
<div class="container">
        <div class="sidebar">
            <div class="logo">
                <img src="logo.jpeg" alt="Hospital Logo">
                <h2>Apollo Hospital</h2>
            </div>
            <h1>Doctor</h1>
        
            <a href="doctordash.html">Dashboard</a>
                    <a href="docprofile.php">My Profile</a>
                    <a href="docviewptprofile.php">Patient Profile</a>
                    <a href="presdash.php">Prescription</a>
                    <a href="labdash.php">Lab Test</a>
                    <a href="docappointment.php">Appointment</a>
                    <a href="taskdash.php">Task</a>
                    <a href="viewdprogress.php">View Progress Notes</a>
                    <a href="stlogin.html">Log Out</a>
        </div>

    <div class="main-content">
        <h1>Edit Lab Request</h1>
        <div class="form-container">

            <form action="editlabreq.php" method="POST">
                <!-- Hidden field for request ID -->
                <input type="hidden" name="request_id" value="<?php echo htmlspecialchars($request_id); ?>">

                <div class="form-row">
                    <label for="patientName">Patient Name:</label>
                    <input type="text" id="patientName" name="patientName" value="<?php echo htmlspecialchars($patientName); ?>" required>
                </div>
                <div class="form-row">
                    <label for="contact">Contact No:</label>
                    <input type="text" id="contact" name="contact" value="<?php echo htmlspecialchars($contact); ?>" required>
                </div>
                <div class="form-row">
                    <label for="testType">Test Type:</label>
                    <input type="text" id="testType" name="testType" value="<?php echo htmlspecialchars($testType); ?>" required>
                </div>
                <div class="form-row">
                    <button type="submit" class="form-btn">Update Request</button>
                    
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
