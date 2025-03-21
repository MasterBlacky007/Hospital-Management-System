<?php
// Database connection
include "conf.php";

// Search functionality
$search = isset($_GET['search']) ? $_GET['search'] : '';

$sql = "SELECT staff.id, staff.name, staff.nic, staff.role, staff.phone 
        FROM staff 
        WHERE staff.id LIKE ? OR staff.nic LIKE ? OR staff.role LIKE ?";
$stmt = $conn->prepare($sql);
$searchParam = "%$search%";
$stmt->bind_param("sss", $searchParam, $searchParam, $searchParam);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff List</title>
    <link rel="stylesheet" href="longtables.css">
</head>
<body>

<div class="container">
    <h3>Staff List</h3>
    <button class="add-patient" onclick="window.location.href='stprofile.html' ">+ Add Staff</button>
    <button class="back" onclick="window.location.href='centerstaffdash.php'">Back</button>

    <!-- Search bar -->
    <input type="text" id="search" placeholder="Search by ID, NIC, or Position" value="<?= htmlspecialchars($search) ?>" onkeyup="searchTable()">

    <table id="staffList">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>NIC</th>
                <th>Position</th>
                <th>Phone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['name'] ?></td>
                    <td><?= $row['nic'] ?></td>
                    <td><?= $row['role'] ?></td>
                    <td><?= $row['phone'] ?></td>
                    <td class="actions">
                        <a href="viewstaff.php?id=<?= $row['id'] ?>">View</a> |
                        <a href="edit_staff.php?id=<?= $row['id'] ?>">Update</a> | 
                        <a href="delete_staff.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script>
    // Simple search function to filter table rows
    function searchTable() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("search");
        filter = input.value.toUpperCase();
        table = document.getElementById("staffList");
        tr = table.getElementsByTagName("tr");

        for (i = 1; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td");
            let matchFound = false;
            for (let j = 0; j < td.length; j++) {
                if (td[j]) {
                    txtValue = td[j].textContent || td[j].innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        matchFound = true;
                        break;
                    }
                }
            }
            if (matchFound) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
</script>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
