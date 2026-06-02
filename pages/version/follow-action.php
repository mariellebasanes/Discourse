<?php
define('MBG', TRUE);
include_once(dirname(dirname(__DIR__)) . '/functions-new.php');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']); exit;
}

$target_id = isset($_POST['target_id']) ? trim($_POST['target_id']) : '';
if (empty($target_id) || empty($identification) || $target_id === $identification) {
    echo json_encode(['success' => false, 'message' => 'Invalid user.']); exit;
}

if (!$EDITH) {
    echo json_encode(['success' => false, 'message' => 'Database unavailable.']); exit;
}

// Check if already following
$stmt = $EDITH->prepare("SELECT id FROM followers WHERE follower_id=? AND following_id=?");
$stmt->bind_param("ss", $identification, $target_id);
$stmt->execute();
$stmt->store_result();
$already = $stmt->num_rows > 0;
$stmt->close();

if ($already) {
    // Unfollow
    $stmt = $EDITH->prepare("DELETE FROM followers WHERE follower_id=? AND following_id=?");
    $stmt->bind_param("ss", $identification, $target_id);
    $stmt->execute();
    $stmt->close();
    echo json_encode(['success' => true, 'following' => false]);
} else {
    // Follow
    $stmt = $EDITH->prepare("INSERT IGNORE INTO followers (follower_id, following_id) VALUES (?,?)");
    $stmt->bind_param("ss", $identification, $target_id);
    $stmt->execute();
    $stmt->close();
    echo json_encode(['success' => true, 'following' => true]);
}
