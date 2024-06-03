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