<?php
// Database configuration
require("../properties/connection.php");

// Query to retrieve markers, including the status, using ST_X() and ST_Y() to get the coordinates from the POINT column
$sql = "SELECT id, name, ST_X(location) AS x, ST_Y(location) AS y, details, status, price FROM facility";  // Assuming 'status' column exists
$result = $conn->query($sql);

$response = array();

if ($result->num_rows > 0) {
    // Fetch all markers
    while ($row = $result->fetch_assoc()) {
        // Include location, status, and other necessary details in the response
        $response['markers'][] = $row;
    }
    $response['status'] = 'success';
} else {
    $response['status'] = 'error';
    $response['message'] = 'No markers found';
}

$conn->close();

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
