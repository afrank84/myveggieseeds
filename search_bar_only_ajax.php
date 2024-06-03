<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plant Search Dropdown</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .dropdown-menu {
            display: block;
            max-height: 200px;
            overflow-y: auto;
        }
        .dropdown-item:hover, .dropdown-item:focus {
            background-color: #e9ecef;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Plant Search</h1>
    <div class="mb-4 position-relative">
        <input type="text" id="searchInput" class="form-control" placeholder="Search by plant ID, parent name, or variety name">
        <div class="dropdown-menu w-100" id="dropdownMenu"></div>
    </div>
</div>

<script>
document.getElementById('searchInput').addEventListener('input', function() {
    var search = this.value;
    if (search.length > 0) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'search_10_results.php?search=' + encodeURIComponent(search), true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                var data = JSON.parse(xhr.responseText);
                var dropdownMenu = document.getElementById('dropdownMenu');
                dropdownMenu.innerHTML = '';
                if (data.length > 0) {
                    data.forEach(function(item) {
                        var dropdownItem = document.createElement('button');
                        dropdownItem.className = 'dropdown-item';
                        dropdownItem.type = 'button';
                        dropdownItem.textContent = item.plant_id + ' - ' + item.parent_name + ' - ' + item.variety_name;
                        dropdownItem.addEventListener('click', function() {
                            document.getElementById('searchInput').value = dropdownItem.textContent;
                            dropdownMenu.innerHTML = '';
                        });
                        dropdownMenu.appendChild(dropdownItem);
                    });
                } else {
                    var noResults = document.createElement('div');
                    noResults.className = 'dropdown-item disabled';
                    noResults.textContent = 'No records found';
                    dropdownMenu.appendChild(noResults);
                }
            }
        };
        xhr.send();
    } else {
        document.getElementById('dropdownMenu').innerHTML = '';
    }
});

// Handle arrow key navigation
document.getElementById('searchInput').addEventListener('keydown', function(event) {
    var dropdownMenu = document.getElementById('dropdownMenu');
    var items = dropdownMenu.getElementsByClassName('dropdown-item');
    if (event.key === 'ArrowDown' || event.key === 'ArrowUp') {
        event.preventDefault();
        var focusedElement = document.activeElement;
        if (focusedElement && focusedElement.classList.contains('dropdown-item')) {
            if (event.key === 'ArrowDown' && focusedElement.nextElementSibling) {
                focusedElement.nextElementSibling.focus();
            } else if (event.key === 'ArrowUp' && focusedElement.previousElementSibling) {
                focusedElement.previousElementSibling.focus();
            }
        } else if (items.length > 0) {
            items[0].focus();
        }
    }
});
</script>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

</body>
</html>
