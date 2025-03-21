<?php
// Database connection
include "conf.php";

// Fetch patient data from the correct `patient` table
$sql = "SELECT id, firstName, lastName, dob, age, gender, nic, address, contact FROM patient";
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
        <h3>Registered Patient List</h3>

        <button class="back" onclick="window.location.href='receppatdet.php'">Back</button>
        
        <input type="text" id="search" placeholder="Search by any field...">
        
        <table id="patientTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Date of Birth</th>
                    <th>Age</th>
                    <th>Gender</th>
                    <th>NIC</th>
                    <th>Address</th>
                    <th>Contact</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['firstName'] . "</td>";
                        echo "<td>" . $row['lastName'] . "</td>";
                        echo "<td>" . $row['dob'] . "</td>";
                        echo "<td>" . $row['age'] . "</td>";
                        echo "<td>" . $row['gender'] . "</td>";
                        echo "<td>" . $row['nic'] . "</td>";
                        echo "<td>" . $row['address'] . "</td>";
                        echo "<td>" . $row['contact'] . "</td>";
                        echo "<td>
                                <button class='btn-update' onclick=\"window.location.href='recupreg.php?id=" . $row['id'] . "'\">Update</button>
                                <button class='btn-delete' onclick=\"deletePatient(" . $row['id'] . ")\">Delete</button>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='10'>No patients found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script>
        // Search functionality
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

        // Delete confirmation function
        function deletePatient(id) {
            if (confirm("Are you sure you want to delete this patient?")) {
                window.location.href = 'recregdel.php?id=' + id;
            }
        }
    </script>
</body>
</html>

<?php
$conn->close();
?>
