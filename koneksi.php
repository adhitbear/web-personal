<?php
$servername = "localhost";
$username = "root";
$password = ""; // password kosong di XAMPP
$dbname = "project"; // <- ganti sesuai nama database kamu

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
