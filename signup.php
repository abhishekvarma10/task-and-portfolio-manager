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
$password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash the password
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$dob = $_POST['dob'];
$gender = $_POST['gender'];
$phone_number = $_POST['phone_number'];

// Check if the email already exists
$checkEmailQuery = "SELECT email FROM users WHERE email = ?";
$stmt = $conn->prepare($checkEmailQuery);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $_SESSION['error'] = "Email already registered. Please use a different email.";
    header("Location: signup_error.html");
    exit();
} else {
    // Email is not registered, proceed with the insertion
    $stmt->close();

    // Prepare SQL statement for insertion
    $insertQuery = "INSERT INTO users (email, password, first_name, last_name, dob, gender, phone_number) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("sssssss", $email, $password, $first_name, $last_name, $dob, $gender, $phone_number);

    // Execute SQL statement
    if ($stmt->execute()) {
        // Store user information in session variables
        $_SESSION['user_id'] = $stmt->insert_id;
        $_SESSION['email'] = $email;
        $_SESSION['first_name'] = $first_name;
        $_SESSION['last_name'] = $last_name;

        // Redirect to dashboard or success page
        header("Location: dashboard1.html");
        exit();
    } else {
        $_SESSION['error'] = "Error: " . $stmt->error;
        // Redirect to error page
        header("Location: signup_error.html");
        exit();
    }

    $stmt->close();
}

$conn->close();
?>
