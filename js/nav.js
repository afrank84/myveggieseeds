document.addEventListener('DOMContentLoaded', () => {
    console.log('Document is ready');
    fetch('../nav.html')
      .then(response => {
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        return response.text();
      })
      .then(data => {
        document.querySelector('#navbar-placeholder').innerHTML = data;
        console.log('Navigation loaded');
      })
      .catch(error => console.error('Error loading navigation:', error));
  });
  