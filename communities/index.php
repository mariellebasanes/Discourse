<?php
define('MBG', TRUE);
include_once(dirname(__DIR__) . '/functions-new.php');

if (isset($_GET['c'])) {
    include('index-inc-community-view.php');
} else {
    include('index-inc-community-list.php');
}
?>
