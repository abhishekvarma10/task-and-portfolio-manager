<?php
// Assuming database connection is established elsewhere
// Modify these details as per your database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "taskman";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prepare SQL statement
    $sql = "INSERT INTO investments (investment_type, amount, company) VALUES (?, ?, ?)";
    
    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sds", $investmentType, $amount, $company);
    
    // Loop through each investment section
    foreach ($_POST['investment-type'] as $key => $investmentType) {
        // Sanitize input values (assuming you have a sanitize_input function)
        $amount = sanitize_input($_POST[$investmentType . '-amount'][$key]);
        $company = sanitize_input($_POST[$investmentType . '-company'][$key]);
        
        // Validate investment amount (basic validation)
        if (!is_numeric($amount) || $amount <= 0) {
            // Handle invalid input
            continue;
        }
        
        // Execute the prepared statement
        $stmt->execute();
    }
    
    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>
