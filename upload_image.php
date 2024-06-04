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
    header("Location: login.php"); // Redirect to login page
    exit;
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
    header("Location: previous_page.php"); // Redirect to previous page
    exit;
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

    // Generate a sanitized file name base
    $file_extension = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
    $file_base_name = $plant_id . "_" . $parent_name . "_" . $variety_name . "_" . $image_type;
    $file_name = $file_base_name . "." . $file_extension;
    $file_name = preg_replace('/[^a-zA-Z0-9_\.-]/', '', $file_name); // Sanitize file name
    $target_file = $target_dir . $file_name;
    $uploadOk = 1;
    $imageFileType = strtolower($file_extension);

    // Check if image file is an actual image or fake image
    $check = getimagesize($_FILES["file"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
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
        // Delete any existing files with the same base name but different extension
        foreach ($allowed_types as $ext) {
            $existing_file = $target_dir . $file_base_name . "." . $ext;
            if (file_exists($existing_file)) {
                unlink($existing_file);
            }
        }

        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            echo "The file ". htmlspecialchars($file_name). " has been uploaded.";

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

    // Redirect back to the previous page
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
}

// Close connection
$conn->close();
?>
