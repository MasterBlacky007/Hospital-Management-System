<?php
// Database connection
include "conf.php";

// Fetch prescription data along with drug details
$sql = "
    SELECT 
        p.id AS prescription_id, 
        p.contact_no, 
        p.patient_name, 
        p.date, 
        p.diagnosis, 
        p.additional_notes, 
        d.drug_name, 
        d.dosage, 
        d.duration, 
        d.instructions
    FROM 
        prescriptions p
    LEFT JOIN 
        prescription_drugs d 
    ON 
        p.id = d.prescription_id
    ORDER BY 
        p.id, d.drug_name";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prescription List</title>
    <link rel="stylesheet" href="viewtable.css">
</head>
<body>
    <div class="container">
        <h3>Prescription List</h3>

        <button class="back" onclick="window.location.href='nursedashboard.html'">Back</button>
        
        <input type="text" id="search" placeholder="Search by any field...">
        
        <table id="prescriptionTable">
            <thead>
                <tr>
                    <th>Prescription ID</th>
                    <th>Contact No</th>
                    <th>Patient Name</th>
                    <th>Date</th>
                    <th>Diagnosis</th>
                    <th>Additional Notes</th>
                    <th>Drug Name</th>
                    <th>Dosage</th>
                    <th>Duration</th>
                    <th>Instructions</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $currentPrescriptionId = null;

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        if ($currentPrescriptionId !== $row['prescription_id']) {
                            // Start a new prescription row
                            $currentPrescriptionId = $row['prescription_id'];

                            // Print main prescription data with the first drug row
                            echo "<tr>";
                            echo "<td rowspan='1'>" . $row['prescription_id'] . "</td>";
                            echo "<td rowspan='1'>" . $row['contact_no'] . "</td>";
                            echo "<td rowspan='1'>" . $row['patient_name'] . "</td>";
                            echo "<td rowspan='1'>" . $row['date'] . "</td>";
                            echo "<td rowspan='1'>" . $row['diagnosis'] . "</td>";
                            echo "<td rowspan='1'>" . $row['additional_notes'] . "</td>";
                            echo "<td>" . $row['drug_name'] . "</td>";
                            echo "<td>" . $row['dosage'] . "</td>";
                            echo "<td>" . $row['duration'] . "</td>";
                            echo "<td>" . $row['instructions'] . "</td>";
                            echo "<td rowspan='1'>
                                <button class='view-button' onclick=\"window.location.href='nview_pres.php?prescriptionid=" . $row['prescription_id'] . "'\">View</button>
                            </td>";
                            echo "</tr>";
                        } else {
                            // Additional drug details for the same prescription
                            echo "<tr>";
                            echo "<td colspan='6'></td>"; // Empty cells for prescription info
                            echo "<td>" . $row['drug_name'] . "</td>";
                            echo "<td>" . $row['dosage'] . "</td>";
                            echo "<td>" . $row['duration'] . "</td>";
                            echo "<td>" . $row['instructions'] . "</td>";
                            echo "<td></td>"; // Empty actions column for additional rows
                            echo "</tr>";
                        }
                    }
                } else {
                    echo "<tr><td colspan='11'>No prescriptions found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Link to external JavaScript -->
    <script src="script.js"></script>
</body>
</html>

<?php
$conn->close();
?>
