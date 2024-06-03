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
    <h2 class="text-center">Parent</h2>
    <h1 class="text-center">Variety</h1>
    <p class="text-center">Zone: 9b</p>
    <!-- Top Layer -->
    <div class="row justify-content-center mt-5">
        <div class="col-md-3">
          <div class="card">
            <img src="https://placehold.co/150" class="card-img-top" alt="Image Placeholder">
            <div class="card-body">
              <p class="card-text text-center">Seed</p>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card">
            <img src="https://placehold.co/150" class="card-img-top" alt="Image Placeholder">
            <div class="card-body">
              <p class="card-text text-center">Plant</p>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card">
            <img src="https://placehold.co/150" class="card-img-top" alt="Image Placeholder">
            <div class="card-body">
              <p class="card-text text-center">Fruit</p>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card">
            <img src="https://placehold.co/150" class="card-img-top" alt="Image Placeholder">
            <div class="card-body">
              <p class="card-text text-center">Flower</p>
            </div>
          </div>
        </div>
      </div>
    <hr/>


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
                <td>Enter_Value</td>
              </tr>
              <tr>
                <td>DTH (Days to Harvest)</td>
                <td>Enter_Value</td>
              </tr>
              <tr>
                <td>Depth to Sow</td>
                <td>Enter_Value</td>
              </tr>
              <tr>
                <td>Seed Spacing</td>
                <td>Enter_Value</td>
              </tr>
              <tr>
                <td>Row Spacing</td>
                <td>Enter_Value</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      
    <!-- Sortable Table Layer -->
    <h4>Records</h4>
    <div class="row justify-content-center mt-5">
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
              <tr>
                <td>YYYY-MM--DD</td>
                <td>Filler text 2</td>
                <td>Filler text 3</td>
              </tr>
              <tr>
                <td>YYYY-MM--DD</td>
                <td>Filler text 5</td>
                <td>Filler text 6</td>
              </tr>
              <tr>
                <td>YYYY-MM--DD</td>
                <td>Filler text 8</td>
                <td>Filler text 9</td>
              </tr>
              <tr>
                <td>YYYY-MM--DD</td>
                <td>Filler text 11</td>
                <td>Filler text 12</td>
              </tr>
              <tr>
                <td>YYYY-MM--DD</td>
                <td>Filler text 14</td>
                <td>Filler text 15</td>
              </tr>
              <tr>
                <td>YYYY-MM--DD</td>
                <td>Filler text 17</td>
                <td>Filler text 18</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <hr/>
      <p class="text-center">Copyright @ 2024</p>

  </div>

  <!-- Bootstrap JS and dependencies -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
  <script src="js/searchbarAjax.js"></script>
  <script src="js/sortEventsTable.js"></script><!--Custom: Frank-->

  
</body>
</html>
