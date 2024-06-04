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
    header("Location: login_page.php");
    exit();
}

// Fetch user information
$username = $_SESSION['username'];
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Handle profile update
$update_successful = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $fullname = $_POST['fullname'];
    $profile_image = $user['profile_image'];

    // Handle profile image upload
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == UPLOAD_ERR_OK) {
        // Delete the old profile image if it exists
        if (!empty($profile_image) && file_exists($profile_image)) {
            unlink($profile_image);
        }

        // Upload the new profile image
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["profile_image"]["name"]);
        move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file);
        $profile_image = $target_file;
    }

    $update_sql = "UPDATE users SET email = ?, fullname = ?, profile_image = ? WHERE username = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ssss", $email, $fullname, $profile_image, $username);

    if ($update_stmt->execute()) {
        $update_successful = true;
    } else {
        echo "Error updating profile: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<?php include('gui_navbar.php'); ?>

<div class="container mt-5">
    <h1 class="text-center">Profile</h1>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card mt-5">
                <div class="card-body">
                    <h5 class="card-title text-center">Profile Information</h5>
                    <form action="profile.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3 text-center">
                            <img src="<?php echo htmlspecialchars($user['profile_image']); ?>" alt="Profile Image" class="rounded-circle" width="150">
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="fullname" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo htmlspecialchars($user['fullname']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="profile_image" class="form-label">Profile Image</label>
                            <input type="file" class="form-control" id="profile_image" name="profile_image">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Update Profile</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if ($update_successful): ?>
    <script>
        // Reload the page to display the updated profile picture
        window.location.href = window.location.href;
    </script>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
