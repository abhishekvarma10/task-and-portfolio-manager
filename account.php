<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Page</title>
</head>
<body>
    <h1>Account Details</h1>
    <p>Email: <?php echo htmlspecialchars($_SESSION['email']); ?></p>
    <p>Name: <?php echo htmlspecialchars($_SESSION['first_name'] . ' ' . $_SESSION['last_name']); ?></p>
    <a href="logout.php">Logout</a>
</body>
</html>
