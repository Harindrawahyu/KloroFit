<?php
session_start();

// Koneksi ke database
require_once __DIR__ . '../../config/koneksi.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized access']);
    exit();
}

// Set header response JSON
header('Content-Type: application/json');
$conn = getConnection();
$user_id = $_SESSION['user_id'];

if (!$conn) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed']);
    exit();
}

if (isset($_GET['id'])) {
                // Mendapatkan aktivitas berdasarkan ID milik user yang login
                $id = $_GET['id'];
                $query = "SELECT * FROM activities WHERE id = :id AND user_id = :user_id";
                $stmt = $conn->prepare($query);
                $stmt->execute([':id' => $id, ':user_id' => $user_id]);
                $activity = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($activity) {
                    echo json_encode(['status' => 'success', 'data' => $activity]);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Activity not found']);
                }
            } else {
                // Mendapatkan semua aktivitas user yang login
                $query = "SELECT * FROM activities WHERE user_id = :user_id";
                $stmt = $conn->prepare($query);
                $stmt->execute([':user_id' => $user_id]);
                $activities = $stmt->fetchAll(PDO::FETCH_ASSOC);

                echo json_encode(['status' => 'success', 'data' => $activities]);
            }

?>
