<?php
// Include database connection
include "conf.php";

// Initialize variables
$task_id = "";
$nurseId = "";
$nurseName = "";
$taskDescription = "";
$taskDate = "";
$taskTime = "";


// Fetch nurses from the nurse table
$nurses = [];
$nurseQuery = "SELECT nurse_id, nurse_name FROM nurses";
$result = mysqli_query($conn, $nurseQuery);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $nurses[] = $row;
    }
}

// Fetch the task details when the page is loaded with the task ID
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $task_id = $_GET['id'];

    // Prepare and execute SQL query to fetch the record
    $sql = "SELECT * FROM nurse_tasks WHERE task_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $task_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // If record exists, populate the form fields
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $nurseId = $row['nurse_id'];
            $taskDescription = $row['task_description'];
            $taskDate = $row['task_date'];
            $taskTime = $row['task_time'];
           
        } else {
            echo "<script>alert('No task found!'); window.location.href='view_tasks.php';</script>";
            exit;
        }
    } else {
        echo "Error preparing statement: " . $conn->error;
        exit;
    }
}

// Handle form submission to update the task record
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $task_id = $_POST['task_id'];
    $nurseId = $_POST['nurseId'];
    $taskDescription = $_POST['taskDescription'];
    $taskDate = $_POST['taskDate'];
    $taskTime = $_POST['taskTime'];
    

    // Prepare and execute SQL query to update the record
    $sql = "UPDATE nurse_tasks SET nurse_id = ?, task_description = ?, task_date = ?, task_time = ? WHERE task_id = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("isssi", $nurseId, $taskDescription, $taskDate, $taskTime, $task_id);
    
        // Check if the update is successful
        if ($stmt->execute()) {
            echo "<script>
                    alert('Task updated successfully!');
                    window.location.href = 'view_tasks.php'; // Redirect after successful update
                  </script>";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Nurse Task</title>
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
        <h1>Edit Nurse Task</h1>
        <div class="form-container">

            <form action="updateTask.php" method="POST">
                <!-- Hidden field for task ID -->
                <input type="hidden" name="task_id" value="<?php echo htmlspecialchars($task_id); ?>">

                <div class="form-row">
                    <label for="nurseId">Nurse Name:</label>
                    <select id="nurseId" name="nurseId" required>
                        <option value="">-- Select Nurse --</option>
                        <?php foreach ($nurses as $nurse): ?>
                            <option value="<?php echo $nurse['nurse_id']; ?>" <?php echo $nurseId == $nurse['nurse_id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($nurse['nurse_name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-row">
                    <label for="taskDescription">Task Description:</label>
                    <textarea id="taskDescription" name="taskDescription" required><?php echo htmlspecialchars($taskDescription); ?></textarea>
                </div>
                <div class="form-row">
                    <label for="taskDate">Task Date:</label>
                    <input type="date" id="taskDate" name="taskDate" value="<?php echo htmlspecialchars($taskDate); ?>" required>
                </div>
                <div class="form-row">
                    <label for="taskTime">Task Time:</label>
                    <input type="time" id="taskTime" name="taskTime" value="<?php echo htmlspecialchars($taskTime); ?>" required>
                </div>
                
                <div class="form-row">
                    <button type="submit" class="form-btn">Update Task</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
