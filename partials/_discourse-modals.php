<div class="dropdown-menu p-0 discourse-notif-dropdown" id="discourseNotifDropdown" aria-labelledby="discourseNotifBell">

  <!-- Header — d-flex/align-items/justify-content replaces .discourse-notif-header -->
  <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
    <span class="fw-bold text-gray-800 fs-6">Notifications</span>
    <button class="btn btn-sm btn-link text-success p-0 fw-bold fs-7 text-decoration-none" id="discourse-mark-all-read">
      Mark all read
    </button>
  </div>

  <!-- List — max-height scroll kept in CSS (.discourse-notif-list) -->
  <div class="discourse-notif-list">

    <!-- Unread notification -->
    <div class="d-flex align-items-start gap-3 px-4 py-3 border-bottom bg-light-success discourse-notif-unread">
      <span class="discourse-notif-dot flex-shrink-0 mt-1"></span>
      <div class="flex-grow-1 overflow-hidden">
        <p class="fs-7 text-gray-700 mb-1">
          <strong class="text-gray-800">Miguel Reyes</strong> upvoted your post "Best AI tools for BSCS students"
        </p>
        <span class="fs-8 text-muted">2 minutes ago</span>
      </div>
    </div>

    <!-- Unread notification -->
    <div class="d-flex align-items-start gap-3 px-4 py-3 border-bottom bg-light-success discourse-notif-unread">
      <span class="discourse-notif-dot flex-shrink-0 mt-1"></span>
      <div class="flex-grow-1 overflow-hidden">
        <p class="fs-7 text-gray-700 mb-1">
          <strong class="text-gray-800">Anonymous</strong> replied to your comment in "Which IDE do you use for Java?"
        </p>
        <span class="fs-8 text-muted">18 minutes ago</span>
      </div>
    </div>

    <!-- Unread notification -->
    <div class="d-flex align-items-start gap-3 px-4 py-3 border-bottom bg-light-success discourse-notif-unread">
      <span class="discourse-notif-dot flex-shrink-0 mt-1"></span>
      <div class="flex-grow-1 overflow-hidden">
        <p class="fs-7 text-gray-700 mb-1">
          <strong class="text-gray-800">Aika Tan</strong> started following you
        </p>
        <span class="fs-8 text-muted">1 hour ago</span>
      </div>
    </div>

    <!-- Read notification -->
    <div class="d-flex align-items-start gap-3 px-4 py-3 border-bottom">
      <span class="discourse-notif-dot discourse-notif-dot-read flex-shrink-0 mt-1"></span>
      <div class="flex-grow-1 overflow-hidden">
        <p class="fs-7 text-gray-700 mb-1">
          Your post "Rust in 2025" reached 50 upvotes 🎉
        </p>
        <span class="fs-8 text-muted">Yesterday</span>
      </div>
    </div>

    <!-- Read notification -->
    <div class="d-flex align-items-start gap-3 px-4 py-3">
      <span class="discourse-notif-dot discourse-notif-dot-read flex-shrink-0 mt-1"></span>
      <div class="flex-grow-1 overflow-hidden">
        <p class="fs-7 text-gray-700 mb-1">
          <strong class="text-gray-800">Juan Santos</strong> commented on "FEU enrollment tips"
        </p>
        <span class="fs-8 text-muted">2 days ago</span>
      </div>
    </div>

  </div>
</div>


<!-- ══════════════════════════════════════════════════════════
     2. PROFILE DROPDOWN
══════════════════════════════════════════════════════════ -->
<div class="dropdown-menu p-0 discourse-profile-dropdown" id="discourseProfileDropdown" aria-labelledby="discourseProfileAvatar">


  <div class="discourse-profile-top d-flex align-items-center gap-3 p-4">
    <img src="assets/images/catalina.webp" alt="Catalina Smith"
      class="discourse-profile-avatar-lg rounded-circle flex-shrink-0" />
    <div class="d-flex flex-column gap-1 flex-grow-1 overflow-hidden">
      <span class="fs-6 fw-bolder text-white lh-sm">Catalina Smith</span>
      <span class="fs-8 text-white opacity-75 lh-sm">T202210292 · BS Information Technology</span>
      <span class="discourse-profile-verified">
        <i class="bi bi-shield-check me-1"></i> Verified Student
      </span>
    </div>
  </div>

  <div class="d-flex justify-content-around align-items-center py-3 border-bottom border-top">
    <div class="d-flex flex-column align-items-center">
      <span class="fs-5 fw-bolder text-gray-800 lh-1">304</span>
      <span class="fs-8 fw-bold text-muted text-uppercase mt-1">Karma</span>
    </div>
    <div class="d-flex flex-column align-items-center">
      <span class="fs-5 fw-bolder text-gray-800 lh-1">3</span>
      <span class="fs-8 fw-bold text-muted text-uppercase mt-1">Posts</span>
    </div>
    <div class="d-flex flex-column align-items-center">
      <span class="fs-5 fw-bolder text-gray-800 lh-1">7</span>
      <span class="fs-8 fw-bold text-muted text-uppercase mt-1">Comments</span>
    </div>
    <div class="d-flex flex-column align-items-center">
      <span class="fs-5 fw-bolder text-gray-800 lh-1">1</span>
      <span class="fs-8 fw-bold text-muted text-uppercase mt-1">Saved</span>
    </div>
  </div>

  <div class="px-2 py-2 border-bottom">
    <span class="d-block fs-8 fw-bolder text-muted text-uppercase px-3 py-1 ls-1">Account</span>
    <a href="#profile" class="d-flex align-items-center fs-7 text-gray-700 text-hover-success text-decoration-none px-3 py-2 rounded-3">
      <i class="bi bi-person me-3 text-muted fs-6" style="width:16px;text-align:center;"></i> View My Profile
    </a>
    <a href="#profile" class="d-flex align-items-center fs-7 text-gray-700 text-hover-success text-decoration-none px-3 py-2 rounded-3">
      <i class="bi bi-file-text me-3 text-muted fs-6" style="width:16px;text-align:center;"></i> My Posts
    </a>
    <a href="#profile" class="d-flex align-items-center fs-7 text-gray-700 text-hover-success text-decoration-none px-3 py-2 rounded-3">
      <i class="bi bi-chat-left-text me-3 text-muted fs-6" style="width:16px;text-align:center;"></i> My Comments
    </a>
    <a href="#profile" class="d-flex align-items-center fs-7 text-gray-700 text-hover-success text-decoration-none px-3 py-2 rounded-3">
      <i class="bi bi-hand-thumbs-up me-3 text-muted fs-6" style="width:16px;text-align:center;"></i> Liked Posts
    </a>
    <a href="#profile" class="d-flex align-items-center fs-7 text-gray-700 text-hover-success text-decoration-none px-3 py-2 rounded-3">
      <i class="bi bi-bookmark me-3 text-muted fs-6" style="width:16px;text-align:center;"></i> Saved Posts
    </a>
    <a href="#profile" class="d-flex align-items-center fs-7 text-gray-700 text-hover-success text-decoration-none px-3 py-2 rounded-3">
      <i class="bi bi-people me-3 text-muted fs-6" style="width:16px;text-align:center;"></i> My Communities
    </a>
  </div>

  <!-- Settings Links -->
  <div class="px-2 py-2 border-bottom">
    <span class="d-block fs-8 fw-bolder text-muted text-uppercase px-3 py-1 ls-1">Settings</span>
    <a href="#profile" class="d-flex align-items-center fs-7 text-gray-700 text-hover-success text-decoration-none px-3 py-2 rounded-3">
      <i class="bi bi-gear me-3 text-muted fs-6" style="width:16px;text-align:center;"></i> Settings
    </a>
    <a href="#profile" class="d-flex align-items-center fs-7 text-gray-700 text-hover-success text-decoration-none px-3 py-2 rounded-3">
      <i class="bi bi-shield-lock me-3 text-muted fs-6" style="width:16px;text-align:center;"></i> Privacy and Security
    </a>
    <a href="#profile" class="d-flex align-items-center fs-7 text-gray-700 text-hover-success text-decoration-none px-3 py-2 rounded-3">
      <i class="bi bi-grid-3x3-gap me-3 text-muted fs-6" style="width:16px;text-align:center;"></i> Paraverse Portal
    </a>
  </div>

  <!-- Log Out -->
  <div class="px-2 py-2">
    <a href="#" class="d-flex align-items-center fs-7 fw-bold text-danger text-hover-danger text-decoration-none px-3 py-2 rounded-3">
      <i class="bi bi-box-arrow-right me-3 fs-6" style="width:16px;text-align:center;"></i> Log Out
    </a>
  </div>

</div>


<!-- ══════════════════════════════════════════════════════════
     3. REPORT POST MODAL
══════════════════════════════════════════════════════════ -->
<div class="modal fade" id="modalReportPost" tabindex="-1" aria-labelledby="modalReportPostLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered discourse-report-dialog">
    <div class="modal-content discourse-report-content">

      <div class="modal-header border-bottom px-5 py-4">
        <h5 class="modal-title fs-5 fw-bolder text-gray-800" id="modalReportPostLabel">
          <i class="bi bi-flag-fill text-danger me-2"></i> Report Post
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body px-5 py-5">
        <p class="fs-7 text-muted mb-5">Why are you reporting this post? Select the best reason.</p>

        <div class="d-flex flex-column gap-3" id="discourseReportOptions">

          <button class="discourse-report-option discourse-report-option-active" data-option="spam">
            <span class="discourse-report-option-icon discourse-report-icon-red"><i class="bi bi-x-circle-fill"></i></span>
            <span class="fs-7 fw-semibold text-gray-700">Content is spam or misleading</span>
          </button>

          <button class="discourse-report-option" data-option="irrelevant">
            <span class="discourse-report-option-icon discourse-report-icon-purple"><i class="bi bi-square-fill"></i></span>
            <span class="fs-7 fw-semibold text-gray-700">Not relevant to this community</span>
          </button>

          <button class="discourse-report-option" data-option="rules">
            <span class="discourse-report-option-icon discourse-report-icon-amber"><i class="bi bi-exclamation-triangle-fill"></i></span>
            <span class="fs-7 fw-semibold text-gray-700">Post violates community rules</span>
          </button>

          <button class="discourse-report-option" data-option="other">
            <span class="discourse-report-option-icon discourse-report-icon-gray"><i class="bi bi-three-dots"></i></span>
            <span class="fs-7 fw-semibold text-gray-700">Others</span>
          </button>
<textarea id="discourseReportOtherText"
  class="form-control form-control-solid fs-7 mt-1"
  rows="3"
  placeholder="Please describe the issue…"
  style="display:none;resize:none;"></textarea>
        </div>
      </div>

      <div class="modal-footer border-top px-5 py-4 gap-3">
        <button type="button" class="btn btn-success fw-bold flex-grow-1" id="discourseReportSubmit">
          <i class="bi bi-send me-2"></i> Submit Report
        </button>
        <button type="button" class="btn btn-light fw-bold" data-bs-dismiss="modal">Cancel</button>
      </div>

    </div>
  </div>
</div>
