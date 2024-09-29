<?php
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"Sensor Data.xls\"");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "algae_monitoring_database";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM sensor_data";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output header
    $fields = $result->fetch_fields();
    foreach ($fields as $field) {
        echo $field->name . "\t";
    }
    echo "\n";

    // Output data
    while ($row = $result->fetch_assoc()) {
        echo implode("\t", $row) . "\n";
    }
} else {
    echo "No results found.";
}

$conn->close();
?>
