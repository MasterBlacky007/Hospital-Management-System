<?php
// Database connection details
include "conf.php";

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];

    // Add Salary
    if ($action == "add") {
        $staff_id = $_POST['staff_id'];
        $staff_name = $_POST['staff_name'];
        $salary_method = $_POST['salary_method'];
        $department = $_POST['department'];
        $ot_rate = $_POST['ot_rate'];
        $ot_hours = $_POST['ot_hours'];
        $basic_salary = $_POST['basic_salary'];
        $salary_date = $_POST['salary_date'];

        // Calculate Net Salary
        $net_salary = $basic_salary + ($ot_rate * $ot_hours);

        // SQL query to insert data
        $sql = "INSERT INTO salaries (staff_id, staff_name, salary_method, department, ot_rate, ot_hours, basic_salary, net_salary, salary_date)
                VALUES ('$staff_id', '$staff_name', '$salary_method', '$department', '$ot_rate', '$ot_hours', '$basic_salary', '$net_salary', '$salary_date')";

    // Update Salary (Not implemented in this example)
    if ($conn->query($sql) === TRUE) {
        echo "Record added successfully!";
        header("Location: salary.php"); // Redirect back to the form page
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
}

// Close connection
$conn->close();
?>