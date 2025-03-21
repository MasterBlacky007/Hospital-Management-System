<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mountapollo";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables for analytics
$labSuppliesData = [];
$drugOrdersData = [];
$supplierOrdersData = [];
$totalLabSupplies = 0;
$totalDrugOrders = 0;
$totalSupplierOrders = 0;
$approvedLabSupplies = 0;
$declinedLabSupplies = 0;
$approvedDrugOrders = 0;
$declinedDrugOrders = 0;
$approvedSupplierOrders = 0;
$declinedSupplierOrders = 0;
$totalQuantityLabSupplies = 0;
$totalQuantityDrugOrders = 0;
$totalQuantitySupplierOrders = 0;
$totalOrders = 0;

// Fetch lab supplies data (remove urgency field)
$labSuppliesQuery = "SELECT category, COUNT(*) AS total, 
                            SUM(CASE WHEN status = 'Approved' THEN 1 ELSE 0 END) AS approved, 
                            SUM(CASE WHEN status = 'Declined' THEN 1 ELSE 0 END) AS declined,
                            SUM(quantity) AS total_quantity
                     FROM lab_supplies_request GROUP BY category";
$labSuppliesResult = $conn->query($labSuppliesQuery);
if ($labSuppliesResult->num_rows > 0) {
    while ($row = $labSuppliesResult->fetch_assoc()) {
        $labSuppliesData[] = [
            'category' => $row['category'],
            'total' => $row['total'],
            'approved' => $row['approved'],
            'declined' => $row['declined'],
            'total_quantity' => $row['total_quantity']
        ];
        $totalLabSupplies += $row['total'];
        $approvedLabSupplies += $row['approved'];
        $declinedLabSupplies += $row['declined'];
        $totalQuantityLabSupplies += $row['total_quantity'];
    }
}

// Fetch drug orders data (remove urgency field)
$drugOrdersQuery = "SELECT category, COUNT(*) AS total, 
                            SUM(CASE WHEN status = 'Approved' THEN 1 ELSE 0 END) AS approved, 
                            SUM(CASE WHEN status = 'Declined' THEN 1 ELSE 0 END) AS declined,
                            SUM(quantity) AS total_quantity
                     FROM drug_orders GROUP BY category";
$drugOrdersResult = $conn->query($drugOrdersQuery);
if ($drugOrdersResult->num_rows > 0) {
    while ($row = $drugOrdersResult->fetch_assoc()) {
        $drugOrdersData[] = [
            'category' => $row['category'],
            'total' => $row['total'],
            'approved' => $row['approved'],
            'declined' => $row['declined'],
            'total_quantity' => $row['total_quantity']
        ];
        $totalDrugOrders += $row['total'];
        $approvedDrugOrders += $row['approved'];
        $declinedDrugOrders += $row['declined'];
        $totalQuantityDrugOrders += $row['total_quantity'];
    }
}

// Fetch supplier orders data (remove urgency field)
$supplierOrdersQuery = "SELECT item_name, COUNT(*) AS total, 
                                SUM(CASE WHEN status = 'Approved' THEN 1 ELSE 0 END) AS approved, 
                                SUM(CASE WHEN status = 'Declined' THEN 1 ELSE 0 END) AS declined,
                                SUM(quantity) AS total_quantity
                         FROM orders GROUP BY item_name";
$supplierOrdersResult = $conn->query($supplierOrdersQuery);
if ($supplierOrdersResult->num_rows > 0) {
    while ($row = $supplierOrdersResult->fetch_assoc()) {
        $supplierOrdersData[] = [
            'item_name' => $row['item_name'],
            'total' => $row['total'],
            'approved' => $row['approved'],
            'declined' => $row['declined'],
            'total_quantity' => $row['total_quantity']
        ];
        $totalSupplierOrders += $row['total'];
        $approvedSupplierOrders += $row['approved'];
        $declinedSupplierOrders += $row['declined'];
        $totalQuantitySupplierOrders += $row['total_quantity'];
    }
}

// Calculate overall percentages
$approvedLabSuppliesPercentage = ($totalLabSupplies > 0) ? ($approvedLabSupplies / $totalLabSupplies) * 100 : 0;
$declinedLabSuppliesPercentage = ($totalLabSupplies > 0) ? ($declinedLabSupplies / $totalLabSupplies) * 100 : 0;

$approvedDrugOrdersPercentage = ($totalDrugOrders > 0) ? ($approvedDrugOrders / $totalDrugOrders) * 100 : 0;
$declinedDrugOrdersPercentage = ($totalDrugOrders > 0) ? ($declinedDrugOrders / $totalDrugOrders) * 100 : 0;

$approvedSupplierOrdersPercentage = ($totalSupplierOrders > 0) ? ($approvedSupplierOrders / $totalSupplierOrders) * 100 : 0;
$declinedSupplierOrdersPercentage = ($totalSupplierOrders > 0) ? ($declinedSupplierOrders / $totalSupplierOrders) * 100 : 0;

// Total Quantity Percentages
$totalQuantity = $totalQuantityLabSupplies + $totalQuantityDrugOrders + $totalQuantitySupplierOrders;
$quantityLabSuppliesPercentage = ($totalQuantity > 0) ? ($totalQuantityLabSupplies / $totalQuantity) * 100 : 0;
$quantityDrugOrdersPercentage = ($totalQuantity > 0) ? ($totalQuantityDrugOrders / $totalQuantity) * 100 : 0;
$quantitySupplierOrdersPercentage = ($totalQuantity > 0) ? ($totalQuantitySupplierOrders / $totalQuantity) * 100 : 0;

// Timezone for Sri Lanka
date_default_timezone_set("Asia/Colombo");
$createdBy = "Center Manager";
$createdTime = date("Y-m-d H:i:s");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders Analytics Report</title>
    <style>
        body {
    font-family: Georgia, sans-serif;
    margin: 0;
    padding: 20px;
    background-color: #f7f7f7; /* Slightly lighter background */
    color: #333;
    line-height: 1.6; /* Improved readability */
}

.report {
    background: #fff;
    padding: 30px;
    border-radius: 8px; /* Softer corners for modern feel */
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1); /* Softer, deeper shadow */
    max-width: 800px;
    margin: 0 auto; /* Center the report */
}

.letterhead {
    display: flex;
    align-items: center;
    margin-bottom: 25px; /* Increased margin for spacing */
    border-bottom: 2px solid #007BFF;
    padding-bottom: 15px; /* Increased padding for better spacing */
}

.letterhead .logo {
    max-height: 90px; /* Reduced size to keep it proportional */
    margin-right: 20px;
}

.letterhead .details h2 {
    margin: 0;
    color: #007BFF;
    font-size: 22px; /* Slightly larger for prominence */
    font-weight: 600; /* Bold for emphasis */
}

h1, h2 {
    color: #08225B;
}

h1 {
    color: #007BFF;
}

button.print-btn {
    background: #08225B;
    color: #fff;
    border: none;
    padding: 12px 24px; /* Slightly larger button for emphasis */
    border-radius: 5px;
    cursor: pointer;
    margin-top: 20px; /* Clear separation from content */
    font-size: 16px; /* Larger font size for readability */
    transition: background-color 0.3s ease; /* Smooth hover transition */
}

button.print-btn:hover {
    background: #0056b3;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 25px; /* More spacing from previous content */
}

table th, table td {
    border: 1px solid #ddd;
    padding: 12px 15px; /* Larger padding for readability */
    text-align: left;
}

table th {
    background-color: #08225B;
    color: white;
    font-size: 14px;
    font-weight: 600;
}

.metadata {
    margin-top: 30px; /* More space from content */
    font-size: 14px;
    color: #777; /* Lighter color for less prominence */
}

@media print {
    button.print-btn {
        display: none; /* Hide print button when printing */
    }

    body {
        padding: 0; /* Remove padding when printing */
    }

    .report {
        max-width: 100%; /* Full width for printing */
        box-shadow: none; /* Remove shadow when printing */
    }

    .letterhead {
        border-bottom: 1px solid #007BFF; /* Thinner border for printing */
    }

    table th, table td {
        font-size: 12px; /* Slightly smaller font for print */
    }
}

.header-details {
    display: flex;
    justify-content: space-between;
    width: 100%; /* Ensure full width for proper alignment */
    margin-top: 20px; /* Increased margin for spacing */
}

.left, .right {
    flex: 1;
    font-size: 14px; /* Standardized font size */
}

    </style>
</head>
<body>
    <div class="container report">
        <div class="letterhead">
            <img src="logo.jpeg" alt="Logo" class="logo">
            <div class="details">
                <h1>MOUNT APOLLO HOSPITALS (PVT) LTD</h1>
                <p>No. 355, Maharagama Road, Boralesgamuwa</p>
                <p>Tel: 077 20 20 261, 077 20 20 578, 011 2 150 150</p>
                <p>Email: info@mountapollohospitals.com | Web: www.mountapollohospitals.com</p>
            </div>
        </div>

        <div class="header-details">
            <div class="left">
                <p><strong>Created By:</strong> <?php echo $createdBy; ?></p>
            </div>
            <div class="right">
                <p><strong>Created Time:</strong> <?php echo $createdTime; ?></p>
            </div>
        </div>

        <h2>Orders Analytics Report</h2>

        <!-- Lab Supplies Section -->
        <h3>Lab Supplies</h3>
        <table>
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Total Requests</th>
                    <th>Approved (%)</th>
                    <th>Declined (%)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($labSuppliesData as $data): 
                    $approvedPercentage = ($data['approved'] / $data['total']) * 100;
                    $declinedPercentage = ($data['declined'] / $data['total']) * 100;
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($data['category']); ?></td>
                    <td><?php echo htmlspecialchars($data['total']); ?></td>
                    <td><?php echo number_format($approvedPercentage, 2) . '%'; ?></td>
                    <td><?php echo number_format($declinedPercentage, 2) . '%'; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Drug Orders Section -->
        <h3>Drug Orders</h3>
        <table>
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Total Orders</th>
                    <th>Approved (%)</th>
                    <th>Declined (%)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($drugOrdersData as $data): 
                    $approvedPercentage = ($data['approved'] / $data['total']) * 100;
                    $declinedPercentage = ($data['declined'] / $data['total']) * 100;
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($data['category']); ?></td>
                    <td><?php echo htmlspecialchars($data['total']); ?></td>
                    <td><?php echo number_format($approvedPercentage, 2) . '%'; ?></td>
                    <td><?php echo number_format($declinedPercentage, 2) . '%'; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Supplier Orders Section -->
        <h3>Supplier Orders</h3>
        <table>
            <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Total Orders</th>
                    <th>Approved (%)</th>
                    <th>Declined (%)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($supplierOrdersData as $data): 
                    $approvedPercentage = ($data['approved'] / $data['total']) * 100;
                    $declinedPercentage = ($data['declined'] / $data['total']) * 100;
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($data['item_name']); ?></td>
                    <td><?php echo htmlspecialchars($data['total']); ?></td>
                    <td><?php echo number_format($approvedPercentage, 2) . '%'; ?></td>
                    <td><?php echo number_format($declinedPercentage, 2) . '%'; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <p><strong>Total Orders Summary</strong></p>
        <table>
            <tr>
                <td><strong>Lab Supplies:</strong></td>
                <td><?php echo $totalLabSupplies; ?> orders</td>
                <td><?php echo number_format($approvedLabSuppliesPercentage, 2) . '%'; ?> Approved</td>
                <td><?php echo number_format($declinedLabSuppliesPercentage, 2) . '%'; ?> Declined</td>
            </tr>
            <tr>
                <td><strong>Drug Orders:</strong></td>
                <td><?php echo $totalDrugOrders; ?> orders</td>
                <td><?php echo number_format($approvedDrugOrdersPercentage, 2) . '%'; ?> Approved</td>
                <td><?php echo number_format($declinedDrugOrdersPercentage, 2) . '%'; ?> Declined</td>
            </tr>
            <tr>
                <td><strong>Supplier Orders:</strong></td>
                <td><?php echo $totalSupplierOrders; ?> orders</td>
                <td><?php echo number_format($approvedSupplierOrdersPercentage, 2) . '%'; ?> Approved</td>
                <td><?php echo number_format($declinedSupplierOrdersPercentage, 2) . '%'; ?> Declined</td>
            </tr>
        </table>

        <p><strong>Total Quantity Overview</strong></p>
        <table>
            <tr>
                <td><strong>Lab Supplies:</strong></td>
                <td><?php echo number_format($quantityLabSuppliesPercentage, 2) . '%'; ?></td>
            </tr>
            <tr>
                <td><strong>Drug Orders:</strong></td>
                <td><?php echo number_format($quantityDrugOrdersPercentage, 2) . '%'; ?></td>
            </tr>
            <tr>
                <td><strong>Supplier Orders:</strong></td>
                <td><?php echo number_format($quantitySupplierOrdersPercentage, 2) . '%'; ?></td>
            </tr>
        </table>

        <!-- Button to Print PDF -->
        <button onclick="window.print()" class="print-btn">Print Report</button>
    </div>

   
</body>
</html>

<?php
// Close connection
$conn->close();
?>
