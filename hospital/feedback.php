<?php
session_start(); // Start the session to retrieve messages
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Form</title>
    <link rel="stylesheet" href="fdback.css">
</head>
<body>
    <div class="container">
        <!-- Main Content -->
        <div class="main-content">
            <h1>Feedback Form</h1>

            <?php
            // Check if there is a feedback message set in the session
            if (isset($_SESSION['feedback_message'])) {
                $message = $_SESSION['feedback_message'];
                $status = $_SESSION['feedback_status'];

                // Display the message with appropriate styling
                echo "<div class='message $status'>$message</div>";

                // Clear the session message after displaying it
                unset($_SESSION['feedback_message']);
                unset($_SESSION['feedback_status']);
            }
            ?>

            <form action="feedbacks.php" method="post">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" placeholder="Enter your name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="form-group">
                    <label for="message">Message:</label>
                    <textarea id="message" name="message" placeholder="Enter your feedback" required></textarea>
                </div>
                <button type="submit" class="submit-btn">Submit</button>
                <a href="patientdash.html" class="back-btn">Back</a>
            </form>

            <!-- Back Button -->
            
        </div>
    </div>
</body>
</html>
