// Fetch test types from the server when the page loads
document.addEventListener('DOMContentLoaded', function () {
    fetch('lab_test_request.php?fetch_tests=true')
        .then(response => response.json())
        .then(data => {
            const testTypeSelect = document.getElementById('testType');
            
            // Populate the dropdown with test types
            data.forEach(test => {
                const option = document.createElement('option');
                option.value = test.id; // Test ID
                option.textContent = test.test_name; // Test Name
                testTypeSelect.appendChild(option);
            });

            // Optionally select the first test type if available
            if (data.length > 0) {
                testTypeSelect.value = data[0].id; // Automatically select the first test type
            }
        })
        .catch(err => console.error('Error fetching test types:', err));
});

// Patient search functionality
document.getElementById('searchPatient').addEventListener('click', function () {
    const patientID = prompt('Enter Patient Contact:');
    if (patientID) {
        fetch(`lab_test_request.php?fetch_patient=true&phone=${patientID}`)
            .then(response => response.json())
            .then(data => {
                if (data) {
                    document.getElementById('patientName').value = data.name;
                    document.getElementById('patientID').value = data.id;
                } else {
                    alert('Patient not found.');
                }
            })
            .catch(err => console.error(err));
});
