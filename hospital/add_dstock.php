<?php
// Include database configuration file
include "conf.php";

// Initialize a variable to hold the success message
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $drug_name = $_POST['drug_name'];
    $category = $_POST['category'];
    $dosage_form = $_POST['dosage_form'];
    $dosage = $_POST['dosage'];
    $quantity = $_POST['quantity'];
    $stock_date = $_POST['stock_date'];
    $expiry_date = $_POST['expiry_date'];

    // Prepare the SQL query to insert the drug stock details
    $sql = "INSERT INTO drug_stock (drug_name, category, dosage_form, dosage, quantity, stock_date, expiry_date) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssssiss", $drug_name, $category, $dosage_form, $dosage, $quantity, $stock_date, $expiry_date);

        // Execute the query
        if ($stmt->execute()) {
            $successMessage = "Drug stock added successfully!";
        } else {
            echo "<script>alert('Error adding drug stock.');</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Error preparing query.');</script>";
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Drug Stock</title>
    <link rel="stylesheet" href="dorder.css">
    <script>
        // Display the success message as an alert if it exists
        document.addEventListener("DOMContentLoaded", function() {
            <?php if (!empty($successMessage)): ?>
            alert("<?php echo $successMessage; ?>");
            <?php endif; ?>
        });
    </script>
</head>
<body>

<div class="main-container">
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
            <img src="logo.jpeg" alt="Hospital Logo">
            <h2>Apollo Hospital</h2>
        </div>
        <h1>Pharmacist </h1>
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
    <div class="content">
        <h1 class="content-title">Add Current Drug Stock</h1>

        <div class="drug-order-form">
            <form method="POST" action="add_dstock.php">
                <div class="form-group">
                    <label for="drug_name" class="form-label">Drug Name:</label>
                    <input type="text" id="drug_name" name="drug_name" class="form-input" required>
                </div>
                <div class="form-group">
                    <label for="category" class="form-label">Category:</label>
                    <select id="category" name="category" class="form-input" required>
                        <option value="">-- Select Category --</option>
                        <option value="Antibiotics">Antibiotics</option>
                        <option value="Pain Relievers">Pain Relievers</option>
                        <option value="Vitamins">Vitamins</option>
                        <option value="Antiseptics">Antiseptics</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="dosage_form" class="form-label">Dosage Form:</label>
                    <select id="dosage_form" name="dosage_form" class="form-input" required>
                        <option value="">-- Select Dosage Form --</option>
                        <option value="Tablet">Tablet</option>
                        <option value="Syrup">Syrup</option>
                        <option value="Capsule">Capsule</option>
                        <option value="Injection">Injection</option>
                        <option value="Suspension">Suspension</option>
                        <option value="Ointment">Ointment</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="dosage" class="form-label">Dosage:</label>
                    <input type="text" id="dosage" name="dosage" class="form-input" required>
                </div>
                <div class="form-group">
                    <label for="quantity" class="form-label">Quantity:</label>
                    <input type="number" id="quantity" name="quantity" class="form-input" required>
                </div>
                <div class="form-group">
                    <label for="stock_date" class="form-label">Stock Date:</label>
                    <input type="date" id="stock_date" name="stock_date" class="form-input" required>
                </div>
                <div class="form-group">
                    <label for="expiry_date" class="form-label">Expiry Date:</label>
                    <input type="date" id="expiry_date" name="expiry_date" class="form-input" required>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-submit">Add Drug Stock</button>
                    <button type="reset" class="btn btn-cancel">Reset</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
