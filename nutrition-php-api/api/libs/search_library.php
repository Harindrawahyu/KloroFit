<!-- Untuk mencari data makanan berdasarakan makanan -->
<?php
// search_library.php
require_once __DIR__ . '/../../koneksi.php';

header("Content-Type: application/json");

// Cek apakah parameter q tersedia
if (!isset($_GET['q']) || trim($_GET['q']) === '') {
    http_response_code(400);
    echo json_encode(["error" => "Parameter 'q' is required"]);
    exit();
}

$query = trim($_GET['q']);

// Query pencarian makanan dari tabel nutrition_library
$sql = "SELECT id, name, calories FROM nutrition_library WHERE name LIKE ? LIMIT 50";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    http_response_code(500);
    echo json_encode(["error" => "Failed to prepare statement"]);
    exit();
}

$searchTerm = "%$query%";
$stmt->bind_param("s", $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

$foods = [];
while ($row = $result->fetch_assoc()) {
    $foods[] = $row;
}

$stmt->close();
$conn->close();

echo json_encode($foods);
