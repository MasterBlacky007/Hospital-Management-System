<?php
// Include the database connection
include 'conf.php';

if (isset($_GET['id'])) {
    $progressId = mysqli_real_escape_string($conn, $_GET['id']);

    // Query to fetch  details
    $query = "SELECT * FROM progressnotes WHERE progressNId = '$progressId'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $progress = mysqli_fetch_assoc($result);
    } else {
        echo "<script>alert('Progress record not found!'); window.location.href = 'viewprogresstables.php';</script>";
    }
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progress Notes</title>
    <link rel="stylesheet" href="formview.css">
</head>
<body>
    <div class="container">
        <h3>Progress Note </h3>
        <?php if (isset($progress)): ?>
            <p><strong>Record ID:</strong> <?php echo $progress['progressNId']; ?></p>
            <p><strong>Patient Name:</strong> <?php echo $progress['patientName']; ?></p>
            <p><strong>Date of Birth:</strong> <?php echo $progress['dob']; ?></p>
            <p><strong>Email:</strong> <?php echo $progress['email']; ?></p>
            <p><strong>Contact No:</strong> <?php echo $progress['contactNo']; ?></p>
            <p><strong>Chief Complaint:</strong> <?php echo $progress['c_complaint']; ?></p>
            <p><strong>Assessment:</strong> <?php echo $progress['assessment']; ?></p>
            <p><strong>Plan:</strong> <?php echo $progress['plan']; ?></p>
            <p><strong>Diagnosis:</strong> <?php echo $progress['diagnosis']; ?></p>
            <p><strong>Added By:</strong> <?php echo $progress['staffName']; ?></p>
            <p><strong>Date:</strong> <?php echo $progress['date']; ?></p>
            <p><strong>Time:</strong> <?php echo $progress['time']; ?></p>
        <?php endif; ?>
        <button class="back-button" onclick="window.history.back()">Back to List</button>
        </div>
</body>
</html>
