<?php
session_start();
$api_base = 'http://localhost/nutrition-php-api/api';

function request($endpoint, $method = 'GET', $data = null, $auth = false) {
    global $api_base;
    $headers = ["Content-Type: application/json"];
    if ($auth && isset($_SESSION['token'])) {
        $headers[] = "Authorization: Bearer {$_SESSION['token']}";
    }
    $opts = [
        'http' => [
            'method'  => $method,
            'header'  => implode("\r\n", $headers),
            'ignore_errors' => true
        ]
    ];
    if ($data) {
        $opts['http']['content'] = json_encode($data);
    }
    $context = stream_context_create($opts);
    return json_decode(file_get_contents("{$api_base}{$endpoint}", false, $context), true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'register':
                $res = request('/auth/register.php', 'POST', [
                    'name' => $_POST['name'],
                    'email' => $_POST['email'],
                    'password' => $_POST['password']
                ]);
                break;
            case 'login':
                $res = request('/auth/login.php', 'POST', [
                    'email' => $_POST['email'],
                    'password' => $_POST['password']
                ]);
                if (isset($res['token'])) {
                    $_SESSION['token'] = $res['token'];
                }
                break;
            case 'logout':
                unset($_SESSION['token']);
                break;
            case 'create_food':
                $res = request('/food_tracking/create_food_tracking.php', 'POST', [
                    'user_id' => $_POST['user_id'],
                    'food_name' => $_POST['food_name'],
                    'calories' => $_POST['calories'],
                    'fat' => $_POST['fat'],
                    'protein' => $_POST['protein'],
                    'carbs' => $_POST['carbs'],
                    'date' => $_POST['date']
                ], true);
                break;
            case 'create_activity':
                $res = request('/activity/create_activity.php', 'POST', [
                    'user_id' => $_POST['user_id'],
                    'activity_type' => $_POST['activity_type'],
                    'duration' => $_POST['duration'],
                    'calories_burned' => $_POST['calories_burned'],
                    'date' => $_POST['date']
                ], true);
                break;
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Nutrition App API Test</title>
</head>
<body>
<h2>Register</h2>
<form method="POST">
    <input type="hidden" name="action" value="register">
    <input type="text" name="name" placeholder="Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Register</button>
</form>

<h2>Login</h2>
<form method="POST">
    <input type="hidden" name="action" value="login">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
</form>

<h2>Logout</h2>
<form method="POST">
    <input type="hidden" name="action" value="logout">
    <button type="submit">Logout</button>
</form>

<h2>Create Food Entry</h2>
<form method="POST">
    <input type="hidden" name="action" value="create_food">
    <input type="number" name="user_id" placeholder="User ID" required>
    <input type="text" name="food_name" placeholder="Food Name" required>
    <input type="number" name="calories" placeholder="Calories" required>
    <input type="number" name="fat" placeholder="Fat" required>
    <input type="number" name="protein" placeholder="Protein" required>
    <input type="number" name="carbs" placeholder="Carbs" required>
    <input type="date" name="date" required>
    <button type="submit">Add Food</button>
</form>

<h2>Create Activity</h2>
<form method="POST">
    <input type="hidden" name="action" value="create_activity">
    <input type="number" name="user_id" placeholder="User ID" required>
    <input type="text" name="activity_type" placeholder="Activity Type" required>
    <input type="number" name="duration" placeholder="Duration (minutes)" required>
    <input type="number" name="calories_burned" placeholder="Calories Burned" required>
    <input type="date" name="date" required>
    <button type="submit">Add Activity</button>
</form>

<?php if (isset($res)) { echo "<h3>Response</h3><pre>" . print_r($res, true) . "</pre>"; } ?>
</body>
</html>
