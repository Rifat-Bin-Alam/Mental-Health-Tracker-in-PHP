<?php
session_start();
include 'db.php'; // Database connection

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // If not logged in, redirect to sign-in page
    header("Location: user_signin.php");
    exit();
}

// Get user details from session
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];

// Query to fetch user details from the database
$sql = "SELECT * FROM users WHERE id = '$user_id'";
$result = mysqli_query($con, $sql);
$user = mysqli_fetch_assoc($result);

// Fetch mental health logs for the user
$log_sql = "SELECT * FROM mental_health_logs WHERE user_id = '$user_id' ORDER BY date DESC";
$log_result = mysqli_query($con, $log_sql);

// Fetch resources
$resources_sql = "SELECT * FROM resources";
$resources_result = mysqli_query($con, $resources_sql);

// Handle the log form submission for add or edit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $date = $_POST['date'];
    $mood = $_POST['mood'];
    $stress_level = $_POST['stress_level'];
    $sleep_hours = $_POST['sleep_hours'];
    $additional_notes = $_POST['additional_notes'];

    // Check if a log exists for the given date
    $check_log_sql = "SELECT * FROM mental_health_logs WHERE user_id = '$user_id' AND date = '$date'";
    $check_result = mysqli_query($con, $check_log_sql);

    if (mysqli_num_rows($check_result) > 0) {
        // Update the existing log
        $update_sql = "UPDATE mental_health_logs SET mood = '$mood', stress_level = '$stress_level', sleep_hours = '$sleep_hours', additional_notes = '$additional_notes' WHERE user_id = '$user_id' AND date = '$date'";
        mysqli_query($con, $update_sql);
    } else {
        // Insert a new log entry
        $insert_sql = "INSERT INTO mental_health_logs (user_id, date, mood, stress_level, sleep_hours, additional_notes) 
                       VALUES ('$user_id', '$date', '$mood', '$stress_level', '$sleep_hours', '$additional_notes')";
        mysqli_query($con, $insert_sql);
    }

    // Redirect back to the dashboard after submission
    header("Location: user_dashboard.php");
    exit();
}

// Handle log deletion
if (isset($_GET['delete_log_id'])) {
    $log_id = $_GET['delete_log_id'];
    $delete_sql = "DELETE FROM mental_health_logs WHERE id = '$log_id' AND user_id = '$user_id'";
    mysqli_query($con, $delete_sql);
    header("Location: user_dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <style>
        /* Blue theme */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff; /* Light blue background */
            margin: 0;
            padding: 0;
        }

        .container {
            width: 50%;
            margin: 50px auto;
            background-color: white;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            border: 1px solid #ddd;
        }

        h1 {
            text-align: center;
            color: #1e90ff; /* Blue color for header */
        }

        p {
            font-size: 18px;
            color: #555;
        }

        .actions a {
            display: inline-block;
            margin: 10px;
            text-decoration: none;
            color: white;
            background-color: #1e90ff; /* Blue button background */
            padding: 10px;
            border-radius: 4px;
        }

        .actions a:hover {
            background-color: #4682b4; /* Darker blue for hover */
        }

        form input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin: 20px 0;
            background-color: #1e90ff; /* Blue logout button */
            color: white;
            font-size: 18px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        form input[type="submit"]:hover {
            background-color: #4682b4; /* Darker blue for hover */
        }

        .log-container {
            margin-top: 20px;
        }

        .log-entry {
            background-color: #f9f9f9;
            padding: 15px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .log-entry button {
            background-color: #ff6347; /* Red button for delete */
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .log-entry button:hover {
            background-color: #e53e3e; /* Darker red for hover */
        }

        .log-entry a {
            color: #4682b4;
            text-decoration: none;
        }

        .log-entry a:hover {
            text-decoration: underline;
        }

        .resources-container {
            margin-top: 20px;
        }

        .resource-entry {
            background-color: #f9f9f9;
            padding: 15px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .resource-entry a {
            color: #1e90ff;
            text-decoration: none;
        }

        .resource-entry a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome, <?php echo $user_name; ?>!</h1>

        <p><strong>Name:</strong> <?php echo $user_name; ?></p>
        <p><strong>Gender:</strong> <?php echo $user['gender']; ?></p>
        <p><strong>Age:</strong> <?php echo $user['age']; ?></p>

        <div class="actions">
            <a href="mental_health_log.php">Add and Keep Track of Mental Health Logs</a>
        </div>

        <form action="logout.php" method="POST">
            <input type="submit" value="Logout">
        </form>

        <div class="log-container">
            <h2>Your Mental Health Logs</h2>
            <?php
            if (mysqli_num_rows($log_result) > 0) {
                while ($log = mysqli_fetch_assoc($log_result)) {
                    echo "<div class='log-entry'>
                            <p><strong>Date:</strong> " . $log['date'] . "</p>
                            <p><strong>Mood:</strong> " . $log['mood'] . "</p>
                            <p><strong>Stress Level:</strong> " . $log['stress_level'] . "</p>
                            <p><strong>Sleep Hours:</strong> " . $log['sleep_hours'] . "</p>
                            <p><strong>Additional Notes:</strong> " . $log['additional_notes'] . "</p>

                            <a href='edit_log.php?log_id=" . $log['id'] . "'>Edit</a> |
                            <a href='?delete_log_id=" . $log['id'] . "' onclick='return confirm(\"Are you sure?\");'>Delete</a>
                          </div>";
                }
            } else {
                echo "<p>No logs found.</p>";
            }
            ?>
        </div>

        <div class="resources-container">
            <h2>Available Resources</h2>
            <?php
            if (mysqli_num_rows($resources_result) > 0) {
                while ($resource = mysqli_fetch_assoc($resources_result)) {
                    echo "<div class='resource-entry'>
                            <p><strong>Title:</strong> " . $resource['title'] . "</p>
                            <p><strong>Category:</strong> " . $resource['category'] . "</p>
                            <a href='" . $resource['link'] . "' target='_blank'>View Resource</a>
                          </div>";
                }
            } else {
                echo "<p>No resources available.</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>
