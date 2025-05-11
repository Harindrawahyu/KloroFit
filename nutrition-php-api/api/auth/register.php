<!-- Register User -->
<?php
require_once __DIR__ . '/../../koneksi.php';

header('Content-Type: application/json');
// require_once '/token/jwt_helper.php';
// require_once '/token/auth.php'; // Pastikan ini ada untuk memanggil fungsi auth

$data = json_decode(file_get_contents("php://input"), true);

// Validasi input
if (!isset($data['name'], $data['email'], $data['password'])) {
    echo json_encode(["error" => "Data tidak lengkap"]);
    exit;
}

$name = $data['name'];
$email = $data['email'];
$password = password_hash($data['password'], PASSWORD_DEFAULT);

$sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $name, $email, $password);

if ($stmt->execute()) {
    echo json_encode(["message" => "Registrasi berhasil"]);
} else {
    echo json_encode(["error" => "Gagal registrasi: " . $conn->error]);
}
