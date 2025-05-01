<?php
include 'koneksi.php';
$servername = "localhost";
$username = "root";
$password = "";
$database = "project";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Connection failed"]));
}

$data = json_decode(file_get_contents("php://input"), true);
$place_id = $data["place_id"];
$is_acquisition = $data["is_acquisition"];

$sql = "UPDATE places SET is_acquisition = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $is_acquisition, $place_id);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Failed to update"]);
}

$stmt->close();
$conn->close();
?>