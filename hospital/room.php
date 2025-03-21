<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Room</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>
<body>
    <div class="form-container">

        <div class="sidebar">
                <div class="logo">
                    <img src="logo.jpeg" alt="Hospital Logo">
                    <h2>Apollo Hospital</h2>
                </div>
                <h1>Nurse</h1>
                <nav>
                <a href="nursedashboard.html">Dashboard</a>
                <a href="nursepatient.php">Patient Profile</a>
                <a href="roomdash.php">Room</a>
                <a href="admissiondash.php">Admission</a>
                <a href="mytask.php">My Task</a>
                <a href="viewlabtest.php">View Lab Test Results</a>
                <a href="pres_view.php">View Prescription</a>
                <a href="vitalsigndash.php">Vital Sign</a>
                <a href="progressdash.php">Progress Notes</a>
                <a href="stlogin.html">Logout</a>
                </nav>
        </div>
        <div class="main-content">
            <h1>Add Room</h1>
            <form action="roomdata.php" method="POST" onsubmit="return validateForm()">
                <!-- Room No -->
                <div class="form-row">
                    <label for="room_no">Room No:</label>
                    <input type="text" id="room_no" name="room_no" required>
                </div>

                <!-- Department -->
                <div class="form-row">
                    <label for="department">Department:</label>
                    <select id="department" name="department" required>
                        <option value="">Select Department</option>
                        <option value="OPD">OPD</option>
                        <option value="ETU">ETU</option>
                        <option value="Dental">Dental</option>
                        <option value="Eye">Eye</option>
                        <option value="Cosmetic Center">Cosmetic Center</option>
                        <option value="Inward Room">Inward Room</option>
                    </select>
                </div>

                <!-- Room Type -->
                <div class="form-row">
                    <label for="room_type">Room Type:</label>
                    <select id="room_type" name="room_type" required>
                        <option value="">Select Room Type</option>
                        <option value="General">General</option>
                        <option value="Private">Private</option>
                        <option value="ICU">ICU</option>
                    </select>
                </div>

                <!-- Status -->
                <div class="form-row">
                    <label for="status">Status:</label>
                    <div>
                        <input type="radio" id="available" name="status" value="Available" required>
                        <label for="available">Available</label>
                        
                        <input type="radio" id="not_available" name="status" value="Not Available">
                        <label for="not_available">Not Available</label>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="form-row">
                    <button type="submit" class="form-btn">Add Room</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
