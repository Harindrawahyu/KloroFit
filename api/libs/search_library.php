<?php
// Koneksi ke database
require_once __DIR__ . '/../../koneksi.php';

// Jika request GET, untuk pencarian makanan
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET['q'])) {
        echo json_encode(['message' => 'Keyword not provided']);
        exit();
    }

    // Keyword pencarian
    $keyword = "%" . $_GET['q'] . "%";

    try {
        // Query pencarian
        $query = "SELECT * FROM nutrition_library WHERE name LIKE :keyword";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':keyword', $keyword, PDO::PARAM_STR);
        $stmt->execute();
        
        // Mendapatkan hasil pencarian
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Cek jika ada hasil
        if (count($results) > 0) {
            echo json_encode([
                'status' => 'success',
                'data' => $results
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'No food found'
            ]);
        }
    } catch (Exception $e) {
        echo json_encode([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
    }
}

// Jika request POST, untuk menambahkan makanan ke tracking pengguna
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mendapatkan data dari body request
    $data = json_decode(file_get_contents("php://input"), true);

    // Validasi data
    if (!isset($data['user_id']) || !isset($data['food_id']) || !isset($data['quantity'])) {
        echo json_encode(['message' => 'Missing required fields']);
        exit();
    }

    $user_id = $data['user_id'];
    $food_id = $data['food_id'];
    $quantity = $data['quantity'];
    $date = date('Y-m-d'); // Tanggal saat ini

    try {
        // Query untuk menambahkan tracking makanan
        $query = "INSERT INTO food_tracking (user_id, food_id, quantity, date) 
                  VALUES (:user_id, :food_id, :quantity, :date)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':food_id', $food_id);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':date', $date);
        $stmt->execute();

        echo json_encode([
            'status' => 'success',
            'message' => 'Food added to tracking successfully'
        ]);
    } catch (Exception $e) {
        echo json_encode([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
    }
}
?>
