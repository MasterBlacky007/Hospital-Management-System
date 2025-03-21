<?php
// Database connection details
include "conf.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salary Management</title>
    <link rel="stylesheet" href="salary.css">
    <style>
        .salary-table .actions button {
    padding: 5px 10px;
    font-size: 14px;
    color: #fff;
    background-color: #007bff; /* Blue for action buttons */
    border: none;
    border-radius: 3px;
    cursor: pointer;
}
        </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="logo">
                <img src="logo.jpeg" alt="Hospital Logo">
                <h2>Apollo Hospital</h2>
            </div>
            <a href="MFdash.php">Dashboard</a>
            <a href="profilefm.php">My Profile</a>
            <a href="bugetr.php">Budget Reports</a>
            <a href="salary.php">Salary</a>
            <a href="paymentview.php">Payments</a>
            <a href="stlogin.html">Log Out</a>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <h2>Add Salary</h2>
            <form method="POST" action="process_salary.php">
                <div class="form-group">
                    <label for="staff_id">Staff ID</label>
                    <input type="text" id="staff_id" name="staff_id" required>
                </div>
                <div class="form-group">
                    <label for="staff_name">Staff Name</label>
                    <input type="text" id="staff_name" name="staff_name" required>
                </div>
                <div class="form-group">
                    <label for="salary_method">Salary Method</label>
                    <select id="salary_method" name="salary_method" required>
                        <option value="Bank Transfer">Bank Transfer</option>
                        <option value="Cash">Cash</option>
                        <option value="Cheque">Cheque</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="department">Department</label>
                    <select id="department" name="department" required>
                        <option value="administrative HR">Administrative HR</option>
                        <option value="administrative Finance">Administrative Finance</option>
                        <option value="medical">Medical</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="ot_rate">OT Rate</label>
                    <input type="number" id="ot_rate" name="ot_rate" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="ot_hours">OT Hours</label>
                    <input type="number" id="ot_hours" name="ot_hours" required>
                </div>
                <div class="form-group">
                    <label for="basic_salary">Basic Salary</label>
                    <input type="number" id="basic_salary" name="basic_salary" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="salary_date">Salary Date</label>
                    <input type="date" id="salary_date" name="salary_date" required>
                </div>
                <div class="form-actions">
                    <button type="submit" name="action" value="add">Add</button>
                    <button type="reset">Cancel</button>
                </div>
            </form>

            <h2>Update Salary</h2>
            <table class="salary-table">
                <thead>
                    <tr>
                        <th>Salary ID</th>
                        <th>Staff ID</th>
                        <th>Staff Name</th>
                        <th>Salary Method</th>
                        <th>Department</th>
                        <th>OT Rate</th>
                        <th>OT Hours</th>
                        <th>Basic Salary</th>
                        <th>Net Salary</th>
                        <th>Salary Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include 'conf.php';
                    $sql = "SELECT * FROM salaries";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['id']}</td>
                                    <td>{$row['staff_id']}</td>
                                    <td>{$row['staff_name']}</td>
                                    <td>{$row['salary_method']}</td>
                                    <td>{$row['department']}</td>
                                    <td>{$row['ot_rate']}</td>
                                    <td>{$row['ot_hours']}</td>
                                    <td>{$row['basic_salary']}</td>
                                    <td>{$row['net_salary']}</td>
                                    <td>{$row['salary_date']}</td>
                                    <td>
                                        <div class='actions'>
                                            <form method='POST' action='delete_salary.php' style='display:inline-block;'>
                                                <input type='hidden' name='id' value='{$row['id']}'>
                                                <button type='submit'>Delete</button>
                                            </form>
                                            <a href='edit_salary.php?id={$row['id']}'>
                                                <button type='button'>Edit</button>
                                            </a>
                                        </div>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='11'>No records found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
