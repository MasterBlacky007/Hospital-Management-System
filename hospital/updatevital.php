<?php
// Include database connection
include 'conf.php';

// Check if the ID is provided in the URL
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']); // Sanitize input

    // Fetch the existing record from the database
    $sql = "SELECT * FROM vital_signs WHERE vitalId = $id";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        echo "<script>alert('Record not found!'); window.location.href = 'view_vital.php';</script>";
        exit;
    }

    // Update logic when the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
        $patient_name = mysqli_real_escape_string($conn, $_POST['patient_name']);
        $contact_no = mysqli_real_escape_string($conn, $_POST['contactNo']);
        $bp = mysqli_real_escape_string($conn, $_POST['bp']);
        $height = mysqli_real_escape_string($conn, $_POST['height']);
        $weight = mysqli_real_escape_string($conn, $_POST['weight']);
        $bmi = 0;

        // Validate height and weight before calculating BMI
        if ($height > 0 && $weight > 0) {
            $bmi = round($weight / (($height / 100) * ($height / 100)), 2);
        }

        // Update query
        $update_sql = "UPDATE vital_signs 
                       SET patientName = '$patient_name', 
                           contact_no = '$contact_no', 
                           bloodp = '$bp', 
                           height = '$height', 
                           weight = '$weight', 
                           bmi = '$bmi' 
                       WHERE vitalId = $id";

        if (mysqli_query($conn, $update_sql)) {
            echo "<script>alert('Record updated successfully!'); window.location.href = 'vitaltable.php';</script>";
        } else {
            echo "<script>alert('Error updating record: " . mysqli_error($conn) . "');</script>";
        }
    }
} else {
    echo "<script>alert('No ID provided!'); window.location.href = 'view_vital.php';</script>";
    exit;
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Vital Signs</title>
    <link rel="stylesheet" href="vupdate.css">
</head>
<body>
    <div class="container">
        <h3>Update Vital Signs</h3>
        <button class="back" onclick="window.location.href='view_vital.php'">Back to List</button>

        <div class="main-content">
            <form action="updatevital.php?id=<?php echo $id; ?>" method="POST">
                <input type="hidden" name="action" value="update">

                <!-- Patient Name -->
                <label for="patient_name">Patient Name</label>
                <input type="text" id="patient_name" name="patient_name" 
                       value="<?php echo htmlspecialchars($row['patientName']); ?>" required>

                <!-- Contact No -->
                <label for="contactNo">Contact No</label>
                <input type="text" id="contactNo" name="contactNo" 
                       value="<?php echo htmlspecialchars($row['contact_no']); ?>" required>

                <!-- Blood Pressure -->
                <label for="bp">Blood Pressure</label>
                <input type="text" id="bp" name="bp" 
                       value="<?php echo htmlspecialchars($row['bloodp']); ?>" required>

                <!-- Height -->
                <label for="height">Height (cm)</label>
                <input type="number" id="height" name="height" step="0.01" 
                       value="<?php echo htmlspecialchars($row['height']); ?>" required>

                <!-- Weight -->
                <label for="weight">Weight (kg)</label>
                <input type="number" id="weight" name="weight" step="0.01" 
                       value="<?php echo htmlspecialchars($row['weight']); ?>" required>

                <!-- Submit Button -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-update" name="action" value="update">Update</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
