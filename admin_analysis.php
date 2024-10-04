<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.html");
    exit();
}

$stakeholder = $_GET['stakeholder'];
$location = $_GET['location'];

$host = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbname = "feedback_db"; // Update with actual database name

$conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch feedback for the selected stakeholder and location
$query = "SELECT question1, question2, question3, question4, question5, question6, question7, question8, question9, question10 FROM feedback WHERE stakeholder = ? AND location = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $stakeholder, $location);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
$suggestions = [];

while ($row = $result->fetch_assoc()) {
    for ($i = 1; $i <= 9; $i++) {
        $data[$i][] = $row["question$i"];
    }
    $suggestions[] = $row['question10'];
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Analysis</title>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawCharts);

        function drawCharts() {
            <?php for ($i = 1; $i <= 9; $i++): ?>
                var data<?php echo $i; ?> = google.visualization.arrayToDataTable([
                    ['Response', 'Count'],
                    <?php
                        if (!empty($data[$i])) {
                            $counts = array_count_values($data[$i]);
                            foreach ($counts as $response => $count) {
                                echo "['$response', $count],";
                            }
                        }
                    ?>
                ]);

                var options<?php echo $i; ?> = {
                    title: 'Question <?php echo $i; ?>',
                    is3D: true,
                    pieSliceText: 'value',
                };

                var chart<?php echo $i; ?> = new google.visualization.PieChart(document.getElementById('chart<?php echo $i; ?>'));
                chart<?php echo $i; ?>.draw(data<?php echo $i; ?>, options<?php echo $i; ?>);
            <?php endfor; ?>
        }
    </script>
    <style>
        .chart-container {
            display: flex;
            flex-wrap: wrap;
        }
        .chart {
            width: 48%;
            height: 400px;
            margin: 1%;
        }
    </style>
</head>
<body>
    <h2>Feedback Analysis for <?php echo $stakeholder; ?> at <?php echo $location; ?></h2>

    <div class="chart-container">
        <?php for ($i = 1; $i <= 9; $i++): ?>
            <div id="chart<?php echo $i; ?>" class="chart"></div>
        <?php endfor; ?>
    </div>

    <h3>Suggestions (Question 10)</h3>
    <ul>
        <?php foreach ($suggestions as $suggestion): ?>
            <li><?php echo htmlspecialchars($suggestion); ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
