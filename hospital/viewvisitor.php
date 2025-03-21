<?php
// Database connection
include "conf.php";

// Fetch patient data
$sql = "SELECT * FROM visitors";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visitors List</title>
    <link rel="stylesheet" href="viewtable.css">
</head>
<body>
    <div class="container">
        <h3>Visitors List</h3>
        <button class="add-patient" onclick="window.location.href='addvisitor.php'">+ Add Visitor</button>
        <button class="back" onclick="window.location.href='visitordash.php'">Back</button>
        
        <input type="text" id="search" placeholder="Search by any field...">
        
        <table id="VisitorTable">
            <thead>
                <tr>
                    <th>Visitor ID</th>
                    <th>Visitor Name</th>
                    <th>NIC</th>
                    <th>Address</th>
                    <th>Contact No</th>
                    <th>Purpose</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['visitor_id'] . "</td>";
                        echo "<td>" . $row['visitor_name'] . "</td>";
                        echo "<td>" . $row['nic'] . "</td>";
                        echo "<td>" . $row['address'] . "</td>";
                        echo "<td>" . $row['contact'] . "</td>";
                        echo "<td>" . $row['purpose'] . "</td>";
                        echo "<td>" . $row['date'] . "</td>";
                        echo "<td>" . $row['time'] . "</td>";
                        echo "<td>
                            <button class='view-button' onclick=\"viewVisitor('" . $row['visitor_id'] . "')\">View</button>
                        </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='11'>No visitor found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    
    <script>
      

document.getElementById('search').addEventListener('input', function() {
    const filter = this.value.toLowerCase();
    const rows = document.querySelectorAll('#VisitorTable tbody tr');
    
    rows.forEach(row => {
        let isMatch = false;
        row.querySelectorAll('td').forEach(cell => {
            if (cell.textContent.toLowerCase().includes(filter)) {
                isMatch = true;
            }
        });

        if (isMatch) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

// Function to view visitor details (optional)
function viewVisitor(visitorId){
    window.location.href = "view_visitor.php?visitor_id=" + visitorId;
}

    </script>
    
</body>
</html>

<?php
$conn->close();
?>
