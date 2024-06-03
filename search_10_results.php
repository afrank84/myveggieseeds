<?php
// Include the configuration file
$config = include('db_config.php');

// Create connection
$conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['database']);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get search query
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

// Query to fetch data
$query = "SELECT plant_id, parent_name, variety_name FROM plants";
if ($search) {
    $query .= " WHERE plant_id LIKE '%$search%' OR parent_name LIKE '%$search%' OR variety_name LIKE '%$search%' LIMIT 10";
}

$result = $conn->query($query);

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

echo json_encode($data);

// Close connection
$conn->close();
?>
