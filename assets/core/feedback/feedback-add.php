<?php

define('MBG', TRUE);
include($_SERVER['DOCUMENT_ROOT'] . "/functions-new.php");

DIRECT_ACCESS_BLOCKED();

if (!empty($identification)) {
    $type = sanitize($_POST['type']);
    $feedback = sanitize($_POST['description']);
    $location = sanitize($_POST['location']);

    $SQL = $EDITH->prepare("INSERT INTO feedback (type, feedback, identification, location) VALUES (?, ?, ?, ?)");
    $SQL->bind_param("ssss", $type, $feedback, $identification, $location);
    $SQL->execute();
    $SQL->close();
}

?>