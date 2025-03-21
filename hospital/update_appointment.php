<?php
include "conf.php";

// Handle the POST request to update appointment status
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Parse JSON input
    $input = json_decode(file_get_contents('php://input'), true);
    $appointmentid = $input['appointmentid'] ?? null;
    $status = $input['status'] ?? null;

    if ($appointmentid && $status) {
        $sql = "UPDATE appointments SET status = ? WHERE appointmentid = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $status, $appointmentid);

        if ($stmt->execute()) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "error" => $stmt->error]);
        }
    } else {
        echo json_encode(["success" => false, "error" => "Invalid input."]);
    }
} else {
    echo json_encode(["success" => false, "error" => "Invalid request method."]);
}
