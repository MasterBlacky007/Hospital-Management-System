<?php
// Include database connection
include('conf.php');

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$prescriptionData = [];
$errorMessage = "";

// Step 1: Search for Prescription Details
if (isset($_POST['search_prescription'])) {
    // Get the search criteria from the form
    $contact_no = mysqli_real_escape_string($conn, $_POST['contact_no']);
    $patient_name = mysqli_real_escape_string($conn, $_POST['patient_name']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);

    // Query to fetch the prescription details
    $query = "SELECT * FROM prescriptions WHERE contact_no = '$contact_no' AND patient_name = '$patient_name' AND date = '$date'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        // Fetch prescription details
        $prescriptionData = mysqli_fetch_assoc($result);
        
        // Fetch the drug details associated with this prescription
        $drugQuery = "SELECT * FROM prescription_drugs WHERE prescription_id = " . $prescriptionData['id'];
        $drugResult = mysqli_query($conn, $drugQuery);
        $prescriptionData['drugs'] = mysqli_fetch_all($drugResult, MYSQLI_ASSOC);
    } else {
        $errorMessage = "No prescription found for this contact number, patient name, and date!";
    }
}

// Step 2: Delete Prescription
if (isset($_POST['delete_prescription'])) {
    $contact_no = mysqli_real_escape_string($conn, $_POST['contact_no']);
    $patient_name = mysqli_real_escape_string($conn, $_POST['patient_name']);

    // Query to delete the drugs associated with the prescription
    $deleteDrugsQuery = "DELETE FROM prescription_drugs WHERE prescription_id IN (SELECT id FROM prescriptions WHERE contact_no = '$contact_no' AND patient_name = '$patient_name')";
    mysqli_query($conn, $deleteDrugsQuery);

    // Query to delete the main prescription
    $deletePrescriptionQuery = "DELETE FROM prescriptions WHERE contact_no = '$contact_no' AND patient_name = '$patient_name'";
    if (mysqli_query($conn, $deletePrescriptionQuery)) {
        echo "<script>
            alert('Prescription deleted successfully!');
            window.location.href = 'presdash.php'; 
        </script>";
        exit;
    } else {
        echo "Error deleting prescription: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Prescription</title>
    <link rel="stylesheet" href="style1.css">

    <script>
        function confirmDelete() {
            return confirm('Are you sure you want to delete this prescription?');
        }
    </script>
</head>
<body>
    <div class="form-container">
        <div class="sidebar">
            <div class="logo">
                <img src="logo.jpeg" alt="Hospital Logo">
                <h2>Apollo Hospital</h2>
            </div>
            <h1>Doctor</h1>
            <nav>
            <a href="doctordash.html">Dashboard</a>
                    <a href="docprofile.php">My Profile</a>
                    <a href="docviewptprofile.php">Patient Profile</a>
                    <a href="presdash.php">Prescription</a>
                    <a href="labdash.php">Lab Test</a>
                    <a href="docappointment.php">Appointment</a>
                    <a href="taskdash.php">Task</a>
                    <a href="viewdprogress.php">View Progress Notes</a>
                    <a href="stlogin.html">Log Out</a>
            </nav>
        </div>

        <div class="main-content">
            <h1>Delete Prescription</h1>
            
            <!-- Search Prescription Form -->
            <form action="deleteprescriptions.php" method="POST">
                <div class="form-row">
                    <label for="contact_no">Enter Contact Number:</label>
                    <input type="text" id="contact_no" name="contact_no" required>
                </div>
                <div class="form-row">
                    <label for="patient_name">Enter Patient Name:</label>
                    <input type="text" id="patient_name" name="patient_name" required>
                </div>
                <div class="form-row">
                    <label for="date">Enter Date:</label>
                    <input type="date" id="date" name="date" required>
                </div>
                <div class="form-row">
                    <button type="submit" name="search_prescription" class="form-btn">Load Prescription Details</button>
                </div>
            </form>

            <?php if (!empty($prescriptionData)): ?>
                <h3>Prescription Details</h3>
                <p><strong>Contact No:</strong> <?= $prescriptionData['contact_no'] ?></p>
                <p><strong>Patient Name:</strong> <?= $prescriptionData['patient_name'] ?></p>
                <p><strong>Diagnosis:</strong> <?= $prescriptionData['diagnosis'] ?></p>

                <h4>Prescribed Drugs:</h4>
                <table class="drug-table">
                    <thead>
                        <tr>
                            <th>Drug Name</th>
                            <th>Dosage</th>
                            <th>Duration</th>
                            <th>Instructions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($prescriptionData['drugs'] as $drug): ?>
                            <tr>
                                <td><?= $drug['drug_name'] ?></td>
                                <td><?= $drug['dosage'] ?></td>
                                <td><?= $drug['duration'] ?></td>
                                <td><?= $drug['instructions'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <form action="deleteprescriptions.php" method="POST" onsubmit="return confirmDelete();">
                    <input type="hidden" name="contact_no" value="<?= $prescriptionData['contact_no'] ?>">
                    <input type="hidden" name="patient_name" value="<?= $prescriptionData['patient_name'] ?>">
                    <button type="submit" name="delete_prescription" class="form-btn">Delete Prescription</button>
                </form>
            <?php endif; ?>

            <?php if (!empty($errorMessage)): ?>
                <p class="error-message"><?= $errorMessage ?></p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
