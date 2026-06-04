<?php
define('MBG', TRUE);
include_once(dirname(__DIR__) . '/functions-new.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit();
}

$community    = isset($_POST['community'])    ? trim($_POST['community'])    : '';
$title        = isset($_POST['title'])        ? trim($_POST['title'])        : '';
$body         = isset($_POST['body'])         ? trim($_POST['body'])         : '';
$topic        = isset($_POST['topic'])        ? trim($_POST['topic'])        : 'GENERAL';
$tags         = isset($_POST['tags'])         ? trim($_POST['tags'])         : '';

if (empty($community) || empty($title) || empty($body)) {
    echo json_encode(['status' => 'error', 'message' => 'Community, title and body are required.']);
    exit();
}

// 1. Verify admin authorization
if ($EDITH) {
    $esc_comm = $EDITH->real_escape_string($community);
    $r = $EDITH->query("SELECT admin_id FROM communities WHERE title='$esc_comm' LIMIT 1");
    if (!$r || $r->num_rows === 0) {
        echo json_encode(['status' => 'error', 'message' => 'Community not found.']);
        exit();
    }
    $comm = $r->fetch_assoc();
    if ($comm['admin_id'] !== $identification) {
        echo json_encode(['status' => 'error', 'message' => 'Unauthorized: Only the community admin can add announcement posts.']);
        exit();
    }
}

// Generate unique slug
function generateUniqueSlug($title) {
    global $EDITH;
    $slug = preg_replace('/[^a-z0-9]+/i', '-', strtolower($title));
    $slug = trim($slug, '-');
    if (empty($slug)) {
        $slug = 'post';
    }
    
    if (!$EDITH) {
        return $slug . '-' . rand(1000, 9999);
    }
    
    $orig_slug = $slug;
    $count = 1;
    while (true) {
        $stmt = $EDITH->prepare("SELECT id FROM posts WHERE slug = ?");
        if (!$stmt) {
            break;
        }
        $stmt->bind_param("s", $slug);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows === 0) {
            $stmt->close();
            break;
        }
        $stmt->close();
        $slug = $orig_slug . '-' . $count;
        $count++;
    }
    return $slug;
}

$slug = generateUniqueSlug($title);
$author_id = $identification;

$inserted = false;
if ($EDITH) {
    // Insert post with is_announcement = 1, is_anonymous = 0
    $stmt = $EDITH->prepare(
        "INSERT INTO posts (title, body, author_id, community, topic, tags, slug, is_anonymous, is_announcement) 
         VALUES (?, ?, ?, ?, ?, ?, ?, 0, 1)"
    );
    if ($stmt) {
        $stmt->bind_param("sssssss", $title, $body, $author_id, $community, $topic, $tags, $slug);
        if ($stmt->execute()) {
            $inserted_id = $stmt->insert_id;
            MIGRATE_POST_HASHTAGS($inserted_id, $tags);
            
            // Increment community post count
            $esc_comm = $EDITH->real_escape_string($community);
            $EDITH->query("UPDATE communities SET posts = posts + 1 WHERE title = '$esc_comm'");
            $inserted = true;
        }
        $stmt->close();
    }
}

if ($inserted) {
    echo json_encode(['status' => 'success', 'message' => 'Announcement posted successfully!']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to create announcement post.']);
}
exit();
