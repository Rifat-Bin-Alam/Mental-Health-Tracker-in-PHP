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

// Check if log_id is passed in the URL
if (isset($_GET['log_id'])) {
    $log_id = $_GET['log_id'];

    // Fetch the log details from the database
    $sql = "SELECT * FROM mental_health_logs WHERE id = '$log_id' AND user_id = '$user_id'";
    $result = mysqli_query($con, $sql);
    $log = mysqli_fetch_assoc($result);

    // If log doesn't exist, redirect back to the dashboard
    if (!$log) {
        header("Location: user_dashboard.php");
        exit();
    }
}

// Handle the form submission for editing the log
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $date = $_POST['date'];
    $mood = $_POST['mood'];
    $stress_level = $_POST['stress_level'];
    $sleep_hours = $_POST['sleep_hours'];
    $additional_notes = $_POST['additional_notes'];

    // Update the log in the database
    $update_sql = "UPDATE mental_health_logs SET date = '$date', mood = '$mood', stress_level = '$stress_level', sleep_hours = '$sleep_hours', additional_notes = '$additional_notes' WHERE id = '$log_id' AND user_id = '$user_id'";
    mysqli_query($con, $update_sql);

    // Redirect back to the dashboard after updating
    header("Location: user_dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Log Entry</title>
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
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Log Entry</h1>

        <form action="edit_log.php?log_id=<?php echo $log['id']; ?>" method="POST">
            <label for="date">Date:</label>
            <input type="date" name="date" value="<?php echo $log['date']; ?>" required><br><br>
            <label for="mood">Mood:</label>
            <input type="text" name="mood" value="<?php echo $log['mood']; ?>" required><br><br>
            <label for="stress_level">Stress Level:</label>
            <input type="text" name="stress_level" value="<?php echo $log['stress_level']; ?>" required><br><br>
            <label for="sleep_hours">Sleep Hours:</label>
            <input type="number" name="sleep_hours" value="<?php echo $log['sleep_hours']; ?>" required><br><br>
            <label for="additional_notes">Additional Notes:</label><br>
            <textarea name="additional_notes" rows="4" cols="50"><?php echo $log['additional_notes']; ?></textarea><br><br>
            <input type="submit" value="Update Log">
        </form>
    </div>
</body>
</html>
