<?php
// Include database connection
include "conf.php";

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get form data
    $budget_id = $_POST['budget_id'];
    $description = $_POST['description'];
    $amount = $_POST['amount'];
    $starting_date = $_POST['starting_date'];
    $ending_date = $_POST['ending_date'];
    $allocated_expenses = $_POST['allocated_expenses'];
    $status = $_POST['status'];

    // Check if the form is for adding or editing (edit_index is set for editing)
    if (isset($_POST['edit_index']) && $_POST['edit_index'] != '') {
        // Update query
        $sql = "UPDATE budget 
                SET description='$description', amount='$amount', starting_date='$starting_date', ending_date='$ending_date', 
                    allocated_expenses='$allocated_expenses', status='$status', updated_at=NOW() 
                WHERE budget_id='$budget_id'";

        if ($conn->query($sql) === TRUE) {
            // Redirect with success message
            header("Location: bugetr.php?msg=Record%20updated%20successfully");
            exit;
        } else {
            // Error updating record
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        // Insert query for adding a new budget
        $sql = "INSERT INTO budget (budget_id, description, amount, starting_date, ending_date, allocated_expenses, status)
                VALUES ('$budget_id', '$description', '$amount', '$starting_date', '$ending_date', '$allocated_expenses', '$status')";

        if ($conn->query($sql) === TRUE) {
            // Redirect with success message
            header("Location: bugetr.php?msg=New%20record%20added%20successfully");
            exit;
        } else {
            // Error inserting record
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Close the database connection
$conn->close();
?>
