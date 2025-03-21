<?php
// Database connection
include "conf.php";

// Start session for user authentication
session_start();

// Check if the user is logged in (using patient email in session)
if (!isset($_SESSION['email'])) {
    // Redirect to login page if not logged in
    header("Location: plogin.php");
    exit();
}

// Get the prescription ID from the URL
$prescription_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($prescription_id === 0) {
    echo "Invalid prescription ID.";
    exit();
}

// Fetch patient ID from the patient_profile table based on email
$patient_email = $_SESSION['email'];
$sql_patient = "SELECT id FROM patientprofile WHERE email = ?";
$stmt = $conn->prepare($sql_patient);
$stmt->bind_param("s", $patient_email);
$stmt->execute();
$result_patient = $stmt->get_result();
$patient_data = $result_patient->fetch_assoc();

if (!$patient_data) {
    echo "Patient not found.";
    exit();
}

// Get the patient ID
$patient_id = $patient_data['id'];

// Fetching prescription details for the logged-in patient
$sql_prescription = "
    SELECT p.id, p.patient_name, p.contact_no, p.date, p.diagnosis,p.additional_notes
    FROM prescriptions p
    WHERE p.id = ? AND p.id = ?";

$stmt_prescription = $conn->prepare($sql_prescription);
$stmt_prescription->bind_param("ii", $prescription_id, $patient_id);
$stmt_prescription->execute();
$result_prescription = $stmt_prescription->get_result();

if ($result_prescription->num_rows === 0) {
    echo "Prescription not found.";
    exit();
}

$prescription = $result_prescription->fetch_assoc();

// Fetch drugs associated with the prescription
$sql_drugs = "
    SELECT drug_name, dosage,instructions
    FROM prescription_drugs
    WHERE prescription_id = ?";

$stmt_drugs = $conn->prepare($sql_drugs);
$stmt_drugs->bind_param("i", $prescription_id);
$stmt_drugs->execute();
$result_drugs = $stmt_drugs->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prescription Details</title>
    <link rel="stylesheet" href="printview1.css">
    <script>
        function goBack() {
            window.history.back();  // Go back to the previous page
        }
    </script>
</head>
<body>

<div class="container">
    <h1>Prescription Details</h1>

    <div>
        <h3>Patient Name: <?php echo htmlspecialchars($prescription['patient_name']); ?></h3>
        <p><strong>Contact No:</strong> <?php echo htmlspecialchars($prescription['contact_no']); ?></p>
        <p><strong>Date:</strong> <?php echo htmlspecialchars($prescription['date']); ?></p>
        <p><strong>Diagnosis:</strong> <?php echo htmlspecialchars($prescription['diagnosis']); ?></p>
        
        <p><strong>Additional Notes:</strong> <?php echo htmlspecialchars($prescription['additional_notes']); ?></p>
    </div>

    <h3>Drugs</h3>
    <table border="1">
        <thead>
            <tr>
                <th>Drug Name</th>
                <th>Dosage</th>
                <th>Instructions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result_drugs->num_rows > 0): ?>
                <?php while ($drug = $result_drugs->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($drug['drug_name']); ?></td>
                        <td><?php echo htmlspecialchars($drug['dosage']); ?></td>
                        <td><?php echo htmlspecialchars($drug['instructions']); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="2">No drugs associated with this prescription.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <br>
    <button onclick="goBack()">Back</button>
</div>

</body>
</html>
