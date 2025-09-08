<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Welcome to Mental Health Tracker</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color:rgb(205, 230, 252);
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            text-align: center;
            max-width: 600px;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            animation: fadeIn 2s ease-in-out;
        }

        h1 {
            color: #007acc;
            margin-bottom: 10px;
        }

        p {
            margin-bottom: 20px;
            font-size: 18px;
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

        .admin-login {
            position: absolute;
            top: 10px;
            right: 10px;
        }

        .admin-login a {
            text-decoration: none;
            font-size: 16px;
            color: white;
            background-color: #007acc;
            padding: 8px 16px;
            border-radius: 5px;
            transition: background-color 0.3s ease-in-out;
        }

        .admin-login a:hover {
            background-color: #005f99;
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
    <div class="admin-login">
        <a href="admin_login.php">Admin Login</a>
    </div>
    <div class="container">
        <h1>Welcome to Mental Health Tracker</h1>
        <p>Here you can keep track of your mental health.</p>
        <div class="links">
            <a href="user_signin.php">User Login</a>
            <a href="user_registration.php">User Registration</a>
        </div>
    </div>
</body>

</html>
