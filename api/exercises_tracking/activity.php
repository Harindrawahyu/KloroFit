<!-- CRUD aktivitas olahraga -->
<?php
session_start();
require_once __DIR__ . '../../config/koneksi.php';

// valodasi login user
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['message' => 'Unauthorized']);
    exit();
}

// Mendapatkan koneksi database
$conn = getConnection();
$user_id = $_SESSION['user_id'];

// Mendapatkan method request
$method = $_SERVER['REQUEST_METHOD'];

    switch ($method) {
        // Get all activities or a specific activity
        case 'GET':
            if (isset($_GET['id'])) {
                $stmt = $conn->prepare("SELECT * FROM activities WHERE id = :id");
                $stmt->execute([':id' => (int)$_GET['id']]);
                $activity = $stmt->fetch(PDO::FETCH_ASSOC);
                echo json_encode($activity ? $activity : ['message' => 'Activity not found']);
            } else {
                $stmt = $conn->query("SELECT * FROM activities ORDER BY created_at DESC");
                echo json_encode($stmt->fetch_all(PDO::FETCH_ASSOC));
            }
            break;

        // Create activity
        case 'POST':
            $data = json_decode(file_get_contents("php://input"), true);
            if (empty($data['user_id']) || empty($data['name']) || empty($data['duration_minutes']) || 
                empty($data['calories_burned']) || empty($data['activity_date'])) {
                echo json_encode(['message' => 'All fields are required']);
                exit();
            }

            $stmt = $conn->prepare("
                INSERT INTO activities (user_id, name, duration_minutes, calories_burned, activity_date) 
                VALUES (:user_id, :name, :duration_minutes, :calories_burned, :activity_date)
            ");
            $stmt->execute([
                ':user_id' => (int)$data['user_id'],
                ':name' => htmlspecialchars($data['name']),
                ':duration_minutes' => (int)$data['duration_minutes'],
                ':calories_burned' => (int)$data['calories_burned'],
                ':activity_date' => $data['activity_date']
            ]);
            echo json_encode(['message' => 'Activity created successfully']);
            break;

        // Update activity
        case 'PUT':
            if (!isset($_GET['user_id'])) {
                echo json_encode(['message' => 'ID not provided']);
                exit();
            }

            $data = json_decode(file_get_contents("php://input"), true);
            if (empty($data['user_id']) || empty($data['name']) || empty($data['duration_minutes']) || 
                empty($data['calories_burned']) || empty($data['activity_date'])) {
                echo json_encode(['message' => 'All fields are required']);
                exit();
            }

            $stmt = $conn->prepare("
                UPDATE activities 
                SET user_id = :user_id, name = :name, duration_minutes = :duration_minutes, 
                    calories_burned = :calories_burned, activity_date = :activity_date 
                WHERE id = :id
            ");
            $stmt->execute([
                ':id' => (int)$_GET['id'],
                ':user_id' => (int)$data['user_id'],
                ':name' => htmlspecialchars($data['name']),
                ':duration_minutes' => (int)$data['duration_minutes'],
                ':calories_burned' => (int)$data['calories_burned'],
                ':activity_date' => $data['activity_date']
            ]);
            echo json_encode(['message' => 'Activity updated successfully']);
            break;

        // Delete activity
        case 'DELETE':
                // Mendapatkan ID dari parameter URL
                if (!isset($_GET['id'])) {
                    echo json_encode(['message' => 'ID is required for delete']);
                    exit();
                }

                // Menghapus aktivitas
                $stmt = $conn->prepare("DELETE FROM activities WHERE id = :id AND user_id = :user_id");
                $stmt->execute([
                    ':id' => (int)$_GET['id'],
                    ':user_id' => $user_id
                ]);

                echo json_encode(['message' => 'Activity deleted successfully']);
                break;

            default:
                echo json_encode(['message' => 'Invalid request method']);
                break;
}
?>
