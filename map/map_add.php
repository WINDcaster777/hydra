<?php
require("../properties/connection.php");

$response = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form values
    $name = isset($_POST['name']) ? $conn->real_escape_string($_POST['name']) : '';
    $location = isset($_POST['location']) ? $conn->real_escape_string($_POST['location']) : '';
    $details = isset($_POST['details']) ? $conn->real_escape_string($_POST['details']) : '';
    $icon = isset($_POST['icon']) ? $conn->real_escape_string($_POST['icon']) : '';

    // Check if location is in correct format (POINT(x, y))
    if (preg_match('/^POINT\((-?\d+(\.\d+)?), (-?\d+(\.\d+)?)\)$/', $location, $matches)) {
        $x = $matches[1]; // X coordinate
        $y = $matches[3]; // Y coordinate

        // Insert into database
        $sql = "INSERT INTO facility (name, location, details, icon, status, date_added) 
                VALUES ('$name', ST_GeomFromText('POINT($x $y)'), '$details', '$icon', 'Available', NOW())";

        if ($conn->query($sql) === TRUE) {
            $response = [
                'status' => 'success',
                'message' => 'Marker added successfully!',
                'data' => [
                    'name' => $name,
                    'location' => $location,
                    'details' => $details,
                    'icon' => $icon
                ]
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Failed to add marker: ' . $conn->error
            ];
        }
    } else {
        $response = [
            'status' => 'error',
            'message' => 'Invalid location format. Must be POINT(x, y).'
        ];
    }
} else {
    $response = [
        'status' => 'error',
        'message' => 'Invalid request method.'
    ];
}

header('Content-Type: application/json');
echo json_encode($response);

$conn->close();
?>
