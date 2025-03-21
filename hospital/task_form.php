<?php
include('conf.php');

// Fetch nurses from the nurse table
$nurses = [];
$nurseQuery = "SELECT nurse_id, nurse_name FROM nurses";
$result = mysqli_query($conn, $nurseQuery);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $nurses[] = $row;
    }
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve the form data
    $taskDescription = mysqli_real_escape_string($conn, $_POST['taskDescription']);
    $nurseId = mysqli_real_escape_string($conn, $_POST['nurseId']);
    $taskDate = mysqli_real_escape_string($conn, $_POST['taskDate']);
    $taskTime = mysqli_real_escape_string($conn, $_POST['taskTime']);
    $assignedByStaffId = mysqli_real_escape_string($conn, $_POST['assignedBy']);  // Staff ID entered in the form

    // Fetch the staff name from the staff table based on the entered staff ID
    $staffQuery = "SELECT name FROM staff WHERE id = '$assignedByStaffId'";
    $staffResult = mysqli_query($conn, $staffQuery);
    if ($staffResult && mysqli_num_rows($staffResult) > 0) {
        $staffRow = mysqli_fetch_assoc($staffResult);
        $staffName = $staffRow['name'];  // Staff name retrieved from the staff table
    } else {
        // Handle the case where the staff ID is not found
        echo "<script>alert('Staff ID not found.'); window.location.href = 'task_form.php';</script>";
        exit;
    }

    // Insert the task assignment details into the nurse_tasks table
    $query = "INSERT INTO nurse_tasks (task_description, nurse_id, task_date, task_time, assigned_by, doctor_name) 
              VALUES ('$taskDescription', '$nurseId', '$taskDate', '$taskTime', '$assignedByStaffId', '$staffName')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Nurse task assigned successfully!');</script>";
    } else {
        echo "<script>alert('Error assigning task: " . mysqli_error($conn) . "'); window.location.href = 'task_form.php';</script>";
    }

    // Close the database connection
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Nurse Task</title>
    <link rel="stylesheet" href="dashboard1.css">
    <style>
        #nurseId {
    width: 100%;
    padding: 12px;
    border: 1px solid #1A4650;
    border-radius: 8px;
    font-size: 1rem;
    background-color: #EDF7F7; 
}

    </style>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <div class="logo">
                <img src="logo.jpeg" alt="Hospital Logo">
                <h2>Apollo Hospital</h2>
            </div>
            <h1>Doctor</h1>
        
            <a href="doctordash.html">Dashboard</a>
                    <a href="docprofile.php">My Profile</a>
                    <a href="docviewptprofile.php">Patient Profile</a>
                    <a href="presdash.php">Prescription</a>
                    <a href="labdash.php">Lab Test</a>
                    <a href="docappointment.php">Appointment</a>
                    <a href="taskdash.php">Task</a>
                    <a href="viewdprogress.php">View Progress Notes</a>
                    <a href="stlogin.html">Log Out</a>
        </div>

        <div class="main-content">
            <h2>Assign Nurse Task</h2>
            <div class="form-container">
                <form method="POST" action="task_form.php">
                    <div class="form-row">
                        <label for="taskDescription">Task Description</label>
                        <textarea id="taskDescription" name="taskDescription" required></textarea>
                    </div>
                    <div class="form-row">
                        <label for="nurseId">Nurse Name</label>
                        <select id="nurseId" name="nurseId" required>
                            <option value="">-- Select Nurse --</option>
                            <?php foreach ($nurses as $nurse): ?>
                                <option value="<?= $nurse['nurse_id'] ?>"><?= $nurse['nurse_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-row">
                        <label for="taskDate">Date</label>
                        <input type="date" id="taskDate" name="taskDate" required>
                    </div>
                    <div class="form-row">
                        <label for="taskTime">Time</label>
                        <input type="time" id="taskTime" name="taskTime" required>
                    </div>
                    <div class="form-row">
                        <label for="assignedBy">Assigned By (Staff ID)</label>
                        <input type="text" id="assignedBy" name="assignedBy" required>
                    </div>
                    <div class="form-row">
                        <button type="submit" class="register-btn">Assign Task</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
