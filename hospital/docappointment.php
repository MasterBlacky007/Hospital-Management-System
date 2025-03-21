<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Appointments</title>
    <link rel="stylesheet" href="longtable.css">
    <script>
        // Function to update appointment status (accept/reject)
        function updateAppointmentStatus(appointmentid, status) {
            fetch('update_appointment.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ appointmentid: appointmentid, status: status })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Appointment " + status);
                    location.reload(); // Reload the page to update the table
                } else {
                    alert("Failed to update appointment status.");
                }
            })
            .catch(error => {
                console.error("Error updating appointment status:", error);
                alert("An error occurred.");
            });
        }
    </script>
</head>
<body>

<h1>Manage Appointments</h1>

<!-- Date Picker Form -->
<form method="GET" action="">
    <label for="appointmentDate">Select Date:</label>
    <input type="date" id="appointmentDate" name="appointmentDate" value="<?php echo date('Y-m-d'); ?>" required>
    <button type="submit">View Appointments</button>
</form>

<table border="1">
    <thead>
        <tr>
            <th>Appointment ID</th>
            <th>Patient Name</th>
            <th>Age</th>
            <th>Doctor ID</th>
            <th>Appointment Date</th>
            <th>Appointment Time</th>
            <th>Contact No</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        include "conf.php";

        // Assuming the doctor is logged in, get the doctor's ID from session or URL
        $doctor_id = 1; // Replace with actual logic for getting doctor ID from session/login

        // Get selected date from the form (default to today if no date is selected)
        $selectedDate = isset($_GET['appointmentDate']) ? $_GET['appointmentDate'] : date('Y-m-d');

        // Fetch appointments for the selected date and doctor
        $sql = "SELECT appointmentid, patientName, age, doctor_id, appointmentDate, appointmentTime, contactNo, status 
                FROM appointments
                WHERE doctor_id = ? AND appointmentDate = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $doctor_id, $selectedDate);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['appointmentid']); ?></td>
                <td><?php echo htmlspecialchars($row['patientName']); ?></td>
                <td><?php echo htmlspecialchars($row['age']); ?></td>
                <td><?php echo htmlspecialchars($row['doctor_id']); ?></td>
                <td><?php echo htmlspecialchars($row['appointmentDate']); ?></td>
                <td><?php echo htmlspecialchars($row['appointmentTime']); ?></td>
                <td><?php echo htmlspecialchars($row['contactNo']); ?></td>
                <td><?php echo htmlspecialchars($row['status']); ?></td>
                <td>
                    <?php if ($row['status'] == 'pending'): ?>
                        <button class="accept" onclick="updateAppointmentStatus(<?php echo $row['appointmentid']; ?>, 'accepted')">Accept</button>
                        <button class="reject" onclick="updateAppointmentStatus(<?php echo $row['appointmentid']; ?>, 'rejected')">Reject</button>
                    <?php else: ?>
                        <span>Action Taken</span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<button class="back" onclick="window.location.href='doctordash.html'">Back</button>

</body>
</html>
