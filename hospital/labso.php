<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab Supplies Request</title>
    <link rel="stylesheet" href="styleslb.css">
</head>
<body>

<div class="container">
    <div class="sidebar">
        <div class="logo">
            <img src="logo.jpeg" alt="Hospital Logo">
            <h2>Apollo Hospital</h2>
        </div>
        <h1>MLT</h1>
        <a href="mltdashboard.php">Dashboard</a>
        <a href="profilemlt.php">My Profile</a>
        <a href="lreq.html">Test Requests</a>
        <a href="search.php">View Patient Details</a>
        <a href="labtestdash.php">Lab Test Result</a>
        <a href="labsuprdash.php">Lab Supply Request</a>
        <a href="stlogin.html">Log Out</a>
    </div>

    <div class="main">
        <div class="form-container">
            <h2>Request Lab Supplies</h2>
            <form action="lsup_req.php" method="POST">
                <label for="request_date">Request Date:</label>
                <input type="date" id="request_date" name="request_date" value="<?php echo date('Y-m-d'); ?>" readonly>

                <label for="item_name">Item Name:</label>
                <input type="text" id="item_name" name="item_name" required>

                <label for="category">Category:</label>
                <select id="category" name="category" required>
                    <option value="">-- Select Category --</option>
                    <option value="Reagents">Reagents</option>
                    <option value="Equipment">Equipment</option>
                    <option value="Consumables">Consumables</option>
                </select>

                <label for="quantity">Quantity:</label>
                <input type="number" id="quantity" name="quantity" min="1" required>

                <label for="urgency">Urgency:</label>
                <select id="urgency" name="urgency" required>
                    <option value="">-- Select Urgency --</option>
                    <option value="Low">Low</option>
                    <option value="Medium">Medium</option>
                    <option value="High">High</option>
                </select>

                <label for="notes">Additional Notes:</label>
                <textarea id="notes" name="notes" rows="5" placeholder="Enter any specific details..."></textarea>

                <button type="submit">Submit</button>
                <button type="reset">Cancel</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>
