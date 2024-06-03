<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plants Table</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<?php include('gui_navbar.php'); ?>
<div class="container mt-5">
    <h1 class="mb-4">Plants Table</h1>
    <p>Total Records: <span id="recordNumber"></span></p>
    <div class="mb-4">
        <input type="text" id="searchInput" class="form-control" placeholder="Search by plant ID, parent name, or variety name">
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Plant ID</th>
                <th>Parent Name</th>
                <th>Variety Name</th>
            </tr>
        </thead>
        <tbody id="plantsTable">
            <!-- Data will be populated here via AJAX -->
        </tbody>
    </table>
</div>

<script>
document.getElementById('searchInput').addEventListener('input', function() {
    var search = this.value;
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'search_plants_ajax.php?search=' + encodeURIComponent(search), true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            document.getElementById('plantsTable').innerHTML = response.data;
            document.getElementById('recordNumber').textContent = response.total_records;
        }
    };
    xhr.send();
});

// Initial load
window.onload = function() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'search_plants_ajax.php', true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            document.getElementById('plantsTable').innerHTML = response.data;
            document.getElementById('recordNumber').textContent = response.total_records;
        }
    };
    xhr.send();
};
</script>


<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>
