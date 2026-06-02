<?php
define('MBG', TRUE);
include_once(dirname(dirname(__DIR__)) . '/functions-new.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit();
}

$name         = isset($_POST['name'])         ? trim($_POST['name'])         : '';
$desc         = isset($_POST['desc'])         ? trim($_POST['desc'])         : '';
$category     = isset($_POST['category'])     ? trim($_POST['category'])     : 'my-communities';
$theme_color  = isset($_POST['theme_color'])  ? trim($_POST['theme_color'])  : '#1A8B44';
$custom_topics_raw = isset($_POST['custom_topics']) ? trim($_POST['custom_topics']) : '';

if (empty($name) || empty($desc)) {
    echo json_encode(['status' => 'error', 'message' => 'Community name and description are required.']);
    exit();
}

// Sanitize
$name         = sanitize($name);
$desc         = sanitize($desc);
$category     = sanitize($category);
$theme_color  = preg_match('/^#[0-9a-fA-F]{3,6}$/', $theme_color) ? $theme_color : '#1A8B44';

// Sanitize and normalize custom topics (comma-separated list)
$custom_topics = '';
if (!empty($custom_topics_raw)) {
    $topics_arr = array_filter(array_map(function($t) {
        return ucfirst(strtolower(trim(strip_tags($t))));
    }, explode(',', $custom_topics_raw)));
    $custom_topics = implode(',', array_slice(array_unique($topics_arr), 0, 20));
}

// Derive bg/text class from theme_color
// Map hex color to Bootstrap light classes
$color_map = [
    '#1A8B44' => ['bg-light-success', 'text-success', 'bi-people-fill'],
    '#0b5ed7' => ['bg-light-primary', 'text-primary', 'bi-cpu'],
    '#6610f2' => ['bg-light-primary', 'text-primary', 'bi-stars'],
    '#d63384' => ['bg-light-danger',  'text-danger',  'bi-heart-fill'],
    '#dc3545' => ['bg-light-danger',  'text-danger',  'bi-exclamation-circle'],
    '#fd7e14' => ['bg-light-warning', 'text-warning', 'bi-lightbulb-fill'],
    '#ffc107' => ['bg-light-warning', 'text-warning', 'bi-trophy'],
    '#6c757d' => ['bg-secondary',     'text-secondary','bi-chat-fill'],
    '#212529' => ['bg-dark',          'text-white',   'bi-shield-fill'],
    '#198754' => ['bg-light-success', 'text-success', 'bi-leaf-fill'],
    '#0dcaf0' => ['bg-light-info',    'text-info',    'bi-info-circle-fill'],
    '#20c997' => ['bg-light-success', 'text-success', 'bi-activity'],
];

[$bg_class, $text_class, $icon] = $color_map[$theme_color] ?? ['bg-light-success', 'text-success', 'bi-people-fill'];

// Refine icon by community name keywords
$name_lower = strtolower($name);
if      (strpos($name_lower, 'life')   !== false) $icon = 'bi-heart-fill';
elseif  (strpos($name_lower, 'food')   !== false || strpos($name_lower, 'trip') !== false) $icon = 'bi-cup-hot-fill';
elseif  (strpos($name_lower, 'cosplay') !== false || strpos($name_lower, 'art') !== false || strpos($name_lower, 'creative') !== false) $icon = 'bi-palette-fill';
elseif  (strpos($name_lower, 'enroll') !== false || strpos($name_lower, 'thesis') !== false || strpos($name_lower, 'academ') !== false) $icon = 'bi-journal-bookmark-fill';
elseif  (strpos($name_lower, 'innovat') !== false || strpos($name_lower, 'startup') !== false) $icon = 'bi-lightbulb-fill';
elseif  (strpos($name_lower, 'diliman') !== false || strpos($name_lower, 'mortarboard') !== false) $icon = 'bi-mortarboard-fill';
elseif  (strpos($name_lower, 'alabang') !== false) $icon = 'bi-building-fill';
elseif  (strpos($name_lower, 'sport') !== false || strpos($name_lower, 'game') !== false) $icon = 'bi-trophy-fill';
elseif  (strpos($name_lower, 'music') !== false) $icon = 'bi-music-note-beamed';
elseif  (strpos($name_lower, 'tech') !== false || strpos($name_lower, 'dev') !== false) $icon = 'bi-cpu-fill';
elseif  (strpos($name_lower, 'study') !== false || strpos($name_lower, 'group') !== false || strpos($name_lower, 'fresh') !== false) $icon = 'bi-people-fill';

$creator_id = $identification ?? null;
$inserted   = false;

if ($EDITH && $creator_id) {
    // Check name not already taken
    $chk = $EDITH->prepare("SELECT id FROM communities WHERE title=? LIMIT 1");
    if ($chk) {
        $chk->bind_param("s", $name);
        $chk->execute();
        $chk->store_result();
        if ($chk->num_rows > 0) {
            $chk->close();
            echo json_encode(['status' => 'error', 'message' => 'A community with that name already exists.']);
            exit();
        }
        $chk->close();
    }

    $stmt = $EDITH->prepare(
        "INSERT INTO communities (title, `desc`, category, theme_color, icon, bg_class, text_class, members, posts, admin_id, custom_topics)
         VALUES (?, ?, ?, ?, ?, ?, ?, 1, 0, ?, ?)"
    );
    if ($stmt) {
        $stmt->bind_param("sssssssss", $name, $desc, $category, $theme_color, $icon, $bg_class, $text_class, $creator_id, $custom_topics);
        if ($stmt->execute()) {
            $inserted = true;
            // Add creator as admin member
            $stmt_m = $EDITH->prepare(
                "INSERT IGNORE INTO community_members (community_title, identification, role) VALUES (?, ?, 'admin')"
            );
            if ($stmt_m) {
                $stmt_m->bind_param("ss", $name, $creator_id);
                $stmt_m->execute();
                $stmt_m->close();
            }
        }
        $stmt->close();
    }
}

if (!$inserted) {
    if (!isset($_SESSION['mock_communities'])) $_SESSION['mock_communities'] = [];
    array_unshift($_SESSION['mock_communities'], [
        'title' => $name, 'desc' => $desc, 'category' => $category,
        'theme_color' => $theme_color, 'icon' => $icon,
        'bg_class' => $bg_class, 'text_class' => $text_class,
        'members' => 1, 'posts' => 0, 'admin_id' => $creator_id,
        'custom_topics' => $custom_topics,
    ]);
    if (!isset($_SESSION['joined_communities'])) $_SESSION['joined_communities'] = [];
    $_SESSION['joined_communities'][] = $name;
}

echo json_encode([
    'status'    => 'success',
    'community' => [
        'title'         => $name,
        'desc'          => $desc,
        'category'      => $category,
        'theme_color'   => $theme_color,
        'icon'          => $icon,
        'bg_class'      => $bg_class,
        'text_class'    => $text_class,
        'members'       => 1,
        'posts'         => 0,
        'admin_id'      => $creator_id,
        'custom_topics' => $custom_topics,
    ]
]);
exit();
