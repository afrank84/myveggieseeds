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

// Get the plant ID from the URL
$plant_id = isset($_GET['plant_id']) ? intval($_GET['plant_id']) : 0;

// Fetch plant details
$query = "SELECT * FROM plants WHERE plant_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $plant_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  $plant = $result->fetch_assoc();
} else {
  die("No details found for the specified plant.");
}

// Close statement and connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Micro Farm</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
  <?php include('gui_navbar.php'); ?>
  <div class="container">
    <h2 class="text-center"><?php echo htmlspecialchars($plant['parent_name']); ?></h2>
    <h1 class="text-center"><?php echo htmlspecialchars($plant['variety_name']); ?></h1>
    <p class="text-center">Zone: 9b</p>

    <!-- Top Layer -->
    <div class="row justify-content-center mt-5">
      <div class="col-md-3">
        <div class="card">
          <img src="<?php echo htmlspecialchars($plant['seed_image_url']); ?>" class="card-img-top" alt="Seed Image" style="object-fit: cover; aspect-ratio: 1; width: 100%; height: auto; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#imageModal" data-bs-image="<?php echo htmlspecialchars($plant['seed_image_url']); ?>">
          <div class="card-body">
            <p class="card-text text-center">Seed</p>
            <?php if (in_array($user_role, $allowed_roles)) { ?>
              <form action="upload_image.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="plant_id" value="<?php echo $plant['plant_id']; ?>">
                <input type="hidden" name="parent_name" value="<?php echo htmlspecialchars($plant['parent_name']); ?>">
                <input type="hidden" name="variety_name" value="<?php echo htmlspecialchars($plant['variety_name']); ?>">
                <input type="hidden" name="image_type" value="seed">
                <input type="file" name="file" required>
                <button type="submit" class="btn btn-primary btn-sm mt-2">Upload</button>
              </form>
            <?php } ?>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card">
          <img src="<?php echo htmlspecialchars($plant['plant_image_url']); ?>" class="card-img-top" alt="Plant Image" style="object-fit: cover; aspect-ratio: 1; width: 100%; height: auto; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#imageModal" data-bs-image="<?php echo htmlspecialchars($plant['plant_image_url']); ?>">
          <div class="card-body">
            <p class="card-text text-center">Plant</p>
            <?php if (in_array($user_role, $allowed_roles)) { ?>
              <form action="upload_image.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="plant_id" value="<?php echo $plant['plant_id']; ?>">
                <input type="hidden" name="parent_name" value="<?php echo htmlspecialchars($plant['parent_name']); ?>">
                <input type="hidden" name="variety_name" value="<?php echo htmlspecialchars($plant['variety_name']); ?>">
                <input type="hidden" name="image_type" value="plant">
                <input type="file" name="file" required>
                <button type="submit" class="btn btn-primary btn-sm mt-2">Upload</button>
              </form>
            <?php } ?>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card">
          <img src="<?php echo htmlspecialchars($plant['fruit_image_url']); ?>" class="card-img-top" alt="Fruit Image" style="object-fit: cover; aspect-ratio: 1; width: 100%; height: auto; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#imageModal" data-bs-image="<?php echo htmlspecialchars($plant['fruit_image_url']); ?>">
          <div class="card-body">
            <p class="card-text text-center">Fruit</p>
            <?php if (in_array($user_role, $allowed_roles)) { ?>
              <form action="upload_image.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="plant_id" value="<?php echo $plant['plant_id']; ?>">
                <input type="hidden" name="parent_name" value="<?php echo htmlspecialchars($plant['parent_name']); ?>">
                <input type="hidden" name="variety_name" value="<?php echo htmlspecialchars($plant['variety_name']); ?>">
                <input type="hidden" name="image_type" value="fruit">
                <input type="file" name="file" required>
                <button type="submit" class="btn btn-primary btn-sm mt-2">Upload</button>
              </form>
            <?php } ?>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card">
          <img src="<?php echo htmlspecialchars($plant['flower_image_url']); ?>" class="card-img-top" alt="Flower Image" style="object-fit: cover; aspect-ratio: 1; width: 100%; height: auto; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#imageModal" data-bs-image="<?php echo htmlspecialchars($plant['flower_image_url']); ?>">
          <div class="card-body">
            <p class="card-text text-center">Flower</p>
            <?php if (in_array($user_role, $allowed_roles)) { ?>
              <form action="upload_image.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="plant_id" value="<?php echo $plant['plant_id']; ?>">
                <input type="hidden" name="parent_name" value="<?php echo htmlspecialchars($plant['parent_name']); ?>">
                <input type="hidden" name="variety_name" value="<?php echo htmlspecialchars($plant['variety_name']); ?>">
                <input type="hidden" name="image_type" value="flower">
                <input type="file" name="file" required>
                <button type="submit" class="btn btn-primary btn-sm mt-2">Upload</button>
              </form>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
    <hr />



    <h4>Information</h4>

    <!-- 12-Column Table Layer -->
    <div class="row justify-content-center mt-5">
      <div class="col-12" style="max-width: 72rem;">
        <table class="table table-bordered text-center">
          <tbody>
            <tr>
              <td>Jan</td>
              <td>Feb</td>
              <td>Mar</td>
              <td>Apr</td>
              <td>May</td>
              <td>Jun</td>
              <td>Jul</td>
              <td>Aug</td>
              <td>Sep</td>
              <td>Oct</td>
              <td>Nov</td>
              <td>Dec</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Table -->
    <div class="row justify-content-center mt-5">
      <div class="col-12" style="max-width: 72rem;">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">Stats</th>
              <th scope="col">Value</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>DTG (Days to Grow)</td>
              <td><?php echo htmlspecialchars($plant['dtg_days_to_grow']); ?></td>
            </tr>
            <tr>
              <td>DTH (Days to Harvest)</td>
              <td><?php echo htmlspecialchars($plant['dth_days_to_harvest']); ?></td>
            </tr>
            <tr>
              <td>Depth to Sow</td>
              <td><?php echo htmlspecialchars($plant['depth_to_sow']); ?></td>
            </tr>
            <tr>
              <td>Seed Spacing</td>
              <td><?php echo htmlspecialchars($plant['seed_spacing']); ?></td>
            </tr>
            <tr>
              <td>Row Spacing</td>
              <td><?php echo htmlspecialchars($plant['row_spacing']); ?></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Sortable Table Layer -->
    <div class="row justify-content-center">
            <div class="col-12" style="max-width: 72rem;">
                <table id="sortableTable" class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col" onclick="sortTable(0)">Date</th>
                            <th scope="col" onclick="sortTable(1)">Event</th>
                            <th scope="col" onclick="sortTable(2)">Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (($handle = fopen("events/records.csv", "r")) !== FALSE) {
                            // Skip the header row
                            fgetcsv($handle, 1000, ",");
                            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                                echo "<tr>";
                                echo "<td>{$data[0]}</td>";
                                echo "<td>{$data[1]}</td>";
                                echo "<td>{$data[2]}</td>";
                                echo "</tr>";
                            }
                            fclose($handle);
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

    <!-- Add this modal structure at the end of your body section -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="imageModalLabel"><?php echo htmlspecialchars($plant['parent_name'] . ' : ' . $plant['variety_name']); ?></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <img src="" id="modalImage" class="img-fluid" alt="Large Image">
          </div>
        </div>
      </div>
    </div>


    <hr />
    <p class="text-center">Copyright @ 2024</p>

  </div>

  <!-- Bootstrap JS and dependencies -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
  <script src="js/searchbarAjax.js"></script>
  <script src="js/sortEventsTable.js"></script><!--Custom: Frank-->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var imageModal = document.getElementById('imageModal');
      imageModal.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget; // Button that triggered the modal
        var imageSrc = button.getAttribute('data-bs-image'); // Extract info from data-bs-* attributes
        var modalImage = imageModal.querySelector('#modalImage');
        modalImage.src = imageSrc;
      });
    });
  </script>

</body>

</html>