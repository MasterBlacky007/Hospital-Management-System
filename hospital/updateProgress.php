<?php
// Include database connection
include 'conf.php';

// Check if ID is provided in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the existing record from the database
    $sql = "SELECT * FROM progressnotes WHERE progressNId = $id";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        echo "<script>alert('Record not found!')</script>";
        exit;
    }

    // Update logic when form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
        $patient_name = mysqli_real_escape_string($conn, $_POST['patient_name']);
        $contact_no = mysqli_real_escape_string($conn, $_POST['contactNo']);
        $dob = mysqli_real_escape_string($conn, $_POST['dob']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $chief_complaint = mysqli_real_escape_string($conn, $_POST['chief_complaint']);
        $assessment = mysqli_real_escape_string($conn, $_POST['assessment']);
        $plan = mysqli_real_escape_string($conn, $_POST['plan']);
        $diagnosis = mysqli_real_escape_string($conn, $_POST['diagnosis']);
        $staff_name = mysqli_real_escape_string($conn, $_POST['staff_name']);

        // Update query
        $update_sql = "UPDATE progressnotes SET patientName = '$patient_name', contactNo = '$contact_no', dob = '$dob', 
                       email = '$email', c_complaint = '$chief_complaint', assessment = '$assessment', plan = '$plan',
                       diagnosis = '$diagnosis', staffName = '$staff_name' WHERE progressNId = $id";

        if (mysqli_query($conn, $update_sql)) {
            echo "<script>alert('Record updated successfully!'); window.location.href = 'viewprogresstable.php';</script>";
        } else {
            echo "<script>alert('Error updating record: " . mysqli_error($conn) . "');</script>";
        }
    }
} else {
    echo "No ID provided!";
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
    <title>Update Progress Note</title>
    <link rel="stylesheet" href="viewupdate.css">
</head>
<body>
    <div class="container">
        <h3>Update Progress Note</h3>
        <button class="back" onclick="window.location.href='viewprogresstable.php'">Back to List</button>

        <div class="main-content">
            <form action="updateprogress.php?id=<?php echo $id; ?>" method="POST">
                <input type="hidden" name="action" value="update">

                <label for="patient_name">Patient Name</label>
                <input type="text" id="patient_name" name="patient_name" value="<?php echo $row['patientName']; ?>" required>

                <label for="contactNo">Contact No</label>
                <input type="text" id="contactNo" name="contactNo" value="<?php echo $row['contactNo']; ?>" required>

                <label for="dob">Date of Birth</label>
                <input type="date" id="dob" name="dob" value="<?php echo $row['dob']; ?>" required>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo $row['email']; ?>" required>

                <label for="chief_complaint">Chief Complaint</label>
                <textarea id="chief_complaint" name="chief_complaint" required><?php echo $row['c_complaint']; ?></textarea>

                <label for="assessment">Assessment</label>
                <textarea id="assessment" name="assessment" required><?php echo $row['assessment']; ?></textarea>

                <label for="plan">Plan</label>
                <textarea id="plan" name="plan" required><?php echo $row['plan']; ?></textarea>

                <label for="diagnosis">Diagnosis</label>
                <textarea id="diagnosis" name="diagnosis" required><?php echo $row['diagnosis']; ?></textarea>

                <label for="staff_name">Staff Name</label>
                <input type="text" id="staff_name" name="staff_name" value="<?php echo $row['staffName']; ?>" required>

                <div class="form-actions">
                    <button type="submit" class="btn btn-update" name="action" value="update">Update</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
