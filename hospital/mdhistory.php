<?php
include "conf.php";
// Function to fetch patient data from the database
function fetch_patient_data() {
    global $conn;
    
    $query = "
        SELECT 
            p.id AS prescription_id, 
            p.contact_no, 
            p.patient_name, 
            p.date, 
            p.diagnosis, 
            p.additional_notes, 
            p.status, 
            GROUP_CONCAT(CONCAT_WS(' - ', d.drug_name, d.dosage, d.duration, d.instructions) SEPARATOR '<br>') AS drug_details
        FROM 
            prescriptions p
        LEFT JOIN 
            prescription_drugs d 
        ON 
            p.id = d.prescription_id
        GROUP BY 
            p.id
        ORDER BY 
            p.id";
    
    $result = $conn->query($query);
    
    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);  // Return the patient data as an associative array
    } else {
        return null;  // Return null if no data is found
    }
}

$prescriptions_data = fetch_patient_data();  // Fetch data once when the page loads
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Information</title>
    <link rel="stylesheet" href="style4.css">
    <script>
        // Function to filter table rows based on search input
        function filterTable() {
            var input, filter, table, tr, td, i, j, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("prescriptionTable");
            tr = table.getElementsByTagName("tr");

            for (i = 1; i < tr.length; i++) {  // Start from 1 to skip the header row
                tr[i].style.display = "none";  // Initially hide all rows
                td = tr[i].getElementsByTagName("td");
                
                for (j = 0; j < td.length; j++) {
                    if (td[j]) {
                        txtValue = td[j].textContent || td[j].innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";  // Show the row if it matches the search filter
                            break;
                        }
                    }
                }
            }
        }
    </script>
</head>
<body>
<div class="sidebar">
    <div class="logo">
        <img src="logo.jpeg" alt="Hospital Logo">
        <h2>Apollo Hospital</h2>
    </div>
    <h1>Pharmacist</h1>
                <a href="pharmasictdashboard.php">Dashboard</a>
                <a href="profileph.php">My Profile</a>
                <a href="load_pres.php">Prescription</a>
                <a href="phdrugorderdash.php">Drug Order</a>
                <a href="drugstock.php">Drug Stock</a>
                <a href="mdhistory.php">MD History</a>
                <a href="drugdash.php">Drugs List</a>
                <a href="stlogin.html">Log Out</a>
</div>

<!-- Main Content -->
<div class="form-container">
    <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Search for prescriptions...">

    <div class="results">
        <table id="prescriptionTable">
            <thead>
                <tr>
                    <th>Prescription ID</th>
                    <th>Patient Name</th>
                    <th>Contact No</th>
                    <th>Diagnosis</th>
                    <th>Drug Details</th>
                    <th>Additional Notes</th>
                    <th>Status</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php
                // Loop through the fetched prescriptions data and display them in the table
                if ($prescriptions_data) {
                    foreach ($prescriptions_data as $row) {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($row['prescription_id']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['patient_name']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['contact_no']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['diagnosis']) . '</td>';
                        echo '<td>' . $row['drug_details'] . '</td>';
                        echo '<td>' . htmlspecialchars($row['additional_notes']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['status']) . '</td>';
                        
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="7">No prescriptions found.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
