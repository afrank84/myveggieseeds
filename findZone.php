<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plant Hardiness Zone Finder</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Plant Hardiness Zone Finder</h1>
        <form action="index.php" method="post" class="mt-4">
            <div class="mb-3">
                <label for="city" " class="form-label">City</label>
                <input type="text" class="form-control" id="city" name="city" required>
            </div>
            <div class="mb-3">
                <label for="state" class="form-label">State</label>
                <input type="text" class="form-control" id="state" name="state" required>
            </div>
            <button type="submit" class="btn btn-primary">Find Hardiness Zone</button>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $city = htmlspecialchars($_POST['city']);
            $state = htmlspecialchars($_POST['state']);

            $city_encoded = urlencode($city);
            $state_encoded = urlencode($state);

            $url = "https://apps.npr.org/plant-hardiness-garden-map/?name=$city_encoded&state=$state_encoded";

            echo "<div class='mt-4'>";
            echo "<h2>Results for $city, $state</h2>";
            echo "<p>Click the link below to see the plant hardiness zone for your location:</p>";
            echo "<a href='$url' target='_blank'>$url</a>";
            echo "</div>";
        }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.3/js/bootstrap.min.js"></script>
</body>
</html>

