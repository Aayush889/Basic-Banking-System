<!DOCTYPE html>
<html>
<head>
    <title>Transfer Money</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
<?php include 'navbar.html'; ?>
    <?php
    $conn = mysqli_connect("localhost","root","","Banking");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sender_id = $_POST['sender_id'];
    $amount = $_POST['amount'];
    $recipient_id = $_POST['recipient'];

    $sender_query = "SELECT * FROM customers WHERE Id = $sender_id";
    $sender_result = mysqli_query($conn, $sender_query);
    $sender = mysqli_fetch_assoc($sender_result);

    $recipient_query = "SELECT * FROM customers WHERE Id = $recipient_id";
    $recipient_result = mysqli_query($conn, $recipient_query);
    $recipient = mysqli_fetch_assoc($recipient_result);

    if ($sender['Balance'] >= $amount) {
        mysqli_begin_transaction($conn);

        try {
            $new_sender_balance = $sender['Balance'] - $amount;
            $update_sender_query = "UPDATE customers SET Balance = $new_sender_balance WHERE Id = $sender_id";
            mysqli_query($conn, $update_sender_query);

            $new_recipient_balance = $recipient['Balance'] + $amount;
            $update_recipient_query = "UPDATE customers SET Balance = $new_recipient_balance WHERE Id = $recipient_id";
            mysqli_query($conn, $update_recipient_query);

            $insert_transfer_query = "INSERT INTO transfers (sender_id, recipient_id, amount) VALUES ($sender_id, $recipient_id, $amount)";
            mysqli_query($conn, $insert_transfer_query);

            mysqli_commit($conn);

            echo "<h2>Transfer Successful!</h2>";
           echo "<center><script src=\"https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js\"></script><lottie-player src=\"https://assets2.lottiefiles.com/packages/lf20_4chtroo0.json\"  background=\"transparent\"  speed=\"1\"  style=\"width: 300px; height: 300px;\"  loop autoplay></lottie-player></center>";
        } catch (Exception $e) {
            mysqli_rollback($conn);
            echo "<h2>Error occurred while transferring money.</h2>";
        }
    } else {
        echo "<h2>Insufficient balance.</h2>";
    }

    mysqli_close($conn);
    ?>
</body>
</html>
