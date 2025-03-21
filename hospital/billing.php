<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing Page - Mount Apollo Hospital</title>
    <link rel="stylesheet" href="bill.css">
    <script src="billing.js" defer></script>
    
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
            <img src="logo.jpeg" alt="Hospital Logo">
            <h2>Apollo Hospital</h2>
        </div>
        <h1>Cashier</h1>
        <a href="cashierdash.php">Dashboard</a>
        <a href="profilecashier.php">My Profile</a>
        <a href="cashpatient.php">Patient Details</a>
        <a href="billing.php">Generate Bill</a>
        <a href="invoice.php">View Bills</a>
        <a href="paymentonline.php">Transactions</a>
        <a href="stlogin.html">Log Out</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <header>
            <h2>Billing Page</h2>
        </header>

        <!-- Billing Form Section -->
        <section class="billing-form">
            <button class="btn-primary" onclick="window.location.href='invoice.php'">Invoice List</button>
            <form method="POST" action="bill.php" id="billingForm">
                <!-- Patient Details -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="patientID">Patient ID</label>
                        <input type="text" id="patientID" name="patientID" placeholder="Enter Patient ID" required>
                    </div>
                    <button type="button"  id="searchBtn" class="btn-search">Search</button>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="firstName">Full Name</label>
                        <input type="text" id="firstName" name="firstName" placeholder="Enter First Name" required readonly>
                    </div>
                    <div class="form-group">
                        <label for="lastName">Last Name</label>
                        <input type="text" id="lastName" name="lastName" placeholder="Enter Last Name" required readonly>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" id="address" name="address" placeholder="Enter Address" readonly>
                    </div>
                    <div class="form-group">
                        <label>Date</label>
                        <input type="date" name="date" id="date" value="<?php echo date('Y-m-d'); ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label>Contact No</label>
                        <input type="int" name="contact" id="contact" placeholder="contact No" readonly>
                    </div>
                </div>

                <!-- Billing Details -->
                <h3>Item Details</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Account Name</th>
                            <th>Description</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Sub Total</th>
                            <th>Add/Remove</th>
                        </tr>
                    </thead>
                    <tbody id="billingTable">
                        <tr>
                            <td>
                                <select name="accountName[]" required>
                                    <option value="">Select Option</option>
                                    <option value="Consultation">Consultation</option>
                                    <option value="Medication">Medication</option>
                                    <option value="Labtest">Lab test</option>
                                </select>
                            </td>
                            <td><input type="text" name="description[]" placeholder="Description"></td>
                            <td><input type="number" name="quantity[]" min="1" placeholder="Qty" class="qty" oninput="calculateTotal()"></td>
                            <td><input type="number" name="price[]" min="0" placeholder="Price" class="price" oninput="calculateTotal()"></td>
                            <td><input type="number" name="subtotal[]" placeholder="0.00" class="subtotal" readonly></td>
                            <td>
                                <button type="button" class="btn-add">Add</button>
                                <button type="button" class="btn-remove">Remove</button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- Totals -->
                <div class="totals">
                   
                    <div class="row grand-total">
                        <label>Grand Total</label>
                        <input type="number" name="grandTotal" id="grandTotal" placeholder="0.00" readonly>
                    </div>
                </div>

                <!-- Payments -->
                <div class="payments">
                    <div class="row">
                        <label>Paid Amount</label>
                        <input type="number" name="paidAmount" id="paidAmount" placeholder="Enter Paid Amount" required>
                    </div>
                    <div class="row">
                        <label>Due Amount</label>
                        <input type="number" name="dueAmount" id="dueAmount" placeholder="0.00" readonly>
                    </div>
                    <div class="row">
                        <label>Balance</label>
                        <input type="number" name="balance" id="balance" placeholder="0.00" readonly>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="form-buttons">
                    <button type="button" class="btn-calculate" onclick="calculateTotal()">Calculate</button>
                    <button type="button" class="btn-print" onclick="window.location.href='viewbill.php?patientID=' + document.getElementById('patientID').value;">View</button>
                    <button type="reset" class="btn-reset">Reset</button>
                    <button type="submit" class="btn-save" onclick="window.location.href='viewbill.php?patientID=' + document.getElementById('patientID').value;">Save</button>
                </div>
            </form>
        </section>
    </div>
    <script>
    document.getElementById('searchBtn').addEventListener('click', function () {
        // Get the patient ID entered by the user
        var patientID = document.getElementById('patientID').value;

        if (patientID) {
            // Fetch patient details from the server
            fetch('searchpatient.php?patientID=' + patientID)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        // Show an alert if no patient is found or another error occurs
                        alert(data.error);
                    } else {
                        // Populate the form fields with patient data
                        document.getElementById('firstName').value = data.firstName || '';
                        document.getElementById('lastName').value = data.lastName || '';
                        document.getElementById('address').value = data.address || '';
                        document.getElementById('contact').value = data.contact || '';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while fetching patient details.');
                });
        } else {
            alert('Please enter a Patient ID.');
        }
    });
</script>

</body>
</html>
