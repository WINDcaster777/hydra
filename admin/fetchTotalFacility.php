<?php
require_once ("../properties/connection.php");

$sql = "SELECT count(*) AS total FROM facility WHERE status='available'";
$result = mysqli_query($conn, $sql);

// Check the query result
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

$row = mysqli_fetch_assoc($result);
echo $row['total'] ?? 0;
?>
