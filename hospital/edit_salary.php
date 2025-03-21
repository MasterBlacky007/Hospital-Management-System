<?php
// Database connection
include "conf.php";

$id = $_GET['id'] ?? null;
$salary = null;

// Fetch existing salary details
if ($id) {
    $sql = "SELECT * FROM salaries WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $salary = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['id'];
    $staff_id = $_POST['staff_id'];
    $staff_name = $_POST['staff_name'];
    $salary_method = $_POST['salary_method'];
    $department = $_POST['department'];
    $ot_rate = $_POST['ot_rate'];
    $ot_hours = $_POST['ot_hours'];
    $basic_salary = $_POST['basic_salary'];
    $salary_date = $_POST['salary_date'];

    $net_salary = $basic_salary + ($ot_rate * $ot_hours);

    $update_sql = "UPDATE salaries SET staff_id = ?, staff_name = ?, salary_method = ?, department = ?, ot_rate = ?, ot_hours = ?, basic_salary = ?, net_salary = ?, salary_date = ? WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("ssssiidisi", $staff_id, $staff_name, $salary_method, $department, $ot_rate, $ot_hours, $basic_salary, $net_salary, $salary_date, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Salary record updated successfully.'); window.location.href = 'salary.php';</script>";
        exit();
    } else {
        echo "<script>alert('Error updating record: " . $conn->error . "'); window.location.href = 'salary.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Salary</title>
    <link rel="stylesheet" href="viewupdate.css">
    <style>
        .form-group select {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
            appearance: none;
            cursor: pointer;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }
        .form-group select:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
            outline: none;
        }
        .form-group::after {
            content: '▼';
            font-size: 12px;
            color: #555;
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h3>Edit Salary</h3>
        
        <form method="POST" action="edit_salary.php">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($salary['id']); ?>">

            <div class="form-group">
                <label for="staff_id">Staff ID</label>
                <input type="text" id="staff_id" name="staff_id" value="<?php echo htmlspecialchars($salary['staff_id']); ?>" required>
            </div>

            <div class="form-group">
                <label for="staff_name">Staff Name</label>
                <input type="text" id="staff_name" name="staff_name" value="<?php echo htmlspecialchars($salary['staff_name']); ?>" required>
            </div>

        <div class="form-group">
            <label for="salary_method">Salary Method</label>
                <select id="salary_method" name="salary_method" required>
                <option value="Bank Transfer" <?php echo ($salary['salary_method'] === 'Bank Transfer') ? 'selected' : ''; ?>>Bank Transfer</option>
                <option value="Cash" <?php echo ($salary['salary_method'] === 'Cash') ? 'selected' : ''; ?>>Cash</option>
                <option value="Cheque" <?php echo ($salary['salary_method'] === 'Cheque') ? 'selected' : ''; ?>>Cheque</option>
            </select>
        </div>

        <div class="form-group">
            <label for="department">Department</label>
            <select id="department" name="department" required>
                <option value="administrative HR" <?php echo ($salary['department'] === 'administrative HR') ? 'selected' : ''; ?>>Administrative HR</option>
                <option value="administrative Finance" <?php echo ($salary['department'] === 'administrative Finance') ? 'selected' : ''; ?>>Administrative Finance</option>
                <option value="medical" <?php echo ($salary['department'] === 'medical') ? 'selected' : ''; ?>>Medical</option>
                <option value="other" <?php echo ($salary['department'] === 'other') ? 'selected' : ''; ?>>Other</option>
            </select>
        </div>

            <div class="form-group">
                <label for="ot_rate">OT Rate</label>
                <input type="number" id="ot_rate" name="ot_rate" step="0.01" value="<?php echo htmlspecialchars($salary['ot_rate']); ?>" required>
            </div>

            <div class="form-group">
                <label for="ot_hours">OT Hours</label>
                <input type="number" id="ot_hours" name="ot_hours" value="<?php echo htmlspecialchars($salary['ot_hours']); ?>" required>
            </div>

            <div class="form-group">
                <label for="basic_salary">Basic Salary</label>
                <input type="number" id="basic_salary" name="basic_salary" step="0.01" value="<?php echo htmlspecialchars($salary['basic_salary']); ?>" required>
            </div>

            <div class="form-group">
                <label for="salary_date">Salary Date</label>
                <input type="date" id="salary_date" name="salary_date" value="<?php echo htmlspecialchars($salary['salary_date']); ?>" required>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-update">Update</button>
            </div>
        </form>
    </div>
</body>
</html>
