<?php
session_start();
include 'db.php'; // Database connection

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query the database to check if the email exists
    $sql = "SELECT * FROM admin WHERE email = '$email'";
    $result = mysqli_query($con, $sql);
    $admin = mysqli_fetch_assoc($result);

    if ($admin && $admin['password'] === $password) {
        // If email exists and password matches, store admin data in session
        $_SESSION['admin_id'] = $admin['id']; // Store admin id in session
        $_SESSION['admin_name'] = $admin['name']; // Store admin name in session
        header("Location: admin_dashboard.php"); // Redirect to admin dashboard
        exit();
    } else {
        $error_message = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            max-width: 400px;
            margin: 100px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #007acc;
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            font-weight: bold;
            color: #007acc;
        }
        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .submit-btn {
            background-color: #007acc;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }
        .submit-btn:hover {
            background-color: #005f99;
        }
        .error {
            color: red;
            font-weight: bold;
            text-align: center;
        }
        .back-home {
            text-align: center;
            margin-top: 20px;
        }
        .back-home a {
            text-decoration: none;
            color: #007acc;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Admin Login</h1>

    <?php if (isset($error_message)) : ?>
        <p class="error"><?= $error_message ?></p>
    <?php endif; ?>

    <form method="POST" action="admin_login.php">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div class="form-group">
            <button type="submit" class="submit-btn">Login</button>
        </div>
    </form>

    <div class="back-home">
        <p><a href="index.php">Back to Home</a></p>
    </div>
</div>

</body>
</html>
