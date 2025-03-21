<?php
include "conf.php";
session_start();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $userRole = trim($_POST['userRole']);

    // Input validation
    if (!empty($email) && !empty($password) && !empty($userRole)) {
        // Prepare the SQL query
        $sql = "SELECT id, name, password, role FROM staff WHERE email = ? AND role = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $email, $userRole);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Verify password
            if ($password === $user['password']){ 
                // Store user info in the session
                $_SESSION['user_id'] = $user['id']; // Staff ID for assigning tasks
                $_SESSION['user_role'] = $user['role'];
                $_SESSION['user_name'] = $user['name'];

                // Redirect to role-based dashboard
                switch ($userRole) {
                    case "center manager":
                        header("Location: centerdash.php");
                        break;
                    case "inventory manager":
                        header("Location: inventorymanager.php");
                        break;
                    case "finance manager":
                        header("Location: MFdash.php");
                        break;
                    case "doctor":
                        header("Location: doctordash.html");
                        break;
                    case "nurse":
                        header("Location: nursedashboard.html");
                        break;
                    case "pharmacist":
                        header("Location: pharmasictdashboard.php");
                        break;
                    case "MLT":
                        header("Location: mltdashboard.php");
                        break;
                    case "receptionist":
                        header("Location: receptionistdashboard.html");
                        break;
                    case "cashier":
                        header("Location: cashierdash.php");
                        break;
                    default:
                        header("Location: login.html");
                        break;
                }
                exit();
            } else {
                // Invalid password
                echo "<script>
                        alert('Invalid password. Please try again.');
                        window.location.href = 'stlogin.html';
                      </script>";
                exit();
            }
        } else {
            // No user found
            echo "<script>
                    alert('No user found with the provided credentials.');
                    window.location.href = 'stlogin.html';
                  </script>";
            exit();
        }
    } else {
        // Missing fields
        echo "<script>
                alert('All fields are required.');
                window.location.href = 'stlogin.html';
              </script>";
        exit();
    }
}
?>
