<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "algae_monitoring_database";

$mysqli = new mysqli($servername, $username, $password, $dbname);

if ($mysqli->connect_error) {
    http_response_code(500);  // Internal Server Error
    echo json_encode(["error" => "Connection failed: " . $mysqli->connect_error]);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        // Retrieve data
        $sql = "SELECT Brightness, Temperature, TDS, pH, Time FROM sensor_data";
        $result = $mysqli->query($sql);

        $data = [];
        if ($result) {
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
            }
            echo json_encode($data);
        } else {
            http_response_code(500);  // Internal Server Error
            echo json_encode(["error" => "SQL query failed"]);
        }
        break;

    default:
        // Unsupported request method
        http_response_code(405);  // Method Not Allowed
        echo json_encode(["error" => "Invalid request method"]);
        break;
}

// Close the database connection
$mysqli->close();
?>
