function logout() {
  // Send an AJAX request to the same page with a logout action
  fetch('home.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
    },
    body: 'action=logout',
    credentials: 'same-origin',
  })
    .then((response) => {
      if (response.ok) {
        window.location.href = 'signin.php';
      } else {
        console.error('Logout failed');
      }
    })
    .catch((error) => {
      console.error('Error:', error);
    });
}
