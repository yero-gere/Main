<?php
// Database connection
include("db.php");

// Fetch international destinations (Search)
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    // Modify the query to filter international destinations
    $query = "SELECT * FROM destinations WHERE type = 'national' AND (location LIKE '%$search%' OR name LIKE '%$search%' OR price LIKE '%$search%')";
    $result = $conn->query($query);

    $destinations = [];

    while ($row = $result->fetch_assoc()) {
        $destinations[] = $row;
    }

    echo json_encode($destinations);
}

// Insert new international destination
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name=$_POST['name'];
    $price=$_POST["price"];
    $description=$_POST["description"];
    $location=$_POST['location'];
    $image_url=$_POST['image_url'];
    // Add the type as 'international' for new destinations
    $type = $_POST['type'];

    $query = "INSERT INTO destinations (name,price,description,location,image_url,type) 
              VALUES ('$name','$price','$description','$location','$image_url','$type')";

    if ($conn->query($query) === TRUE) {
        echo "New national destination added successfully";
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }
}

$conn->close();
?>
