<?php
require_once '../../config/koneksi.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
    http_response_code(405);
    echo json_encode(["error" => "Only PUT method allowed"]);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);
$user_id = getUserIdFromToken();
$tracking_id = $data['id'] ?? null;
$food_id = $data['food_id'] ?? null;
$date = $data['date'] ?? date('Y-m-d');
$quantity = $data['quantity'] ?? 1;

// Validasi: apakah food_id tersedia di nutrition_library
$check_food = $conn->prepare("SELECT id FROM nutrition_library WHERE id = ?");
$check_food->bind_param("i", $food_id);
$check_food->execute();
$check_food->store_result();

if ($check_food->num_rows === 0) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid food_id"]);
    exit();
}
$check_food->close();

// Update data food_tracking
$stmt = $conn->prepare("UPDATE food_tracking SET food_id = ?, date = ?, quantity = ? WHERE id = ? AND user_id = ?");
$stmt->bind_param("isiii", $food_id, $date, $quantity, $tracking_id, $user_id);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Food tracking updated"]);
} else {
    http_response_code(500);
    echo json_encode(["error" => "Failed to update tracking"]);
}
$stmt->close();
$conn->close();
?>
