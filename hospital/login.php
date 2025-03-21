<?php
include "conf.php";

session_start();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $userRole = $_POST['userRole'];

    // Input validation
    if (!empty($email) && !empty($password) && !empty($userRole)) {
        // Prepare the SQL query
        $sql = "SELECT * FROM staff WHERE email = ? AND role = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $email, $userRole);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Verify password (simple comparison)
            if ($password === $user['password']) {
                // Store user info in the session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_role'] = $userRole;
                $_SESSION['user_name'] = $user['name'];

                // Redirect to role-based dashboard
                switch ($userRole) {
                    case "cmanager":
                        header("Location: centerdash.php");
                        break;
                    case "imanager":
                        header("Location: inventorymanager.php");
                        break;
                    case "fmanager":
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
            }  else {
                // Invalid password
                echo "<script>
                        alert('Invalid password. Please try again.');
                        window.location.href = 'login.html';
                      </script>";
                exit();
            }
        } else {
            // No user found
            echo "<script>
                    alert('No user found with the provided credentials.');
                    window.location.href = 'login.html';
                  </script>";
            exit();
        }
    } else {
        // Missing fields
        echo "<script>
                alert('All fields are required.');
                window.location.href = 'login.html';
              </script>";
        exit();
    }
}
?>
