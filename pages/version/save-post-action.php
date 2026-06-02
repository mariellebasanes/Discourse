<?php
define('MBG', TRUE);
include_once(dirname(dirname(__DIR__)) . '/functions-new.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

$post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
if ($post_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Post ID is required.']);
    exit;
}

$user_id = $identification;

if ($EDITH) {
    // Check if already saved
    $stmt = $EDITH->prepare("SELECT 1 FROM saved_posts WHERE post_id = ? AND identification = ?");
    if ($stmt) {
        $stmt->bind_param("is", $post_id, $user_id);
        $stmt->execute();
        $stmt->store_result();
        $is_saved = ($stmt->num_rows > 0);
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Database check query failed.']);
        exit;
    }

    if ($is_saved) {
        // Unsave post
        $stmt = $EDITH->prepare("DELETE FROM saved_posts WHERE post_id = ? AND identification = ?");
        if ($stmt) {
            $stmt->bind_param("is", $post_id, $user_id);
            $stmt->execute();
            $stmt->close();
        }
        $saved = false;
    } else {
        // Save post
        $stmt = $EDITH->prepare("INSERT INTO saved_posts (post_id, identification) VALUES (?, ?)");
        if ($stmt) {
            $stmt->bind_param("is", $post_id, $user_id);
            $stmt->execute();
            $stmt->close();
        }
        $saved = true;
    }

    echo json_encode(['success' => true, 'saved' => $saved]);
    exit;
} else {
    // Session fallback if DB offline
    if (!isset($_SESSION['saved_posts']) || !is_array($_SESSION['saved_posts'])) {
        $_SESSION['saved_posts'] = [];
    }

    $index = array_search($post_id, $_SESSION['saved_posts']);
    if ($index !== false) {
        unset($_SESSION['saved_posts'][$index]);
        $_SESSION['saved_posts'] = array_values($_SESSION['saved_posts']);
        $saved = false;
    } else {
        $_SESSION['saved_posts'][] = $post_id;
        $saved = true;
    }

    echo json_encode(['success' => true, 'saved' => $saved]);
    exit;
}
?>
