<?php
require 'db.php';
require '../redis/redisSession.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"));

if (!$data || !isset($data->username, $data->email, $data->password)) {
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
    exit;
}

function validate_password($password) {
    if (strlen($password) < 8) {
        return "Password must be at least 8 characters long.";
    }
    if (!preg_match('/[A-Z]/', $password)) {
        return "Password must contain at least one uppercase letter.";
    }
    if (!preg_match('/[a-z]/', $password)) {
        return "Password must contain at least one lowercase letter.";
    }
    if (!preg_match('/\d/', $password)) {
        return "Password must contain at least one number.";
    }
    if (!preg_match('/[\W]/', $password)) {
        return "Password must contain at least one special character.";
    }
    return true;
}

$validation_result = validate_password($data->password);
if ($validation_result !== true) {
    echo json_encode(['success' => false, 'message' => $validation_result]);
    exit;
}

try {
    // Check if username or email already exists
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$data->username, $data->email]);
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        echo json_encode(['success' => false, 'message' => 'Username or Email already exists']);
        exit;
    }

    // Insert new user
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->execute([
        $data->username,
        $data->email,
        password_hash($data->password, PASSWORD_DEFAULT)
    ]);
    echo json_encode(['success' => true, 'message' => 'Registration successful']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
