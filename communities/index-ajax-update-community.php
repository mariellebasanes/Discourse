<?php
define('MBG', TRUE);
include_once(dirname(__DIR__) . '/functions-new.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit();
}

$title        = isset($_POST['title'])        ? trim($_POST['title'])        : '';
$desc         = isset($_POST['desc'])         ? trim($_POST['desc'])         : '';
$category     = isset($_POST['category'])     ? trim($_POST['category'])     : 'my-communities';
$theme_color  = isset($_POST['theme_color'])  ? trim($_POST['theme_color'])  : '#1A8B44';
$icon         = isset($_POST['icon'])         ? trim($_POST['icon'])         : 'bi-people-fill';
$custom_topics_raw = isset($_POST['custom_topics']) ? trim($_POST['custom_topics']) : '';

if (empty($title) || empty($desc)) {
    echo json_encode(['status' => 'error', 'message' => 'Community title and description are required.']);
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
        echo json_encode(['status' => 'error', 'message' => 'Unauthorized: Only the community admin can edit settings.']);
        exit();
    }
}

// Sanitize inputs
$title        = sanitize($title);
$desc         = sanitize($desc);
$category     = sanitize($category);
$theme_color  = preg_match('/^#[0-9a-fA-F]{3,6}$/', $theme_color) ? $theme_color : '#1A8B44';
$icon         = sanitize($icon);

// Sanitize custom topics
$custom_topics = '';
if (!empty($custom_topics_raw)) {
    $topics_arr = array_filter(array_map(function($t) {
        return ucfirst(strtolower(trim(strip_tags($t))));
    }, explode(',', $custom_topics_raw)));
    $custom_topics = implode(',', array_slice(array_unique($topics_arr), 0, 20));
}

// Map color to classes
$color_map = [
    '#1A8B44' => ['bg-light-success', 'text-success'],
    '#0b5ed7' => ['bg-light-primary', 'text-primary'],
    '#6610f2' => ['bg-light-primary', 'text-primary'],
    '#d63384' => ['bg-light-danger',  'text-danger'],
    '#dc3545' => ['bg-light-danger',  'text-danger'],
    '#fd7e14' => ['bg-light-warning', 'text-warning'],
    '#ffc107' => ['bg-light-warning', 'text-warning'],
    '#6c757d' => ['bg-secondary',     'text-secondary'],
    '#212529' => ['bg-dark',          'text-white'],
    '#198754' => ['bg-light-success', 'text-success'],
    '#0dcaf0' => ['bg-light-info',    'text-info'],
    '#20c997' => ['bg-light-success', 'text-success'],
];
[$bg_class, $text_class] = $color_map[$theme_color] ?? ['bg-light-success', 'text-success'];

// If new logo is uploaded, save it
$logo_url = null;
if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
    $target_dir = dirname(__DIR__) . '/assets/images/communities/';
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    $file_ext = strtolower(pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION));
    $new_filename = uniqid('comm_', true) . '.' . $file_ext;
    if (move_uploaded_file($_FILES['logo']['tmp_name'], $target_dir . $new_filename)) {
        $logo_url = '/Discourse/assets/images/communities/' . $new_filename;
    }
}

$new_admin_id = isset($_POST['new_admin_id']) ? trim($_POST['new_admin_id']) : '';

$updated = false;
if ($EDITH) {
    if ($logo_url !== null) {
        $stmt = $EDITH->prepare(
            "UPDATE communities 
             SET `desc` = ?, category = ?, theme_color = ?, icon = ?, bg_class = ?, text_class = ?, custom_topics = ?, logo_url = ? 
             WHERE title = ?"
        );
        $stmt->bind_param("sssssssss", $desc, $category, $theme_color, $icon, $bg_class, $text_class, $custom_topics, $logo_url, $title);
    } else {
        $stmt = $EDITH->prepare(
            "UPDATE communities 
             SET `desc` = ?, category = ?, theme_color = ?, icon = ?, bg_class = ?, text_class = ?, custom_topics = ? 
             WHERE title = ?"
        );
        $stmt->bind_param("ssssssss", $desc, $category, $theme_color, $icon, $bg_class, $text_class, $custom_topics, $title);
    }
    if ($stmt) {
        if ($stmt->execute()) {
            $updated = true;
        }
        $stmt->close();
    }

    // Handle Admin Promotion/Transfer
    if (!empty($new_admin_id)) {
        $esc_new_admin = $EDITH->real_escape_string($new_admin_id);
        $esc_title = $EDITH->real_escape_string($title);
        // Verify they are a member of this community
        $chk_member = $EDITH->query("SELECT id FROM community_members WHERE community_title='$esc_title' AND identification='$esc_new_admin' LIMIT 1");
        if ($chk_member && $chk_member->num_rows > 0) {
            $EDITH->query("UPDATE communities SET admin_id='$esc_new_admin' WHERE title='$esc_title'");
            $EDITH->query("UPDATE community_members SET role='member' WHERE community_title='$esc_title' AND role='admin'");
            $EDITH->query("UPDATE community_members SET role='admin' WHERE community_title='$esc_title' AND identification='$esc_new_admin'");
        }
    }
}

if ($updated) {
    echo json_encode(['status' => 'success', 'message' => 'Community updated successfully!']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to update community details.']);
}
exit();
