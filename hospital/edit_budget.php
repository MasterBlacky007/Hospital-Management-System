<?php
// Include database connection
include "conf.php";

// Get the budget_id from the URL
if (isset($_GET['id'])) {
    $budget_id = $_GET['id'];
    
    // Query to fetch the existing budget data based on the budget_id
    $sql = "SELECT * FROM budget WHERE budget_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $budget_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Fetch the budget data
        $row = $result->fetch_assoc();
    } else {
        echo "Budget not found.";
        exit;
    }
} else {
    echo "Invalid budget ID.";
    exit;
}

// Handle the form submission for updating the budget
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get updated values from the form
    $budget_id = $_POST['budget_id'];
    $description = $_POST['description'];
    $amount = $_POST['amount'];
    $starting_date = $_POST['starting_date'];
    $ending_date = $_POST['ending_date'];
    $allocated_expenses = $_POST['allocated_expenses'];
    $status = $_POST['status'];

    // Update the budget in the database
    $update_sql = "UPDATE budget SET description = ?, amount = ?, starting_date = ?, ending_date = ?, allocated_expenses = ?, status = ? WHERE budget_id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("sissisi", $description, $amount, $starting_date, $ending_date, $allocated_expenses, $status, $budget_id);
    
    if ($update_stmt->execute()) {
        // Redirect with a success message
        header("Location: bugetr.php?msg=" . urlencode("Budget updated successfully!"));
        exit;
    } else {
        echo "Error updating budget.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Budget</title>
    <link rel="stylesheet" href="budgetr.css">
</head>
<body>
    <div class="container">
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
        <div class="content">
            <h1>Edit Budget</h1>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="budget_id">Budget ID</label>
                    <input type="text" name="budget_id" id="budget_id" value="<?php echo $row['budget_id']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <input type="text" name="description" id="description" value="<?php echo $row['description']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="amount">Amount</label>
                    <input type="number" name="amount" id="amount" value="<?php echo $row['amount']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="starting_date">Starting Date</label>
                    <input type="date" name="starting_date" id="starting_date" value="<?php echo $row['starting_date']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="ending_date">Ending Date</label>
                    <input type="date" name="ending_date" id="ending_date" value="<?php echo $row['ending_date']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="allocated_expenses">Allocated Expenses</label>
                    <input type="number" name="allocated_expenses" id="allocated_expenses" value="<?php echo $row['allocated_expenses']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <input type="text" name="status" id="status" value="<?php echo $row['status']; ?>" required>
                </div>
                <div class="buttons">
                    <button type="submit" class="Add" name="action" value="Update" class="Update">Update</button>
                    <button type="reset" class="cancel">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

<?php
// Close the database connection at the end of the script
$conn->close();
?>
