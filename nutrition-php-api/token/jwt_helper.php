<?php
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

require_once '../vendor/autoload.php';

$jwt_secret = "SECRET_KEY_KAMU"; // Ganti dengan secret kuat

function generate_jwt($payload) {
    global $jwt_secret;
    return JWT::encode($payload, $jwt_secret, 'HS256');
}

function validate_jwt($token) {
    global $jwt_secret;
    try {
        $decoded = JWT::decode($token, new Key($jwt_secret, 'HS256'));
        return (array) $decoded;
    } catch (Exception $e) {
        return false;
    }
}
