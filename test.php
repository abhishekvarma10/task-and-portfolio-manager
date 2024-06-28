<?php
$servername = "localhost";
$username = "root";
$password = "";  // No password
$dbname = "test";
$port = 3307;  // Specify the port

// Enable detailed error reporting
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // Create a new mysqli instance
    $conn = new mysqli($servername, $username, $password, $dbname, $port);
    echo "Connected successfully";
} catch (mysqli_sql_exception $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
