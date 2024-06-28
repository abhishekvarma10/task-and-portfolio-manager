<?php
session_start(); // Start the session

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = ""; // Leave it blank for XAMPP default (no password for root)
$dbname = "taskman"; // Replace with your actual database name
$port = 3307; // Specify the port number

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assuming you receive POST data from a form
$email = $_POST['email'];
$password = $_POST['password']; // Plain text password from the form

// Prepare SQL statement to fetch user details
$query = "SELECT user_id, password FROM users WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($user_id, $hashed_password);

if ($stmt->num_rows > 0) {
    $stmt->fetch();
    // Verify the hashed password
    if (password_verify($password, $hashed_password)) {
        // Password is correct, store user information in session variables
        $_SESSION['user_id'] = $user_id;
        $_SESSION['email'] = $email;
        
        // Redirect to dashboard or success page
        header("Location: dashboard1.html");
        exit();
    } else {
        $_SESSION['error'] = "Invalid password. Please try again.";
        // Redirect to error page
        header("Location: login_error.html");
        exit();
    }
} else {
    $_SESSION['error'] = "No user found with that email address.";
    // Redirect to error page
    header("Location: login_error.html");
    exit();
}

$stmt->close();
$conn->close();
?>
