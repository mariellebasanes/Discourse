<?php
define('MBG', TRUE);
include_once(dirname(dirname(__DIR__)) . '/functions-new.php');
header('Content-Type: application/json');

$community = isset($_GET['c']) ? trim($_GET['c']) : '';

$global_topics = ["Technology","Culture","Gaming","FEU","Ideas","Creative","Science","News","AI","Academics","Lifestyle","Entertainment","Music","Politics","Issues","Sports","Others"];

if (empty($community) || !$EDITH) {
    echo json_encode(['topics' => $global_topics, 'source' => 'global']);
    exit;
}

$esc = $EDITH->real_escape_string($community);
$r = $EDITH->query("SELECT custom_topics FROM communities WHERE title='$esc' LIMIT 1");
$row = $r ? $r->fetch_assoc() : null;

if ($row && !empty($row['custom_topics'])) {
    $custom = array_filter(array_map('trim', explode(',', $row['custom_topics'])));
    echo json_encode(['topics' => array_values($custom), 'source' => 'custom']);
} else {
    echo json_encode(['topics' => $global_topics, 'source' => 'global']);
}
exit;
