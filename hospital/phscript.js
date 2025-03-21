// Function to filter table rows based on search input
function searchTable() {
    // Declare variables
    let input = document.getElementById('search');
    let filter = input.value.toLowerCase();
    let table = document.getElementById('drugTable');
    let rows = table.getElementsByTagName('tr');

    // Loop through all rows in the table body
    for (let i = 1; i < rows.length; i++) {
        let cells = rows[i].getElementsByTagName('td');
        let rowContainsFilter = false;

        // Loop through each cell in the row
        for (let j = 0; j < cells.length; j++) {
            if (cells[j] && cells[j].innerText.toLowerCase().includes(filter)) {
                rowContainsFilter = true;
                break;
            }
        }

        // Show or hide the row based on the search filter
        rows[i].style.display = rowContainsFilter ? '' : 'none';
    }
}
