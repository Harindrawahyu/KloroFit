<?php
require '../vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

/**
 * Fungsi untuk memverifikasi token JWT
 * Mengembalikan object payload token jika valid
 */
function verifyJWT() {
    $headers = getallheaders();

    if (!isset($headers['Authorization'])) {
        http_response_code(401);
        echo json_encode([
            'status' => false,
            'message' => 'Authorization header missing'
        ]);
        exit;
    }

    $authHeader = $headers['Authorization'];
    $token = str_replace('Bearer ', '', $authHeader);

    try {
        $decoded = JWT::decode($token, new Key('your_secret_key', 'HS256'));
        return $decoded;
    } catch (Exception $e) {
        http_response_code(401);
        echo json_encode([
            'status' => false,
            'message' => 'Invalid or expired token',
            'error' => $e->getMessage()
        ]);
        exit;
    }
}

/**
 * Mengambil user ID dari token JWT
 */
function getUserIdFromToken() {
    $decoded = verifyJWT();
    return $decoded->user_id ?? null;
}
?>
