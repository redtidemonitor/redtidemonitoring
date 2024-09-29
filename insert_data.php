<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "algae_monitoring_database";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get data from GET request
$temperature = $_GET['temperature'];
$TDS = $_GET['tdsvalue'];
$brightness = $_GET['brightness'];
$ph = $_GET['pH'];
$sendtime = $_GET['time'];

// Insert data into database
$sql = "INSERT INTO sensor_data (Temperature, TDS, Brightness, pH, Time) VALUES ('$temperature', '$TDS', '$brightness', '$ph', '$sendtime')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
