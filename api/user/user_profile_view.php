<!-- untuk menampilkan semua data user -->
<?php
// File: api/profile.php
require_once __DIR__ . '/../../koneksi.php';
require_once '../vendor/autoload.php'; // pastikan composer terinstall dan autoload ada
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

// Header agar format JSON dan CORS
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Ambil token dari header Authorization
$headers = apache_request_headers();
$authHeader = isset($headers['Authorization']) ? $headers['Authorization'] : '';

if (!$authHeader || !preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
    http_response_code(401);
    echo json_encode(["error" => "Unauthorized. Token not found."]);
    exit;
}

$jwt = $matches[1];
$secret_key = "your_secret_key"; // samakan dengan secret saat generate token

try {
    $decoded = JWT::decode($jwt, new Key($secret_key, 'HS256'));
    $user_id = $decoded->data->id;

    // Ambil data user dari DB
    $query = "SELECT id, name, email, created_at FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        echo json_encode([
            "status" => "success",
            "user" => $user
        ]);
    } else {
        http_response_code(404);
        echo json_encode(["error" => "User not found"]);
    }
} catch (Exception $e) {
    http_response_code(401);
    echo json_encode(["error" => "Access denied", "message" => $e->getMessage()]);
}
?>
