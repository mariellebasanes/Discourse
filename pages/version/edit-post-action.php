<?php
define('MBG', TRUE);
include_once(dirname(dirname(__DIR__)) . '/functions-new.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: /Discourse/index.php");
    exit();
}

$post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
$title = isset($_POST['title']) ? trim($_POST['title']) : '';
$body = isset($_POST['body']) ? trim($_POST['body']) : '';
$remove_image = isset($_POST['remove_image']) && $_POST['remove_image'] == '1';

if ($post_id <= 0 || empty($title)) {
    header("Location: /Discourse/index.php");
    exit();
}

$image_url = null;
$has_new_image = false;

// Handle new image upload
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $target_dir = dirname(dirname(__DIR__)) . '/assets/images/posts/';
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    $file_ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
    $new_filename = uniqid('post_', true) . '.' . $file_ext;
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_dir . $new_filename)) {
        $image_url = '/Discourse/assets/images/posts/' . $new_filename;
        $has_new_image = true;
    }
}

$updated = false;

if ($EDITH) {
    // Get existing image_url first
    $stmt = $EDITH->prepare("SELECT image_url FROM posts WHERE id = ?");
    $existing_image_url = null;
    if ($stmt) {
        $stmt->bind_param("i", $post_id);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res && $row = $res->fetch_assoc()) {
            $existing_image_url = $row['image_url'];
        }
        $stmt->close();
    }

    // Determine final image_url
    if ($has_new_image) {
        $final_image_url = $image_url;
    } else if ($remove_image) {
        $final_image_url = null;
    } else {
        $final_image_url = $existing_image_url;
    }

    // Update in database
    $stmt = $EDITH->prepare("UPDATE posts SET title = ?, body = ?, image_url = ? WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("sssi", $title, $body, $final_image_url, $post_id);
        if ($stmt->execute()) {
            $updated = true;
        }
        $stmt->close();
    }
}

// Update in Session fallback mock posts list
if (isset($_SESSION['mock_posts']) && is_array($_SESSION['mock_posts'])) {
    foreach ($_SESSION['mock_posts'] as $key => $mp) {
        if ($mp['id'] == $post_id) {
            $_SESSION['mock_posts'][$key]['title'] = $title;
            $_SESSION['mock_posts'][$key]['body'] = $body;
            if ($has_new_image) {
                $_SESSION['mock_posts'][$key]['image_url'] = $image_url;
            } else if ($remove_image) {
                $_SESSION['mock_posts'][$key]['image_url'] = null;
            }
            $updated = true;
            break;
        }
    }
}

// Redirect back to view post page
header("Location: /Discourse/pages/version/view-post.php?id=" . $post_id . ($updated ? "&status=success" : "&status=error"));
exit();
?>
