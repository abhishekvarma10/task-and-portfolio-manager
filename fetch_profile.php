<?php
session_start();
// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION['user_id'];

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = ""; // Assuming no password for root
$dbname = "taskman";
$port = 3307; // Specify your MySQL port

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and execute SQL statement to fetch user details including profile photo
$stmt = $conn->prepare("SELECT email, first_name, last_name, dob, gender, phone_number, profile_photo FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($email, $first_name, $last_name, $dob, $gender, $phone_number, $profile_photo);

// Fetch the results
if ($stmt->fetch()) {
    ?>
    <div class="profile-info">
        <label>Email:</label>
        <p><?php echo $email; ?></p>
    </div>
    <div class="profile-info">
        <label>First Name:</label>
        <p><?php echo $first_name; ?></p>
    </div>
    <div class="profile-info">
        <label>Last Name:</label>
        <p><?php echo $last_name; ?></p>
    </div>
    <div class="profile-info">
        <label>Date of Birth:</label>
        <p><?php echo $dob; ?></p>
    </div>
    <div class="profile-info">
        <label>Gender:</label>
        <p><?php echo $gender; ?></p>
    </div>
    <div class="profile-info">
        <label>Phone Number:</label>
        <p><?php echo $phone_number; ?></p>
    </div>
    <?php
} else {
    echo "No user found with ID: " . $user_id;
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
