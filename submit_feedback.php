<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "feedback_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve token from session
$token = $_SESSION['token'];

// Retrieve feedback form data and echo for each question
$question1 = $_POST['question1'];
echo "Question 1: " . $question1 . "<br>";

$question2 = $_POST['question2'];
echo "Question 2: " . $question2 . "<br>";

$question3 = $_POST['question3'];
echo "Question 3: " . $question3 . "<br>";

$question4 = $_POST['question4'];
echo "Question 4: " . $question4 . "<br>";

$question5 = $_POST['question5'];
echo "Question 5: " . $question5 . "<br>";

$question6 = $_POST['question6'];
echo "Question 6: " . $question6 . "<br>";

$question7 = $_POST['question7'];
echo "Question 7: " . $question7 . "<br>";

$question8 = $_POST['question8'];
echo "Question 8: " . $question8 . "<br>";

$question9 = $_POST['question9'];
echo "Question 9: " . $question9 . "<br>";

$question10 = $_POST['question10'];
echo "Question 10: " . $question10 . "<br>";

// Retrieve location from session (assuming location is stored in session)
$location = $_SESSION['location']; // Ensure you are storing location in session when the user selects it
echo "Location: " . $location . "<br>";

// Prepare and bind
$stmt = $conn->prepare("UPDATE feedback SET question1 = ?, question2 = ?, question3 = ?, question4 = ?, question5 = ?, question6 = ?, question7 = ?, question8 = ?, question9 = ?, question10 = ? WHERE token = ?");
$stmt->bind_param("sssssssssss", $question1, $question2, $question3, $question4, $question5, $question6, $question7, $question8, $question9, $question10, $token);

// Execute the statement
if ($stmt->execute()) {
    // Redirect to piechart.php with location parameter
    header("Location: thanks.html?location=" . urlencode($location));
    exit();
} else {
    echo "Error: " . $stmt->error;
}

// Close connection
$stmt->close();
$conn->close();
?>
