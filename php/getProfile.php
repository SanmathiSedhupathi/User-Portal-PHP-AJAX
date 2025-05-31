<?php
require 'db.php';
require '../redis/redisSession.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->token)) {
    echo json_encode(['success' => false, 'message' => 'Token missing']);
    exit;
}

$userId = $redis->get($data->token);

if ($userId) {
    $stmt = $pdo->prepare("SELECT username, email, age, dob, contact FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode(['success' => true, 'data' => $user]);
} else {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
}
