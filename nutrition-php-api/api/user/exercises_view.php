<!-- Menampilkan data aktivitas olahraga -->
<?php
require_once __DIR__ . '/../../koneksi.php';
// require_once __DIR__ . '/../../token/auth.php'; // Pastikan ini ada untuk memanggil fungsi auth
header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $user_id = $_GET['user_id'];
    $result = $conn->query("SELECT * FROM exercises WHERE user_id = $user_id");
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);
}

if ($method === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $sql = "INSERT INTO exercises (name, duration, calories_burned, user_id)
            VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siii", $data['name'], $data['duration'],
                      $data['calories_burned'], $data['user_id']);
    $stmt->execute();
    echo json_encode(["message" => "Aktivitas ditambahkan"]);
}
