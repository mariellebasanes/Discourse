<?php
if (!function_exists('getCommunityIconDetails')) {
  function getCommunityIconDetails($name, $category = null)
  {
    $name_lower = strtolower($name);

    // Default: FEU Tech — matches sidebar: bg-light-success text-success, bi-cpu
    $icon       = "bi-cpu";
    $bg_class   = "bg-light-success";
    $text_class = "text-success";

    if (strpos($name_lower, 'life') !== false) {
      // FEU Life — matches sidebar: bg-light-danger text-danger, bi-heart-fill
      $icon       = "bi-heart-fill";
      $bg_class   = "bg-light-danger";
      $text_class = "text-danger";
    } elseif (strpos($name_lower, 'culture') !== false || strpos($name_lower, 'hub') !== false) {
      // CultureHub — matches sidebar: bg-light-primary text-primary, bi-music-note-beamed
      $icon       = "bi-music-note-beamed";
      $bg_class   = "bg-light-primary";
      $text_class = "text-primary";
    } elseif (strpos($name_lower, 'fresh') !== false || strpos($name_lower, 'study') !== false || strpos($name_lower, 'group') !== false) {
      $icon       = "bi-people-fill";
      $bg_class   = "bg-light-info";
      $text_class = "text-info";
    } elseif (strpos($name_lower, 'food') !== false || strpos($name_lower, 'trip') !== false) {
      $icon       = "bi-cup-hot-fill";
      $bg_class   = "bg-light-warning";
      $text_class = "text-warning";
    } elseif (strpos($name_lower, 'cosplay') !== false || strpos($name_lower, 'artist') !== false) {
      $icon       = "bi-palette-fill";
      $bg_class   = "bg-light-primary";
      $text_class = "text-primary";
    } elseif (strpos($name_lower, 'enroll') !== false || strpos($name_lower, 'thesis') !== false || strpos($name_lower, 'advice') !== false) {
      $icon       = "bi-journal-bookmark-fill";
      $bg_class   = "bg-light-warning";
      $text_class = "text-warning";
    } elseif (strpos($name_lower, 'innovat') !== false) {
      $icon       = "bi-lightbulb-fill";
      $bg_class   = "bg-light-warning";
      $text_class = "text-warning";
    } elseif (strpos($name_lower, 'alabang') !== false) {
      $icon       = "bi-building-fill";
      $bg_class   = "bg-light-warning";
      $text_class = "text-warning";
    } elseif (strpos($name_lower, 'diliman') !== false) {
      $icon       = "bi-mortarboard-fill";
      $bg_class   = "bg-light-info";
      $text_class = "text-info";
    }

    return [
      'icon'       => $icon,
      'bg_class'   => $bg_class,
      'text_class' => $text_class,
      // keep hex keys as empty so old code doesn't break
      'bg_hex'     => '',
      'color_hex'  => '',
    ];
  }
}

if (!function_exists('getCategoryBadgeStyle')) {
  function getCategoryBadgeStyle($category)
  {
    $cat = strtoupper(trim($category));
    switch ($cat) {
      case 'TECHNOLOGY':
        return ['class' => 'badge-light-primary',  'icon' => 'bi-cpu',               'icon_color' => 'text-primary'];
      case 'CULTURE':
        return ['class' => 'badge-light-danger',   'icon' => 'bi-palette',           'icon_color' => 'text-danger'];
      case 'GAMING':
        return ['class' => 'badge-light-warning',  'icon' => 'bi-controller',        'icon_color' => 'text-warning'];
      case 'FEU':
        return ['class' => 'badge-light-warning',  'icon' => 'bi-building',          'icon_color' => 'text-warning'];
      case 'IDEAS':
        return ['class' => 'badge-light-info',     'icon' => 'bi-lightbulb',         'icon_color' => 'text-info'];
      case 'CREATIVE':
        return ['class' => 'badge-light-primary',  'icon' => 'bi-stars',             'icon_color' => 'text-primary'];
      case 'SCIENCE':
        return ['class' => 'badge-light-info',     'icon' => 'bi-droplet-half',      'icon_color' => 'text-info'];
      case 'NEWS':
        return ['class' => 'badge-light-danger',   'icon' => 'bi-newspaper',         'icon_color' => 'text-danger'];
      case 'AI':
        return ['class' => 'badge-light-success',  'icon' => 'bi-robot',             'icon_color' => 'text-success'];
      case 'ACADEMICS':
        return ['class' => 'badge-light-warning',  'icon' => 'bi-book',              'icon_color' => 'text-warning'];
      case 'LIFESTYLE':
        return ['class' => 'badge-light-info',     'icon' => 'bi-emoji-smile',       'icon_color' => 'text-info'];
      case 'ENTERTAINMENT':
        return ['class' => 'badge-light-primary',  'icon' => 'bi-film',              'icon_color' => 'text-primary'];
      case 'MUSIC':
        return ['class' => 'badge-light-danger',   'icon' => 'bi-music-note',        'icon_color' => 'text-danger'];
      case 'POLITICS':
        return ['class' => 'badge-light-dark',     'icon' => 'bi-megaphone',         'icon_color' => 'text-dark'];
      case 'ISSUES':
        return ['class' => 'badge-light-danger',   'icon' => 'bi-exclamation-circle', 'icon_color' => 'text-danger'];
      case 'SPORTS':
        return ['class' => 'badge-light-warning',  'icon' => 'bi-trophy',            'icon_color' => 'text-warning'];
      default:
        return ['class' => 'badge-light-secondary', 'icon' => 'bi-tag',               'icon_color' => 'text-secondary'];
    }
  }
}
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
      <?php include($_SERVER['DOCUMENT_ROOT'] . '/includes/widget-applications-browser.php'); ?>
      <a href="/Discourse/index.php" onclick="KTApp.showPageLoading()" class="d-flex align-items-center ms-4">
        <img src="/Discourse/assets/images/Discourse-logo.png" class="h-70px me-2">
      </a>
    </div>

    <div class="d-flex align-items-stretch justify-content-end" id="kt_app_header_wrapper">
      <div class="app-navbar flex-shrink-0 align-items-center">

        <!-- Communities Link -->
        <div class="app-navbar-item ms-1 ms-md-3">
          <a href="/Discourse/pages/version/community-home-page.php" class="btn btn-icon btn-custom btn-active-color-primary w-35px h-35px w-md-40px h-md-40px" title="Communities" onclick="KTApp.showPageLoading()">
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
          include($_SERVER['DOCUMENT_ROOT'] . '/includes/widget-app-item-login.php');
          include($_SERVER['DOCUMENT_ROOT'] . '/includes/widget-app-item-hamburger.php');
          ?>
        </div>

      </div>
    </div>
  </div>
</div>