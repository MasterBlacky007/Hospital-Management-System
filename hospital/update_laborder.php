<?php
// Include database connection
include('conf.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $action = $_POST['action'];

    if ($action === "approve") {
        // Approve the request
        $sql = "UPDATE lab_supplies_request SET status = 'Approved' WHERE id = $id";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Request Approved!'); window.location.href = 'viewlaborder.php';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } elseif ($action === "decline") {
        // Decline the request and get the reason using JavaScript prompt
        echo "
            <script>
                var reason = prompt('Please provide a reason for declining this request:');
                if (reason) {
                    // Send the reason back to the server
                    fetch('update_laborder.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: 'id=$id&action=decline_submit&reason=' + encodeURIComponent(reason)
                    }).then(response => {
                        if (response.ok) {
                            alert('Request Declined!');
                            window.location.href = 'viewlaborder.php';
                        } else {
                            alert('An error occurred while declining the request.');
                        }
                    }).catch(error => {
                        alert('Error: ' + error.message);
                    });
                } else {
                    alert('Decline action cancelled.');
                    window.location.href = 'viewlaborder.php';
                }
            </script>
        ";
    } elseif ($action === "decline_submit") {
        // Update the request with the decline reason
        $reason = $_POST['reason'];
        $sql = "UPDATE lab_supplies_request SET status = 'Declined', decline_reason = '$reason' WHERE id = $id";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Request Declined!'); window.location.href = 'viewlaborder.php';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
}
?>
