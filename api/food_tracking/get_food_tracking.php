<?php
// get_food_tracking.php
require_once '../../config/koneksi.php';
// require_once '../../token/auth.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(["error" => "Only GET method is allowed"]);
    exit();
}

$user_id = getUserIdFromToken();

$sql = "SELECT ft.id, ft.date, ft.quantity, nl.food_name, nl.calories
        FROM food_tracking ft
        JOIN nutrition_library nl ON ft.food_id = nl.id
        WHERE ft.user_id = ?
        ORDER BY ft.date DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

$stmt->close();
$conn->close();

echo json_encode($data);
