<?php
// Database connection
$host = 'localhost';
$user = 'root';
$pass = ''; // Change if you have a password
$db = 'travel'; // Replace with your DB name

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get and sanitize POST data
$name = htmlspecialchars(trim($_POST['name']));
$email = htmlspecialchars(trim($_POST['email']));
$phone = htmlspecialchars(trim($_POST['phone']));
$message = htmlspecialchars(trim($_POST['message']));

// Validate required fields
if ($name && $email && $message) {
    $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, phone, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $phone, $message);

    if ($stmt->execute()) {
        echo "<script>alert('Message sent successfully!'); window.location.href='contact.html';</script>";
    } else {
        echo "<script>alert('Error submitting the form.'); history.back();</script>";
    }

    $stmt->close();
} else {
    echo "<script>alert('Please fill in all required fields.'); history.back();</script>";
}

$conn->close();
?>
