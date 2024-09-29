<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "algae_monitoring_database";  

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    http_response_code(500);  // Internal Server Error
    echo json_encode(["error" => "Connection failed: " . $conn->connect_error]);
    exit;
}

header('Content-Type: application/json');

$sql = "SELECT Brightness as brightness, Temperature as temperature, TDS as tds, pH as pH, Time as time FROM sensor_data";
$result = $conn->query($sql);

$data = array();
if ($result) {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Convert numeric fields explicitly to ensure they are numbers
            $row['time'] = (float)$row['time'];
            $row['brightness'] = (float)$row['brightness'];
            $row['temperature'] = (float)$row['temperature'];
            $row['tds'] = (float)$row['tds'];
            $row['pH'] = (float)$row['pH'];
            
            $data[] = $row;
        }
    }
    echo json_encode($data);
} else {
    http_response_code(500);  
    echo json_encode(["error" => "SQL query failed"]);
}

$conn->close();
?>
