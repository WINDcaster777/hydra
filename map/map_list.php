<?php
require("../properties/connection.php");

$sql = "SELECT id, name, details, status, price FROM facility";
$result = $conn->query($sql);

$markers = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $markers[] = $row;
    }
}

$conn->close();

header('Content-Type: application/json');
echo json_encode(['data' => $markers]);
?>
