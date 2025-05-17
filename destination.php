
<?php
// Database connection
$host = "localhost";
$user = "root";
$password = ""; // Adjust if needed
$dbname = "travel"; // Use your actual database name

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// Get parameters from the frontend (AJAX)
$sort = $_GET['sort'] ?? '';
$filter = $_GET['filter'] ?? '';
$search = $_GET['search'] ?? '';

// Start building the SQL query
$sql = "SELECT * FROM destinations WHERE 1";

// Search condition
if (!empty($search)) {
    $search = $conn->real_escape_string($search);
    $sql .= " AND name LIKE '%$search%'";
}

// Filter condition
if ($filter === 'National') {
    $sql .= " AND type = 'National'";
} elseif ($filter === 'International') {
    $sql .= " AND type = 'International'";
}

// Sorting condition
if ($sort === 'lth') {
    $sql .= " ORDER BY price ASC";
} elseif ($sort === 'htl') {
    $sql .= " ORDER BY price DESC";
}

// Execute the query
$result = $conn->query($sql);

$destinations = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $destinations[] = $row;
    }
}

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($destinations);

$conn->close();
?>
