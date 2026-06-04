<?php
// Functions removed and separated to functions-new.php
?>
<div id="kt_app_header" class="app-header bg-white" data-kt-sticky="true"
  data-kt-sticky-activate="{default: true, lg: true}" data-kt-sticky-name="app-header-minimize"
  data-kt-sticky-offset="{default: '200px', lg: '0'}" data-kt-sticky-animation="false">

  <div class="app-container container-xxl d-none justify-content-start align-items-center position-absolute h-100 bg-white"
    style="z-index: 999;">
    <div id="search-box"></div>
  </div>

  <div class="app-container container-xxl d-flex align-items-stretch justify-content-between" id="kt_app_header_container">

    <div class="app-navbar flex-shrink-0">
      <?php 
      $widget_path = $_SERVER['DOCUMENT_ROOT'] . '/includes/widget-applications-browser.php';
      if (file_exists($widget_path)) {
          include($widget_path);
      }
      ?>
      <a href="/Discourse/index.php" onclick="KTApp.showPageLoading()" class="d-flex align-items-center ms-4">
        <img src="/Discourse/assets/images/Discourse-logo.png" class="h-70px me-2">
      </a>
    </div>

    <div class="d-flex align-items-stretch justify-content-end" id="kt_app_header_wrapper">
      <div class="app-navbar flex-shrink-0 align-items-center">

        <!-- Communities Link -->
        <div class="app-navbar-item ms-1 ms-md-3">
          <a href="/Discourse/communities/index.php" class="btn btn-icon btn-custom btn-active-color-primary w-35px h-35px w-md-40px h-md-40px" title="Communities" onclick="KTApp.showPageLoading()">
            <i class="bi bi-people fs-2 text-gray-700"></i>
          </a>
        </div>

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
          $login_widget = $_SERVER['DOCUMENT_ROOT'] . '/includes/widget-app-item-login.php';
          $hamburger_widget = $_SERVER['DOCUMENT_ROOT'] . '/includes/widget-app-item-hamburger.php';
          if (file_exists($login_widget)) {
              include($login_widget);
          }
          if (file_exists($hamburger_widget)) {
              include($hamburger_widget);
          }
          ?>
        </div>

      </div>
    </div>
  </div>
</div>

<script>
  window.currentUser = {
    identification: <?php echo json_encode($identification); ?>,
    displayName: <?php echo json_encode($ACCOUNT['display_name'] ?? 'Guest'); ?>,
    avatar: <?php echo json_encode($ACCOUNT['avatar_md'] ?? '/Discourse/assets/images/anonymous.png'); ?>
  };

  // Custom UI alert system to replace native alert() popups
  window.showUiAlert = function(type, message) {
      var container = document.getElementById('ui-toast-container');
      if (!container) {
          container = document.createElement('div');
          container.id = 'ui-toast-container';
          container.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 999999; display: flex; flex-direction: column; gap: 10px; pointer-events: none;';
          document.body.appendChild(container);
      }
      
      var toast = document.createElement('div');
      toast.style.cssText = 'min-width: 300px; max-width: 400px; background: #fff; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.15); padding: 16px; border-left: 5px solid #1A8B44; pointer-events: auto; opacity: 0; transform: translateY(-20px); transition: opacity 0.3s ease, transform 0.3s ease; display: flex; align-items: start; gap: 12px; font-family: Inter, sans-serif;';
      
      var iconHtml = '<i class="bi bi-info-circle-fill text-info fs-4"></i>';
      if (type === 'error') {
          toast.style.borderLeftColor = '#f1416c';
          iconHtml = '<i class="bi bi-exclamation-circle-fill text-danger fs-4"></i>';
      } else if (type === 'warning') {
          toast.style.borderLeftColor = '#ffc700';
          iconHtml = '<i class="bi bi-exclamation-triangle-fill text-warning fs-4"></i>';
      } else if (type === 'success') {
          toast.style.borderLeftColor = '#50cd89';
          iconHtml = '<i class="bi bi-check-circle-fill text-success fs-4"></i>';
      }
      
      toast.innerHTML = iconHtml + 
          '<div style="flex-grow: 1; text-align: left;">' +
          '  <div style="font-weight: 700; color: #181c32; font-size: 13px; text-transform: uppercase; margin-bottom: 2px;">' + type + '</div>' +
          '  <div style="color: #5e6278; font-size: 12.5px; line-height: 1.4;">' + message + '</div>' +
          '</div>' +
          '<button type="button" style="background: none; border: none; color: #a1a5b7; font-size: 18px; cursor: pointer; padding: 0; line-height: 1; font-weight: bold;">&times;</button>';
          
      toast.querySelector('button').onclick = function() {
          toast.style.opacity = '0';
          toast.style.transform = 'translateY(-20px)';
          setTimeout(function() { toast.remove(); }, 300);
      };
      
      container.appendChild(toast);
      
      // Trigger transition
      setTimeout(function() {
          toast.style.opacity = '1';
          toast.style.transform = 'translateY(0)';
      }, 10);
      
      // Auto-remove after 4 seconds
      setTimeout(function() {
          if (toast.parentNode) {
              toast.style.opacity = '0';
              toast.style.transform = 'translateY(-20px)';
              setTimeout(function() { toast.remove(); }, 300);
          }
      }, 4000);
  };

  // Override standard window.alert
  window.alert = function(msg) {
      if (!msg) return;
      var type = 'error';
      var lower = msg.toLowerCase();
      if (lower.indexOf('success') !== -1 || lower.indexOf('posted') !== -1 || lower.indexOf('deleted') !== -1 || lower.indexOf('updated') !== -1) {
          type = 'success';
      } else if (lower.indexOf('warning') !== -1 || lower.indexOf('please') !== -1 || lower.indexOf('cannot') !== -1 || lower.indexOf('required') !== -1 || lower.indexOf('select') !== -1) {
          type = 'warning';
      }
      window.showUiAlert(type, msg);
  };

  // On page load, check for status or error in URL parameters and display toast
  window.addEventListener('DOMContentLoaded', function() {
      var urlParams = new URLSearchParams(window.location.search);
      if (urlParams.has('status')) {
          var status = urlParams.get('status');
          if (status === 'success') {
              window.showUiAlert('success', 'Action completed successfully!');
          } else if (status === 'post_success') {
              window.showUiAlert('success', 'Post created successfully!');
          } else if (status === 'post_error') {
              window.showUiAlert('error', 'Failed to create post. Please try again.');
          } else if (status === 'error') {
              window.showUiAlert('error', 'An error occurred.');
          }
      }
      if (urlParams.has('error')) {
          var error = urlParams.get('error');
          if (error === 'missing_fields') {
              window.showUiAlert('warning', 'Please fill in all required fields.');
          } else {
              window.showUiAlert('error', error.replace(/_/g, ' '));
          }
      }
  });
</script>
