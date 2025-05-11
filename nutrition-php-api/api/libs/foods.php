<!-- Menampilkan data makanan -->
<?php
header('Content-Type: application/json');
include '../koneksi.php';
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $user_id = $_GET['user_id'];
    $result = $conn->query("SELECT * FROM foods WHERE user_id = $user_id");
    $foods = [];
    while ($row = $result->fetch_assoc()) {
        $foods[] = $row;
    }
    echo json_encode($foods);
}

if ($method === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $sql = "INSERT INTO foods (name, calories, fat, protein, carbs, user_id)
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siiiii", $data['name'], $data['calories'], $data['fat'],
                      $data['protein'], $data['carbs'], $data['user_id']);
    $stmt->execute();
    echo json_encode(["message" => "Makanan ditambahkan"]);
}
