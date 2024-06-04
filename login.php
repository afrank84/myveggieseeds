<?php
session_start();

// Include the configuration file
$config = include('db_config.php');

// Create connection
$conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['database']);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $inputUsername = $_POST['username'];
    $inputPassword = $_POST['password'];

    // Fetch user from database
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $inputUsername);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($inputPassword, $user['password'])) {
        $_SESSION['username'] = $user['username'];
        echo "Login successful!";
        // Redirect to a protected page or dashboard
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Invalid username or password!";
    }

    $stmt->close();
}

$conn->close();
?>