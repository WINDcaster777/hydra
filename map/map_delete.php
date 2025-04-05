<?php
// Include your database connection file
include('db_connection.php');

// Check if an ID is passed via GET
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $marker_id = $_GET['id'];

    // Prepare SQL query to delete the marker from the database
    $query = "DELETE FROM markers WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $marker_id);

    // Execute the query
    if ($stmt->execute()) {
        // Return success response
        echo json_encode([
            'status' => 'success',
            'message' => 'Marker deleted successfully!'
        ]);
    } else {
        // Return error response
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to delete marker. Please try again.'
        ]);
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    // If no ID is provided or the ID is not valid
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid marker ID provided.'
    ]);
}
?>
