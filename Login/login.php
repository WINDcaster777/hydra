<?php
session_start();


require_once ("../properties/connection.php");

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        // Check plain text password (no hashing)
        if ($password === $row['password']) {
            $_SESSION['user'] = $row['username'];
            header("Location: adminDash.php");
            exit();
        } else {
            $error = "Invalid username or password.";
        }
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link 
      rel="stylesheet" 
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" 
      crossorigin="anonymous">
    <style>
        html, body {
            height: 100%;
            margin: 0;
        }
        body {
            background: url('https://img.freepik.com/premium-photo/abstract-blur-hotel-resort-as-blurred-background_1339-73035.jpg?w=996') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 10px;
            padding: 2.5rem;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <h4 class="text-center mb-4">Login</h4>
        <?php if (isset($error)) : ?>
            <div class="alert alert-danger mb-3" role="alert">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Username:</label>
                <input 
                    type="text" 
                    name="username" 
                    id="username" 
                    class="form-control" 
                    required 
                    autofocus>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    class="form-control" 
                    required>
            </div>
            <button type="submit" class="btn btn-primary btn-block mb-3">Log In</button>
        </form>
        <div class="text-center text-muted">
            &copy; <?php echo date("Y"); ?>
        </div>
    </div>

    <script 
      src="https://code.jquery.com/jquery-3.5.1.slim.min.js" 
      crossorigin="anonymous"></script>
    <script 
      src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js" 
      crossorigin="anonymous"></script>
</body>
</html>
