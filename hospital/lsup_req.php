<?php
 // Database connection
 include "conf.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture form data
    $request_date = $_POST['request_date'];
    $item_name = $_POST['item_name'];
    $category = $_POST['category'];
    $quantity = $_POST['quantity'];
    $urgency = $_POST['urgency'];
    $notes = $_POST['notes'];

   

    // Insert data into the database
    $sql = "INSERT INTO lab_supplies_request(request_date, item_name, category, quantity, urgency, notes) 
            VALUES ('$request_date', '$item_name', '$category', $quantity, '$urgency', '$notes')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Request submitted successfully!'); window.location.href = 'labso.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the connection
    $conn->close();
}
?>
