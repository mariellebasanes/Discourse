<?php

define('MBG', TRUE);

DIRECT_ACCESS_BLOCKED();
//SESSION_TIMEOUT_BLOCKED();

$id = intval($_POST['id']);
$tableKey = htmlspecialchars($_POST['table'], ENT_QUOTES, 'UTF-8');

// Input validation
if ($id <= 0 || empty($tableKey)) {
  echo json_encode([
    'status' => 'error',
    'message' => 'Invalid input data.'
  ]);
  exit;
}

$SQL->close();

header('Content-Type: application/json');
echo json_encode($response);
exit;
