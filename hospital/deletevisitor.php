<?php

include('conf.php');

// Initialize variables
$visitorData = [];
$errorMessage = "";

// Step 1: Load Visitor Details
if (isset($_POST['load_details'])) {
    // Get the contact number and date from the form
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);

    // Query to fetch the visitor details
    $query = "SELECT * FROM visitors WHERE contact = '$contact' AND date = '$date'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        // Fetch visitor details
        $visitorData = mysqli_fetch_assoc($result);
    } else {
        $errorMessage = "No visitor found with this contact number and date!";
    }
}

// Step 2: Delete Visitor
if (isset($_POST['delete_visitor'])) {
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);

    // Query to delete the visitor
    $deleteQuery = "DELETE FROM visitors WHERE contact = '$contact'";
    if (mysqli_query($conn, $deleteQuery)) {
        echo "<script>
            alert('Visitor deleted successfully!');
            window.location.href = 'visitordash.php'; 
        </script>";
        exit;
    } else {
        echo "Error deleting visitor: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Visitor</title>
    <link rel="stylesheet" href="style.css">

    <script>
        function confirmDelete() {
            return confirm('Are you sure you want to delete this visitor?');
        }
    </script>
</head>
<body>
    <h2>Delete Visitor</h2>
    <div class="form-container">
        <!-- Step 1: Load Visitor Details -->
        <form action="deletevisitor.php" method="POST">
            <div class="form-row">
                <label for="contact">Enter Contact No:</label>
                <input type="text" id="contact" name="contact" required>
            </div>
            <div class="form-row">
                <label for="date">Enter Date:</label>
                <input type="date" id="date" name="date" required>
            </div>
            <div class="form-row">
                <button type="submit" name="load_details" class="form-btn">Load Details</button>
            </div>
        </form>

        <?php if (!empty($visitorData)): ?>
            <h3>Visitor Details</h3>
            <p><strong>Visitor Name:</strong> <?= $visitorData['visitor_name'] ?></p>
            <p><strong>NIC:</strong> <?= $visitorData['nic'] ?></p>
            <p><strong>Address:</strong> <?= $visitorData['address'] ?></p>
            <p><strong>Contact No:</strong> <?= $visitorData['contact'] ?></p>
            <p><strong>Purpose:</strong> <?= $visitorData['purpose'] ?></p>
            <p><strong>Date:</strong> <?= $visitorData['date'] ?></p>
            <p><strong>Time:</strong> <?= $visitorData['time'] ?></p>

            <!-- Step 2: Confirm and Delete Visitor -->
            <form action="deletevisitor.php" method="POST" onsubmit="return confirmDelete();">
                <input type="hidden" name="contact" value="<?= $visitorData['contact'] ?>">
                <button type="submit" name="delete_visitor" class="form-btn">Delete Visitor</button>
            </form>
        <?php endif; ?>

        <?php if (!empty($errorMessage)): ?>
            <p class="error-message"><?= $errorMessage ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
