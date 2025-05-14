<?php
// Koneksi ke database
require_once __DIR__ . '/../../koneksi.php';

// Set header response JSON
header('Content-Type: application/json');

// Cek method request
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['user_id'])) {
            $user_id = $_GET['user_id'];
            $query = "SELECT * FROM food_tracking WHERE user_id = :user_id ORDER BY consumed_at DESC";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($data);
        } else {
            echo json_encode(['message' => 'User ID is required']);
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['user_id'], $data['food_name'], $data['calories'], $data['protein'], $data['fat'], $data['carbs'])) {
            echo json_encode(['message' => 'Incomplete data']);
            exit();
        }

        $query = "INSERT INTO food_tracking (user_id, food_name, calories, protein, fat, carbs, consumed_at) 
                  VALUES (:user_id, :food_name, :calories, :protein, :fat, :carbs, :consumed_at)";
        $stmt = $conn->prepare($query);
        $stmt->execute([
            ':user_id' => $data['user_id'],
            ':food_name' => $data['food_name'],
            ':calories' => $data['calories'],
            ':protein' => $data['protein'],
            ':fat' => $data['fat'],
            ':carbs' => $data['carbs'],
            ':consumed_at' => date('Y-m-d')
        ]);

        echo json_encode(['message' => 'Food data added successfully']);
        break;

    case 'PUT':
        if (!isset($_GET['id'])) {
            echo json_encode(['message' => 'ID is required']);
            exit();
        }

        $id = $_GET['id'];
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['food_name'], $data['calories'], $data['protein'], $data['fat'], $data['carbs'])) {
            echo json_encode(['message' => 'Incomplete data']);
            exit();
        }

        $query = "UPDATE food_tracking 
                  SET food_name = :food_name, calories = :calories, protein = :protein, fat = :fat, carbs = :carbs 
                  WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->execute([
            ':food_name' => $data['food_name'],
            ':calories' => $data['calories'],
            ':protein' => $data['protein'],
            ':fat' => $data['fat'],
            ':carbs' => $data['carbs'],
            ':id' => $id
        ]);

        echo json_encode(['message' => 'Food data updated successfully']);
        break;

    case 'DELETE':
        if (!isset($_GET['id'])) {
            echo json_encode(['message' => 'ID is required']);
            exit();
        }

        $id = $_GET['id'];
        $query = "DELETE FROM food_tracking WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        echo json_encode(['message' => 'Food data deleted successfully']);
        break;

    default:
        echo json_encode(['message' => 'Invalid request method']);
}
