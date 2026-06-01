<?php
if (!function_exists('getCommunityIconDetails')) {
    function getCommunityIconDetails($name, $category = null) {
        $name_lower = strtolower($name);
        $cat_lower = $category ? strtolower($category) : '';

        // Each entry: icon, bg hex (light tint), icon color hex (dark saturated shade)
        // Default fallback — FEU Tech / CPU / general
        $icon       = "bi-cpu";
        $bg_hex     = "#d1fae5"; // light emerald
        $color_hex  = "#065f46"; // deep emerald

        if (strpos($name_lower, 'life') !== false) {
            $icon      = "bi-heart-fill";
            $bg_hex    = "#fce7f3"; // light rose/pink
            $color_hex = "#9d174d"; // deep rose

        } elseif (strpos($name_lower, 'fresh') !== false || strpos($name_lower, 'study') !== false || strpos($name_lower, 'group') !== false) {
            $icon      = "bi-people-fill";
            $bg_hex    = "#dbeafe"; // light blue
            $color_hex = "#1e3a8a"; // deep blue

        } elseif (strpos($name_lower, 'food') !== false || strpos($name_lower, 'trip') !== false) {
            $icon      = "bi-cup-hot-fill";
            $bg_hex    = "#fef3c7"; // light amber
            $color_hex = "#92400e"; // deep amber/brown

        } elseif (strpos($name_lower, 'cosplay') !== false || strpos($name_lower, 'artist') !== false || strpos($name_lower, 'culture') !== false || strpos($name_lower, 'hub') !== false) {
            $icon      = "bi-palette-fill";
            $bg_hex    = "#e0f2fe"; // light cyan
            $color_hex = "#0c4a6e"; // deep cyan/navy

        } elseif (strpos($name_lower, 'enroll') !== false || strpos($name_lower, 'thesis') !== false || strpos($name_lower, 'advice') !== false) {
            $icon      = "bi-journal-bookmark-fill";
            $bg_hex    = "#ede9fe"; // light violet
            $color_hex = "#4c1d95"; // deep violet

        } elseif (strpos($name_lower, 'innovat') !== false) {
            $icon      = "bi-lightbulb-fill";
            $bg_hex    = "#fff7ed"; // light orange
            $color_hex = "#7c2d12"; // deep burnt orange

        } elseif ($cat_lower === "feu alabang") {
            $icon      = "bi-building-fill";
            $bg_hex    = "#fef9c3"; // light yellow
            $color_hex = "#713f12"; // deep yellow-brown

        } elseif ($cat_lower === "feu diliman") {
            $icon      = "bi-mortarboard-fill";
            $bg_hex    = "#dbeafe"; // light blue
            $color_hex = "#1e3a8a"; // deep blue
        }

        return [
            'icon'       => $icon,
            'bg_hex'     => $bg_hex,
            'color_hex'  => $color_hex,
            // Keep legacy keys for backward compatibility
            'bg_class'   => '',
            'text_class' => ''
        ];
    }
}

if (!function_exists('getCategoryBadgeStyle')) {
    function getCategoryBadgeStyle($category) {
        $cat = strtoupper(trim($category));
        switch ($cat) {
            case 'NEWS':
                return 'background-color: #8b5cf6; color: #ffffff;'; // Purple
            case 'TECHNOLOGY':
            case 'AI':
                return 'background-color: #10b981; color: #ffffff;'; // Emerald/Teal
            case 'CULTURE':
            case 'CREATIVE':
            case 'MUSIC':
                return 'background-color: #ec4899; color: #ffffff;'; // Pink
            case 'GAMING':
            case 'SPORTS':
                return 'background-color: #f97316; color: #ffffff;'; // Orange
            case 'FEU':
            case 'ACADEMICS':
                return 'background-color: #eab308; color: #ffffff;'; // Gold/Yellow
            case 'IDEAS':
            case 'LIFESTYLE':
                return 'background-color: #06b6d4; color: #ffffff;'; // Cyan
            default:
                return 'background-color: #6b7280; color: #ffffff;'; // Gray
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

<script>
  window.currentUser = {
    identification: <?php echo json_encode($identification); ?>,
    displayName: <?php echo json_encode($ACCOUNT['display_name'] ?? 'Guest'); ?>,
    avatar: <?php echo json_encode($ACCOUNT['avatar_md'] ?? '/Discourse/assets/images/anonymous.png'); ?>
  };
</script>