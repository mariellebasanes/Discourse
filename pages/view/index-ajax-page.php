<?php

define('MBG', TRUE);

DIRECT_ACCESS_BLOCKED();

$END_URL = $_GET['slug'] ?? '';
if (!$END_URL) {
  echo json_encode(['error' => 'Missing slug']);
  exit;
}

header('Content-Type: application/json');
echo json_encode($response);
