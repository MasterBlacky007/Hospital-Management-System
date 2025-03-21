<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drug Stock Order Request</title>
    <link rel="stylesheet" href="dorder.css"> <!-- Link to the CSS file -->
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
                <a href="phdrugorderdash.php">Drug Order</a>
                <a href="drugstock.php">Drug Stock</a>
                <a href="mdhistory.php">MD History</a>
                <a href="drugdash.php">Drugs List</a>
                <a href="stlogin.html">Log Out</a>
    </div>

    <!-- Main Content -->
    <div class="content">
        <h1 class="content-title">Request Drug Stock Order</h1>
        <div class="drug-order-form">
            <form action="process_order.php" method="POST">
                <div class="form-group">
                    <label for="request_date" class="form-label">Request Date:</label>
                    <input type="date" id="request_date" name="request_date" class="form-input" value="<?php echo date('Y-m-d'); ?>" readonly>
                </div>

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
                    <label for="quantity" class="form-label">Quantity:</label>
                    <input type="number" id="quantity" name="quantity" class="form-input" min="1" required>
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
                    <label for="urgency" class="form-label">Urgency:</label>
                    <select id="urgency" name="urgency" class="form-input" required>
                        <option value="">-- Select Urgency --</option>
                        <option value="Low">Low</option>
                        <option value="Medium">Medium</option>
                        <option value="High">High</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="notes" class="form-label">Additional Notes:</label>
                    <textarea id="notes" name="notes" class="form-textarea" rows="5" placeholder="Enter any specific details..."></textarea>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-submit">Submit Order</button>
                    <button type="reset" class="btn btn-cancel">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
