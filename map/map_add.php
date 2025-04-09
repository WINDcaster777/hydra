<?php
require("../properties/connection.php");

$response = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize input
    $name = isset($_POST['name']) ? trim($conn->real_escape_string($_POST['name'])) : '';
    $location = isset($_POST['location']) ? trim($conn->real_escape_string($_POST['location'])) : '';
    $details = isset($_POST['details']) ? trim($conn->real_escape_string($_POST['details'])) : '';
    $status = isset($_POST['icon']) ? strtolower(trim($conn->real_escape_string($_POST['icon']))) : 'unavailable';
    $price = isset($_POST['price']) ? trim($conn->real_escape_string($_POST['price'])) : '0';

    // Image handling
    $imagePath = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../upload/';
        $originalName = basename($_FILES['image']['name']);
        $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (in_array($extension, $allowedExtensions)) {
            $newFilename = uniqid('img_', true) . '.' . $extension;
            $fullPath = $uploadDir . $newFilename;

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            if (move_uploaded_file($_FILES['image']['tmp_name'], $fullPath)) {
                $imagePath = 'upload/' . $newFilename; // Save relative path
            } else {
                $response = [
                    'status' => 'error',
                    'message' => 'Failed to upload image.'
                ];
                echo json_encode($response);
                exit;
            }
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Invalid image format. Allowed: jpg, jpeg, png, gif, webp.'
            ];
            echo json_encode($response);
            exit;
        }
    }

    // Validate status
    $validStatuses = ['available', 'unavailable'];
    if (!in_array($status, $validStatuses)) {
        $status = 'available';
    }

    // Validate location format
    if (preg_match('/^POINT\((-?\d+(\.\d+)?) (-?\d+(\.\d+)?)\)$/', $location, $matches)) {
        $x = $matches[1];
        $y = $matches[3];

        // Insert into DB with image path
        $sql = "INSERT INTO facility (name, location, details, status, price, image, date_added) 
                VALUES ('$name', ST_GeomFromText('POINT($x $y)'), '$details', '$status', '$price', '$imagePath', NOW())";

        if ($conn->query($sql) === TRUE) {
            $response = [
                'status' => 'success',
                'message' => 'Marker added successfully!',
                'data' => [
                    'name' => $name,
                    'location' => $location,
                    'details' => $details,
                    'status' => $status,
                    'price' => $price,
                    'image' => $imagePath
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
            'message' => 'Invalid location format. Must be POINT(x y).'
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
