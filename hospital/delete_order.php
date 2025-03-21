<?php
// Include database connection
include "conf.php";

// Get the raw POST data (JSON)
$data = json_decode(file_get_contents('php://input'), true);

// Extract order_id from the incoming request
$order_id = $data['order_id'];

// Prepare and execute the delete query
$sql = "DELETE FROM orders WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $order_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
?>
