<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$database = "travel"; // Make sure this database exists

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input
    $name = htmlspecialchars(trim($_POST['name']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $destination = htmlspecialchars(trim($_POST['destination']));
    $date = $_POST['date'];
    $travelers = (int)$_POST['travelers'];

    // Basic validation
    if (empty($name) || empty($email) || empty($destination) || empty($date) || $travelers <= 0) {
        echo "Please fill all fields correctly.";
        exit;
    }

    // Insert into the database
    $stmt = $conn->prepare("INSERT INTO bookings (name, email, destination, date, travelers) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $name, $email, $destination, $date, $travelers);

    if ($stmt->execute()) {
        echo "Booking successful! Thank you, $name.";
        echo "<script>alert('Booking  successfully!'); window.location.href='index.html';</script>";
    } else {
        echo "Booking failed. Please try again later.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
