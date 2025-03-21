<?php
// Database connection
include "conf.php";

// Fetch patient data
$sql = "SELECT * FROM patientprofile";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient List - Mount Apollo Hospital</title>
    <link rel="stylesheet" href="viewtable.css">
    <style>
        .btn-update, .btn-delete {
            display: block;
            width: 100px;
            padding: 5px;
            margin: 2px 0;
            text-align: center;
            text-decoration: none;
            border-radius: 4px;
        }
        .btn-update {
            background-color: #4CAF50;
            color: white;
        }
        .btn-delete {
            background-color: #f44336;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h3>Patient Profile List</h3>

        <button class="back" onclick="window.location.href='receppatdet.php'">Back</button>
        
        <input type="text" id="search" placeholder="Search by any field...">
        
        <table id="patientTable">
            <thead>
                <tr>
                    <th>Profile ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Gender</th>
                    <th>Age</th>
                    <th>DOB</th>
                    <th>NIC</th>
                    <th>Mobile No</th>
                    <th>Address</th>
                    <th>Email</th>
                    <th>Special Notes</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['firstname'] . "</td>";
                        echo "<td>" . $row['lastname'] . "</td>";
                        echo "<td>" . $row['gender'] . "</td>";
                        echo "<td>" . $row['age'] . "</td>";
                        echo "<td>" . $row['dob'] . "</td>";
                        echo "<td>" . $row['nic'] . "</td>";
                        echo "<td>" . $row['contact'] . "</td>";
                        echo "<td>" . $row['address'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>" . $row['special_notes'] . "</td>";
                        echo "<td>";
                        echo "<a href='recuprpat.php?id=" . $row['id'] . "' class='btn-update'>Update</a>";
                        echo "<a href='recdelrpat.php?id=" . $row['id'] . "' class='btn-delete' onclick='return confirm(\"Are you sure you want to delete this patient?\");'>Delete</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='12'>No patients found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

   
    <script>
        document.getElementById('search').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#patientTable tbody tr');

            rows.forEach(row => {
                let match = false;
                const cells = row.querySelectorAll('td');
                cells.forEach(cell => {
                    if (cell.textContent.toLowerCase().includes(searchTerm)) {
                        match = true;
                    }
                });

                row.style.display = match ? '' : 'none';
            });
        });
    </script>
</body>
</html>

<?php
$conn->close();
?>
