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

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    die("Unauthorized access. Please log in.");
}

// Fetch user details
$username = $_SESSION['username'];
$query = "SELECT role FROM users WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $user_role = $user['role'];
} else {
    die("User not found.");
}

$allowed_roles = ['admin', 'contributor'];
if (!in_array($user_role, $allowed_roles)) {
    die("Unauthorized access.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $plant_id = intval($_POST['plant_id']);
    $parent_name = preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['parent_name']);
    $variety_name = preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['variety_name']);
    $image_type = preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['image_type']);

    $target_dir = "uploads/plants/";
    
    // Ensure the target directory exists
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $file_name = $plant_id . "_" . $parent_name . "_" . $variety_name . "_" . $image_type . "_" . basename($_FILES["file"]["name"]);
    $file_name = preg_replace('/[^a-zA-Z0-9_\.-]/', '', $file_name); // Sanitize file name
    $target_file = $target_dir . $file_name;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["file"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size (5MB max)
    if ($_FILES["file"]["size"] > 5000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($imageFileType, $allowed_types)) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            echo "The file ". htmlspecialchars(basename($_FILES["file"]["name"])). " has been uploaded.";

            // Update the database with the new image URL
            $image_url = $target_file;
            $query = "UPDATE plants SET " . $image_type . "_image_url = ? WHERE plant_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("si", $image_url, $plant_id);
            if ($stmt->execute()) {
                echo "Image URL updated in the database.";
            } else {
                echo "Error updating database: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

// Close connection
$conn->close();
?>
