<?php
session_start();
include 'db.php'; // Database connection

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query the database to check if the email exists
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($con, $sql);
    $user = mysqli_fetch_assoc($result);

    if ($user && $user['password'] == $password) {
        // If email exists and password matches, store user data in session
        $_SESSION['user_id'] = $user['id']; // Store user_id in session
        $_SESSION['user_name'] = $user['name'];  // Store user name in session

        header("Location: user_dashboard.php"); // Redirect to user dashboard
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
    <title>User Sign In</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            text-align: center;
            max-width: 2000px;  
            padding: 80px;  
            background: white;
            border-radius: 8px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            animation: fadeIn 2s ease-in-out;
        }

        h2 {
            color: #007acc;
            margin-bottom: 10px;
        }

        p {
            margin-bottom: 20px;
            font-size: 18px;
        }

        .error {
            color: red;
            font-size: 16px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .form-group label {
            display: block;
            font-size: 16px;
            margin-bottom: 8px;
        }

        .form-group input {
            width: 100%;
            padding: 15px;  /* Increased padding for better spacing */
            margin-bottom: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .form-group input[type="submit"] {
            background-color: #007acc;
            color: white;
            border: none;
            cursor: pointer;
        }

        .form-group input[type="submit"]:hover {
            background-color: #005f99;
        }

        .links {
            margin-top: 20px;
        }

        .links a {
            display: inline-block;
            margin: 10px;
            padding: 10px 20px;
            text-decoration: none;
            color: white;
            background-color: #007acc;
            border-radius: 5px;
            transition: background-color 0.3s ease-in-out;
        }

        .links a:hover {
            background-color: #005f99;
        }

        .back-home {
            margin-top: 20px;
        }

        .back-home a {
            text-decoration: none;
            color: #007acc;
            font-size: 16px;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

    </style>
</head>

<body>
    <div class="container">
        <h2>User Sign-In</h2>

        <?php
        if (isset($error_message)) {
            echo "<p class='error'>$error_message</p>";
        }
        ?>

        <form action="user_signin.php" method="POST">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" required>
            </div>

            <div class="form-group">
                <input type="submit" value="Sign In">
            </div>
        </form>

        <div class="back-home">
            <p><a href="index.php">Back to Home</a></p>
        </div>
    </div>
</body>

</html>
