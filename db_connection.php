<?php
// Include the configuration file
$config = include('db_config.php');

// Create connection
$conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['database']);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

// Your database operations here

// Close connection
$conn->close();
?>
