<?php
define('MBG', TRUE);
include_once(dirname(dirname(__DIR__)) . '/functions-new.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit();
}

$post_id = isset($_POST['post_id']) ? (int)$_POST['post_id'] : 0;
$action = isset($_POST['action']) ? trim($_POST['action']) : ''; // 'highlight' or 'unhighlight'

if ($post_id <= 0 || !in_array($action, ['highlight', 'unhighlight'])) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid parameters.']);
    exit();
}

if (!$EDITH) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed.']);
    exit();
}

// 1. Fetch community name of the post
$stmt = $EDITH->prepare("SELECT community FROM posts WHERE id = ? LIMIT 1");
if (!$stmt) {
    echo json_encode(['status' => 'error', 'message' => 'Failed to prepare post query.']);
    exit();
}
$stmt->bind_param("i", $post_id);
$stmt->execute();
$post_res = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$post_res) {
    echo json_encode(['status' => 'error', 'message' => 'Post not found.']);
    exit();
}

$community_name = $post_res['community'];

// 2. Verify current user is the admin of that community
$stmt = $EDITH->prepare("SELECT admin_id FROM communities WHERE title = ? LIMIT 1");
if (!$stmt) {
    echo json_encode(['status' => 'error', 'message' => 'Failed to prepare community query.']);
    exit();
}
$stmt->bind_param("s", $community_name);
$stmt->execute();
$comm_res = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$comm_res) {
    echo json_encode(['status' => 'error', 'message' => 'Community not found.']);
    exit();
}

if ($comm_res['admin_id'] !== $identification) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized: Only the community admin can highlight posts.']);
    exit();
}

// 3. Perform update
$is_highlighted = ($action === 'highlight') ? 1 : 0;
$stmt = $EDITH->prepare("UPDATE posts SET is_highlighted = ? WHERE id = ?");
if (!$stmt) {
    echo json_encode(['status' => 'error', 'message' => 'Failed to prepare update query.']);
    exit();
}
$stmt->bind_param("ii", $is_highlighted, $post_id);
$stmt->execute();
$stmt->close();

echo json_encode([
    'status' => 'success',
    'message' => ($is_highlighted ? 'Post highlighted successfully!' : 'Post unhighlighted successfully!')
]);
exit();
