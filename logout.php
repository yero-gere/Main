<?php
// Start the session
session_start();

// Destroy all session data
session_unset();
session_destroy();

// Redirect to the login page or homepage
header("Location: index.html"); // Or any page where you want to redirect the user after logout
exit();
?>
