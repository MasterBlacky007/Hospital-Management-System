<?php
// Database connection
include "conf.php";

// Check if the patient ID is provided
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Fetch the patient's data
    $sql = "SELECT * FROM patient WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $patient = $result->fetch_assoc();

    if (!$patient) {
        die("Patient not found.");
    }
} else {
    die("No patient ID provided.");
}

// Handle form submission for updating the patient
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $dob = $_POST['dob'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $nic = $_POST['nic'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];

    // Update the patient's data in the database
    $updateSql = "UPDATE patient SET firstName = ?, lastName = ?, dob = ?, age = ?, gender = ?, nic = ?, address = ?, contact = ? WHERE id = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("ssssssssi", $firstName, $lastName, $dob, $age, $gender, $nic, $address, $contact, $id);

    if ($updateStmt->execute()) {
        echo "<script>alert('Patient updated successfully.'); window.location.href='recptreg.php';</script>";
    } else {
        echo "<script>alert('Error updating patient.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Patient - Mount Apollo Hospital</title>
    <link rel="stylesheet" href="dashboard1.css">
    <style>
        #gender {
            width: 100%;
            padding: 12px;
            border: 1px solid #1A4650;
            border-radius: 8px;
            font-size: 1rem;
            background-color: #EDF7F7;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="sidebar">
        <div class="logo">
            <img src="logo.jpeg" alt="Hospital Logo">
            <h2>Apollo Hospital</h2>
        </div>
        <h1>Receptionist</h1>
                    <a href="receptionistdashboard.html">Dashboard</a>
                    <a href="profilerec.php">My Profile</a>
                    <a href="patientRegister.html">Patient Registration</a>
                    <a href="patientprofile.html">Patient Profile</a>
                    <a href="receppatdet.php">Patient Details</a>
                    <a href="appointmentdash.php">Appointment</a>
                    <a href="visitordash.php">Visitors</a></li>
                    <a href="stlogin.html">Logout</a>
    </div>

    <div class="main-content">
        <h1>Update Patient</h1>
        <div class="form-container">
            <form method="POST">
                <!-- Hidden field for patient ID -->
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">

                <div class="form-row">
                    <label for="firstName">First Name:</label>
                    <input type="text" id="firstName" name="firstName" value="<?php echo htmlspecialchars($patient['firstName']); ?>" required>
                </div>
                <div class="form-row">
                    <label for="lastName">Last Name:</label>
                    <input type="text" id="lastName" name="lastName" value="<?php echo htmlspecialchars($patient['lastName']); ?>" required>
                </div>
                <div class="form-row">
                    <label for="dob">Date of Birth:</label>
                    <input type="date" id="dob" name="dob" value="<?php echo htmlspecialchars($patient['dob']); ?>" required>
                </div>
                <div class="form-row">
                    <label for="age">Age:</label>
                    <input type="number" id="age" name="age" value="<?php echo htmlspecialchars($patient['age']); ?>" required>
                </div>
                <div class="form-row">
                    <label for="gender">Gender:</label>
                    <select id="gender" name="gender" required>
                        <option value="Male" <?php echo $patient['gender'] === 'Male' ? 'selected' : ''; ?>>Male</option>
                        <option value="Female" <?php echo $patient['gender'] === 'Female' ? 'selected' : ''; ?>>Female</option>
                    </select>
                </div>
                <div class="form-row">
                    <label for="nic">NIC:</label>
                    <input type="text" id="nic" name="nic" value="<?php echo htmlspecialchars($patient['nic']); ?>" required>
                </div>
                <div class="form-row">
                    <label for="address">Address:</label>
                    <textarea id="address" name="address" required><?php echo htmlspecialchars($patient['address']); ?></textarea>
                </div>
                <div class="form-row">
                    <label for="contact">Mobile No:</label>
                    <input type="text" id="contact" name="contact" value="<?php echo htmlspecialchars($patient['contact']); ?>" required>
                </div>
                <div class="form-row">
                    <button type="submit" class="form-btn">Update Patient</button>
                    <button type="button" class="form-btn" onclick="window.location.href='viewtable.php'">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
