<?php
session_start();

// Database connection
include "conf.php";

// Retrieve the logged-in patient's contact number
if (!isset($_SESSION['contact_number'])) {
    header("Location: plogin.html");
    exit();
}

$contact_number = $_SESSION['contact_number'];

// Retrieve lab test results by contact number
$sql = "
    SELECT 
        lr.id AS result_id, 
        lr.patientName, 
        p.contact, 
        lr.testType, 
        lr.filePath, 
        lr.testDate, 
        lr.resultDetails, 
        lr.created_at
    FROM lab_test_results lr
    JOIN patientprofile p ON lr.contact = p.contact
    WHERE p.contact = ?";  // Filter by contact number

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $contact_number);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab Results</title>
    <link rel="stylesheet" href="result.css">
    <script>
        let originalData = [];
        
        // Store original data for reset
        window.onload = function() {
            let rows = document.querySelectorAll("#results-table tbody tr");
            rows.forEach(row => {
                originalData.push(row.innerHTML);
            });
        }

        // Real-time search function
        function filterResults() {
            const searchTerm = document.getElementById("search-input").value.toLowerCase();
            const table = document.getElementById("results-table");
            const rows = table.getElementsByTagName("tr");

            for (let i = 1; i < rows.length; i++) {  // Start from index 1 to skip the table header row
                let row = rows[i];
                let cells = row.getElementsByTagName("td");
                let found = false;

                // Loop through all cells in the row to check if the search term matches
                for (let j = 0; j < cells.length; j++) {
                    if (cells[j].textContent.toLowerCase().includes(searchTerm)) {
                        found = true;
                        break;
                    }
                }

                // Show row if found, otherwise hide it
                row.style.display = found ? "" : "none";
            }
        }

        // Clear search field and reset the table
        function clearSearch() {
            document.getElementById("search-input").value = "";
            resetTable();  // Reset the table to its original state
        }

        // Reset the table to its original content
        function resetTable() {
            const table = document.getElementById("results-table");
            const rows = table.getElementsByTagName("tr");

            // Reset all rows to visible
            for (let i = 1; i < rows.length; i++) {
                rows[i].style.display = "";
            }
        }

        // Function to handle the back action
        function goBack() {
            window.location.href = "patientmedi.php";  // Redirect to patientmedi.php
        }
    </script>
</head>
<body>

<div class="container">
    <h1>Lab Results</h1>
    
   
    <input type="text" id="search-input" onkeyup="filterResults()" placeholder="Search by Patient Name, Test Name, or Status" />
    <button type="button" onclick="clearSearch()">Clear</button>
    <button type="button" onclick="goBack()">Back</button>

    <!-- Results Table -->
    <table class="results-table" id="results-table">
        <thead>
            <tr>
                <th>Patient Name</th>
                <th>Phone</th>
                <th>Test Type</th>
                <th>File Path</th>
                <th>Test Date</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['patientName']); ?></td>
                    <td><?php echo htmlspecialchars($row['contact']); ?></td>
                    <td><?php echo htmlspecialchars($row['testType']); ?></td>
                    <td>
                        <?php 
                            if (!empty($row['filePath'])) {
                                echo '<a href="' . htmlspecialchars($row['filePath']) . '" target="_blank">View File</a>';
                            } else {
                                echo 'No file available';
                            }
                        ?>
                    </td>
                    <td><?php echo htmlspecialchars($row['testDate']); ?></td>
                    <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                    <td>
                        <?php if (empty($row['filePath'])): ?>
                            <a href="viewptestResult.php?result_id=<?php echo $row['result_id']; ?>" class="view-btn">View</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
