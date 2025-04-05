<?php
// Database connection
require("../properties/connection.php");

// Query to retrieve all markers from the database
$sql = "SELECT id, name, details, status FROM facility";
$result = $conn->query($sql);

$markers = [];

// Fetch markers from the database
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $markers[] = $row;
    }
    $response = [
        'status' => 'success',
        'markers' => $markers
    ];
} else {
    $response = [
        'status' => 'error',
        'message' => 'No markers found'
    ];
}

$conn->close();

// Set content type to JSON and output the response
header('Content-Type: application/json');
echo json_encode($response);
?>
