<?php
require 'db.php';
require '../redis/redisSession.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->token)) {
    echo json_encode(['success' => false, 'message' => 'Token missing']);
    exit;
}

if (!isset($data->age) || !isset($data->dob) || !isset($data->contact)) {
    echo json_encode(['success' => false, 'message' => 'Incomplete data']);
    exit;
}

$userId = $redis->get($data->token);

if ($userId === false) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

// Validate age
if (!is_numeric($data->age) || $data->age < 1 || $data->age > 120) {
    echo json_encode(['success' => false, 'message' => 'Invalid age']);
    exit;
}

// Validate dob
$dobDate = date_create($data->dob);
$now = new DateTime();
if (!$dobDate) {
    echo json_encode(['success' => false, 'message' => 'Invalid date of birth']);
    exit;
}
// Check DOB is not in the future
if ($dobDate > $now) {
    echo json_encode(['success' => false, 'message' => 'Date of birth cannot be in the future']);
    exit;
}

// Validate contact
if (!preg_match('/^\d{10,15}$/', $data->contact)) {
    echo json_encode(['success' => false, 'message' => 'Invalid contact number']);
    exit;
}

// Validate age matches DOB (±1 year tolerance)
$diff = $dobDate->diff($now);
$calculatedAge = $diff->y;

if (abs($calculatedAge - $data->age) > 1) {
    echo json_encode(['success' => false, 'message' => 'Age does not match date of birth']);
    exit;
}

try {
    $stmt = $pdo->prepare("UPDATE users SET age = ?, dob = ?, contact = ? WHERE id = ?");
    $stmt->execute([$data->age, $data->dob, $data->contact, $userId]);
    echo json_encode(['success' => true, 'message' => 'Profile updated']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
exit;
