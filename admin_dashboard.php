<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.html");
    exit();
}

// Database connection
$host = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbname = "feedback_db"; // Update with your actual database name

$conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f4f4f4;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
            width: 300px;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        label {
            margin-bottom: 10px;
            font-size: 14px;
            color: #666;
        }

        select, button {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 16px;
            width: 100%;
        }

        button {
            background-color: #3498db;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #2980b9;
        }

        select:focus, button:focus {
            outline: none;
            border-color: #3498db;
        }
    </style>
</head>
<body>
    <h2>Welcome to the Admin Dashboard, <?php echo $_SESSION['admin']; ?>!</h2>

    <form action="admin_analysis.php" method="GET">
        <!-- Stakeholder Dropdown -->
        <label for="stakeholder">Type of Stakeholder:</label>
        <select id="stakeholder" name="stakeholder" required>
            <option value="Student">Student</option>
            <option value="Faculty">Faculty</option>
        </select>
        
        <!-- Location Dropdown -->
        <label for="location">Location:</label>
        <select id="location" name="location" required>
            <option value="Library">Library</option>
            <option value="Parking">Parking</option>
            <option value="Girls Hostel">Girls Hostel</option>
            <option value="Boys Hostel">Boys Hostel</option>
            <option value="Medicalfacility">Medicalfacility</option>
            <option value="ECELL">Ecell</option>
            <option value="GUESTHOUSE">Guesthouse</option>
            <option value="GROUND">Ground</option>
            <option value="BANK">Bank</option>
            <option value="ABLOCK">ABlock</option>
            <option value="IT">IT</option>
        </select>

        <button type="submit">Analyze Feedback</button>
    </form>
</body>
</html>
