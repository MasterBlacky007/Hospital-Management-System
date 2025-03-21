<?php
// Database connection
include "conf.php";

// Check if 'id' parameter is passed in the URL
if (isset($_GET['id'])) {
    $staff_id = $_GET['id'];

    // Start a transaction to ensure data consistency
    $conn->begin_transaction();

    try {
        // First, check if the staff member exists in the 'staff' table
        $sql = "SELECT * FROM staff WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $staff_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Delete staff member from position-specific table based on their role
            $staff = $result->fetch_assoc();
            $role = $staff['role'];

            // Position-specific delete queries
            switch ($role) {
                case 'doctor':
                    $sql = "DELETE FROM doctor WHERE staff_id = ?";
                    break;
                case 'nurse':
                    $sql = "DELETE FROM nurses WHERE staff_id = ?";
                    break;
                case 'pharmacist':
                    $sql = "DELETE FROM pharmacist WHERE staff_id = ?";
                    break;
                case 'cashier':
                    $sql = "DELETE FROM cashiers WHERE staff_id = ?";
                    break;
                case 'receptionist':
                    $sql = "DELETE FROM receptionists WHERE staff_id = ?";
                    break;
                case 'MLT':
                    $sql = "DELETE FROM mlt WHERE staff_id = ?";
                    break;
                case 'finance manager':
                    $sql = "DELETE FROM finance_manager WHERE staff_id = ?";
                    break;
                case 'inventory manager':
                    $sql = "DELETE FROM inventory_manager WHERE staff_id = ?";
                    break;
                default:
                    // If the role doesn't match any known position, skip position-specific deletion
                    break;
            }

            // Execute the position-specific deletion query if applicable
            if (isset($sql)) {
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $staff_id);
                $stmt->execute();
            }

            // Now delete from the 'staff' table
            $sql = "DELETE FROM staff WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $staff_id);
            $stmt->execute();

            // Commit the transaction
            $conn->commit();

            // Redirect back to the staff list page with a success message
            echo "<script>alert('Staff member successfully deleted!'); window.location.href = 'view_staff.php';</script>";
        } else {
            echo "Staff member not found.";
        }
    } catch (Exception $e) {
        // Rollback the transaction if something goes wrong
        $conn->rollback();
        echo "Error deleting staff member: " . $e->getMessage();
    }
} else {
    echo "No staff ID provided.";
}

// Close the database connection
$conn->close();
?>
