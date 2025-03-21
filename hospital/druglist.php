<?php
// Database connection
include "conf.php";

// Fetch data from the drug_list table
$sql = "SELECT * FROM drugs";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Drug List</title>
    <link rel="stylesheet" href="longtable.css">
</head>
<body>

<div class="container">
    <!-- Back Button -->
    <button class="back" onclick="window.location.href='drugdash.php'">Back</button>

    <!-- Main Content -->
    <div class="form-container">
        <h2>Drug List</h2>

        <!-- Search Bar -->
        <input type="text" id="search" placeholder="Search by any field..." onkeyup="searchTable()">
        
        <table id="drugTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Drug Name</th>
                    <th>Category</th>
                    <th>Dosage Form</th>
                    <th>Dosage</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td data-label='ID'>" . $row['drug_id'] . "</td>";
                        echo "<td data-label='Drug Name'>" . $row['drug_name'] . "</td>";
                        echo "<td data-label='Category'>" . $row['category'] . "</td>";
                        echo "<td data-label='Dosage Form'>" . $row['dosage_form'] . "</td>";
                        echo "<td data-label='Dosage'>" . $row['dosage'] . "</td>";
                        echo "<td data-label='Actions'>
                            <a href='dledit.php?id=" . $row['drug_id'] . "' class='btn accept'>Update</a>
                            <a href='delete_drug.php?id=" . $row['drug_id'] . "' class='btn reject' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                        </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No drugs found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script src="phscript.js"></script> <!-- Link to external JS file -->

</body>
</html>

<?php
// Close connection
$conn->close();
?>
