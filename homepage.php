<?php
session_start();
include("connect.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
</head>
<body>
    <div style="text-align:center; padding:15%;">
        <p style="font-size:50px; font-weight:bold;">
            Hello 
            <?php 
            if (isset($_SESSION['email'])) {
                $email = $_SESSION['email'];
                // Prevent SQL injection by using prepared statements
                $stmt = $conn->prepare("SELECT firstName, lastName FROM users WHERE email = ?");
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $result = $stmt->get_result();
                
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo htmlspecialchars($row['firstName']) . ' ' . htmlspecialchars($row['lastName']);
                    }
                } else {
                    echo "User not found.";
                }

                $stmt->close();
            } else {
                echo "No user logged in.";
            }
            ?>
            :)
        </p>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>
