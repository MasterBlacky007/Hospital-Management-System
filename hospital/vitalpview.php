<?php
session_start();

// Database connection
include "conf.php";

// Retrieve the logged-in patient's contact number
if (!isset($_SESSION['contact_number'])) {
    header("Location: plogin.html");
    exit();
}

$contact_number = $_SESSION['contact_number'];

// Retrieve vital signs for the logged-in patient
$sql_vital_signs = "
    SELECT 
        vitalId,
        patientName,
        contact_no,
        bloodp,
        height,
        weight,
        bmi,
        time
    FROM vital_signs
    WHERE contact_no = ?
";

$stmt_vital_signs = $conn->prepare($sql_vital_signs);
$stmt_vital_signs->bind_param("s", $contact_number);
$stmt_vital_signs->execute();
$result_vital_signs = $stmt_vital_signs->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vital Signs</title>
    <link rel="stylesheet" href="viewtable.css">
    <script>
        function filterResults() {
            const searchTerm = document.getElementById("search").value.toLowerCase();
            const rows = document.querySelectorAll("#vital-signs-table tbody tr");

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
    <h1>Vital Signs</h1>
    <input type="text" id="search" onkeyup="filterResults()" placeholder="Search by any field">
    <button class="back" onclick="clearSearch()">Clear</button>
    <button class="back" onclick="goBack()">Back</button>

    <table id="vital-signs-table">
        <thead>
            <tr>
                <th>Vital ID</th>
                <th>Patient Name</th>
                <th>Contact No</th>
                <th>Blood Pressure</th>
                <th>Height</th>
                <th>Weight</th>
                <th>BMI</th>
                <th>Time</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result_vital_signs->num_rows > 0) {
                while ($row = $result_vital_signs->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['vitalId']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['patientName']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['contact_no']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['bloodp']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['height']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['weight']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['bmi']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['time']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='10'>No vital signs found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>
