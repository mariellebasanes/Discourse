<?php
define('MBG', TRUE);
include($_SERVER['DOCUMENT_ROOT'] . '/sample/functions-new.php');

IS_LOGGED_IN($_SERVER['REQUEST_URI']);

$META_TITLE = "Management";
$META_DESC = "Create and edit information";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php HEAD_ESSENTIALS(); ?>
  <link href="/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
  <script src="/assets/plugins/custom/datatables/datatables.bundle.js" defer></script>
</head>

<body id="kt_app_body" data-kt-app-page-loading-enabled="true" data-kt-app-page-loading="on"
  data-kt-app-layout="light-header" data-kt-app-header-fixed="true" data-kt-app-header-fixed-mobile="true"
  class="app-default">
  <?php include($_SERVER['DOCUMENT_ROOT'] . "/sample/partials/_page-loader.php"); ?>
  <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
    <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
      <?php include($_SERVER['DOCUMENT_ROOT'] . "/sample/partials/_header.php"); ?>
      <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
        <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
          <div class="d-flex flex-column flex-column-fluid">
            <main>
              <div id="kt_app_content" class="app-content flex-column-fluid">
                <div id="kt_app_content_container" class="app-container container-xxl">
                  <?php include("index-inc-table.php"); ?>
                </div>
              </div>
            </main>
          </div>
          <?php include($_SERVER['DOCUMENT_ROOT'] . "/sample/partials/_footer.php"); ?>
        </div>
      </div>
    </div>
  </div>
  <?php include($_SERVER['DOCUMENT_ROOT'] . "/sample/partials/_scrolltop.php"); ?>
</body>

</html>
