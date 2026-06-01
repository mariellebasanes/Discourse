<?php

define('MBG', TRUE);
include(dirname(dirname(__DIR__)) . '/functions-new.php');


// IS_LOGGED_IN($_SERVER['REQUEST_URI']);

// $SQL = "SELECT * FROM table WHERE slug = ?";
// $SQL = $TABLE->prepare($SQL);
// $SQL->bind_param('s', $END_URL);
// $SQL->execute();
// $RESULT = $SQL->get_result();

// if($RESULT->num_rows == 0){
//     header("location: ../");
//     exit();
// }

// $RECORD = $RESULT->fetch_assoc();

// $META_TITLE = $RECORD['name'];
// $META_DESC = $RECORD['description'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php HEAD_ESSENTIALS(); ?>
</head>

<body id="kt_app_body" data-kt-app-page-loading-enabled="true" data-kt-app-page-loading="on"
  data-kt-app-layout="light-header" data-kt-app-header-fixed="true" data-kt-app-header-fixed-mobile="true"
  class="app-default">
  <?php include(dirname(dirname(__DIR__)) . '/partials/_page-loader.php'); ?>
  <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
    <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
      <?php include(dirname(dirname(__DIR__)) . '/partials/_header.php'); ?>
      <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
        <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
          <div class="d-flex flex-column flex-column-fluid">
            <main>
              <div id="kt_app_content" class="flex-column-fluid">
                <?php include('index-section-table.php'); ?>
              </div>
            </main>
          </div>
          <?php include(dirname(dirname(__DIR__)) . '/partials/_footer.php'); ?>
        </div>
      </div>
    </div>
  </div>
  <?php include(dirname(dirname(__DIR__)) . '/partials/_scrolltop.php'); ?>
</body>

</html>