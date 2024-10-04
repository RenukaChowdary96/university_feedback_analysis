<?php
session_start();

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "feedback_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$stakeholder = $_POST['stakeholder'];
$academic_year = $_POST['academic_year'];
$education_level = $_POST['education_level'];
$course_type = $_POST['course_type'];
$specialization = $_POST['specialization'];
$location = $_POST['location'];

// Generate a unique token
$token = bin2hex(random_bytes(16)); // Generate a random 32-character hexadecimal token

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO feedback (token, stakeholder, academic_year, education_level, course_type, specialization, location) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssss", $token, $stakeholder, $academic_year, $education_level, $course_type, $specialization, $location);

if ($stmt->execute()) {
    // Store token and location in session
    $_SESSION['token'] = $token;
    $_SESSION['location'] = $location; // Store location for later use

    // Redirect to appropriate feedback form based on location
    $feedbackForms = [
        'Library' => 'feedback_library.html',
        'Boys Hostel' => 'feedback_boys_hostel.html',
        'Girls Hostel' => 'feedback_girls_hostel.html',
        'Playground' => 'feedback_playground.html',
        'Parking Area' => 'feedback_parking_area.html',
        'Guest House' => 'feedback_guesthouse.html',
        'Medical Facility' => 'feedback_medical_facility.html',
        'Bank' => 'feedback_bank.html',
        'Administration Block' => 'feedback_administration_block.html',
        'Placement Cell' => 'feedback_placement_cell.html'
    ];

    if (array_key_exists($location, $feedbackForms)) {
        header("Location: " . $feedbackForms[$location]);
        exit();
    } else {
        echo "Invalid location.";
    }
} else {
    echo "Error: " . $stmt->error;
}

// Close connection
$stmt->close();
$conn->close();
?>
