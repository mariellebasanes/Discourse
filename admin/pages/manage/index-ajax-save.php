<?php

define('MBG', TRUE);

DIRECT_ACCESS_BLOCKED();

$response = [
  'status' => 'success',
  'message' => 'Record has been successfully saved from the database.'
];

header('Content-Type: application/json');
echo json_encode($response);
exit();

?>
