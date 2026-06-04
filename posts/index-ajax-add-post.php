<?php
define('MBG', TRUE);
include_once(dirname(__DIR__) . '/functions-new.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: /Discourse/index.php");
    exit();
}

$title = isset($_POST['title']) ? trim($_POST['title']) : '';
$body = isset($_POST['body']) ? trim($_POST['body']) : '';
$community = isset($_POST['community']) ? trim($_POST['community']) : '';
$topic = isset($_POST['topic']) ? trim($_POST['topic']) : 'GENERAL';
$tags = isset($_POST['tags']) ? trim($_POST['tags']) : '';
$is_anonymous = (isset($_POST['is_anonymous']) && $_POST['is_anonymous'] == '1') ? 1 : 0;
$redirect_back_url = isset($_POST['redirect_back']) ? $_POST['redirect_back'] : '/Discourse/posts/index.php?action=create';

if (empty($title) || empty($topic) || empty($body)) {
    $redirect_back = $redirect_back_url . "?error=missing_fields";
    if (!empty($community)) {
        $redirect_back .= "&c=" . urlencode($community);
    }
    header("Location: " . $redirect_back);
    exit();
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
$author_id = $identification; // From functions-new.php

// Handle post image upload
$image_url = null;
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $target_dir = dirname(__DIR__) . '/assets/images/posts/';
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    $file_ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
    $new_filename = uniqid('post_', true) . '.' . $file_ext;
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_dir . $new_filename)) {
        $image_url = '/Discourse/assets/images/posts/' . $new_filename;
    }
}

$inserted_id = null;

if ($EDITH) {
    // Insert into Database
    $stmt = $EDITH->prepare("INSERT INTO posts (title, body, author_id, community, topic, tags, slug, is_anonymous, image_url) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("sssssssis", $title, $body, $author_id, $community, $topic, $tags, $slug, $is_anonymous, $image_url);
        if ($stmt->execute()) {
            $inserted_id = $stmt->insert_id;
            MIGRATE_POST_HASHTAGS($inserted_id, $tags);
            if (!empty($community)) {
                // Increment community post count
                $esc_comm = $EDITH->real_escape_string($community);
                $EDITH->query("UPDATE communities SET posts = posts + 1 WHERE title = '$esc_comm'");
            }
        }
        $stmt->close();
    }
}

// Fallback: Store in Session mock posts list
if (!$inserted_id) {
    if (!isset($_SESSION['mock_posts'])) {
        $_SESSION['mock_posts'] = [];
    }
    // Generate a temporary ID for mock posts
    $inserted_id = 1000 + count($_SESSION['mock_posts']);
    
    // Get author details
    $author_details = GET_ACCOUNT_DETAILS($author_id);
    
    $new_mock_post = [
        'id' => $inserted_id,
        'title' => $title,
        'body' => $body,
        'author_id' => $author_id,
        'display_name' => $author_details['display_name'] ?? 'User',
        'avatar_md' => $author_details['avatar_md'] ?? '/Discourse/assets/images/anonymous.png',
        'community' => $community,
        'topic' => $topic,
        'tags' => $tags,
        'slug' => $slug,
        'upvotes' => 0,
        'downvotes' => 0,
        'comment_count' => 0,
        'is_anonymous' => $is_anonymous,
        'is_poll' => 0,
        'created_at' => date('Y-m-d H:i:s'),
        'comments' => [],
        'image_url' => $image_url
    ];
    
    // Prepend to mock posts
    array_unshift($_SESSION['mock_posts'], $new_mock_post);
}

// Redirect back to homepage or community dashboard
$redirect_url = "/Discourse/index.php";
if (!empty($community)) {
    $redirect_url = "/Discourse/communities/index.php?c=" . urlencode($community);
}

$status_param = $inserted_id ? "status=post_success" : "status=post_error";

if (strpos($redirect_url, '?') !== false) {
    $redirect_url .= "&" . $status_param;
} else {
    $redirect_url .= "?" . $status_param;
}

header("Location: " . $redirect_url);
exit();
