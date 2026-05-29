<?php
// Sample Notifications Data
$notifications = [
    ['user' => 'Miguel Reyes', 'text' => 'upvoted your post "Best AI tools for BSCS students"', 'time' => '2 minutes ago', 'is_read' => false],
    ['user' => 'Anonymous', 'text' => 'replied to your comment in "Which IDE do you use for Java?"', 'time' => '18 minutes ago', 'is_read' => false],
    ['user' => 'Aika Tan', 'text' => 'started following you', 'time' => '1 hour ago', 'is_read' => false],
    ['user' => 'Your post', 'text' => '"Rust in 2025" reached 50 upvotes 🎉', 'time' => 'Yesterday', 'is_read' => true],
    ['user' => 'Juan Santos', 'text' => 'commented on "FEU enrollment tips"', 'time' => '2 days ago', 'is_read' => true]
];
?>

<div id="laf-notification-btn" class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-30px h-30px w-md-40px h-md-40px" style="cursor: pointer;">
  <i class="bi bi-bell-fill fs-4"></i>
</div>

<div id="laf-notification-dropdown" class="card shadow-lg menu menu-sub menu-sub-dropdown" style="
  display: none;
  position: fixed;
  z-index: 999999;
  width: 360px;
  max-height: 480px;
  border-radius: 1rem;
  overflow-y: auto;
  opacity: 0;
  transform: translateY(-6px);
  transition: opacity .18s ease, transform .18s ease;
">
  <div class="card-header d-flex justify-content-between align-items-center px-6 py-4 border-bottom border-gray-200">
    <h6 class="text-dark fw-bolder text-uppercase m-0" style="font-size: 17.55px; letter-spacing: 0.05em;">Notifications</h6>
    <a href="#" class="text-success fw-bold" style="font-size: 13px;">Mark all read</a>
  </div>

  <div class="card-body p-0 d-flex flex-column">
    <?php foreach ($notifications as $noti): ?>
      <a href="#" class="d-flex align-items-start gap-3 px-6 py-4 border-bottom border-gray-100 text-gray-700 bg-hover-light text-decoration-none" style="font-size: 14px; <?= !$noti['is_read'] ? 'background-color: #f2faf6;' : '' ?>">
        
        <span class="rounded-circle mt-2 flex-shrink-0" style="width: 7px; height: 7px; <?= !$noti['is_read'] ? 'background-color: #1f4e39;' : 'border: 1px solid #a1a5b7;' ?>"></span>
        
        <div class="d-flex flex-column gap-1">
          <div class="text-gray-800">
            <strong class="text-gray-900 fw-bold"><?= htmlspecialchars($noti['user']) ?></strong> <?= htmlspecialchars($noti['text']) ?>
          </div>
          <div class="text-muted" style="font-size: 12px;"><?= htmlspecialchars($noti['time']) ?></div>
        </div>
      </a>
    <?php endforeach; ?>
  </div>
</div>

<script>
(function() {
  var btn = document.getElementById('laf-notification-btn');
  var dropdown = document.getElementById('laf-notification-dropdown');
  if (!btn || !dropdown) return;

  document.body.appendChild(dropdown);

  function positionDropdown() {
    var rect = btn.getBoundingClientRect();
    dropdown.style.top = (rect.bottom + window.scrollY + 8) + 'px';
    dropdown.style.left = (rect.right + window.scrollX - 360) + 'px';
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
      if (dropdown.style.opacity === '0') dropdown.style.display = 'none';
    }, 180);
  }

  btn.addEventListener('click', function(e) {
    e.stopPropagation();
    var profileDropdown = document.getElementById('laf-profile-dropdown');
    if (profileDropdown) profileDropdown.style.display = 'none';
    dropdown.style.display === 'block' ? closeDropdown() : openDropdown();
  });

  document.addEventListener('click', function(e) {
    if (dropdown.style.display === 'block' && !dropdown.contains(e.target) && !btn.contains(e.target)) {
      closeDropdown();
    }
  });

  window.addEventListener('resize', function() { if (dropdown.style.display === 'block') positionDropdown(); });
  window.addEventListener('scroll', function() { if (dropdown.style.display === 'block') positionDropdown(); }, true);
})();
</script>