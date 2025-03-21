<?php
include "conf.php"; // Include database configuration

// Check if 'date' is passed in the GET request
if (isset($_GET['date'])) {
    $date = $_GET['date'];

    // Validate the date format (YYYY-MM-DD)
    if (DateTime::createFromFormat('Y-m-d', $date) !== false) {
        // Prepare the SQL query to fetch lab requests by date
        $sql = "SELECT * FROM lab_requests WHERE DATE(request_date) = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            echo json_encode(['error' => 'Failed to prepare the query']);
            exit();
        }

        $stmt->bind_param("s", $date); // Bind the date parameter
        $stmt->execute(); // Execute the query

        $result = $stmt->get_result(); // Get the result set

        $requests = [];
        while ($row = $result->fetch_assoc()) {
            $requests[] = $row; // Store each row in the requests array
        }

        echo json_encode($requests); // Return the result as JSON
        $stmt->close();
    } else {
        echo json_encode(['error' => 'Invalid date format. Expected format: YYYY-MM-DD']);
    }
} else {
    echo json_encode(['error' => 'Date parameter is missing']);
}

$conn->close();
?>