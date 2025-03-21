<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    $conn = new mysqli("localhost", "root", "", "mountapollo");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve form data
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $nic = $_POST['nic'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $position = $_POST['position'];
    $specialization = !empty($_POST['specialization']) ? $_POST['specialization'] : null;

    // Insert data into the staff table
    $sql = "INSERT INTO staff (email, password, role, name, nic, gender, phone, additionalNotes) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("ssssssss", $email, $password, $position, $name, $nic, $gender, $phone, $specialization);
    
    if ($stmt->execute()) {
        $staff_id = $conn->insert_id;

        // Position-specific insertion logic
        $positionTables = [
            "doctor" => "doctor",
            "nurse" => "nurses",
            "pharmacist" => "pharmacist",
            "cashier" => "cashiers",
            "receptionist" => "receptionists",
            "MLT" => "mlt",
            "finance manager" => "finance_manager",
            "inventory manager" => "inventory_manager"
        ];

        $positionField = ($position === "cashier" || $position === "receptionist" || $position === "finance manager" || $position === "inventory manager") 
            ? "NULL" : "?";

        $sql = "INSERT INTO {$positionTables[$position]} (staff_id, {$position}_name, email, specialization, phone) 
                VALUES (?, ?, ?, $positionField, ?)";
        
        $stmt = $conn->prepare($sql);

        if ($positionField === "NULL") {
            $stmt->bind_param("isss", $staff_id, $name, $email, $phone);
        } else {
            $stmt->bind_param("issss", $staff_id, $name, $email, $specialization, $phone);
        }

        if (!$stmt) {
            die("Error preparing statement: " . $conn->error);
        }

        if ($stmt->execute()) {
            echo "<script>alert('Staff member successfully registered!'); window.location.href = 'stprofile.html';</script>";
        } else {
            echo "Error inserting into position-specific table: " . $stmt->error;
        }
    } else {
        echo "Error inserting into staff table: " . $stmt->error;
    }

    // Close connections
    $stmt->close();
    $conn->close();
}
?>
