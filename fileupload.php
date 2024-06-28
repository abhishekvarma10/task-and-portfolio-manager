<?php
// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["uploadedFile"])) {
    
    // Database connection parameters
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "taskman"; // Change to your database name
    
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // File details
    $file_name = $_FILES["uploadedFile"]["name"];
    $file_type = $_FILES["uploadedFile"]["type"];
    $file_size = $_FILES["uploadedFile"]["size"];
    $file_temp = $_FILES["uploadedFile"]["tmp_name"];
    
    // Read file content
    $fp = fopen($file_temp, 'r');
    $file_content = fread($fp, filesize($file_temp));
    $file_content = addslashes($file_content); // Escapes special characters
    
    fclose($fp);
    
    // Insert file data into database
    $sql = "INSERT INTO files (filename, file_type, file_size, file_content) VALUES ('$file_name', '$file_type', $file_size, '$file_content')";
    
    if ($conn->query($sql) === TRUE) {
        echo "File uploaded successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    $conn->close();
}
?>
