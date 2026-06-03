<?php
define('MBG', TRUE);
include_once(dirname(dirname(__DIR__)) . '/functions-new.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit();
}

$title = isset($_POST['title']) ? trim($_POST['title']) : '';

if (empty($title)) {
    echo json_encode(['status' => 'error', 'message' => 'Community title is required.']);
    exit();
}

// 1. Verify admin authorization
if ($EDITH) {
    $esc_title = $EDITH->real_escape_string($title);
    $r = $EDITH->query("SELECT admin_id FROM communities WHERE title='$esc_title' LIMIT 1");
    if (!$r || $r->num_rows === 0) {
        echo json_encode(['status' => 'error', 'message' => 'Community not found.']);
        exit();
    }
    $comm = $r->fetch_assoc();
    if ($comm['admin_id'] !== $identification) {
        echo json_encode(['status' => 'error', 'message' => 'Unauthorized: Only the community admin can delete the community.']);
        exit();
    }
}

$deleted = false;
if ($EDITH) {
    // Start transaction to keep DB clean
    $EDITH->begin_transaction();
    try {
        // A. Delete all posts in this community
        // This will automatically cascade and delete comments, poll_options, poll_votes, saved_posts, post_hashtags via DB foreign keys!
        $stmt_posts = $EDITH->prepare("DELETE FROM posts WHERE community = ?");
        if ($stmt_posts) {
            $stmt_posts->bind_param("s", $title);
            $stmt_posts->execute();
            $stmt_posts->close();
        }

        // B. Delete the community itself
        // This will cascade and delete all members in community_members!
        $stmt_comm = $EDITH->prepare("DELETE FROM communities WHERE title = ?");
        if ($stmt_comm) {
            $stmt_comm->bind_param("s", $title);
            $stmt_comm->execute();
            $stmt_comm->close();
        }

        $EDITH->commit();
        $deleted = true;
    } catch (Exception $e) {
        $EDITH->rollback();
        echo json_encode(['status' => 'error', 'message' => 'Transaction failed: ' . $e->getMessage()]);
        exit();
    }
}

if ($deleted) {
    echo json_encode(['status' => 'success', 'message' => 'Community deleted successfully.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to delete community.']);
}
exit();
