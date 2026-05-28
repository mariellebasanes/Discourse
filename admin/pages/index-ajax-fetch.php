<?php

define('MBG', TRUE);
DIRECT_ACCESS_BLOCKED();

$sql_details = array(
  'user' => '',
  'pass' => '',
  'db' => '',
  'host' => ''
);

$table = '';
$primaryKey = '';

$columns = array(
  array(
    'db' => 'id',
    'dt' => 0,
    'formatter' => fn($d, $row) => htmlspecialchars($d)
  ),
);


$extraWhere = "1=1";

require($_SERVER['DOCUMENT_ROOT'] . '/assets/_datatables-ssp.php');
echo json_encode(
  SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, null, $extraWhere)
);


?>
