<!DOCTYPE html>
<html>
<head>
    <title>View Customer</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
<?php include 'navbar.html'; ?>
    <h2>Customer Details</h2>
    <?php
    $conn = mysqli_connect("localhost", "root", "", "Banking");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $customer_id = $_GET['id'];

    $query = "SELECT * FROM customers WHERE Id = $customer_id";
    $result = mysqli_query($conn, $query);
    $customer = mysqli_fetch_assoc($result);

    echo "<p><strong>Name:</strong> " . $customer['Name'] . "</p>";
    echo "<p><strong>Email:</strong> " . $customer['Email'] . "</p>";
    echo "<p><strong>Current Balance:</strong> " . $customer['Balance'] . "</p>";

    $query = "SELECT * FROM customers WHERE Id != $customer_id";
    $result = mysqli_query($conn, $query);
    ?>
    <h3>Transfer Money</h3>
    <form action="transfer.php" method="post" onsubmit="return validateForm();">
        <input type="hidden" name="sender_id" value="<?php echo $customer_id; ?>">
        <label for="amount">Amount:</label>
        <input type="number" name="amount" id="amount" step="0.01" required>
        <label for="recipient">Recipient:</label>
        <select name="recipient" id="recipient" required>
            <option value="">Select a recipient</option>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $row['Id'] . "'>" . $row['Name'] . "</option>";
            }
            ?>
        </select>
        <input type="submit" value="Transfer">
    </form>
    

    <script>
        function validateForm() {
            var amount = document.getElementById('amount').value;
            var currentBalance = <?php echo $customer['Balance']; ?>;

            if (parseFloat(amount) <= 0) {
                alert("Amount must be greater than zero.");
                return false;
            }

            if (parseFloat(amount) > currentBalance) {
                alert("Insufficient balance.");
                return false;
            }

            return true;
        }
    </script>
</body>
</html>
