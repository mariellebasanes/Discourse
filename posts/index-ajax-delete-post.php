<?php
define('MBG', TRUE);
include_once(dirname(__DIR__) . '/functions-new.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit();
}

$post_id = isset($_POST['id']) ? intval($_POST['id']) : 0;

if ($post_id <= 0) {
    echo json_encode(['status' => 'error', 'message' => 'Valid post ID is required.']);
    exit();
}

// 1. Verify user is logged in
if (empty($identification)) {
    echo json_encode(['status' => 'error', 'message' => 'You must be logged in to delete a post.']);
    exit();
}

// 2. Fetch post to verify ownership
if ($EDITH) {
    $stmt = $EDITH->prepare("SELECT author_id, community FROM posts WHERE id = ?");
    if (!$stmt) {
        echo json_encode(['status' => 'error', 'message' => 'Database error preparing query.']);
        exit();
    }
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $post = $res->fetch_assoc();
    $stmt->close();

    if (!$post) {
        echo json_encode(['status' => 'error', 'message' => 'Post not found.']);
        exit();
    }

    // Check if author matches logged-in user
    if ($post['author_id'] !== $identification) {
        echo json_encode(['status' => 'error', 'message' => 'Unauthorized: Only the post author can delete this post.']);
        exit();
    }

    // 3. Perform Deletion
    // Start transaction to keep DB clean
    $EDITH->begin_transaction();
    try {
        // Delete the post. Foreign keys are configured to ON DELETE CASCADE, 
        // so this automatically cleans up comments, saves, poll options/votes, and hashtag links.
        $stmt_del = $EDITH->prepare("DELETE FROM posts WHERE id = ?");
        if ($stmt_del) {
            $stmt_del->bind_param("i", $post_id);
            $stmt_del->execute();
            $stmt_del->close();
        }

        // Decrement community post count
        $community_title = $post['community'];
        $stmt_comm = $EDITH->prepare("UPDATE communities SET posts = GREATEST(0, posts - 1) WHERE title = ?");
        if ($stmt_comm) {
            $stmt_comm->bind_param("s", $community_title);
            $stmt_comm->execute();
            $stmt_comm->close();
        }

        $EDITH->commit();
        echo json_encode(['status' => 'success', 'message' => 'Post deleted successfully.']);
    } catch (Exception $e) {
        $EDITH->rollback();
        echo json_encode(['status' => 'error', 'message' => 'Transaction failed: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Database connection not available.']);
}
exit();
