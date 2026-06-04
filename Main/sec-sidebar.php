<!-- ── Widget 1: Discourse Info Card ──────────────────────── -->
<div class="card discourse-info-card mt-10 mb-4 border-0 position-relative overflow-hidden rounded-4 shadow-sm">
  <div class="discourse-widget-center-glow position-absolute w-100 h-100 top-0 start-0" style="pointer-events:none;z-index:0;"></div>

  <div class="card-body p-4 d-flex flex-column justify-content-between h-100 position-relative" style="z-index:1;">

    <div class="d-flex align-items-center gap-2 mb-2">
      <img src="/Discourse/assets/images/Discourse-logo.png" alt="Discourse Logo" class="discourse-sidebar-logo" />
    </div>

    <p class="text-white opacity-75 fs-7 fw-normal lh-base mb-3">
      Ask questions, start debates, post anonymously. No prof. No judgment. Just FEU Tech students keeping it real.
    </p>

    <div class="d-flex flex-column gap-1 border-top border-white-10 pt-2 flex-grow-1">

      <a href="/Discourse/posts/index.php?poll=1"
        class="discourse-info-post-item d-flex align-items-start gap-2 p-2 rounded text-decoration-none">
        <span class="fs-7 mt-1">📊</span>
        <div class="d-flex flex-column">
          <span class="text-white fs-7 fw-semibold lh-sm text-line-clamp-2">
            Poll: How do you actually study for finals?...
          </span>
          <span class="text-white opacity-50 fs-8">just posted</span>
        </div>
      </a>

      <a href="/Discourse/posts/index.php"
        class="discourse-info-post-item d-flex align-items-start gap-2 p-2 rounded text-decoration-none">
        <span class="fs-7 mt-1">🔵</span>
        <div class="d-flex flex-column">
          <span class="text-white fs-7 fw-semibold lh-sm text-line-clamp-2">
            The silent revolution in edge AI — why on-device inference is changing everything
          </span>
          <span class="text-white opacity-50 fs-8">3 comments · most active</span>
        </div>
      </a>

      <a href="/Discourse/posts/index.php?sample=1"
        class="discourse-info-post-item d-flex align-items-start gap-2 p-2 rounded text-decoration-none">
        <span class="fs-7 mt-1">💡</span>
        <div class="d-flex flex-column">
          <span class="text-white fs-7 fw-semibold lh-sm text-line-clamp-2">
            What if community governance used ranked-choice weighted by stake, not by account age?
          </span>
          <span class="text-white opacity-50 fs-8">no replies yet</span>
        </div>
      </a>

    </div>
  </div>
</div>

<!-- Widget 2: Community Stats -->
<div class="card border-0 shadow-sm rounded-4 mb-4">
  <div class="card-body p-4">
    <h6 class="fs-6 fw-bold text-gray-800 mb-3">Community Stats</h6>

    <div class="d-flex flex-column gap-3">

      <div class="discourse-stat-item d-flex align-items-center justify-content-between pb-3">
        <div class="d-flex align-items-center gap-3">
          <div class="d-flex align-items-center justify-content-center bg-light-success rounded-2 fs-5"
            style="width:36px;height:36px;flex-shrink:0;">
            <i class="bi bi-people-fill text-success"></i>
          </div>
          <span class="fs-7 fw-bold text-gray-800 text-uppercase" style="letter-spacing:0.06em;">Members</span>
        </div>
        <div class="d-flex flex-column text-end">
          <span class="fs-5 fw-bolder text-gray-800">4,819</span>
          <span class="fs-8 text-muted text-uppercase" style="letter-spacing:0.04em;">+143 This Week</span>
        </div>
      </div>

      <div class="discourse-stat-item d-flex align-items-center justify-content-between pb-3">
        <div class="d-flex align-items-center gap-3">
          <div class="d-flex align-items-center justify-content-center bg-light-success rounded-2 fs-5"
            style="width:36px;height:36px;flex-shrink:0;">
            <i class="bi bi-file-text-fill text-success"></i>
          </div>
          <span class="fs-7 fw-bold text-gray-800 text-uppercase" style="letter-spacing:0.06em;">Posts Today</span>
        </div>
        <div class="d-flex flex-column text-end">
          <span class="fs-5 fw-bolder text-gray-800">390</span>
          <span class="fs-8 text-muted text-uppercase" style="letter-spacing:0.04em;">Across 9 Topics</span>
        </div>
      </div>

      <div class="discourse-stat-item d-flex align-items-center justify-content-between pb-3">
        <div class="d-flex align-items-center gap-3">
          <div class="d-flex align-items-center justify-content-center bg-light-success rounded-2 fs-5"
            style="width:36px;height:36px;flex-shrink:0;">
            <i class="bi bi-wifi text-success"></i>
          </div>
          <span class="fs-7 fw-bold text-gray-800 text-uppercase" style="letter-spacing:0.06em;">Online Now</span>
        </div>
        <div class="d-flex flex-column text-end">
          <span class="fs-5 fw-bolder text-gray-800">1,042</span>
          <span class="fs-8 text-muted text-uppercase" style="letter-spacing:0.04em;">Active Users</span>
        </div>
      </div>

    </div>
  </div>
</div>

<!-- Widget 3: Communities List — dynamic via getCommunityIconDetails() -->
<div class="card border-0 shadow-sm rounded-4 mb-4">
  <div class="card-body p-4">
    <div class="d-flex align-items-center justify-content-between mb-3">
      <h6 class="fs-6 fw-bold text-gray-800 mb-0">Communities</h6>
      <a href="/Discourse/communities/index.php"
        class="badge badge-light-success rounded-pill px-4 py-2 fs-8 fw-bold text-decoration-none dc-see-all-btn">
        See All
      </a>
    </div>

    <div class="d-flex flex-column gap-2">

      <?php
      $sidebarCommunities = [];
      if ($EDITH) {
          $res = $EDITH->query("SELECT title, members, logo_url, theme_color, icon, bg_class, text_class FROM communities ORDER BY members DESC, id DESC LIMIT 5");
          if ($res) {
              while ($row = $res->fetch_assoc()) {
                  $sidebarCommunities[] = [
                      'name' => $row['title'],
                      'label' => $row['title'],
                      'members' => number_format($row['members']),
                      'logo_url' => $row['logo_url'],
                      'theme_color' => $row['theme_color'],
                      'icon' => $row['icon'],
                      'bg_class' => $row['bg_class'],
                      'text_class' => $row['text_class']
                  ];
              }
          }
      }
      if (empty($sidebarCommunities)) {
          $sidebarCommunities = [
            ['name' => 'FEU LIFE',    'label' => 'FEU LIFE',    'members' => '5',   'logo_url' => null, 'theme_color' => '#d63384', 'icon' => 'bi-heart-fill', 'bg_class' => 'bg-light-danger', 'text_class' => 'text-danger'],
            ['name' => 'Freshies',    'label' => 'Freshies',    'members' => '3',   'logo_url' => null, 'theme_color' => '#0b5ed7', 'icon' => 'bi-people-fill', 'bg_class' => 'bg-light-primary', 'text_class' => 'text-primary'],
            ['name' => 'Study Group',  'label' => 'Study Group', 'members' => '4',   'logo_url' => null, 'theme_color' => '#1A8B44', 'icon' => 'bi-people-fill', 'bg_class' => 'bg-light-success', 'text_class' => 'text-success'],
          ];
      }
      foreach ($sidebarCommunities as $comm):
      ?>
        <a href="/Discourse/communities/index.php?c=<?php echo urlencode($comm['name']); ?>" class="discourse-community-item d-flex align-items-center gap-3 text-decoration-none p-2 rounded-2">
          <div class="d-flex align-items-center justify-content-center rounded-2 fs-5"
            style="width:38px;height:38px;flex-shrink:0; <?php echo !empty($comm['logo_url']) ? 'background-image: url(\'' . htmlspecialchars($comm['logo_url']) . '\'); background-size: cover; background-position: center;' : getLightColorStyle($comm['theme_color']); ?>">
            <?php if (empty($comm['logo_url'])) { ?>
            <i class="bi <?php echo htmlspecialchars($comm['icon'] ?? 'bi-people-fill'); ?>" style="color: <?php echo htmlspecialchars($comm['theme_color']); ?> !important;"></i>
            <?php } ?>
          </div>
          <div class="d-flex flex-column">
            <span class="fs-6 fw-bold text-gray-800"><?php echo htmlspecialchars($comm['label']); ?></span>
            <span class="fs-8 text-muted"><?php echo htmlspecialchars($comm['members']); ?> members</span>
          </div>
        </a>
      <?php endforeach; ?>

    </div>
  </div>
</div>

<!-- Widget 4: Browse Topics — dynamic via getCategoryBadgeStyle() -->
<div class="card border-0 shadow-sm rounded-4 mb-4">
  <div class="card-body p-4">
    <h6 class="fs-6 fw-bold text-gray-800 mb-3">Browse Topics</h6>
    <div class="d-flex flex-wrap gap-2">
      <?php
      $sidebarTopics = [
        'TECHNOLOGY',
        'CULTURE',
        'GAMING',
        'FEU',
        'IDEAS',
        'CREATIVE',
        'SCIENCE',
        'NEWS',
        'AI',
        'ACADEMICS',
        'LIFESTYLE',
        'ENTERTAINMENT',
        'MUSIC',
        'POLITICS',
        'ISSUES',
        'SPORTS'
      ];
      foreach ($sidebarTopics as $topic):
        $b = getCategoryBadgeStyle($topic);
      ?>
        <a href="/Discourse/topics/index.php?t=<?php echo $topic; ?>" class="badge <?php echo $b['class']; ?> rounded-pill px-3 py-2 fs-8 text-decoration-none dc-topic-tag fw-bold">
          <i class="bi <?php echo $b['icon']; ?> <?php echo $b['icon_color']; ?> me-1"></i><?php echo $topic; ?>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<!-- Widget 5: Campus Buzz -->
<div class="card border-0 shadow-sm rounded-4 mb-4">
  <div class="card-body p-4">
    <h6 class="fs-6 fw-bold text-gray-800 mb-3">Campus Buzz</h6>

    <p class="fs-8 fw-bold text-muted text-uppercase mb-2" style="letter-spacing:0.08em;">Trending Today</p>
    <div class="d-flex flex-wrap gap-2 mb-3">
      <a href="/Discourse/hashtags/index.php?tag=hashtag" class="badge badge-light rounded-pill border px-4 py-2 fs-8 text-decoration-none text-gray-800 text-hover-primary">#HASHTAG</a>
      <a href="/Discourse/hashtags/index.php?tag=worldpeace" class="badge badge-light rounded-pill border px-4 py-2 fs-8 text-decoration-none text-gray-800 text-hover-primary">#WORLDPEACE</a>
      <a href="/Discourse/hashtags/index.php?tag=valorant" class="badge badge-light rounded-pill border px-4 py-2 fs-8 text-decoration-none text-gray-800 text-hover-primary">#VALORANT</a>
      <a href="/Discourse/hashtags/index.php?tag=petition" class="badge badge-light rounded-pill border px-4 py-2 fs-8 text-decoration-none text-gray-800 text-hover-primary">#PETITION</a>
      <a href="/Discourse/hashtags/index.php?tag=poster" class="badge badge-light rounded-pill border px-4 py-2 fs-8 text-decoration-none text-gray-800 text-hover-primary">#POSTER</a>
    </div>

    <p class="fs-8 fw-bold text-muted text-uppercase mb-2" style="letter-spacing:0.08em;">Posting Tips</p>
    <ul class="list-unstyled d-flex flex-column gap-2 m-0 p-0">
      <li class="fs-7 text-gray-600 d-flex align-items-start gap-2">
        <i class="bi bi-arrow-right-circle-fill text-warning mt-1 flex-shrink-0"></i>
        Use anonymous mode for sensitive topics — your ID stays hidden.
      </li>
      <li class="fs-7 text-gray-600 d-flex align-items-start gap-2">
        <i class="bi bi-arrow-right-circle-fill text-warning mt-1 flex-shrink-0"></i>
        Post a poll to settle debates fast.
      </li>
      <li class="fs-7 text-gray-600 d-flex align-items-start gap-2">
        <i class="bi bi-arrow-right-circle-fill text-warning mt-1 flex-shrink-0"></i>
        Tag the right community for better reach.
      </li>
    </ul>
  </div>
</div>