<?php
include ("../properties/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $birthdate = $_POST['birthdate'];
    $address = $_POST['address'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($_POST['password'] !== $confirm_password) {
        die("Passwords do not match.");
    }

    // Insert data into the database
    $sql = "INSERT INTO users (name, age, birthdate, address, gender, email, username, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sissssss", $name, $age, $birthdate, $address, $gender, $email, $username, $password);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: ../Login/login.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>
