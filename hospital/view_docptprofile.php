<?php
// Include database connection
include "conf.php";

// Check if 'profileid' is passed in the URL
if (isset($_GET['profileid'])) {
    $profileId = $_GET['profileid'];

    // Fetch patient details from the database
    $sql = "SELECT * FROM patientprofile WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $profileId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $patient = $result->fetch_assoc();
    } else {
        echo "Patient not found.";
        exit();
    }
} else {
    echo "No patient selected.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Patient Details</title>
    <link rel="stylesheet" href="formview.css">
</head>
<body>
    <div class="container">
        <h3>Patient Details</h3>
        <div class="patient-details">
            <p><strong>Profile ID:</strong> <?php echo htmlspecialchars($patient['id']); ?></p>
            <p><strong>First Name:</strong> <?php echo htmlspecialchars($patient['firstname']); ?></p>
            <p><strong>Last Name:</strong> <?php echo htmlspecialchars($patient['lastname']); ?></p>
            <p><strong>Gender:</strong> <?php echo htmlspecialchars($patient['gender']); ?></p>
            <p><strong>Age:</strong> <?php echo htmlspecialchars($patient['age']); ?></p>
            <p><strong>Date of Birth:</strong> <?php echo htmlspecialchars($patient['dob']); ?></p>
            <p><strong>NIC:</strong> <?php echo htmlspecialchars($patient['nic']); ?></p>
            <p><strong>Mobile No:</strong> <?php echo htmlspecialchars($patient['contact']); ?></p>
            <p><strong>Address:</strong> <?php echo htmlspecialchars($patient['address']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($patient['email']); ?></p>
            <p><strong>Special Notes:</strong> <?php echo htmlspecialchars($patient['special_notes']); ?></p>
        </div>
        <button class="back-button" onclick="window.location.href='docviewptprofile.php'">Back to Patient List</button>
    </div>
</body>
</html>

<?php
// Close database connection
$conn->close();
?>
