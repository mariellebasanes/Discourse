<?php
define('MBG', TRUE);
include_once(dirname(__DIR__) . '/functions-new.php');

$id = isset($_GET['id']) ? trim($_GET['id']) : '';

if (empty($id) || $id === $identification) {
    include('index-inc-profile-view.php');
} else {
    include('index-inc-profile-other.php');
}
?>
