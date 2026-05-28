<?php
// Sample user data 
$user_name   = 'Catalina Smith';
$user_id     = 'T202210292';
$user_avatar = '/LAF/assets/images/catalina.webp';
?>

<div id="profile-trigger" style="position:relative; display:inline-block; vertical-align:middle;">
  <img src="<?= htmlspecialchars($user_avatar) ?>"
    id="avatar-btn"
    class="rounded-circle border border-2 border-gray-200 w-40px h-40px object-fit-cover cursor-pointer d-block"
    alt="user" />
</div>

<div id="profile-dropdown" class="discourse-profile-dropdown card shadow-lg menu menu-sub menu-sub-dropdown border border-gray-200" style="
  display: none;
  position: fixed;
  background: #fff;
  z-index: 99999;
  width: 320px;
  border-radius: 1rem !important;
  overflow: hidden;
  opacity: 0;
  transform: translateY(-6px);
  transition: opacity .18s ease, transform .18s ease;
">
  
  <div class="discourse-profile-top d-flex align-items-center gap-3 px-5 py-4" style="background: linear-gradient(180deg, #e4f4ec 0%, #f4faf7 100%); border-bottom: 1px solid #edf2f0;">
    <img src="<?= htmlspecialchars($user_avatar) ?>" alt="avatar" class="discourse-profile-avatar-lg rounded-circle border border-2 border-white" style="width: 52px; height: 52px; object-fit: cover;">
    <div class="discourse-profile-info d-flex flex-column min-width-0">
      <div class="discourse-profile-name text-gray-900 fw-bolder text-truncate fs-4"><?= htmlspecialchars($user_name) ?></div>
      <div class="discourse-profile-id text-muted text-truncate fs-6 mt-1"><?= htmlspecialchars($user_id) ?> · BS Information Technology</div>
      <div class="discourse-profile-verified badge d-inline-flex align-items-center px-2 py-1 mt-1 fw-bold align-self-start fs-8" style="background-color: #d2edd9; color: #1f4e39; border: 1px solid #b8dfc4; border-radius: 20px; gap: 4px;">
        <i class="bi bi-shield-check fs-8"></i> ?????
      </div>
    </div>
  </div>

  <div class="discourse-profile-stats-row d-flex justify-content-around align-items-center py-3 bg-light-opacity-50 border-bottom border-gray-100">
    <div class="discourse-profile-stat d-flex flex-column align-items-center">
      <span class="discourse-profile-stat-val text-gray-900 fw-bolder fs-2">304</span>
      <span class="discourse-profile-stat-label text-muted fw-bold text-uppercase fs-8" style="letter-spacing: 0.05em; margin-top: 4px;">Karma</span>
    </div>
    <div class="discourse-profile-stat d-flex flex-column align-items-center">
      <span class="discourse-profile-stat-val text-gray-900 fw-bolder fs-2">3</span>
      <span class="discourse-profile-stat-label text-muted fw-bold text-uppercase fs-8" style="letter-spacing: 0.05em; margin-top: 4px;">Posts</span>
    </div>
    <div class="discourse-profile-stat d-flex flex-column align-items-center">
      <span class="discourse-profile-stat-val text-gray-900 fw-bolder fs-2">7</span>
      <span class="discourse-profile-stat-label text-muted fw-bold text-uppercase fs-8" style="letter-spacing: 0.05em; margin-top: 4px;">Comments</span>
    </div>
    <div class="discourse-profile-stat d-flex flex-column align-items-center">
      <span class="discourse-profile-stat-val text-gray-900 fw-bolder fs-2">1</span>
      <span class="discourse-profile-stat-label text-muted fw-bold text-uppercase fs-8" style="letter-spacing: 0.05em; margin-top: 4px;">Saved</span>
    </div>
  </div>

  <div style="max-height: 320px; overflow-y: auto;" class="py-2 px-2">
    
    <div class="discourse-profile-section d-flex flex-column gap-1 mb-2">
      <span class="discourse-profile-section-label text-muted fw-bolder text-uppercase px-3 py-1 fs-8" style="letter-spacing: 0.08em;">Account</span>
      <a href="/profile" class="discourse-profile-link nav-link text-gray-700 bg-hover-light-success rounded px-3 py-2 d-flex align-items-center gap-3 fs-6"><i class="bi bi-person-circle text-muted fs-6"></i> View My Profile</a>
      <a href="/my-posts" class="discourse-profile-link nav-link text-gray-700 bg-hover-light-success rounded px-3 py-2 d-flex align-items-center gap-3 fs-6"><i class="bi bi-journal-text text-muted fs-6"></i> My Posts</a>
      <a href="/LAF/pages/lost-item-reports/index.php" class="discourse-profile-link nav-link text-gray-700 bg-hover-light-success rounded px-3 py-2 d-flex align-items-center gap-3 fs-6"><i class="bi bi-chat-left-text-fill text-muted fs-6"></i> My Comments</a>
      <a href="/liked-posts" class="discourse-profile-link nav-link text-gray-700 bg-hover-light-success rounded px-3 py-2 d-flex align-items-center gap-3 fs-6"><i class="bi bi-hand-thumbs-up-fill text-muted fs-6"></i> Liked Posts</a>
      <a href="/saved-posts" class="discourse-profile-link nav-link text-gray-700 bg-hover-light-success rounded px-3 py-2 d-flex align-items-center gap-3 fs-6"><i class="bi bi-bookmark-fill text-muted fs-6"></i> Saved Posts</a>
      <a href="/my-communities" class="discourse-profile-link nav-link text-gray-700 bg-hover-light-success rounded px-3 py-2 d-flex align-items-center gap-3 fs-6"><i class="bi bi-people-fill text-muted fs-6"></i> My Communities</a>
    </div>

    <div class="discourse-profile-section d-flex flex-column gap-1 border-top border-gray-100 pt-2 mb-2">
      <span class="discourse-profile-section-label text-muted fw-bolder text-uppercase px-3 py-1 fs-8" style="letter-spacing: 0.08em;">Settings</span>
      <a href="/account-settings" class="discourse-profile-link nav-link text-gray-700 bg-hover-light-success rounded px-3 py-2 d-flex align-items-center gap-3 fs-6"><i class="bi bi-gear-fill text-muted fs-6"></i> Settings</a>
      <a href="/privacy" class="discourse-profile-link nav-link text-gray-700 bg-hover-light-success rounded px-3 py-2 d-flex align-items-center gap-3 fs-6"><i class="bi bi-shield-lock-fill text-muted fs-6"></i> Privacy and Security</a>
    </div>

    <div class="discourse-profile-section border-top border-gray-100 pt-2">
      <a href="/" class="discourse-profile-link nav-link text-gray-900 fw-bold bg-hover-light-success rounded px-3 py-2 d-flex align-items-center gap-3 fs-6"><i class="bi bi-grid-3x3-gap-fill text-muted fs-6"></i> Paraverse Portal</a>
    </div>

    <div class="discourse-profile-logout-wrap border-top border-gray-100 pt-2 mt-1">
      <a href="/sign-out" class="discourse-profile-logout nav-link text-danger bg-hover-light-danger rounded px-3 py-2 d-flex align-items-center gap-3 fs-6 fw-bold">
        <i class="bi bi-box-arrow-right text-danger fs-6"></i> Log Out
      </a>
    </div>

  </div>
</div>

<style>
  .bg-hover-light-success:hover {
    background-color: #f0f5f2 !important;
    color: #115e3b !important;
  }
  .bg-hover-light-success:hover i {
    color: #115e3b !important;
  }
</style>

<script>
  (function() {
    var btn = document.getElementById('avatar-btn');
    var dropdown = document.getElementById('profile-dropdown');
    if (!btn || !dropdown) return;

    document.body.appendChild(dropdown);

    function positionDropdown() {
      var rect = btn.getBoundingClientRect();
      dropdown.style.top = (rect.bottom + window.scrollY + 8) + 'px';
      dropdown.style.left = (rect.right + window.scrollX - 320) + 'px';
    }

    function openDropdown() {
      positionDropdown();
      dropdown.style.display = 'block';
      dropdown.getBoundingClientRect();
      dropdown.style.opacity = '1';
      dropdown.style.transform = 'translateY(0)';
    }

    function closeDropdown() {
      dropdown.style.opacity = '0';
      dropdown.style.transform = 'translateY(-6px)';
      setTimeout(function() {
        if (dropdown.style.opacity === '0') {
          dropdown.style.display = 'none';
        }
      }, 180);
    }

    var isOpen = false;

    btn.addEventListener('click', function(e) {
      e.stopPropagation();
      var notiDropdown = document.getElementById('laf-notification-dropdown');
      if (notiDropdown) notiDropdown.style.display = 'none';
      isOpen = !isOpen;
      isOpen ? openDropdown() : closeDropdown();
    });

    document.addEventListener('click', function(e) {
      if (isOpen && !dropdown.contains(e.target) && e.target !== btn) {
        isOpen = false;
        closeDropdown();
      }
    });

    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape' && isOpen) {
        isOpen = false;
        closeDropdown();
      }
    });

    window.addEventListener('resize', function() { if (isOpen) positionDropdown(); });
    window.addEventListener('scroll', function() { if (isOpen) positionDropdown(); }, true);
  })();
</script>
