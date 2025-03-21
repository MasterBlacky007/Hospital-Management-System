<?php
// Include database connection
include "conf.php";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch drug names from the database
$drugs = [];
$sql = "SELECT drug_name FROM drugs";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $drugs[] = $row['drug_name'];
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_prescription'])) {
    // Collect form data
    $contact_no = htmlspecialchars($_POST['contact_no']);
    $patient_name = htmlspecialchars($_POST['patient_name']);
    $date = htmlspecialchars($_POST['date']);
    $diagnosis = htmlspecialchars($_POST['diagnosis']);
    $notes = htmlspecialchars($_POST['notes']);
    
    // Validate required fields
    if (!empty($contact_no) && !empty($patient_name) && !empty($date) && !empty($diagnosis)) {
        // Insert the main prescription data
        $stmt = $conn->prepare("INSERT INTO prescriptions (contact_no, patient_name, date, diagnosis, additional_notes) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $contact_no, $patient_name, $date, $diagnosis, $notes);

        if ($stmt->execute()) {
            // Get the ID of the inserted prescription
            $prescription_id = $stmt->insert_id;

            // Insert each drug into the prescription_details table
            $drug_names = $_POST['drug_name'];
            $dosages = $_POST['dosage'];
            $durations = $_POST['duration'];
            $instructions = $_POST['instructions'];

            for ($i = 0; $i < count($drug_names); $i++) {
                $drug_name = htmlspecialchars($drug_names[$i]);
                $dosage = htmlspecialchars($dosages[$i]);
                $duration = htmlspecialchars($durations[$i]);
                $instruction = htmlspecialchars($instructions[$i]);

                // Insert drug details
                $stmt = $conn->prepare("INSERT INTO prescription_drugs (prescription_id, drug_name, dosage, duration, instructions) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("issss", $prescription_id, $drug_name, $dosage, $duration, $instruction);
                $stmt->execute();
            }

            echo "<script>alert('Prescription saved successfully!');</script>";
        } else {
            echo "<script>alert('Error saving prescription: " . $conn->error . "');</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Please fill all required fields.');</script>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prescription Form</title>
    <link rel="stylesheet" href="prescriptions.css">
</head>
<body>
    <div class="container">
        <!-- Sidebar Section -->
        <div class="sidebar">
            <div class="logo">
                <img src="logo.jpeg" alt="Hospital Logo">
                <h2>Apollo Hospital</h2>
            </div>
            <h1>Doctor</h1>
                    <a href="doctordash.html">Dashboard</a>
                    <a href="docprofile.php">My Profile</a>
                    <a href="docviewptprofile.php">Patient Profile</a>
                    <a href="presdash.php">Prescription</a>
                    <a href="labdash.php">Lab Test</a>
                    <a href="docappointment.php">Appointment</a>
                    <a href="taskdash.php">Task</a>
                    <a href="viewdprogress.php">View Progress Notes</a>
                    <a href="stlogin.html">Log Out</a>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <h1>Prescription Form</h1>
            <div class="form-container">
                <form method="POST">
                    <!-- Patient Contact Number -->
                    <div class="form-row">
                        <label for="contact_no">Patient Contact No:</label>
                        <input type="text" id="contact_no" name="contact_no" required>
                    </div>

                    <!-- Patient Name -->
                    <div class="form-row">
                        <label for="patient_name">Patient Name:</label>
                        <input type="text" id="patient_name" name="patient_name" required>
                    </div>

                    <!-- Prescription Details -->
                    <div class="form-row">
                        <label for="date">Date:</label>
                        <input type="date" id="date" name="date" required>

                        <label for="diagnosis">Diagnosis:</label>
                        <textarea id="diagnosis" name="diagnosis" required></textarea>
                    </div>

                    <!-- Multiple Drugs Input -->
                    <div class="form-row" id="drug-section">
                        <div class="drug-entry">
                            <label for="drug_name">Drug Name:</label>
                            <select name="drug_name[]" required>
                                <option value="">-- Select Drug --</option>
                                <?php foreach ($drugs as $drug): ?>
                                    <option value="<?php echo htmlspecialchars($drug); ?>"><?php echo htmlspecialchars($drug); ?></option>
                                <?php endforeach; ?>
                            </select>

                            <label for="dosage">Dosage:</label>
                            <input type="text" name="dosage[]" required>

                            <label for="duration">Duration:</label>
                            <input type="text" name="duration[]" required>

                            <label for="instructions">Instructions:</label>
                            <textarea name="instructions[]"></textarea>
                        </div>
                    </div>
                    <button type="button" id="add-drug-btn">Add More Drugs</button>

                    <!-- Additional Notes -->
                    <div class="form-row">
                        <label for="notes">Additional Notes:</label>
                        <textarea id="notes" name="notes"></textarea>
                    </div>

                    <!-- Submit Button -->
                    <div class="form-row">
                        <button type="submit" name="submit_prescription" class="register-btn">Save Prescription</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('add-drug-btn').addEventListener('click', function () {
            const drugSection = document.getElementById('drug-section');
            const newDrugEntry = document.querySelector('.drug-entry').cloneNode(true);
            newDrugEntry.querySelectorAll('input, select, textarea').forEach(input => input.value = '');
            drugSection.appendChild(newDrugEntry);
        });
    </script>
</body>
</html>
