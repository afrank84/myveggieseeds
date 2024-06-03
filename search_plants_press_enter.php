<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plants Table</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Plants Table</h1>
    <form method="GET" class="mb-4">
        <input type="text" name="search" id="searchInput" class="form-control" placeholder="Search by plant ID, parent name, or variety name" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
    </form>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Plant ID</th>
                <th>Parent Name</th>
                <th>Variety Name</th>
            </tr>
        </thead>
        <tbody id="plantsTable">
            <?php
            // Include the configuration file
            $config = include('db_config.php');

            // Create connection
            $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['database']);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Query to fetch data
            $query = "SELECT plant_id, parent_name, variety_name FROM plants";
            if (isset($_GET['search'])) {
                $search = $conn->real_escape_string($_GET['search']);
                $query .= " WHERE plant_id LIKE '%$search%' OR parent_name LIKE '%$search%' OR variety_name LIKE '%$search%'";
            }

            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['plant_id']}</td>
                            <td>{$row['parent_name']}</td>
                            <td>{$row['variety_name']}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No records found</td></tr>";
            }

            // Close connection
            $conn->close();
            ?>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

</body>
</html>
