document.getElementById('payment_method').addEventListener('change', function() {
    var cardDetails = document.getElementById('cardDetails');
    var uploadSection = document.getElementById('uploadSection');
    
    if (this.value === 'Credit/Debit Card') {
        cardDetails.style.display = 'block'; // Show card details section
        uploadSection.style.display = 'none'; // Hide upload section
    } else if (this.value === 'Online Payment') {
        cardDetails.style.display = 'none'; // Hide card details section
        uploadSection.style.display = 'block'; // Show upload section
    } else {
        cardDetails.style.display = 'none'; // Hide both sections if no selection
        uploadSection.style.display = 'none';
        document.querySelector('input[name="transaction_file"]').value = ''; // Clear file input
    }
});