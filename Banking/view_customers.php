<!DOCTYPE html>
<html>
<head>
    <title>View All Customers</title>
     <link rel="stylesheet" type="text/css" href="styles.css"> 
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        
        tr:hover {
            background-color: #e0f7f2;
        }
        
    </style>
</head>
<body><?php include 'navbar.html'; ?>
    <h2>All Customers</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Current Balance</th>
            <th>Action</th>
        </tr>
        <?php
        $conn = mysqli_connect("localhost","root","","Banking");

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $query = "SELECT * FROM customers";
        $result = mysqli_query($conn, $query);

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['Id'] . "</td>";
            echo "<td>" . $row['Name'] . "</td>";
            echo "<td>" . $row['Email'] . "</td>";
            echo "<td>" . $row['Balance'] . "</td>";
            echo "<td><a href='view_customer.php?id=" . $row['Id'] . "'>View</a></td>";
            echo "</tr>";
        }

        mysqli_close($conn);
        ?>
    </table>
</body>
</html>
