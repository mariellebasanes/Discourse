<?php
define('MBG', TRUE);
include_once(dirname(dirname(__DIR__)) . '/functions-new.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit();
}

$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$desc = isset($_POST['desc']) ? trim($_POST['desc']) : '';
$category = isset($_POST['category']) ? trim($_POST['category']) : 'my-communities';
$theme_color = isset($_POST['theme_color']) ? trim($_POST['theme_color']) : '#1A8B44';

if (empty($name) || empty($desc)) {
    echo json_encode(['status' => 'error', 'message' => 'Community name and description are required.']);
    exit();
}

// Sanitize inputs
$name = sanitize($name);
$desc = sanitize($desc);
$category = sanitize($category);
$theme_color = sanitize($theme_color);

// Deduce icon details based on name and category
$icon = 'bi-cpu';
$bg_class = 'bg-light-success';
$text_class = 'text-success';

$name_lower = strtolower($name);
$cat_lower = strtolower($category);

if (strpos($name_lower, 'life') !== false) {
    $icon = 'bi-heart-fill';
    $bg_class = 'bg-light-danger';
    $text_class = 'text-danger';
} elseif (strpos($name_lower, 'fresh') !== false || strpos($name_lower, 'study') !== false || strpos($name_lower, 'group') !== false) {
    $icon = 'bi-people-fill';
    $bg_class = 'bg-light-primary';
    $text_class = 'text-primary';
} elseif (strpos($name_lower, 'food') !== false || strpos($name_lower, 'trip') !== false) {
    $icon = 'bi-cup-hot-fill';
    $bg_class = 'bg-light-warning';
    $text_class = 'text-warning';
} elseif (strpos($name_lower, 'cosplay') !== false || strpos($name_lower, 'artist') !== false || strpos($name_lower, 'culture') !== false || strpos($name_lower, 'hub') !== false) {
    $icon = 'bi-palette-fill';
    $bg_class = 'bg-light-info';
    $text_class = 'text-info';
} elseif (strpos($name_lower, 'enroll') !== false || strpos($name_lower, 'thesis') !== false || strpos($name_lower, 'advice') !== false) {
    $icon = 'bi-journal-bookmark-fill';
    $bg_class = 'bg-light-info';
    $text_class = 'text-info';
} elseif (strpos($name_lower, 'innovat') !== false) {
    $icon = 'bi-lightbulb-fill';
    $bg_class = 'bg-light-warning';
    $text_class = 'text-warning';
} elseif ($cat_lower === 'feu alabang') {
    $icon = 'bi-building-fill';
    $bg_class = 'bg-light-warning';
    $text_class = 'text-warning';
} elseif ($cat_lower === 'feu diliman') {
    $icon = 'bi-mortarboard-fill';
    $bg_class = 'bg-light-primary';
    $text_class = 'text-primary';
}

$inserted = false;

if ($EDITH) {
    $stmt = $EDITH->prepare("INSERT INTO communities (title, `desc`, category, theme_color, icon, bg_class, text_class, members, posts) VALUES (?, ?, ?, ?, ?, ?, ?, 1, 0)");
    if ($stmt) {
        $stmt->bind_param("sssssss", $name, $desc, $category, $theme_color, $icon, $bg_class, $text_class);
        if ($stmt->execute()) {
            $inserted = true;
            // Also insert into community_members
            $stmt_m = $EDITH->prepare("INSERT IGNORE INTO community_members (community_title, identification) VALUES (?, ?)");
            if ($stmt_m) {
                $stmt_m->bind_param("ss", $name, $identification);
                $stmt_m->execute();
                $stmt_m->close();
            }
        }
        $stmt->close();
    }
}

// Fallback to Session mock storage
if (!$inserted) {
    if (!isset($_SESSION['mock_communities'])) {
        $_SESSION['mock_communities'] = [];
    }
    
    $new_mock_community = [
        'title' => $name,
        'desc' => $desc,
        'category' => $category,
        'theme_color' => $theme_color,
        'icon' => $icon,
        'bg_class' => $bg_class,
        'text_class' => $text_class,
        'members' => 1,
        'posts' => 0
    ];
    
    array_unshift($_SESSION['mock_communities'], $new_mock_community);
    
    // Also save in joined_communities session fallback
    if (!isset($_SESSION['joined_communities']) || !is_array($_SESSION['joined_communities'])) {
        $_SESSION['joined_communities'] = [];
    }
    $_SESSION['joined_communities'][] = $name;
}

echo json_encode([
    'status' => 'success',
    'community' => [
        'title' => $name,
        'desc' => $desc,
        'category' => $category,
        'theme_color' => $theme_color,
        'icon' => $icon,
        'bg_class' => $bg_class,
        'text_class' => $text_class,
        'members' => 1,
        'posts' => 0
    ]
]);
exit();
