<?php
session_start();
include 'db.php'; // Database connection

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: user_signin.php");
    exit();
}

// Get user data from session
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];

// Handle the form submission for adding or updating a log
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $date = $_POST['date'];
    $mood = $_POST['mood'];
    $stress_level = $_POST['stress_level'];
    $sleep_hours = $_POST['sleep_hours'];
    $additional_notes = $_POST['additional_notes'];

    // Insert data into mental_health_logs table
    $sql = "INSERT INTO mental_health_logs (user_id, date, mood, stress_level, sleep_hours, additional_notes)
            VALUES ('$user_id', '$date', '$mood', '$stress_level', '$sleep_hours', '$additional_notes')";

    if (mysqli_query($con, $sql)) {
        $success_message = "Mental health log added successfully!";
    } else {
        $error_message = "Error occurred while adding the log. Please try again.";
    }
}

// Retrieve existing logs from the database
$sql = "SELECT * FROM mental_health_logs WHERE user_id = '$user_id' ORDER BY date DESC";
$result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mental Health Log</title>
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
        .form-group {
            margin-bottom: 15px;
        }
        label {
            font-weight: bold;
            color: #007acc;
        }
        input[type="text"], input[type="date"], input[type="number"], textarea, select {
            width: 90%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        textarea {
            resize: vertical;
        }
        .submit-btn {
            background-color: #007acc;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .submit-btn:hover {
            background-color: #005f99;
        }
        .log-entry {
            background-color: #e9f4ff;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
        }
        .log-entry span {
            display: block;
            margin: 5px 0;
        }
        .error, .success {
            color: red;
            font-weight: bold;
            text-align: center;
        }
        .success {
            color: green;
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
    <h1>Mental Health Log</h1>

    <?php
    if (isset($error_message)) {
        echo "<p class='error'>$error_message</p>";
    }
    if (isset($success_message)) {
        echo "<p class='success'>$success_message</p>";
    }
    ?>

    <form method="POST" action="mental_health_log.php">
        <div class="form-group">
            <label for="date">Date</label>
            <input type="date" id="date" name="date" required>
        </div>

        <div class="form-group">
            <label for="mood">Mood</label>
            <select id="mood" name="mood" required>
                <option value="Happy">Happy</option>
                <option value="Neutral">Neutral</option>
                <option value="Sad">Sad</option>
            </select>
        </div>

        <div class="form-group">
            <label for="stress_level">Stress Level</label>
            <select id="stress_level" name="stress_level" required>
                <option value="Low">Low</option>
                <option value="Medium">Medium</option>
                <option value="High">High</option>
            </select>
        </div>

        <div class="form-group">
            <label for="sleep_hours">Sleep Hours</label>
            <input type="number" id="sleep_hours" name="sleep_hours" min="0" max="24" required>
        </div>

        <div class="form-group">
            <label for="additional_notes">Additional Notes</label>
            <textarea id="additional_notes" name="additional_notes"></textarea>
        </div>

        <div class="form-group">
            <input type="submit" class="submit-btn" value="Add Log">
        </div>
    </form>

    <h2>Your Previous Logs</h2>

    <?php while ($log = mysqli_fetch_assoc($result)): ?>
        <div class="log-entry">
            <span><strong>Date:</strong> <?php echo $log['date']; ?></span>
            <span><strong>Mood:</strong> <?php echo $log['mood']; ?></span>
            <span><strong>Stress Level:</strong> <?php echo $log['stress_level']; ?></span>
            <span><strong>Sleep Hours:</strong> <?php echo $log['sleep_hours']; ?></span>
            <span><strong>Additional Notes:</strong> <?php echo $log['additional_notes']; ?></span>
        </div>
    <?php endwhile; ?>

    <div class="back-home">
        <p><a href="user_dashboard.php">Back to Dashboard</a></p>
    </div>
</div>

</body>
</html>
