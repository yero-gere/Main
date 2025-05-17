<?php
// Include database connection
include('db.php');

// Fetch the total number of destinations
$sql_total = "SELECT COUNT(*) AS total FROM destinations";
$result_total = $conn->query($sql_total);
$total_row = $result_total->fetch_assoc();
$total_destinations = $total_row['total'];

// If a search term is passed, filter the destinations
$search = isset($_GET['search']) ? "%" . $_GET['search'] . "%" : '';

// Fetch destinations based on the search term (if any)
$sql_destinations = "SELECT id, name, location, price FROM destinations 
                     WHERE name LIKE ? OR location LIKE ?";
$stmt = $conn->prepare($sql_destinations);
$stmt->bind_param("ss", $search, $search);
$stmt->execute();
$result = $stmt->get_result();

// Prepare the destinations data to send to frontend
$destinations = [];
while ($row = $result->fetch_assoc()) {
    $destinations[] = $row;
}

// Return the data in JSON format
echo json_encode([
    'total_destinations' => $total_destinations,
    'destinations' => $destinations
]);

$conn->close();
?>
