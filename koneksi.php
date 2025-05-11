<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "db_nutrition_app";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die(json_encode(["error" => "Koneksi gagal: " . $conn->connect_error]));
}
?>
