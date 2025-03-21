<?php
// Database connection
include "conf.php";

// Check if 'prescriptionid' is passed in the URL
if (isset($_GET['prescriptionid'])) {
    $PrescriptionId = $_GET['prescriptionid'];

    // Fetch prescription details
    $sqlPrescription = "SELECT * FROM prescriptions WHERE id = ?";
    $stmtPrescription = $conn->prepare($sqlPrescription);
    $stmtPrescription->bind_param("i", $PrescriptionId);
    $stmtPrescription->execute();
    $resultPrescription = $stmtPrescription->get_result();

    if ($resultPrescription->num_rows > 0) {
        $Prescription = $resultPrescription->fetch_assoc();
    } else {
        echo "<script>alert('Prescription not found.'); window.location.href='viewprescription.php';</script>";
        exit();
    }

    // Fetch drug details for the prescription
    $sqlDrugs = "SELECT * FROM prescription_drugs WHERE prescription_id = ?";
    $stmtDrugs = $conn->prepare($sqlDrugs);
    $stmtDrugs->bind_param("i", $PrescriptionId);
    $stmtDrugs->execute();
    $resultDrugs = $stmtDrugs->get_result();
} else {
    echo "<script>alert('No Prescription selected.'); window.location.href='viewprescription.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prescription Details</title>
    <link rel="stylesheet" href="printview1.css">
</head>
<body>
    <div class="container">
        <!-- Header Section -->
        <div class="header">
            <img src="logo.jpeg" alt="Hospital Logo" class="logo">
            <div class="header-content">
                <h1>MOUNT APOLLO HOSPITALS (PVT) LTD</h1>
                <p>No. 355, Maharagama Road, Boralesgamuwa</p>
                <p>
                    Tel: 077 20 20 261, 077 20 20 578, 011 2 150 150<br>
                    Email: info@mountapollohospitals.com<br>
                    Web: www.mountapollohospitals.com
                </p>
            </div>
        </div>

        <!-- Prescription Details -->
        <h3>Prescription Details</h3>
        <div class="prescription-details">
            <p><strong>Prescription ID:</strong> <?php echo htmlspecialchars($Prescription['id']); ?></p>
            <p><strong>Contact No:</strong> <?php echo htmlspecialchars($Prescription['contact_no']); ?></p>
            <p><strong>Patient Name:</strong> <?php echo htmlspecialchars($Prescription['patient_name']); ?></p>
            <p><strong>Date:</strong> <?php echo htmlspecialchars($Prescription['date']); ?></p>
            <p><strong>Diagnosis:</strong> <?php echo htmlspecialchars($Prescription['diagnosis']); ?></p>
            <p><strong>Additional Notes:</strong> <?php echo htmlspecialchars($Prescription['additional_notes']); ?></p>
        </div>

        <!-- Drug Details -->
        <h3>Drug Details</h3>
        <table>
            <thead>
                <tr>
                    <th>Drug Name</th>
                    <th>Dosage</th>
                    <th>Duration</th>
                    <th>Instructions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($resultDrugs->num_rows > 0) {
                    while ($drug = $resultDrugs->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($drug['drug_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($drug['dosage']) . "</td>";
                        echo "<td>" . htmlspecialchars($drug['duration']) . "</td>";
                        echo "<td>" . htmlspecialchars($drug['instructions']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No drug details found for this prescription.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Buttons -->
        <div class="action-buttons">
            <button class="print-button" onclick="window.print()">Print Prescription</button>
            <button class="back-button" onclick="window.history.back()">Back to Prescription List</button>
        </div>
    </div>
</body>
</html>

<?php
// Close database connections
$stmtPrescription->close();
$stmtDrugs->close();
$conn->close();
?>
