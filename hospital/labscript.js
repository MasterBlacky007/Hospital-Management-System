//mlt lab result
// Search functionality for the Lab Test Results table
function viewdocPatient(profileId) {
    // Redirect to the patient details page with the profile ID as a query parameter
    window.location.href = `viewlabtest.php?profileid=${profileId}`;
}

// Function to implement search functionality
document.getElementById('search').addEventListener('input', function () {
    const searchValue = this.value.toLowerCase();
    const tableRows = document.querySelectorAll('#labResultsTable tbody tr');

    tableRows.forEach(row => {
        const rowData = row.textContent.toLowerCase();
        if (rowData.includes(searchValue)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});
// Redirect to the page to view test results
function viewTestResults(testID) {
    window.location.href = "viewtestResults.php?id=" + testID;
}

// Redirect to the page to update test results
function updateTestResult(testID) {
    window.location.href = "updateTestResult.php?id=" + testID;
}

// Confirm and delete the test result
function deleteTestResult(testID) {
    if (confirm("Are you sure you want to delete this test result?")) {
        // Make a request to delete the record
        fetch(`deleteTestResult.php?id=${testID}`, { method: 'GET' })
            .then(response => response.text())
            .then(data => {
                alert(data);
                // Reload the page to reflect changes
                location.reload();
            })
            .catch(error => console.error("Error:", error));
    }
}