<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "feedback_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve feedback form data from POST
$token = $_POST['token'];
$location = $_POST['location'];
$question1 = $_POST['question1'];
$question2 = $_POST['question2'];
$question3 = $_POST['question3'];
$question4 = $_POST['question4'];
$question5 = $_POST['question5'];
$question6 = $_POST['question6'];
$question7 = $_POST['question7'];
$question8 = $_POST['question8'];
$question9 = $_POST['question9'];
$question10 = $_POST['question10'];

// Prepare and bind the SQL statement for inserting data into the feedback table
$stmt = $conn->prepare("INSERT INTO feedback (token, location, question1, question2, question3, question4, question5, question6, question7, question8, question9, question10) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssssssss", $token, $location, $question1, $question2, $question3, $question4, $question5, $question6, $question7, $question8, $question9, $question10);

// Execute the statement and check if data is successfully inserted
if ($stmt->execute()) {
    // Redirect to thank you page with location parameter
    header("Location: thanks.html?location=" . urlencode($location));
    exit();
} else {
    // Output error message in case of failure
    echo "Error: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
