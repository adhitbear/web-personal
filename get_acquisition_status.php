<?php
include 'koneksi.php';
$servername = "localhost";
$username = "root";
$password = "";
$database = "project";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed"]));
}

$sql = "SELECT id, is_acquisition FROM places";
$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[$row['id']] = (bool)$row['is_acquisition'];
}

header('Content-Type: application/json');
echo json_encode($data);
$conn->close();
?>