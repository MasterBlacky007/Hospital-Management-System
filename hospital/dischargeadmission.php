<?php
include "conf.php";

// Check if 'id' is provided in the URL
if (isset($_GET['id']) && !isset($_GET['notes'])) {
    $admission_id = $_GET['id'];

    // Capture additional record through JavaScript prompt only when notes are not yet provided
    echo "
    <script>
        var additionalNotes = prompt('Please enter additional notes for the discharge:');
        if (additionalNotes !== null && additionalNotes.trim() !== '') {
            // Send the data back to PHP and reload the page with the notes parameter
            window.location.href = 'dischargeadmission.php?id={$admission_id}&notes=' + encodeURIComponent(additionalNotes);
        } else {
            alert('Discharge canceled. Additional notes are required.');
            window.history.back();
        }
    </script>";
} elseif (isset($_GET['id'], $_GET['notes'])) {
    $admission_id = $_GET['id'];
    $additional_notes = $_GET['notes'];

    // SQL query to update the discharge details with the additional notes
    $sql = "UPDATE admissions 
            SET discharge_date = CURDATE(), 
                additional_record = ?, 
                status = 'Discharged' 
            WHERE admission_id = ?";

    // Prepare and execute the statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $additional_notes, $admission_id);

    if ($stmt->execute()) {
        echo "
        <script>
            alert('Patient discharged successfully.');
            window.location.href = 'view_discharge.php';
        </script>";
    } else {
        echo "
        <script>
            alert('Error: " . $stmt->error . "');
            window.history.back();
        </script>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "
    <script>
        alert('Invalid request.');
        window.history.back();
    </script>";
}
?>
