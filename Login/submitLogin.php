<?php
session_start();

require ("../properties/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get username and password from POST data
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    // Prepare statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($db_password_hash);

    // Check if a record was returned
    if ($stmt->fetch()) {
        // Verify the hashed password
        if (password_verify($password, $db_password_hash)) {
            $_SESSION["username"] = $username;
            header("Location: ../admin/adminDash.php");
            exit();
        } else {
            $error = "Invalid username or password!";
        }
    } else {
        $error = "Invalid username or password!";
    }
    $stmt->close();
    mysqli_close($conn);
}
?>
