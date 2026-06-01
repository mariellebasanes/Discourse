<?php
define('MBG', TRUE);
include(dirname(dirname(__DIR__)) . '/functions-new.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

$post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
$body = isset($_POST['body']) ? trim($_POST['body']) : '';

if ($post_id <= 0 || empty($body)) {
    echo json_encode(['success' => false, 'message' => 'Missing comment content or post reference.']);
    exit;
}

// Sanitize inputs
$body = sanitize($body);
$author_id = $identification;
$author_name = $ACCOUNT['display_name'];

// Check if this post is a session mock post
if (isset($_SESSION['mock_posts']) && is_array($_SESSION['mock_posts'])) {
    foreach ($_SESSION['mock_posts'] as $key => $mp) {
        if ($mp['id'] === $post_id) {
            $_SESSION['mock_posts'][$key]['comments'][] = [
                'post_id' => $post_id,
                'author_id' => $author_id,
                'author_name' => $author_name,
                'body' => $body,
                'created_at' => date('Y-m-d H:i:s'),
                'avatar_md' => $ACCOUNT['avatar_md'] ?? '/Discourse/assets/images/anonymous.png'
            ];
            echo json_encode(['success' => true]);
            exit;
        }
    }
}

if (!$EDITH) {
    echo json_encode(['success' => false, 'message' => 'Database connection not available.']);
    exit;
}

$stmt = $EDITH->prepare("INSERT INTO comments (post_id, author_id, author_name, body) VALUES (?, ?, ?, ?)");
if ($stmt) {
    $stmt->bind_param("isss", $post_id, $author_id, $author_name, $body);
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to save comment to database: ' . $stmt->error]);
    }
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Database prepare failed.']);
}
?>
