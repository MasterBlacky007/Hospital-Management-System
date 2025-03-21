<?php
// Database connection
include "conf.php";

if (isset($_GET['nic'])) {
    $nic = $conn->real_escape_string($_GET['nic']);

    $query = "SELECT firstName, lastName, dob, age, gender, nic, address,contact FROM patient WHERE nic = '$nic'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $patient = $result->fetch_assoc();
        echo json_encode($patient);
    } else {
        echo json_encode([]);
    }
}

$conn->close();
?>
