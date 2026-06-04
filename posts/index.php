<?php
define('MBG', TRUE);
include_once(dirname(__DIR__) . '/functions-new.php');

if (isset($_GET['action'])) {
    if ($_GET['action'] === 'create') {
        include('index-inc-post-create.php');
    } elseif ($_GET['action'] === 'edit') {
        include('index-inc-post-edit.php');
    } else {
        if (isset($_GET['id'])) {
            include('index-inc-post-view.php');
        } else {
            header("Location: /Discourse/index.php");
            exit();
        }
    }
} elseif (isset($_GET['id'])) {
    include('index-inc-post-view.php');
} else {
    header("Location: /Discourse/index.php");
    exit();
}
?>
