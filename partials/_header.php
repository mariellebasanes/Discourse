<div id="kt_app_header" class="app-header bg-white" data-kt-sticky="true"
  data-kt-sticky-activate="{default: true, lg: true}" data-kt-sticky-name="app-header-minimize"
  data-kt-sticky-offset="{default: '200px', lg: '0'}" data-kt-sticky-animation="false">

  <div
    class="app-container container-xxl d-none justify-content-start align-items-center position-absolute h-100 bg-white"
    style="z-index: 999;">
    <div id="search-box"></div>
  </div>

  <div class="app-container container-xxl d-flex align-items-stretch justify-content-between "
    id="kt_app_header_container">

    <div class="app-navbar flex-shrink-0">
      <!-- App Browser Icon -->
      <div class="app-navbar-item me-3">
        <a href="#" class="btn btn-icon btn-custom btn-icon-muted btn-active-light w-35px h-35px">
          <span class="svg-icon svg-icon-1">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><rect x="2" y="2" width="9" height="9" rx="2" fill="currentColor"/><rect opacity="0.3" x="13" y="2" width="9" height="9" rx="2" fill="currentColor"/><rect opacity="0.3" x="13" y="13" width="9" height="9" rx="2" fill="currentColor"/><rect opacity="0.3" x="2" y="13" width="9" height="9" rx="2" fill="currentColor"/></svg>
          </span>
        </a>
      </div>
      <a href="/Discourse/index.php" onclick="KTApp.showPageLoading()" class="d-flex align-items-center text-decoration-none">
        <div class="d-flex align-items-center">
          <span class="svg-icon svg-icon-2hx svg-icon-success me-2">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path opacity="0.3" d="M2 4V16C2 16.6 2.4 17 3 17H13L16.6 20.6C17.1 21.1 18 20.8 18 20V17H21C21.6 17 22 16.6 22 16V4C22 3.4 21.6 3 21 3H3C2.4 3 2 3.4 2 4Z" fill="currentColor"></path>
                  <path d="M18 9H6C5.4 9 5 8.6 5 8C5 7.4 5.4 7 6 7H18C18.6 7 19 7.4 19 8C19 8.6 18.6 9 18 9ZM16 12C16 11.4 15.6 11 15 11H6C5.4 11 5 11.4 5 12C5 12.6 5.4 13 6 13H15C15.6 13 16 12.6 16 12Z" fill="currentColor"></path>
              </svg>
          </span>
          <span class="fs-1 fw-bolder" style="color: #FFB800;">Discourse</span>
        </div>
      </a>
    </div>

    <div class="d-flex align-items-stretch justify-content-end flex-lg-grow-1" id="kt_app_header_wrapper">

      <div class="app-header-menu app-header-mobile-drawer align-items-stretch " data-kt-drawer="true"
        data-kt-drawer-name="app-header-menu" data-kt-drawer-activate="{default: true, lg: false}"
        data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="end"
        data-kt-drawer-toggle="#kt_app_header_menu_toggle" data-kt-swapper="true"
        data-kt-swapper-mode="{default: 'append', lg: 'prepend'}"
        data-kt-swapper-parent="{default: '#kt_app_body', lg: '#kt_app_header_wrapper'}">
        <div
          class=" menu menu-rounded menu-column menu-lg-row my-5 my-lg-0 align-items-stretch fw-semibold px-2 px-lg-0"
          id="kt_app_header_menu" data-kt-menu="true">

          <div class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">
            <a href="/badges" onclick="KTApp.showPageLoading()" class="menu-link text-hover-primary">
              <span class="menu-title">Badges</span>
            </a>
          </div>

        </div>
      </div>

      <div class="app-navbar flex-shrink-0">
        <!-- Notification Bell -->
        <div class="app-navbar-item me-3">
          <a href="#" class="btn btn-icon btn-custom btn-icon-muted btn-active-light w-35px h-35px position-relative">
            <i class="fas fa-bell fs-4"></i>
          </a>
        </div>
        <!-- User Avatar -->
        <div class="app-navbar-item">
          <a href="/Discourse/pages/version/profile.php" class="cursor-pointer symbol symbol-35px">
            <div class="symbol-label fs-7 fw-bold bg-success text-inverse-success">U</div>
          </a>
        </div>
      </div>

    </div>

  </div>
</div>
