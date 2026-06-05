<?php
define('MBG', TRUE);
include($_SERVER['DOCUMENT_ROOT'] . '/Discourse/functions-new.php');

//IS_LOGGED_IN($_SERVER['REQUEST_URI']);

$META_TITLE = "Dashboard · Discourse";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php HEAD_ESSENTIALS(); ?>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/css/dashboard.css" rel="stylesheet">
  <link href="assets/css/sec-hero.css" rel="stylesheet">
  <link href="assets/css/sec-sidebar.css" rel="stylesheet">
  <link href="assets/css/sec-search-filter.css" rel="stylesheet">
  <link href="assets/css/sec-posts.css?v=1.0.7" rel="stylesheet">
  <link href="assets/css/sec-modals.css?v=1.0.1" rel="stylesheet">
</head>

<body id="kt_app_body" data-kt-app-page-loading-enabled="true" data-kt-app-page-loading="on"
  data-kt-app-layout="light-header" class="app-default">
  <?php include("partials/_page-loader.php"); ?>
  <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
    <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
      <?php include("partials/_header.php"); ?>
      <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
        <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
          <div class="d-flex flex-column flex-column-fluid">
            <main>
              <div class="app-container container-xxl">

                <!-- 2-column layout: Left feed + Right sidebar -->
                <div class="discourse-dashboard-layout" id="discourse-dashboard">

                  <!-- ── LEFT COLUMN ──────────────────────────────────────── -->
                  <div class="discourse-feed-col">
                    <?php include("main/sec-hero.php"); ?>
                    <?php include("main/sec-search-filter.php"); ?>
                    <?php include("main/sec-posts.php"); ?>
                  </div>

                  <!-- ── RIGHT COLUMN ─────────────────────────────────────── -->
                  <div class="discourse-sidebar-col">
                    <?php include("main/sec-sidebar.php"); ?>
                  </div>

                </div>

                <?php include("partials/_discourse-modals.php"); ?>
              </div>
            </main>
          </div>
          <?php include("partials/_footer.php"); ?>
        </div>
      </div>
    </div>
  </div>
  <?php include("partials/_scrolltop.php"); ?>
  <script src="assets/js/dashboard.js"></script>
  <script src="assets/js/sec-hero.js"></script>
  <script src="assets/js/sec-sidebar.js"></script>
  <script src="assets/js/sec-search-filter.js"></script>
  <script src="assets/js/sec-posts.js?v=1.0.5"></script>
  <script src="assets/js/sec-modals.js"></script>
</body>

</html>