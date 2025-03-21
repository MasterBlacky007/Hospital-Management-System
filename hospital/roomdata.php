<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $room_no = $_POST['room_no'];
    $department = $_POST['department'];
    $room_type = $_POST['room_type'];
    $status = $_POST['status'];

    // Database connection
    include "conf.php";

    $sql = "INSERT INTO rooms (room_no, department, room_type, status) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $room_no, $department, $room_type, $status);

    if ($stmt->execute()) {
        echo "<script>alert('Room added successfully!');window.location.href = 'room.php';</script></script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
