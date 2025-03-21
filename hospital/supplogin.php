<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="login-container">
        <div class="logo">
            <img src="logo.jpeg" alt="Hospital Logo" class="logo">
        </div>


        <!-- Login form -->
        <form action="suplogin.php" method="POST" class="login-form">
            <h2>Supplier Login</h2>
            <input type="text" name="email" placeholder="Enter your email" required>
            <input type="password" name="password" placeholder="Enter your password" required>
            <button type="submit" class="login-btn">Login</button>
        </form>

        <!-- Error message container -->
        <p id="error-message" class="error-message">
            <?php
            session_start();
            if (isset($_SESSION['error_message'])) {
                echo $_SESSION['error_message'];
                unset($_SESSION['error_message']); // Clear message after displaying
            }
            ?>
        </p>
    </div>
</body>
</html>
