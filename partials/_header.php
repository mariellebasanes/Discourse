<div id="kt_app_header" class="app-header bg-white" data-kt-sticky="true"
  data-kt-sticky-activate="{default: true, lg: true}" data-kt-sticky-name="app-header-minimize"
  data-kt-sticky-offset="{default: '200px', lg: '0'}" data-kt-sticky-animation="false">

  <div class="app-container container-xxl d-none justify-content-start align-items-center position-absolute h-100 bg-white"
    style="z-index: 999;">
    <div id="search-box"></div>
  </div>

  <div class="app-container container-xxl d-flex align-items-stretch justify-content-between" id="kt_app_header_container">

    <div class="app-navbar flex-shrink-0">
      <?php include($_SERVER['DOCUMENT_ROOT'] . '/includes/widget-applications-browser.php'); ?>
      <a href="/" onclick="KTApp.showPageLoading()" class="d-flex align-items-center ms-4">
        <img src="/Discourse/assets/images/Discourse-logo.png" class="h-70px me-2">
      </a>
    </div>

    <div class="d-flex align-items-stretch justify-content-end" id="kt_app_header_wrapper">
      <div class="app-navbar flex-shrink-0 align-items-center">

        <!-- 1. Notification Bell  -->
        <div class="app-navbar-item ms-1 ms-md-3" style="position: relative;">
          <?php
          $noti_partial = __DIR__ . '/_notification.php';

          if (file_exists($noti_partial)) {
            include($noti_partial);
          } else {
            echo '<b style="color:red; font-size:10px;">FILE NOT FOUND!</b>';
          }
          ?>
        </div>
      <!-- 2. Profile Pic — Clickable Dropdown -->
      <div class="app-navbar-item ms-1 ms-md-3" style="position:relative;">
        <?php
        $dropdown_partial = __DIR__ . '/_profile-dropdown.php';
        if (file_exists($dropdown_partial)) {
          include($dropdown_partial);
        } else {
          echo '<img src="/LAF/assets/images/catalina.webp" class="rounded-circle" style="width:40px;height:40px;" alt="user">';
        }
        ?>
      </div>

      <!-- Optional/Hidden Widgets -->
      <div class="d-none">
        <?php
        include($_SERVER['DOCUMENT_ROOT'] . '/includes/widget-app-item-login.php');
        include($_SERVER['DOCUMENT_ROOT'] . '/includes/widget-app-item-hamburger.php');
        ?>
      </div>

    </div>
  </div>
</div>
</div>