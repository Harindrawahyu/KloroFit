<?php
require_once '../../koneksi.php';
// require_once '../../token/auth.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    http_response_code(405);
    echo json_encode(["error" => "Only DELETE method allowed"]);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);
$user_id = getUserIdFromToken();
$tracking_id = $data['id'] ?? null;

$stmt = $conn->prepare("DELETE FROM food_tracking WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $tracking_id, $user_id);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Food tracking deleted"]);
} else {
    http_response_code(500);
    echo json_encode(["error" => "Failed to delete tracking"]);
}
$stmt->close();
$conn->close();
?>
