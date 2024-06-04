<?php
// plant_detail.php

// Include the configuration file
$config = include('db_config.php');

// Create connection
$conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['database']);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the plant ID from the URL
$plant_id = isset($_GET['plant_id']) ? intval($_GET['plant_id']) : 0;

// Fetch plant details
$query = "SELECT * FROM plants WHERE plant_id = $plant_id";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $plant = $result->fetch_assoc();
} else {
    die("No details found for the specified plant.");
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plant Details</title>
</head>
<body>
    <h1>Plant Details</h1>
    <?php if ($plant): ?>
        <p><strong>Plant ID:</strong> <?php echo htmlspecialchars($plant['plant_id']); ?></p>
        <p><strong>Parent Name:</strong> <?php echo htmlspecialchars($plant['parent_name']); ?></p>
        <p><strong>Variety Name:</strong> <?php echo htmlspecialchars($plant['variety_name']); ?></p>
        <!-- Add more fields as needed -->
    <?php else: ?>
        <p>No details found for this plant.</p>
    <?php endif; ?>
</body>
</html>
