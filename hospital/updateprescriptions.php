<?php
// Database connection
include "conf.php";

$successMessage = ''; // Initialize success message

// Retrieve list of all drugs for dropdown
$drugs = [];
$stmt = $conn->prepare("SELECT drug_name FROM drugs");
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $drugs[] = $row['drug_name'];
}
$stmt->close();

if (isset($_POST['submit_update'])) {
    $contact_no = $_POST['contact_no'];
    $patient_name = $_POST['patient_name'];
    $date = $_POST['date'];
    $diagnosis = $_POST['diagnosis'];
    $additional_notes = $_POST['notes'];

    // Update the prescription details
    $stmt = $conn->prepare("UPDATE prescriptions SET patient_name = ?, date = ?, diagnosis = ?, additional_notes = ? WHERE contact_no = ? AND date = ?");
    $stmt->bind_param("ssssss", $patient_name, $date, $diagnosis, $additional_notes, $contact_no, $date);
    $stmt->execute();

    // Fetch the prescription ID for the current prescription
    $stmt = $conn->prepare("SELECT id FROM prescriptions WHERE contact_no = ? AND date = ?");
    $stmt->bind_param("ss", $contact_no, $date);
    $stmt->execute();
    $result = $stmt->get_result();
    $prescription_id = $result->fetch_assoc()['id'];
    $stmt->close();

    // Existing prescription drugs for this prescription ID
    $existing_drugs = [];
    $stmt = $conn->prepare("SELECT id, drug_name FROM prescription_drugs WHERE prescription_id = ?");
    $stmt->bind_param("i", $prescription_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $existing_drugs[$row['id']] = $row['drug_name'];
    }
    $stmt->close();

    // Process the submitted drug details
    $drug_names = $_POST['drug_name'];
    $dosages = $_POST['dosage'];
    $durations = $_POST['duration'];
    $instructions = $_POST['instructions'];

    $updated_drug_ids = [];

    foreach ($existing_drugs as $drug_id => $existing_drug_name) {
        $found_index = array_search($existing_drug_name, $drug_names);

        if ($found_index !== false) {
            // Update existing drug entry
            $stmt = $conn->prepare("UPDATE prescription_drugs SET dosage = ?, duration = ?, instructions = ? WHERE id = ?");
            $stmt->bind_param("sssi", $dosages[$found_index], $durations[$found_index], $instructions[$found_index], $drug_id);
            $stmt->execute();
            $updated_drug_ids[] = $drug_id;
            // Remove matched drug to avoid reprocessing
            unset($drug_names[$found_index], $dosages[$found_index], $durations[$found_index], $instructions[$found_index]);
        }
    }

    // Insert new drug entries for unmatched submitted drugs
    foreach ($drug_names as $index => $drug_name) {
        $stmt = $conn->prepare("INSERT INTO prescription_drugs (prescription_id, drug_name, dosage, duration, instructions) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $prescription_id, $drug_name, $dosages[$index], $durations[$index], $instructions[$index]);
        $stmt->execute();
    }

    $successMessage = 'Prescription updated successfully.'; // Set success message
}

$prescription = null;

if (isset($_POST['search_prescription'])) {
    $contact_no_search = $_POST['contact_no_search'];
    $date_search = $_POST['date_search'];

    $stmt = $conn->prepare("SELECT * FROM prescriptions WHERE contact_no = ? AND date = ?");
    $stmt->bind_param("ss", $contact_no_search, $date_search);
    $stmt->execute();
    $result = $stmt->get_result();
    $prescription = $result->fetch_assoc();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Prescription</title>
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
            <h1>Search Prescription</h1>
            <div class="form-container">
                <form method="POST">
                    <div class="form-row">
                        <label for="contact_no_search">Contact No:</label>
                        <input type="text" id="contact_no_search" name="contact_no_search">
                    </div>

                    <div class="form-row">
                        <label for="patient_name_search">Patient Name:</label>
                        <input type="text" id="patient_name_search" name="patient_name_search">
                    </div>

                    <div class="form-row">
                        <label for="date_search">Date:</label>
                        <input type="date" id="date_search" name="date_search">
                    </div>

                    <div class="form-row">
                        <button type="submit" name="search_prescription" class="register-btn">Search Prescription</button>
                    </div>
                </form>
            </div>

            <!-- Display Prescription Form if Prescription Found -->
            <?php if ($prescription): ?>
            <h1>Update Prescription</h1>
            <div class="form-container">
                <form method="POST">
                    <!-- Patient Contact No (for search and update) -->
                    <div class="form-row">
                        <label for="contact_no">Patient Contact No:</label>
                        <input type="text" id="contact_no" name="contact_no" value="<?= $prescription['contact_no'] ?? '' ?>" required>
                    </div>

                    <!-- Patient Name -->
                    <div class="form-row">
                        <label for="patient_name">Patient Name:</label>
                        <input type="text" id="patient_name" name="patient_name" value="<?= $prescription['patient_name'] ?? '' ?>" required>
                    </div>

                    <!-- Prescription Details -->
                    <div class="form-row">
                        <label for="date">Date:</label>
                        <input type="date" id="date" name="date" value="<?= $prescription['date'] ?? '' ?>" required>

                        <label for="diagnosis">Diagnosis:</label>
                        <textarea id="diagnosis" name="diagnosis" required><?= $prescription['diagnosis'] ?? '' ?></textarea>
                    </div>

                    <!-- Multiple Drugs Input -->
                    <div class="form-row" id="drug-section">
                        <?php
                        // Fetch the drugs already assigned to this prescription
                        $drugs_in_prescription = [];
                        $contact_no = $prescription['contact_no'];
                        $date = $prescription['date'];

                        $stmt = $conn->prepare("SELECT * FROM prescription_drugs WHERE prescription_id = (SELECT id FROM prescriptions WHERE contact_no = ? AND date = ?)");
                        $stmt->bind_param("ss", $contact_no, $date);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        while ($row = $result->fetch_assoc()) {
                            $drugs_in_prescription[] = $row;
                        }
                        $stmt->close();
                        ?>

                        <?php foreach ($drugs_in_prescription as $drug): ?>
                        <div class="drug-entry">
                            <label for="drug_name">Drug Name:</label>
                            <select name="drug_name[]" required>
                                <option value="">-- Select Drug --</option>
                                <?php foreach ($drugs as $drug_name): ?>
                                    <option value="<?php echo htmlspecialchars($drug_name); ?>" <?= ($drug_name == $drug['drug_name']) ? 'selected' : '' ?>>
                                        <?php echo htmlspecialchars($drug_name); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>

                            <label for="dosage">Dosage:</label>
                            <input type="text" name="dosage[]" value="<?= $drug['dosage'] ?>" required>

                            <label for="duration">Duration:</label>
                            <input type="text" name="duration[]" value="<?= $drug['duration'] ?>" required>

                            <label for="instructions">Instructions:</label>
                            <textarea name="instructions[]"><?= $drug['instructions'] ?></textarea>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <button type="button" id="add-drug-btn">Add More Drugs</button>

                    <!-- Additional Notes -->
                    <div class="form-row">
                        <label for="notes">Additional Notes:</label>
                        <textarea id="notes" name="notes"><?= $prescription['additional_notes'] ?? '' ?></textarea>
                    </div>

                    <!-- Submit Button -->
                    <div class="form-row">
                        <button type="submit" name="submit_update" class="register-btn">Update Prescription</button>
                    </div>
                </form>
            </div>
            <?php endif; ?>
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

    <!-- Display success alert if prescription is updated -->
    <script>
        <?php if ($successMessage): ?>
            alert("<?php echo $successMessage; ?>");
        <?php endif; ?>
    </script>
</body>
</html>
