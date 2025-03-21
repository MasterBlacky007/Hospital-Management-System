<?php
// Include database connection
include "conf.php";

// Check if a success message exists in the URL query string
if (isset($_GET['msg'])) {
    $msg = urldecode($_GET['msg']);
    echo "<script type='text/javascript'>alert('$msg');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Budget Records</title>
    <link rel="stylesheet" href="budgetr.css">
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <div class="logo">
                <img src="logo.jpeg" alt="Hospital Logo">
                <h2>Apollo Hospital</h2>
            </div>
            <h1>Finance Manager </h1>
            <a href="MFdash.php">Dashboard</a>
            <a href="profilefm.php">My Profile</a>
            <a href="bugetr.php">Budget Reports</a>
            <a href="salary.php">Salary</a>
            <a href="paymentview.php">Payments</a>
            <a href="stlogin.html">Log Out</a>
        </div>
        <div class="content">
            <h1>Budget Records</h1>
            <form method="POST" action="process.php">
                <input type="hidden" name="edit_index" id="edit_index" value="">
                <div class="form-group">
                    <label for="budget_id">Budget ID</label>
                    <input type="text" name="budget_id" id="budget_id">
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <input type="text" name="description" id="description" required>
                </div>
                <div class="form-group">
                    <label for="amount">Amount</label>
                    <input type="number" name="amount" id="amount" required>
                </div>
                <div class="form-group">
                    <label for="starting_date">Starting Date</label>
                    <input type="date" name="starting_date" id="starting_date" required>
                </div>
                <div class="form-group">
                    <label for="ending_date">Ending Date</label>
                    <input type="date" name="ending_date" id="ending_date" required>
                </div>
                <div class="form-group">
                    <label for="allocated_expenses">Allocated Expenses</label>
                    <input type="number" name="allocated_expenses" id="allocated_expenses" required>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <input type="text" name="status" id="status" required>
                </div>
                <div class="buttons">
                    <button type="submit" name="action" value="Add" class="Add">Add</button>
                    <button type="reset" class="cancel">Cancel</button>
                </div>
            </form>
            <table>
                <thead>
                    <tr>
                        <th>Budget ID</th>
                        <th>Description</th>
                        <th>Amount</th>
                        <th>Starting Date</th>
                        <th>Ending Date</th>
                        <th>Allocated Expenses</th>
                        <th>Remaining Amount</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Query to fetch budget reports
                    $sql = "SELECT *, (amount - allocated_expenses) AS remaining_amount FROM budget";
                    $result = $conn->query($sql);

                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                <td>{$row['budget_id']}</td>
                                <td>{$row['description']}</td>
                                <td>{$row['amount']}</td>
                                <td>{$row['starting_date']}</td>
                                <td>{$row['ending_date']}</td>
                                <td>{$row['allocated_expenses']}</td>
                                <td>{$row['remaining_amount']}</td>
                                <td>{$row['status']}</td>
                                <td class='actions'>
                                    <a href='edit_budget.php?id={$row['budget_id']}'><button type='button'>Edit</button></a>
                                    <a href='delete_budget.php?id={$row['budget_id']}' onclick=\"return confirm('Are you sure you want to delete this record?');\"><button type='button'>Delete</button></a>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='9'>No records found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

<?php
// Close the database connection at the end of the script
$conn->close();
?>
