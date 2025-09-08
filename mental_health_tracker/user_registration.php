<?php
session_start();
include 'db.php'; // Database connection

// Registration logic
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $age = $_POST['age'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $gender = $_POST['gender'];

    // Check if passwords match
    if ($password != $confirm_password) {
        $error_message = "Passwords do not match!";
    } else {
        // Check if email already exists
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($con, $sql);

        if (mysqli_num_rows($result) > 0) {
            $error_message = "Email already exists. Please use a different email.";
        } else {
            // Insert user data into the database
            $sql = "INSERT INTO users (name, email, age, password, gender) VALUES ('$name', '$email', '$age', '$password', '$gender')";
            if (mysqli_query($con, $sql)) {
                $success_message = "Successfully registered! You can now <a href='user_signin.php'>Sign In</a>";
            } else {
                $error_message = "Error occurred while registering. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 350px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #007acc;
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 5px;
            text-align: left; /* Align labels to the left */
            font-size: 16px;
        }

        input[type="text"],
        input[type="email"],
        input[type="number"],
        input[type="password"],
        select {
            padding: 8px;
            margin-bottom: 15px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        input[type="submit"] {
            padding: 10px;
            background-color: #007acc;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #005f99;
        }

        .error {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }

        .success {
            color: green;
            text-align: center;
            margin-bottom: 10px;
        }

        .back-home {
            text-align: center;
        }

        .back-home a {
            color: #007acc;
            text-decoration: none;
        }

        .back-home a:hover {
            text-decoration: underline;
        }
        
    </style>
</head>

<body>

    <div class="container">
        <h2>User Registration</h2>

        <?php
        if (isset($error_message)) {
            echo "<p class='error'>$error_message</p>";
        }
        if (isset($success_message)) {
            echo "<p class='success'>$success_message</p>";
        }
        ?>

        <form action="user_registration.php" method="POST">
            <label for="name">Name</label>
            <input type="text" name="name" required>

            <label for="email">Email</label>
            <input type="email" name="email" required>

            <label for="age">Age</label>
            <input type="number" name="age" required>

            <label for="password">Password</label>
            <input type="password" name="password" required>

            <label for="confirm_password">Confirm Password</label>
            <input type="password" name="confirm_password" required>

            <label for="gender">Gender</label>
            <select name="gender" required>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>

            <input type="submit" value="Register">
        </form>

        <div class="back-home">
            <p><a href="index.php">Back to Home</a></p>
        </div>
    </div>

</body>
</html>
