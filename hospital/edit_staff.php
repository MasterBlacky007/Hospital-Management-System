<?php
// Database connection
include "conf.php";

if (!isset($_GET['id'])) {
    die("Invalid request. No staff ID provided.");
}

$staff_id = $_GET['id'];
$staffQuery = "SELECT * FROM staff WHERE id = ?";
$stmt = $conn->prepare($staffQuery);
$stmt->bind_param("i", $staff_id);
$stmt->execute();
$staff = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$staff) {
    die("Staff member not found.");
}

// Define position-to-table mapping
$positionTables = [
    "doctor" => "doctor",
    "nurse" => "nurses",
    "pharmacist" => "pharmacist",
    "MLT" => "mlt",
    "receptionist" => "receptionists",
    "cashier" => "cashiers",
    "finance manager" => "finance_manager",
    "inventory manager" => "inventory_manager"
];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $nic = $_POST['nic'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $new_position = $_POST['position'];
    $specialization = !empty($_POST['specialization']) ? $_POST['specialization'] : null;

    $old_position = $staff['role'];
    $updateQuery = "UPDATE staff SET name = ?, gender = ?, nic = ?, phone = ?, email = ?, password = ?, role = ?, additionalNotes = ? WHERE id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("ssssssssi", $name, $gender, $nic, $phone, $email, $password, $new_position, $specialization, $staff_id);
    $stmt->execute();
    
    // Position change handling
    if ($new_position !== $old_position) {
        // Delete old position record
        $deleteOldQuery = "DELETE FROM {$positionTables[$old_position]} WHERE staff_id = ?";
        $stmt = $conn->prepare($deleteOldQuery);
        $stmt->bind_param("i", $staff_id);
        $stmt->execute();

        // Insert into new position record
        $insertNewQuery = "INSERT INTO {$positionTables[$new_position]} (staff_id, {$new_position}_name, email, specialization, phone) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertNewQuery);
        $stmt->bind_param("issss", $staff_id, $name, $email, $specialization, $phone);
        $stmt->execute();
    }

    echo "<script>alert('Staff member updated successfully!'); window.location.href = 'view_staff.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Staff</title>
    <link rel="stylesheet" href="regstaff.css">
</head>
<body>
    <div class="content">
        <center><h1>Edit Staff Member</h1></center>
        <form method="POST">
            <input type="text" name="name" value="<?= htmlspecialchars($staff['name']) ?>" required>
            <select name="gender" required>
                <option value="Male" <?= $staff['gender'] == 'Male' ? 'selected' : '' ?>>Male</option>
                <option value="Female" <?= $staff['gender'] == 'Female' ? 'selected' : '' ?>>Female</option>
            </select>
            <input type="text" name="nic" value="<?= htmlspecialchars($staff['nic']) ?>" required>
            <input type="text" name="phone" value="<?= htmlspecialchars($staff['phone']) ?>" required>
            <input type="email" name="email" value="<?= htmlspecialchars($staff['email']) ?>" required>
            <input type="password" name="password" value="<?= htmlspecialchars($staff['password']) ?>" required>
            <select name="position" required>
                <option value="doctor" <?= $staff['role'] == 'doctor' ? 'selected' : '' ?>>Doctor</option>
                <option value="nurse" <?= $staff['role'] == 'nurse' ? 'selected' : '' ?>>Nurse</option>
                <option value="pharmacist" <?= $staff['role'] == 'pharmacist' ? 'selected' : '' ?>>Pharmacist</option>
                <option value="MLT" <?= $staff['role'] == 'MLT' ? 'selected' : '' ?>>MLT</option>
                <option value="receptionist" <?= $staff['role'] == 'receptionist' ? 'selected' : '' ?>>Receptionist</option>
                <option value="cashier" <?= $staff['role'] == 'cashier' ? 'selected' : '' ?>>Cashier</option>
                <option value="finance manager" <?= $staff['role'] == 'finance manager' ? 'selected' : '' ?>>Finance Manager</option>
                <option value="inventory manager" <?= $staff['role'] == 'inventory manager' ? 'selected' : '' ?>>Inventory Manager</option>
            </select>
            <input type="text" name="specialization" value="<?= htmlspecialchars($staff['additionalNotes']) ?>">
            <button type="submit">Update</button>
            <a href="view_staff.php" style="display: block; text-align: center; margin-top: 10px; text-decoration: none; color: white; background-color: #007BFF; padding: 10px 15px; border-radius: 5px;">Back</a>
        </form>
    </div>
</body>
</html>
