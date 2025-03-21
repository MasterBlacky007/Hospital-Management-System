<?php
// Include database configuration file
include "conf.php";

// DrugStock class to manage drug stock operations
class DrugStock {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    // Fetch drug details by ID
    public function getDrugById($id) {
        $sql = "SELECT * FROM drug_stock WHERE stock_id = ?";
        if ($stmt = $this->conn->prepare($sql)) {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $drug = $result->fetch_assoc();
            $stmt->close();
            return $drug;
        }
        return null;
    }

    // Update drug stock details
    public function updateDrug($id, $drug_name, $category, $dosage_form, $dosage, $quantity, $stock_date, $expiry_date) {
        $sql = "UPDATE drug_stock SET 
                drug_name = ?, 
                category = ?, 
                dosage_form = ?, 
                dosage = ?, 
                quantity = ?, 
                stock_date = ?, 
                expiry_date = ? 
                WHERE stock_id = ?";

        if ($stmt = $this->conn->prepare($sql)) {
            $stmt->bind_param("ssssissi", $drug_name, $category, $dosage_form, $dosage, $quantity, $stock_date, $expiry_date, $id);
            $success = $stmt->execute();
            $stmt->close();
            return $success;
        }
        return false;
    }
}

// Initialize variables
$successMessage = "";
$errorMessage = "";
$drug = null;

// Create DrugStock object
$drugStock = new DrugStock($conn);

// Fetch drug details if ID is provided in URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $drug = $drugStock->getDrugById($id);

    if (!$drug) {
        $errorMessage = "No drug found with the specified ID.";
    }
} else {
    $errorMessage = "Invalid request. No ID specified.";
}

// Handle form submission for updating the drug stock
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['stock_id'];
    $drug_name = $_POST['drug_name'];
    $category = $_POST['category'];
    $dosage_form = $_POST['dosage_form'];
    $dosage = $_POST['dosage'];
    $quantity = $_POST['quantity'];
    $stock_date = $_POST['stock_date'];
    $expiry_date = $_POST['expiry_date'];

    if ($drugStock->updateDrug($id, $drug_name, $category, $dosage_form, $dosage, $quantity, $stock_date, $expiry_date)) {
        echo "<script>alert('Drug stock updated successfully!'); window.location.href='show.php';</script>";
        exit;
    } else {
        $errorMessage = "Error updating drug stock.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Drug Stock</title>
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
        <h1 class="content-title">Update Drug Stock</h1>

        <?php if ($errorMessage): ?>
            <div class="alert alert-error">
                <?= htmlspecialchars($errorMessage); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($drug)): ?>
            <div class="drug-order-form">
                <form method="POST" action="update_dstock.php">
                    <input type="hidden" name="stock_id" value="<?= htmlspecialchars($drug['stock_id']); ?>">

                    <div class="form-group">
                        <label for="drug_name">Drug Name:</label>
                        <input type="text" id="drug_name" name="drug_name" class="form-input" value="<?= htmlspecialchars($drug['drug_name']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="category">Category:</label>
                        <select id="category" name="category" class="form-input" required>
                            <option value="Antibiotics" <?= $drug['category'] == 'Antibiotics' ? 'selected' : ''; ?>>Antibiotics</option>
                            <option value="Pain Relievers" <?= $drug['category'] == 'Pain Relievers' ? 'selected' : ''; ?>>Pain Relievers</option>
                            <option value="Vitamins" <?= $drug['category'] == 'Vitamins' ? 'selected' : ''; ?>>Vitamins</option>
                            <option value="Antiseptics" <?= $drug['category'] == 'Antiseptics' ? 'selected' : ''; ?>>Antiseptics</option>
                            <option value="Other" <?= $drug['category'] == 'Other' ? 'selected' : ''; ?>>Other</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="dosage_form">Dosage Form:</label>
                        <select id="dosage_form" name="dosage_form" class="form-input" required>
                            <option value="Tablet" <?= $drug['dosage_form'] == 'Tablet' ? 'selected' : ''; ?>>Tablet</option>
                            <option value="Syrup" <?= $drug['dosage_form'] == 'Syrup' ? 'selected' : ''; ?>>Syrup</option>
                            <option value="Capsule" <?= $drug['dosage_form'] == 'Capsule' ? 'selected' : ''; ?>>Capsule</option>
                            <option value="Injection" <?= $drug['dosage_form'] == 'Injection' ? 'selected' : ''; ?>>Injection</option>
                            <option value="Suspension" <?= $drug['dosage_form'] == 'Suspension' ? 'selected' : ''; ?>>Suspension</option>
                            <option value="Ointment" <?= $drug['dosage_form'] == 'Ointment' ? 'selected' : ''; ?>>Ointment</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="dosage">Dosage:</label>
                        <input type="text" id="dosage" name="dosage" class="form-input" value="<?= htmlspecialchars($drug['dosage']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="quantity">Quantity:</label>
                        <input type="number" id="quantity" name="quantity" class="form-input" value="<?= htmlspecialchars($drug['quantity']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="stock_date">Stock Date:</label>
                        <input type="date" id="stock_date" name="stock_date" class="form-input" value="<?= htmlspecialchars($drug['stock_date']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="expiry_date">Expiry Date:</label>
                        <input type="date" id="expiry_date" name="expiry_date" class="form-input" value="<?= htmlspecialchars($drug['expiry_date']); ?>" required>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-submit">Update</button>
                        <button type="button" class="btn btn-cancel" onclick="window.location.href='show.php'">Cancel</button>
                    </div>
                </form>
            </div>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
