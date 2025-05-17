document.addEventListener('DOMContentLoaded', function () {
  // Initialize sidenav
  const sideNav = document.querySelectorAll('.sidenav');
  M.Sidenav.init(sideNav);

  // Handle form submission
  const form = document.querySelector('#contact-form');
  form.addEventListener('submit', function (e) {
    e.preventDefault();
    alert('Thank you! Your message has been submitted.');
    form.reset();
  });
});
