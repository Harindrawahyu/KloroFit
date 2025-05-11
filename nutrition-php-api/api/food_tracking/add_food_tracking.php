<?php
require_once '../../koneksi.php';
// require_once '../../token/auth.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["error" => "Only POST method allowed"]);
    exit();
}

// Ambil data JSON dari body
$data = json_decode(file_get_contents('php://input'), true);
$user_id = getUserIdFromToken();

$food_id = $data['food_id'] ?? null;
$date = $data['date'] ?? date('Y-m-d');
$quantity = $data['quantity'] ?? 1;

// Validasi: Cek apakah food_id valid di nutrition_library
$check_stmt = $conn->prepare("SELECT id FROM nutrition_library WHERE id = ?");
$check_stmt->bind_param("i", $food_id);
$check_stmt->execute();
$check_stmt->store_result();

if ($check_stmt->num_rows === 0) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid food_id, not found in nutrition_library"]);
    exit();
}
$check_stmt->close();

// Simpan ke tabel food_tracking
$stmt = $conn->prepare("INSERT INTO food_tracking (user_id, food_id, date, quantity) VALUES (?, ?, ?, ?)");
$stmt->bind_param("iisi", $user_id, $food_id, $date, $quantity);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Food tracking added"]);
} else {
    http_response_code(500);
    echo json_encode(["error" => "Failed to add tracking"]);
}

$stmt->close();
$conn->close();
?>
