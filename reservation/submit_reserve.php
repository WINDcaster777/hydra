<?php
session_start()


require_once ("../properties/connection.php");

if (isset($_POST['submit'])) {
    $facility = isset($_POST['facility']);
    $fullname = isset($_POST['fullnme']);
    $email_address = isset($_POST['email address']);
    $check_in = isset($_POST['check in']);
    $check_out = isset($_POST['check out']);
    $total_price = isset($_POST['price']);
    $additional_notes = isset($_POST['additional notes'];)


    // For demonstration, output the values
    echo "<h5>Reservation Form Received:</h5>"; 
    echo "Facility: " . htmlspecialchars($facility);
    echo "Full Name: " . htmlspecialchars($fullname);
    echo "Email Address: " . htmlspecialchars($email_address);
    echo "Check In: " . htmlspecialchars($check_in);
    echo "Check Out: " . htmlspecialchars($check_out);
    echo "Total Price: " . htmlspecialchars($total_price);
    echo "Additional Notes: " . htmlspecialchars($additional_notes);


    // After processing, redirect to confirmation.php
    header("Location: confirmation.php");
    exit(); // Always call exit after a header redirect to stop further execution
}
?>