<!-- Login User -->
<?php
require_once __DIR__ . '/../../koneksi.php';
require_once __DIR__ . '/../../token/jwt_helper.php';
require_once __DIR__ . '/../../token/auth.php'; // Pastikan ini ada untuk memanggil fungsi auth

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['email'], $data['password'])) {
    $email = $data['email'];
    $password = $data['password'];

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            $payload = [
                "user_id" => $row['id'],
                "email" => $email,
                "exp" => time() + (60 * 60 * 24) // token berlaku 1 hari
            ];
            $token = generate_jwt($payload);
            echo json_encode(["token" => $token]);
        } else {
            echo json_encode(["error" => "Invalid password"]);
        }
    } else {
        echo json_encode(["error" => "User not found"]);
    }
} else {
    echo json_encode(["error" => "Missing email or password"]);
}
?>