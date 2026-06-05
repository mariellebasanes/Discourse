<?php
define('MBG', TRUE);
include_once(dirname(__DIR__) . '/functions-new.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit();
}

if (empty($identification)) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized: Please log in first.']);
    exit();
}

$display_name = isset($_POST['display_name']) ? trim($_POST['display_name']) : '';
$program      = isset($_POST['program'])      ? trim($_POST['program'])      : '';
$campus       = isset($_POST['campus'])       ? trim($_POST['campus'])       : '';
$bio          = isset($_POST['bio'])          ? trim($_POST['bio'])          : '';

if (empty($display_name)) {
    echo json_encode(['status' => 'error', 'message' => 'Display name is required.']);
    exit();
}

$avatar_md = null;
$cover_md  = null;

// Handle Avatar Upload
if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
    $target_dir = dirname(__DIR__) . '/assets/images/avatars/';
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    $file_ext = strtolower(pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION));
    if (in_array($file_ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
        $new_filename = uniqid('avatar_', true) . '.' . $file_ext;
        if (move_uploaded_file($_FILES['avatar']['tmp_name'], $target_dir . $new_filename)) {
            $avatar_md = '/Discourse/assets/images/avatars/' . $new_filename;
        }
    }
}

// Handle Cover Upload
if (isset($_FILES['cover']) && $_FILES['cover']['error'] === UPLOAD_ERR_OK) {
    $target_dir = dirname(__DIR__) . '/assets/images/covers/';
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    $file_ext = strtolower(pathinfo($_FILES['cover']['name'], PATHINFO_EXTENSION));
    if (in_array($file_ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
        $new_filename = uniqid('cover_', true) . '.' . $file_ext;
        if (move_uploaded_file($_FILES['cover']['tmp_name'], $target_dir . $new_filename)) {
            $cover_md = '/Discourse/assets/images/covers/' . $new_filename;
        }
    }
}

$updated = false;
if ($EDITH) {
    $sql = "UPDATE accounts SET display_name = ?, program = ?, campus = ?, bio = ?";
    $params = [$display_name, $program, $campus, $bio];
    $types = "ssss";
    
    if ($avatar_md !== null) {
        $sql .= ", avatar_md = ?";
        $params[] = $avatar_md;
        $types .= "s";
    }
    if ($cover_md !== null) {
        $sql .= ", cover_md = ?";
        $params[] = $cover_md;
        $types .= "s";
    }
    
    $sql .= " WHERE identification = ?";
    $params[] = $identification;
    $types .= "s";
    
    $stmt = $EDITH->prepare($sql);
    if ($stmt) {
        $stmt->bind_param($types, ...$params);
        if ($stmt->execute()) {
            $updated = true;
        }
        $stmt->close();
    }
}

if ($updated) {
    echo json_encode(['status' => 'success', 'message' => 'Profile updated successfully!']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to update profile.']);
}
exit();
