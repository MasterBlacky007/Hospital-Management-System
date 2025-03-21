<?php
// Include the database connection
include 'conf.php';

if (isset($_GET['id'])) {
    $vitalId = mysqli_real_escape_string($conn, $_GET['id']);

    // Query to fetch the vital sign details
    $query = "SELECT * FROM vital_signs WHERE vitalId = '$vitalId'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $vitalSign = mysqli_fetch_assoc($result);
    } else {
        echo "<script>alert('Vital sign record not found!'); window.location.href = 'vitaltable.php';</script>";
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
    <title>Vital Sign Details</title>
    <link rel="stylesheet" href="formview.css">
</head>
<body>
    <div class="container">
        <h3>Vital Sign Details</h3>
        <?php if (isset($vitalSign)): ?>
            <p><strong>Vital Sign ID:</strong> <?php echo $vitalSign['vitalId']; ?></p>
            <p><strong>Patient Name:</strong> <?php echo $vitalSign['patientName']; ?></p>
            <p><strong>Contact No:</strong> <?php echo $vitalSign['contact_no']; ?></p>
            <p><strong>Blood Pressure:</strong> <?php echo $vitalSign['bloodp']; ?></p>
            <p><strong>Height (cm):</strong> <?php echo $vitalSign['height']; ?></p>
            <p><strong>Weight (kg):</strong> <?php echo $vitalSign['weight']; ?></p>
            <p><strong>BMI:</strong> <?php echo $vitalSign['bmi']; ?></p>
            <p><strong>Staff ID:</strong> <?php echo $vitalSign['staffid']; ?></p>
            <p><strong>Staff Name:</strong> <?php echo $vitalSign['staffname']; ?></p>
        <?php endif; ?>
        <button class="back-button" onclick="window.history.back()">Back to Results</button>
    </div>
</body>
</html>
