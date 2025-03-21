<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "mountapollo");

// Error handling
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Queries to get counts
$totalPatients = $conn->query("SELECT COUNT(*) AS count FROM patient")->fetch_assoc()['count'];
$totalProfiles = $conn->query("SELECT COUNT(*) AS count FROM patientprofile")->fetch_assoc()['count'];

// Calculate percentages
$profilesPercentage = ($totalPatients > 0) ? ($totalProfiles / $totalPatients) * 100 : 0;
$withoutProfilesPercentage = 100 - $profilesPercentage;

// Timezone for Sri Lanka
date_default_timezone_set("Asia/Colombo");
$createdBy = "Center Manager"; // Replace with the actual creator's name
$createdTime = date("Y-m-d H:i:s");
$updatedTime = date("Y-m-d H:i:s");

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Analytics Report</title>
    <link rel="stylesheet" href="patientreport1.css"> <!-- External CSS -->
</head>
<body>
    <div class="report">
        <!-- Letterhead -->
        <div class="letterhead">
            <img src="logo.jpeg" alt="Hospital Letterhead" class="logo">
            <div class="details">
                <h1>MOUNT APOLLO HOSPITALS (PVT) LTD</h1>
                <p>No. 355, Maharagama Road, Boralesgamuwa</p>
                <p>Tel: 077 20 20 261, 077 20 20 578, 011 2 150 150</p>
                <p>Email: info@mountapollohospitals.com | Web: www.mountapollohospitals.com</p>
            </div>
            
        </div>
        <div class="header-details">
    <div class="left">
        <p><strong>Created By:</strong> <?php echo $createdBy; ?></p>
    </div>
    <div class="right">
        <p><strong>Created Date & Time:</strong> <?php echo $createdTime; ?></p>
    </div>
</div>

        <h2>Patient Analytics Report</h2>
       

        <!-- Overview Section -->
        

        <!-- Table Section -->
        <div class="table-section">
          
            <table>
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Total Count</th>
                        <th>Percentage</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Total Patients Registered</td>
                        <td><?php echo $totalPatients; ?></td>
                        <td>100%</td>
                    </tr>
                    <tr>
                        <td>Total Profiles Created</td>
                        <td><?php echo $totalProfiles; ?></td>
                        <td><?php echo number_format($profilesPercentage, 2); ?>%</td>
                    </tr>
                    <tr>
                        <td>Patients without Profiles</td>
                        <td><?php echo $totalPatients - $totalProfiles; ?></td>
                        <td><?php echo number_format($withoutProfilesPercentage, 2); ?>%</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Analytics Section -->
        <div class="analytics">
            <h2>Overview</h2>
            <p>Total Patients Registered: <strong><?php echo $totalPatients; ?></strong></p>
            <p>Total Profiles Created: <strong><?php echo $totalProfiles; ?></strong></p>
            <p>Profiles as Percentage of Registrations: <strong><?php echo number_format($profilesPercentage, 2); ?>%</strong></p>
        </div>

      
        
        <button onclick="window.print()" class="print-btn">Print Report</button>
    </div>
</body>
</html>
