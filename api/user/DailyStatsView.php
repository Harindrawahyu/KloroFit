<!-- untuk menampilkan data statistik harian -->
<?php
require_once __DIR__ . '/../../koneksi.php';
// pastikan file ini memverifikasi token JWT

header("Content-Type: application/json");

// Verifikasi JWT
$headers = apache_request_headers();
if (!isset($headers['Authorization'])) {
    echo json_encode(["error" => "Authorization header missing"]);
    exit;
}

$token = str_replace("Bearer ", "", $headers['Authorization']);
$user = verifyJWT($token); // function dari jwt_handler.php

if (!$user) {
    echo json_encode(["error" => "Invalid token"]);
    exit;
}

$user_id = $user->id; 
$tanggal = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');

$query = "SELECT 
            SUM(calories) AS total_calories,
            SUM(protein) AS total_protein,
            SUM(fat) AS total_fat,
            SUM(carbs) AS total_carbs
          FROM food_tracking
          WHERE user_id = ? AND consumed_at = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("is", $user_id, $tanggal);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

echo json_encode([
    "date" => $tanggal,
    "stats" => $data
]);
?>
