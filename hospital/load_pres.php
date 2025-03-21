<?php
// Database connection
include "conf.php";

// Initialize variables
$contact_no = '';
$date = date('Y-m-d'); // Default to today's date
$prescriptions_data = [];

// Display message from the previous operation
if (isset($_GET['message'])) {
    $message = htmlspecialchars($_GET['message']);
    echo "<script>alert('$message');</script>";
}

// Fetch prescriptions based on search criteria
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contact_no = $_POST['contact_no'];
    $date = $_POST['date'];

    $sql = "
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
        WHERE 
            p.contact_no LIKE ? AND p.date = ?
        GROUP BY 
            p.id
        ORDER BY 
            p.id";
    $stmt = $conn->prepare($sql);
    $search_contact_no = "%$contact_no%";
    $stmt->bind_param("ss", $search_contact_no, $date);
    $stmt->execute();
    $result = $stmt->get_result();
    $prescriptions_data = $result->fetch_all(MYSQLI_ASSOC);
} else {
    // Fetch today's prescriptions by default
    $sql = "
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
        WHERE 
            p.date = ?
        GROUP BY 
            p.id
        ORDER BY 
            p.id";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $date);
    $stmt->execute();
    $result = $stmt->get_result();
    $prescriptions_data = $result->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prescription List</title>
    <link rel="stylesheet" href="longtable.css">
    <style>
        /* Styling for the contact input */
form label {
    font-weight: bold;
    margin-right: 10px;
}

form input[type="text"], form input[type="date"] {
    padding: 8px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 4px;
    width: 200px;
    margin-right: 10px;
}

/* Button styling for action buttons in the table */
#prescriptionTable button {
    padding: 6px 12px;
    margin: 5px;
    font-size: 14px;
    border-radius: 4px;
    cursor: pointer;
}

/* Styling for View button */
.view-button {
    background-color: #2196F3; /* Blue */
    color: white;
}

/* Styling for Accept button */
.accept {
    background-color: #4CAF50; /* Green */
    color: white;
}

/* Styling for Reject button */
.reject {
    background-color: #f44336; /* Red */
    color: white;
}

/* Organizing buttons vertically */
#prescriptionTable form {
    display: flex;
    flex-direction: column;
    align-items: center;
}

#prescriptionTable .view-button,
#prescriptionTable .accept,
#prescriptionTable .reject {
    width: 100%;
    margin-bottom: 5px;
}

    </style>
</head>
<body>
    <div class="container">
        <h3>Prescription List</h3>

        <button class="back" onclick="window.location.href='pharmasictdashboard.php'">Back</button>
        
        <form method="POST">
            <label for="contact_no">Contact No:</label>
            <input type="text" id="contact_no" name="contact_no" value="<?php echo htmlspecialchars($contact_no); ?>" placeholder="Enter Contact No">
            
            <label for="date">Date:</label>
            <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($date); ?>">
            
            <button type="submit">Search</button>
        </form>

        <table id="prescriptionTable">
            <thead>
                <tr>
                    <th>Prescription ID</th>
                    <th>Contact No</th>
                    <th>Patient Name</th>
                    <th>Date</th>
                    <th>Diagnosis</th>
                    <th>Additional Notes</th>
                    <th>Drug Details</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($prescriptions_data)) {
                    foreach ($prescriptions_data as $row) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['prescription_id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['contact_no']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['patient_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['date']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['diagnosis']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['additional_notes']) . "</td>";
                        echo "<td>" . $row['drug_details'] . "</td>"; // Allow <br> tags for drug details
                        echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                        echo "<td>";
                        if ($row['status'] === 'Pending') {
                            echo "<form method='POST' action='pres_status.php' style='display:inline;'>
                                    <input type='hidden' name='prescription_id' value='" . htmlspecialchars($row['prescription_id']) . "'>
                                    <button type='submit' name='action' value='accept' class='accept'>Accept</button>
                                    <button type='submit' name='action' value='reject' class='reject'>Reject</button>
                                  </form>";
                        }
                        echo "<button class='view-button' onclick=\"window.location.href='view_phpres.php?prescriptionid=" . htmlspecialchars($row['prescription_id']) . "'\">View</button>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>No prescriptions found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
$conn->close();
?>
