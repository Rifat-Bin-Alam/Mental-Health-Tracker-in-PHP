<?php
session_start();
include 'db.php'; // Database connection

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch admin name from session
$admin_name = $_SESSION['admin_name'];

// Handle resource addition
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_resource'])) {
    $title = $_POST['title'];
    $category = $_POST['category'];
    $link = $_POST['link'];

    $sql = "INSERT INTO resources (title, category, link) VALUES ('$title', '$category', '$link')";
    mysqli_query($con, $sql);
}

// Handle resource deletion
if (isset($_GET['delete_resource'])) {
    $resource_id = $_GET['delete_resource'];
    $sql = "DELETE FROM resources WHERE id = $resource_id";
    mysqli_query($con, $sql);
}

// Fetch resources
$resources = mysqli_query($con, "SELECT * FROM resources");

// Search users
$user_search_results = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search_user'])) {
    $search_query = $_POST['search_query'];
    $user_search_results = mysqli_query($con, "SELECT * FROM users WHERE name LIKE '%$search_query%' OR email LIKE '%$search_query%'");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #007acc;
            text-align: center;
        }
        .section {
            margin-bottom: 20px;
        }
        .section h2 {
            color: #007acc;
            border-bottom: 2px solid #007acc;
            padding-bottom: 5px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            font-weight: bold;
            color: #007acc;
        }
        input[type="text"], input[type="url"], select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #007acc;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #005f99;
        }
        .resource-item, .user-item {
            padding: 10px;
            border: 1px solid #ddd;
            margin-bottom: 10px;
            border-radius: 5px;
        }
        .resource-item button, .user-item button {
            float: right;
            background-color: red;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        .resource-item button:hover, .user-item button:hover {
            background-color: darkred;
        }
        .logout-button {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Welcome, <?= $admin_name ?></h1>

    <!-- Search Users -->
    <div class="section">
        <h2>Search Users</h2>
        <form method="POST">
            <div class="form-group">
                <label for="search_query">Search by Name or Email:</label>
                <input type="text" id="search_query" name="search_query" placeholder="Enter name or email">
            </div>
            <button type="submit" name="search_user">Search</button>
        </form>
        <?php if (!empty($user_search_results)) : ?>
            <h3>Search Results:</h3>
            <?php while ($user = mysqli_fetch_assoc($user_search_results)) : ?>
                <div class="user-item">
                    <strong><?= $user['name'] ?></strong> (<?= $user['email'] ?>)
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>

    <!-- Manage Resources -->
    <div class="section">
        <h2>Manage Resources</h2>
        <form method="POST">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="category">Category:</label>
                <select id="category" name="category" required>
                    <option value="picture">Picture</option>
                    <option value="video">Video</option>
                    <option value="url">URL</option>
                </select>
            </div>
            <div class="form-group">
                <label for="link">Link:</label>
                <input type="url" id="link" name="link" required>
            </div>
            <button type="submit" name="add_resource">Add Resource</button>
        </form>

        <h3>Existing Resources:</h3>
        <?php while ($resource = mysqli_fetch_assoc($resources)) : ?>
            <div class="resource-item">
                <strong><?= $resource['title'] ?> (<?= $resource['category'] ?>)</strong>
                <a href="admin_dashboard.php?delete_resource=<?= $resource['id'] ?>" onclick="return confirm('Are you sure?');">
                    <button>Delete</button>
                </a>
            </div>
        <?php endwhile; ?>
    </div>

    <!-- Logout Button -->
    <div class="logout-button">
        <a href="logout.php"><button>Logout</button></a>
    </div>
</div>

</body>
</html>
