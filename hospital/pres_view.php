<?php
session_start();

// Database connection
include "conf.php";

// Retrieve logged-in patient's contact number from session
if (!isset($_SESSION['email'])) {
    header("Location: plogin.html");
    exit();
}

$email = $_SESSION['email'];
$query = "SELECT contact FROM patientprofile WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $contact_number = $row['contact'];
} else {
    echo "<p>Error retrieving contact number.</p>";
    exit();
}

// Retrieve prescriptions by contact number
$sql_prescriptions = "
    SELECT 
        pr.id AS prescription_id,
        pr.contact_no,
        pr.patient_name,
        pr.date,
        pr.diagnosis,
        pr.additional_notes,
        pd.drug_name,
        pd.dosage,
        pd.duration,
        pd.instructions
    FROM prescriptions pr
    JOIN prescription_drugs pd ON pr.id = pd.prescription_id
    WHERE pr.contact_no = ? AND pr.date >= DATE_SUB(CURDATE(), INTERVAL 3 DAY)
";

$stmt_prescriptions = $conn->prepare($sql_prescriptions);
$stmt_prescriptions->bind_param("s", $contact_number);
$stmt_prescriptions->execute();
$result_prescriptions = $stmt_prescriptions->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prescription Records</title>
    <link rel="stylesheet" href="viewtable.css">
    <script>
        function filterResults() {
            const searchTerm = document.getElementById("search").value.toLowerCase();
            const rows = document.querySelectorAll("#results-table tbody tr");

            rows.forEach(row => {
                const cells = row.getElementsByTagName("td");
                let found = false;

                for (let cell of cells) {
                    if (cell.textContent.toLowerCase().includes(searchTerm)) {
                        found = true;
                        break;
                    }
                }

                row.style.display = found ? "" : "none";
            });
        }

        function clearSearch() {
            document.getElementById("search").value = "";
            filterResults();
        }

        function goBack() {
            window.location.href = "patientmedi.php";
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Prescription Records</h1>
        <input type="text" id="search" onkeyup="filterResults()" placeholder="Search by any field...">
        <button class="back" onclick="clearSearch()">Clear</button>
        <button class="back" onclick="goBack()">Back</button>
        

        <table id="results-table">
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
                </tr>
            </thead>
            <tbody>
                <?php
                $currentPrescriptionId = null;
                
                if ($result_prescriptions->num_rows > 0) {
                    while ($row = $result_prescriptions->fetch_assoc()) {
                        if ($currentPrescriptionId !== $row['prescription_id']) {
                            $currentPrescriptionId = $row['prescription_id'];
                            echo "<tr>";
                            echo "<td rowspan='1'>" . htmlspecialchars($row['prescription_id']) . "</td>";
                            echo "<td rowspan='1'>" . htmlspecialchars($row['contact_no']) . "</td>";
                            echo "<td rowspan='1'>" . htmlspecialchars($row['patient_name']) . "</td>";
                            echo "<td rowspan='1'>" . htmlspecialchars($row['date']) . "</td>";
                            echo "<td rowspan='1'>" . htmlspecialchars($row['diagnosis']) . "</td>";
                            echo "<td rowspan='1'>" . htmlspecialchars($row['additional_notes']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['drug_name']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['dosage']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['duration']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['instructions']) . "</td>";
                            echo "</tr>";
                        } else {
                            echo "<tr><td colspan='6'></td>";
                            echo "<td>" . htmlspecialchars($row['drug_name']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['dosage']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['duration']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['instructions']) . "</td></tr>";
                        }
                    }
                } else {
                    echo "<tr><td colspan='11'>No prescriptions found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>