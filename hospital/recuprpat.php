<?php
// Database connection
include "conf.php";

// Check if the ID is passed via GET
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch patient details
    $sql = "SELECT * FROM patientprofile WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $patient = $result->fetch_assoc();
    } else {
        echo "Patient not found.";
        exit();
    }
} else {
    echo "No patient ID provided.";
    exit();
}

// Update patient details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $dob = $_POST['dob'];
    $nic = $_POST['nic'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $special_notes = $_POST['special_notes'];

    $sql = "UPDATE patientprofile SET firstname = ?, lastname = ?, gender = ?, age = ?, dob = ?, nic = ?, contact = ?, address = ?, email = ?, special_notes = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssssi", $firstname, $lastname, $gender, $age, $dob, $nic, $contact, $address, $email, $special_notes, $id);

    if ($stmt->execute()) {
        echo "<script>
            alert('Patient updated successfully!');
            window.location.href = 'recviewrpat.php';
        </script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Patient-Mount Apollo Hospital</title>
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
        <h1>Update Patient Profile</h1>
        <div class="form-container">

            <form action="" method="POST">
                <!-- Hidden field for patient ID -->
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">

                <div class="form-row">
                    <label for="firstname">First Name:</label>
                    <input type="text" id="firstname" name="firstname" value="<?php echo htmlspecialchars($patient['firstname']); ?>" required>
                </div>
                <div class="form-row">
                    <label for="lastname">Last Name:</label>
                    <input type="text" id="lastname" name="lastname" value="<?php echo htmlspecialchars($patient['lastname']); ?>" required>
                </div>
                <div class="form-row">
                    <label for="gender">Gender:</label>
                    <select id="gender" name="gender" required>
                        <option value="Male" <?php echo $patient['gender'] === 'Male' ? 'selected' : ''; ?>>Male</option>
                        <option value="Female" <?php echo $patient['gender'] === 'Female' ? 'selected' : ''; ?>>Female</option>
                    </select>
                </div>
                <div class="form-row">
                    <label for="age">Age:</label>
                    <input type="number" id="age" name="age" value="<?php echo htmlspecialchars($patient['age']); ?>" required>
                </div>
                <div class="form-row">
                    <label for="dob">Date of Birth:</label>
                    <input type="date" id="dob" name="dob" value="<?php echo htmlspecialchars($patient['dob']); ?>" required>
                </div>
                <div class="form-row">
                    <label for="nic">NIC:</label>
                    <input type="text" id="nic" name="nic" value="<?php echo htmlspecialchars($patient['nic']); ?>" required>
                </div>
                <div class="form-row">
                    <label for="contact">Mobile No:</label>
                    <input type="text" id="contact" name="contact" value="<?php echo htmlspecialchars($patient['contact']); ?>" required>
                </div>
                <div class="form-row">
                    <label for="address">Address:</label>
                    <textarea id="address" name="address" required><?php echo htmlspecialchars($patient['address']); ?></textarea>
                </div>
                <div class="form-row">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($patient['email']); ?>" required>
                </div>
                <div class="form-row">
                    <label for="special_notes">Special Notes:</label>
                    <textarea id="special_notes" name="special_notes"><?php echo htmlspecialchars($patient['special_notes']); ?></textarea>
                </div>
                <div class="form-row">
                    <button type="submit" class="form-btn">Update Patient Profile</button>
                    <button type="button" class="form-btn" onclick="window.location.href='recviewrpat.php'">Cancel</button>
                </div>
            </form>

        </div>
    </div>
</div>
</body>
</html>


<?php
$conn->close();
?>
