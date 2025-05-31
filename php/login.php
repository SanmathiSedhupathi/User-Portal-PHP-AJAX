<?php
require 'db.php';
require '../redis/redisSession.php';

header('Content-Type: application/json');

// Read JSON input
$data = json_decode(file_get_contents("php://input"));

if (!$data || !isset($data->email, $data->password)) {
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
    exit;
}

// Fetch user from DB
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$data->email]);
$user = $stmt->fetch();

if ($user && password_verify($data->password, $user['password'])) {
    // Generate token and store in Redis
    $token = bin2hex(random_bytes(16));
    $redis->set($token, $user['id']);
    
    echo json_encode([
        'success' => true,
        'token' => $token
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid credentials'
    ]);
}
