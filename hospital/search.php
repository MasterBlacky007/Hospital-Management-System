<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Patient Details</title>
    <link rel="stylesheet" href="lreq.css">
    <style>
                    /* Style for the input field */
            #patientInfo {
                width: 100%;
                padding: 10px;
                font-size: 16px;
                border: 1px solid #ccc;
                border-radius: 4px;
                box-sizing: border-box;
                margin-bottom: 10px;
                outline: none;
                transition: border-color 0.3s ease;
            }

            #patientInfo:focus {
                border-color: #4CAF50; 
                box-shadow: 0 0 5px rgba(76, 175, 80, 0.5);
            }

           

        </style>
</head>
<body>
    <div class="dashboard">
        <div class="sidebar">
            <div class="logo">
                <img src="logo.jpeg" alt="Hospital Logo">
                <h2>Apollo Hospital</h2>
            </div>
            <h1>MLT</h1>
            <a href="mltdashboard.php">Dashboard</a>
            <a href="profilemlt.php">My Profile</a>
            <a href="lreq.html">Test Requests</a>
            <a href="search.php">View Patient Details</a>
            <a href="labtestdash.php">Lab Test Result</a>
            <a href="labsuprdash.php">Lab Supply Request</a>
            <a href="stlogin.html">Log Out</a>
        </div>

        <div class="main">
            <div class="header">View Patient Details</div>
            <div class="form-container">
                <form id="searchForm" method="post" action="search.php">
                    <input type="text" id="patientInfo" name="patientInfo" placeholder="Enter Patient ID or Name" required>
                    <button type="submit">Search</button>
                </form>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Patient Name</th>
                        <th>Date of Birth</th>
                        <th>NIC</th>
                        <th>Address</th>
                        <th>Contact</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Database connection
                    include "conf.php";

                    // Initialize search query
                    $patientInfo = isset($_POST['patientInfo']) ? $_POST['patientInfo'] : '';

                    if ($patientInfo != '') {
                        // Query the database, concatenating firstName and lastName as patientName
                        $sql = "SELECT id, CONCAT(firstName, ' ', lastName) AS patientName, dob, nic, address, contact 
                                FROM patient 
                                WHERE id LIKE '%$patientInfo%' 
                                   OR firstName LIKE '%$patientInfo%' 
                                   OR lastName LIKE '%$patientInfo%'";

                        $result = $conn->query($sql);

                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                        <td>" . htmlspecialchars($row['id']) . "</td>
                                        <td>" . htmlspecialchars($row['patientName']) . "</td>
                                        <td>" . htmlspecialchars($row['dob']) . "</td>
                                        <td>" . htmlspecialchars($row['nic']) . "</td>
                                        <td>" . htmlspecialchars($row['address']) . "</td>
                                        <td>" . htmlspecialchars($row['contact']) . "</td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>No results found.</td></tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>Please enter search criteria.</td></tr>";
                    }

                    // Close the connection
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
