// Search functionality
function filterTable() {
    const input = document.getElementById("search").value.toLowerCase();
    const table = document.getElementById("patientTable");
    const rows = table.getElementsByTagName("tr");

    for (let i = 1; i < rows.length; i++) {
        const cells = rows[i].getElementsByTagName("td");
        let match = false;

        for (let j = 0; j < cells.length; j++) {
            if (cells[j].innerText.toLowerCase().includes(input)) {
                match = true;
                break;
            }
        }

        rows[i].style.display = match ? "" : "none";
    }
}
function filterTable() {
    const input = document.getElementById("search").value.toLowerCase();
    const table = document.getElementById("AppointmentTable");
    const rows = table.getElementsByTagName("tr");

    for (let i = 1; i < rows.length; i++) {
        const cells = rows[i].getElementsByTagName("td");
        let match = false;

        for (let j = 0; j < cells.length; j++) {
            if (cells[j].innerText.toLowerCase().includes(input)) {
                match = true;
                break;
            }
        }

        rows[i].style.display = match ? "" : "none";
    }
}

function filterTable() {
    const input = document.getElementById("search").value.toLowerCase();
    const table = document.getElementById("visitorTable");
    const rows = table.getElementsByTagName("tr");

    for (let i = 1; i < rows.length; i++) {
        const cells = rows[i].getElementsByTagName("td");
        let match = false;

        for (let j = 0; j < cells.length; j++) {
            if (cells[j].innerText.toLowerCase().includes(input)) {
                match = true;
                break;
            }
        }

        rows[i].style.display = match ? "" : "none";
    }
}

// View button functionality
function viewPatient(profileId) {
    window.location.href = "view_patient.php?profileid=" + profileId;
}

function viewAppointment(appointmentId){
    window.location.href = "view_app.php?appointmentid=" + appointmentId;
}

function viewVisitor(visitorId){
    window.location.href = "view_visitor.php?visitor_id=" + visitorId;
}

// Add event listener for search input
document.getElementById("search").addEventListener("keyup", filterTable);

//add room Nurse 
function validateForm() {
    const roomNo = document.getElementById("room_no").value.trim();
    if (!roomNo.match(/^[0-9]+$/)) {
        alert("Room No must be a valid number.");
        return false;
    }
    return true;
}
//room view search

document.getElementById('search').addEventListener('input', function() {

    var searchQuery = this.value.toLowerCase();

    var rows = document.querySelectorAll('#rooms-table tbody tr');

    rows.forEach(function(row) {
        var cells = row.getElementsByTagName('td');
        var rowText = '';

        for (var i = 0; i < cells.length; i++) {
            rowText += cells[i].textContent.toLowerCase() + ' ';
        }

        if (rowText.indexOf(searchQuery) > -1) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

//view vitalsign
function filterTable() {
    const input = document.getElementById("search").value.toLowerCase();
    const table = document.getElementById("vitalsigntable");
    const rows = table.getElementsByTagName("tr");

    for (let i = 1; i < rows.length; i++) {
        const cells = rows[i].getElementsByTagName("td");
        let match = false;

        for (let j = 0; j < cells.length; j++) {
            if (cells[j].innerText.toLowerCase().includes(input)) {
                match = true;
                break;
            }
        }

        rows[i].style.display = match ? "" : "none";
    }
}

//view progress notes
function filterTable() {
    const input = document.getElementById("search").value.toLowerCase();
    const table = document.getElementById("progressnotes");
    const rows = table.getElementsByTagName("tr");

    for (let i = 1; i < rows.length; i++) {
        const cells = rows[i].getElementsByTagName("td");
        let match = false;

        for (let j = 0; j < cells.length; j++) {
            if (cells[j].innerText.toLowerCase().includes(input)) {
                match = true;
                break;
            }
        }

        rows[i].style.display = match ? "" : "none";
    }
}

//stock serch
function filterTable() {
    const input = document.getElementById("search").value.toLowerCase();
    const table = document.getElementById("stockdetails");
    const rows = table.getElementsByTagName("tr");

    for (let i = 1; i < rows.length; i++) {
        const cells = rows[i].getElementsByTagName("td");
        let match = false;

        for (let j = 0; j < cells.length; j++) {
            if (cells[j].innerText.toLowerCase().includes(input)) {
                match = true;
                break;
            }
        }

        rows[i].style.display = match ? "" : "none";
    }
}
function viewStock(stockId) {
    window.location.href = "view_stock.php?stock_id=" + stockId;
}

function viewProgress(ProgressId) {
    window.location.href = "view_progress.php?progressNId=" + ProgressId;
}
//view 
function filterTable() {
    const input = document.getElementById("search").value.toLowerCase();
    const table = document.getElementById("supplierTable");
    const rows = table.getElementsByTagName("tr");

    for (let i = 1; i < rows.length; i++) {
        const cells = rows[i].getElementsByTagName("td");
        let match = false;

        for (let j = 0; j < cells.length; j++) {
            if (cells[j].innerText.toLowerCase().includes(input)) {
                match = true;
                break;
            }
        }

        rows[i].style.display = match ? "" : "none";
    }
}
function viewProgress(SupplierId) {
    window.location.href = "view_supplier.php?supplier_id=" + SupplierId;
}

function filterTable() {
    const input = document.getElementById("search").value.toLowerCase();
    const table = document.getElementById("visitorTable");
    const rows = table.getElementsByTagName("tr");

    for (let i = 1; i < rows.length; i++) {
        const cells = rows[i].getElementsByTagName("td");
        let match = false;

        for (let j = 0; j < cells.length; j++) {
            if (cells[j].innerText.toLowerCase().includes(input)) {
                match = true;
                break;
            }
        }

        rows[i].style.display = match ? "" : "none";
    }
}
function viewLabtest(labId) {
    window.location.href = "view_labtest.php?id=" + labId;
}
function filterTable() {
    const input = document.getElementById("search").value.toLowerCase();
    const table = document.getElementById("prescriptionTable");
    const rows = table.getElementsByTagName("tr");

    for (let i = 1; i < rows.length; i++) {
        const cells = rows[i].getElementsByTagName("td");
        let match = false;

        for (let j = 0; j < cells.length; j++) {
            if (cells[j].innerText.toLowerCase().includes(input)) {
                match = true;
                break;
            }
        }

        rows[i].style.display = match ? "" : "none";
    }
}

// Function to view patient details
function viewdocPatient(profileId) {
    // Redirect to the patient details page with the profile ID as a query parameter
    window.location.href = `view_docptprofile.php?profileid=${profileId}`;
}

// Function to implement search functionality
document.getElementById('search').addEventListener('input', function () {
    const searchValue = this.value.toLowerCase();
    const tableRows = document.querySelectorAll('#patientTable tbody tr');

    tableRows.forEach(row => {
        const rowData = row.textContent.toLowerCase();
        if (rowData.includes(searchValue)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

//search nurse task


function filterTable() {
    const input = document.getElementById("search").value.toLowerCase();
    const table = document.getElementById("nurseTasks");
    const rows = table.getElementsByTagName("tr");

    for (let i = 1; i < rows.length; i++) {
        const cells = rows[i].getElementsByTagName("td");
        let match = false;

        for (let j = 0; j < cells.length; j++) {
            if (cells[j].innerText.toLowerCase().includes(input)) {
                match = true;
                break;
            }
        }

        rows[i].style.display = match ? "" : "none";
    }
}


