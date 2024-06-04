<?php
// search_plants_ajax.php

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
    $query .= " WHERE plant_id LIKE '%$search%' OR parent_name LIKE '%$search%' OR variety_name LIKE '%$search%'";
}

$result = $conn->query($query);

// Initialize the total records counter
$total_records = $result->num_rows;

$data = '';
if ($total_records > 0) {
    while ($row = $result->fetch_assoc()) {
        $data .= '<tr>';
        $data .= '<td>' . $row['plant_id'] . '</td>';
        $data .= '<td>' . $row['parent_name'] . '</td>';
        $data .= '<td><a href="vegetable.php?plant_id=' . $row['plant_id'] . '">' . $row['variety_name'] . '</a></td>';
        $data .= '</tr>';
    }
} else {
    $data = "<tr><td colspan='3'>No records found</td></tr>";
}

// Close connection
$conn->close();

// Return the total records and data as a JSON object
echo json_encode([
    'total_records' => $total_records,
    'data' => $data
]);
?>
