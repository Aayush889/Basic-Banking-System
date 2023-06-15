<!DOCTYPE html>
<html>
<head>
    <title>Banking System - Transfer History</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <?php include 'navbar.html'; ?>
    <div class="container">
        <center><h1>Transfer History</h1></center>
        <?php
        $conn = mysqli_connect("localhost", "root", "", "Banking");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $query = "SELECT transfers.transfer_id, sender.Name AS sender_name, recipient.Name AS recipient_name, transfers.amount, transfers.date_time
                  FROM transfers
                  INNER JOIN customers AS sender ON transfers.sender_id = sender.Id
                  INNER JOIN customers AS recipient ON transfers.recipient_id = recipient.Id
                  ORDER BY transfers.date_time DESC";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            echo '<table class="table">';
            echo '<thead><tr><th>Sender</th><th>Recipient</th><th>Amount</th><th>Date/Time</th></tr></thead>';
            echo '<tbody>';
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td>' . $row['sender_name'] . '</td>';
                echo '<td>' . $row['recipient_name'] . '</td>';
                echo '<td>' . $row['amount'] . '</td>';
                echo '<td>' . $row['date_time'] . '</td>';
                echo '</tr>';
            }
            echo '</tbody></table>';
        } else {
            echo '<p>No transfer history found.</p>';
        }
        mysqli_close($conn);
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/js/bootstrap.min.js"></script>
</body>
</html>
