<?php
include 'koneksi.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(200);
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$database = "project";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Database connection failed"]));
}

$data = json_decode(file_get_contents("php://input"), true);
if (!$data || !is_array($data)) {
    echo json_encode(["status" => "error", "message" => "Invalid JSON data"]);
    exit();
}

foreach ($data as $place) {
    if (!isset($place['id'], $place['name'], $place['address'], $place['latitude'], $place['longitude'], $place['category'])) {
        continue;
    }

    $id = $conn->real_escape_string($place['id']);
    $name = $conn->real_escape_string($place['name']);
    $address = $conn->real_escape_string($place['address']);
    $latitude = is_numeric($place['latitude']) ? $place['latitude'] : "NULL";
    $longitude = is_numeric($place['longitude']) ? $place['longitude'] : "NULL";
    $category = $conn->real_escape_string($place['category']);

    $check_sql = "SELECT id FROM places WHERE name='$name' AND address='$address'";
    $result = $conn->query($check_sql);

    if ($result->num_rows == 0) {
        $sql = "INSERT INTO places (id, name, address, latitude, longitude, category) 
                VALUES ('$id', '$name', '$address', $latitude, $longitude, '$category')";
        if (!$conn->query($sql)) {
            echo json_encode(["status" => "error", "message" => "Database insert failed"]);
            exit();
        }
    }
}

$conn->close();
echo json_encode(["status" => "success", "message" => "Data saved"]);
?>