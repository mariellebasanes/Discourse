<?php

define('MBG', TRUE);
include($_SERVER['DOCUMENT_ROOT'] . "/functions-new.php");

$SQL = $NMAP->prepare("SELECT code, title, SUBSTRING(parallel, 2) AS parallel, college, program AS department, status AS network_map FROM courses");
//$SQL->bind_param("ss", $location, $identification);
$SQL->execute();
$result = $SQL->get_result();

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data['courses'] = $row;
    }
}

$jsonData = json_encode($data, JSON_PRETTY_PRINT);

$filename = "courses" . date("Y-m-d") . ".json";

header('Content-Type: application/json');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Content-Length: ' . strlen($jsonData));
echo $jsonData;

exit;

?>