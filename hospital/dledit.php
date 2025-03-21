<?php
// Include database configuration file
include "conf.php";

// Check if the drug ID is provided in the URL
if (isset($_GET['id'])) {
    $drug_id = $_GET['id'];

    // Fetch the current details of the drug to populate the form
    $sql = "SELECT * FROM drugs WHERE drug_id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $drug_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if the drug exists
        if ($result->num_rows > 0) {
            $drug = $result->fetch_assoc();
        } else {
            echo "Drug not found.";
            exit;
        }

        $stmt->close();
    } else {
        echo "Error preparing query.";
        exit;
    }

    // Update the drug if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Get updated drug data from form
        $drug_name = $_POST['drug_name'];
        $category = $_POST['category'];
        $dosage_form = $_POST['dosage_form'];
        $dosage = $_POST['dosage'];

        // Prepare the SQL query to update the drug
        $update_sql = "UPDATE drugs SET drug_name = ?, category = ?, dosage_form = ?, dosage = ? WHERE drug_id = ?";

        if ($stmt = $conn->prepare($update_sql)) {
            $stmt->bind_param("ssssi", $drug_name, $category, $dosage_form, $dosage, $drug_id);

            // Execute the query
            if ($stmt->execute()) {
                // Redirect to the drug list page with a success message
                header("Location: show.php?update=1");
            } else {
                echo "Error updating drug.";
            }

            $stmt->close();
        } else {
            echo "Error preparing update query.";
        }
    }
} else {
    echo "No drug ID provided!";
    exit;
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Drug List</title>
    <link rel="stylesheet" href="dorder.css">
</head>
<body>

<div class="main-container">
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
            <img src="logo.jpeg" alt="Hospital Logo">
            <h2>Apollo Hospital</h2>
        </div>
        <h1>Pharmacist</h1>
                <a href="pharmasictdashboard.php">Dashboard</a>
                <a href="profileph.php">My Profile</a>
                <a href="load_pres.php">Prescription</a>
                <a href="drug_order.php">Drug Order</a>
                <a href="drugstock.php">Drug Stock</a>
                <a href="mdhistory.php">MD History</a>
                <a href="drugdash.php">Drugs List</a>
                <a href="stlogin.html">Log Out</a>
    </div>

    <!-- Main Content -->
    <div class="content">
        <h1 class="content-title">Update Drug in List</h1>

        <div class="drug-order-form">
            <form method="POST" action="update_drug.php?id=<?php echo $drug['drug_id']; ?>">
                <div class="form-group">
                    <label for="drug_name" class="form-label">Drug Name:</label>
                    <input type="text" id="drug_name" name="drug_name" value="<?php echo htmlspecialchars($drug['drug_name']); ?>" class="form-input" required>
                </div>

                <!-- Dropdown for Category -->
                <div class="form-group">
                    <label for="category" class="form-label">Category:</label>
                    <select id="category" name="category" class="form-input" required>
                        <option value="" disabled>Select Category</option>
                        <option value="Antibiotics" <?php if($drug['category'] == 'Antibiotics') echo 'selected'; ?>>Antibiotics</option>
                        <option value="Pain Relievers" <?php if($drug['category'] == 'Pain Relievers') echo 'selected'; ?>>Pain Relievers</option>
                        <option value="Vitamins" <?php if($drug['category'] == 'Vitamins') echo 'selected'; ?>>Vitamins</option>
                        <option value="Antiseptics" <?php if($drug['category'] == 'Antiseptics') echo 'selected'; ?>>Antiseptics</option>
                        <option value="Other" <?php if($drug['category'] == 'Other') echo 'selected'; ?>>Other</option>
                    </select>
                </div>

                <!-- Dropdown for Dosage Form -->
                <div class="form-group">
                    <label for="dosage_form" class="form-label">Dosage Form:</label>
                    <select id="dosage_form" name="dosage_form" class="form-input" required>
                        <option value="" disabled>Select Dosage Form</option>
                        <option value="Tablet" <?php if($drug['dosage_form'] == 'Tablet') echo 'selected'; ?>>Tablet</option>
                        <option value="Syrup" <?php if($drug['dosage_form'] == 'Syrup') echo 'selected'; ?>>Syrup</option>
                        <option value="Capsule" <?php if($drug['dosage_form'] == 'Capsule') echo 'selected'; ?>>Capsule</option>
                        <option value="Injection" <?php if($drug['dosage_form'] == 'Injection') echo 'selected'; ?>>Injection</option>
                        <option value="Suspension" <?php if($drug['dosage_form'] == 'Suspension') echo 'selected'; ?>>Suspension</option>
                        <option value="Ointment" <?php if($drug['dosage_form'] == 'Ointment') echo 'selected'; ?>>Ointment</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="dosage" class="form-label">Dosage:</label>
                    <input type="text" id="dosage" name="dosage" value="<?php echo htmlspecialchars($drug['dosage']); ?>" class="form-input" placeholder="e.g., 500mg, 5ml" required>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-submit">Update Drug</button>
                    <button type="button" class="btn btn-cancel" onclick="window.location.href='druglist.php'">Back to Drug List</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
