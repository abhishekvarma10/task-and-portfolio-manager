<?php
$servername = "localhost";
$username = "root";
$password = ""; // Ensure this matches your MySQL setup (blank for XAMPP)
$dbname = "taskman"; // Replace with your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
$conn->close();
?>
