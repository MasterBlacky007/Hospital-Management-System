<?php
// Include database configuration file
include "conf.php";

// Admission class to manage admission operations
class Admission {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    // Fetch admission details by ID
    public function getAdmissionById($id) {
        $sql = "SELECT * FROM admissions WHERE admission_id = ?";
        if ($stmt = $this->conn->prepare($sql)) {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $admission = $result->fetch_assoc();
            $stmt->close();
            return $admission;
        }
        return null;
    }

    // Update admission details
    public function updateAdmission($id, $reason, $roomNumber, $admit_date, $discharge_date, $patient_name, $contact_number) {
        $sql = "UPDATE admissions 
                SET reason = ?, roomNumber = ?, admit_date = ?, discharge_date = ?, patient_name = ?, contact_number = ? 
                WHERE admission_id = ?";

        if ($stmt = $this->conn->prepare($sql)) {
            $stmt->bind_param("ssssssi", $reason, $roomNumber, $admit_date, $discharge_date, $patient_name, $contact_number, $id);
            $success = $stmt->execute();
            $stmt->close();
            return $success;
        }
        return false;
    }
}

// Initialize variables
$successMessage = "";
$errorMessage = "";
$admission = null;

// Create Admission object
$admissionObj = new Admission($conn);

// Fetch admission details if ID is provided in URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $admission = $admissionObj->getAdmissionById($id);

    if (!$admission) {
        $errorMessage = "No admission found with the specified ID.";
    }
} else {
    $errorMessage = "Invalid request. No ID specified.";
}

// Handle form submission for updating the admission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['admission_id'];
    $reason = $_POST['reason'];
    $roomNumber = $_POST['roomNumber'];
    $admit_date = $_POST['admit_date'];
    $discharge_date = $_POST['discharge_date'];
    $patient_name = $_POST['patient_name'];
    $contact_number = $_POST['contact_number'];

    if ($admissionObj->updateAdmission($id, $reason, $roomNumber, $admit_date, $discharge_date, $patient_name, $contact_number)) {
        echo "<script>alert('Admission updated successfully!'); window.location.href='view_discharge.php';</script>";
        exit;
    } else {
        $errorMessage = "Error updating admission.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Admission</title>
    <link rel="stylesheet" href="Nurseadd.css">
</head>
<body>
    <div class="container">
        <h2>Update Admission</h2>

        <?php if ($errorMessage): ?>
            <div class="alert alert-error">
                <?= htmlspecialchars($errorMessage); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($admission)): ?>
            <form method="POST" action="">
                <input type="hidden" name="admission_id" value="<?= htmlspecialchars($admission['admission_id']); ?>">

                <label for="reason">Reason:</label>
                <input type="text" id="reason" name="reason" value="<?= htmlspecialchars($admission['reason']); ?>" required>

                <label for="roomNumber">Room Number:</label>
                <input type="text" id="roomNumber" name="roomNumber" value="<?= htmlspecialchars($admission['roomNumber']); ?>" required>

                <label for="admit_date">Admit Date:</label>
                <input type="date" id="admit_date" name="admit_date" value="<?= htmlspecialchars($admission['admit_date']); ?>" required>

                <label for="discharge_date">Discharge Date:</label>
                <input type="date" id="discharge_date" name="discharge_date" value="<?= htmlspecialchars($admission['discharge_date']); ?>">

                <label for="patient_name">Patient Name:</label>
                <input type="text" id="patient_name" name="patient_name" value="<?= htmlspecialchars($admission['patient_name']); ?>" required>

                <label for="contact_number">Contact Number:</label>
                <input type="text" id="contact_number" name="contact_number" value="<?= htmlspecialchars($admission['contact_number']); ?>" required>

                <button type="submit">Update</button>
                <button type="button" onclick="window.location.href='view_discharge.php'">Cancel</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
