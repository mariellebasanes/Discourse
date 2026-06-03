<?php
define('MBG', TRUE);
include(dirname(dirname(__DIR__)) . '/functions-new.php');
$community_name = isset($_GET['c']) ? trim($_GET['c']) : 'FEU LIFE';
$META_TITLE = htmlspecialchars($community_name) . " - Discourse Community";

// Load community record from DB for stats
$comm_data = [];
if ($EDITH) {
    $esc_cn = $EDITH->real_escape_string($community_name);
    $r = $EDITH->query("SELECT * FROM communities WHERE title='$esc_cn' LIMIT 1");
    if ($r) $comm_data = $r->fetch_assoc() ?: [];
}
// Dynamic counts (always live from DB)
$comm_member_count = 0;
$comm_post_count   = 0;
if ($EDITH) {
    $esc_cn = $EDITH->real_escape_string($community_name);
    $r = $EDITH->query("SELECT COUNT(*) as c FROM community_members WHERE community_title='$esc_cn'");
    $comm_member_count = $r ? (int)$r->fetch_assoc()['c'] : 0;
    $r = $EDITH->query("SELECT COUNT(*) as c FROM posts WHERE community='$esc_cn'");
    $comm_post_count = $r ? (int)$r->fetch_assoc()['c'] : 0;
}
$comm_desc         = $comm_data['desc'] ?? 'A community for FEU students.';
$comm_icon         = $comm_data['icon'] ?? 'bi-people-fill';
$comm_bg           = $comm_data['bg_class'] ?? 'bg-light-success';
$comm_text         = $comm_data['text_class'] ?? 'text-success';
$comm_theme_color  = $comm_data['theme_color'] ?? '#1A8B44';
$comm_admin_id     = $comm_data['admin_id'] ?? null;
$is_community_admin = $comm_admin_id && isset($identification) && $identification === $comm_admin_id;

// Custom topics for this community
$custom_topics_list = [];
if (!empty($comm_data['custom_topics'])) {
    $custom_topics_list = array_filter(array_map('trim', explode(',', $comm_data['custom_topics'])));
}

// Top contributors: real users with most posts in this community
$top_contributors = [];
if ($EDITH) {
    $esc_cn = $EDITH->real_escape_string($community_name);
    $r = $EDITH->query(
        "SELECT a.display_name, a.avatar_md, a.role, a.identification,
                COUNT(p.id) as post_count,
                COALESCE(SUM(p.upvotes), 0) as karma
         FROM posts p
         JOIN accounts a ON p.author_id = a.identification
         WHERE p.community = '$esc_cn' AND p.is_anonymous = 0
         GROUP BY p.author_id
         ORDER BY post_count DESC, karma DESC
         LIMIT 5"
    );
    if ($r) while ($row = $r->fetch_assoc()) $top_contributors[] = $row;
}

if (!function_exists('get_relative_time')) {
    function get_relative_time($datetime) {
        $time = strtotime($datetime);
        if (!$time) return '1d ago';
        $now  = time(); $diff = $now - $time;
        if ($diff < 60) return 'Just now';
        $diff = round($diff / 60);
        if ($diff < 60) return $diff . 'm ago';
        $diff = round($diff / 60);
        if ($diff < 24) return $diff . 'h ago';
        $diff = round($diff / 24);
        if ($diff < 30) return $diff . 'd ago';
        return date('F j, Y', $time);
    }
}

// Load community posts from DB
$db_posts = [];
if ($EDITH) {
    $stmt = $EDITH->prepare(
        "SELECT p.*, a.display_name, a.avatar_md
         FROM posts p
         JOIN accounts a ON p.author_id = a.identification
         WHERE p.community = ?
         ORDER BY p.created_at DESC LIMIT 20"
    );
    if ($stmt) {
        $stmt->bind_param("s", $community_name);
        $stmt->execute();
        $res = $stmt->get_result();
        while ($row = $res->fetch_assoc()) {
            $stmt_cc = $EDITH->prepare("SELECT COUNT(*) as cc FROM comments WHERE post_id = ?");
            $stmt_cc->bind_param("i", $row['id']);
            $stmt_cc->execute();
            $row['comments_count'] = $stmt_cc->get_result()->fetch_assoc()['cc'] ?? 0;
            $stmt_cc->close();
            $stmt_fc = $EDITH->prepare("SELECT body FROM comments WHERE post_id = ? ORDER BY created_at ASC LIMIT 1");
            $stmt_fc->bind_param("i", $row['id']);
            $stmt_fc->execute();
            $fc = $stmt_fc->get_result()->fetch_assoc();
            $row['first_comment'] = $fc['body'] ?? '';
            $stmt_fc->close();
            $db_posts[] = $row;
        }
        $stmt->close();
    }
}
?>


<head>
  <title><?php echo $META_TITLE; ?></title>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="icon" type="image/x-icon" href="/Discourse/assets/img/favicon.png">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&Libre+Franklin:wght@400;600;800&family=News+Cycle:wght@700&display=swap" rel="stylesheet">

  <!-- Metronic Core CSS -->
  <link rel="stylesheet" href="/Discourse/assets/plugins/global/plugins.bundle.css">
  <link rel="stylesheet" href="/Discourse/assets/css/style.keenicons.css">
  <link rel="stylesheet" href="/Discourse/assets/css/style.bundle.v2.full.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Dashboard CSS links -->
  <link href="/Discourse/assets/css/dashboard.css" rel="stylesheet">
  <link href="/Discourse/assets/css/sec-hero.css" rel="stylesheet">
  <link href="/Discourse/assets/css/sec-sidebar.css" rel="stylesheet">
  <link href="/Discourse/assets/css/sec-search-filter.css" rel="stylesheet">
  <link href="/Discourse/assets/css/sec-posts.css" rel="stylesheet">
  <link href="/Discourse/assets/css/sec-modals.css" rel="stylesheet">

  <!-- jQuery -->
  <script src="/Discourse/assets/js/jquery.js"></script>

  <style>
    /* Premium Community Banner design using dashboard green gradient system */
    .community-banner {
      background-color: <?php echo htmlspecialchars($comm_theme_color); ?>;
      position: relative;
      overflow: hidden;
      border-bottom: 3px solid rgba(255,255,255,0.25);
    }

    .community-banner-glow {
      position: absolute;
      width: 100%;
      height: 100%;
      top: 0;
      left: 0;
      background: radial-gradient(circle at 80% 50%, rgba(5, 177, 102, 0.15) 0%, transparent 60%);
      pointer-events: none;
    }

    .community-logo-container {
      background-color: #dce8df;
      border-radius: 16px;
      padding: 10px;
      border: 3px solid rgba(255, 255, 255, 0.15);
      transition: transform 0.3s ease;
    }

    .community-logo-container:hover {
      transform: scale(1.05);
    }

    .vote-btn-v2 {
      background: transparent;
      border: none;
      color: #6c757d;
      transition: all 0.2s ease;
    }

    .vote-btn-v2:hover {
      color: #1a8b44;
      transform: scale(1.15);
    }

    .active-vote-up {
      color: #166534 !important;
    }

    .active-vote-down {
      color: #991b1b !important;
    }
  </style>
</head>

<body id="kt_app_body" data-kt-app-page-loading-enabled="true" data-kt-app-page-loading="on"
  data-kt-app-layout="light-header" class="app-default">
  <?php include(dirname(dirname(__DIR__)) . "/partials/_page-loader.php"); ?>
  <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
    <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
      <?php include(dirname(dirname(__DIR__)) . "/partials/_header.php"); ?>
      <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
        <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
          <div class="d-flex flex-column flex-column-fluid">
            <main>

              <!-- Full-width Community Banner -->
              <div class="community-banner w-100 mb-8 py-10 position-relative">
                <div class="community-banner-glow"></div>
                <div class="container-xxl position-relative z-index-1">
                  <div class="d-flex align-items-center flex-wrap gap-6">
                    <!-- Community Logo -->
                    <div class="flex-shrink-0">
                      <div class="w-100px h-100px w-lg-120px h-lg-120px d-flex align-items-center justify-content-center community-logo-container shadow rounded-3 <?php echo $comm_bg; ?> <?php echo $comm_text; ?> fs-1">
                        <i class="bi <?php echo $comm_icon; ?> fs-2hx"></i>
                      </div>
                    </div>
                    <!-- Community Info -->
                    <div class="flex-grow-1 text-start">
                      <h1 class="text-white fw-bolder fs-2tx mb-2"><?php echo htmlspecialchars($community_name); ?></h1>
                      <p class="text-white text-opacity-75 fs-6 mb-4 mw-600px"><?php echo htmlspecialchars($comm_desc); ?></p>
                      <div class="d-flex gap-3">
                        <div class="border border-white border-opacity-25 rounded px-3 py-1 d-flex align-items-center gap-2">
                          <i class="bi bi-people text-white fs-7"></i>
                          <span class="text-white fw-bold fs-7 comm-members-banner"><?php echo number_format($comm_member_count); ?></span>
                          <span class="text-white text-opacity-75 fs-9">Members</span>
                        </div>
                        <div class="border border-white border-opacity-25 rounded px-3 py-1 d-flex align-items-center gap-2">
                          <i class="bi bi-pencil-square text-white fs-7"></i>
                          <span class="text-white fw-bold fs-7"><?php echo number_format($comm_post_count); ?></span>
                          <span class="text-white text-opacity-75 fs-9">Posts</span>
                        </div>
                      </div>
                    </div>
                    <!-- Join Button -->
                    <?php $is_member = IS_COMMUNITY_MEMBER($community_name, $identification); ?>
                    <div class="flex-shrink-0 ms-auto d-flex align-items-center gap-3">
                      <?php if ($is_community_admin) { ?>
                      <span class="badge d-flex align-items-center gap-1 px-3 py-2 fw-bold fs-8 rounded-pill"
                            style="background:rgba(255,255,255,0.2);color:#fff;border:1px solid rgba(255,255,255,0.4);">
                        <i class="bi bi-shield-fill-check fs-8"></i> ADMIN
                      </span>
                      <?php } ?>
                      <button id="comm-join-btn"
                        class="btn fw-bolder px-8 py-3 d-flex align-items-center gap-2 rounded-pill"
                        data-comm="<?php echo htmlspecialchars($community_name); ?>"
                        data-joined="<?php echo $is_member ? '1' : '0'; ?>"
                        style="<?php echo $is_member
                            ? 'background:transparent;color:#fff;border:2px solid rgba(255,255,255,0.7);'
                            : 'background:#fff;color:#0b301f;border:2px solid #fff;'; ?>">
                        <i class="bi <?php echo $is_member ? 'bi-check-lg' : 'bi-plus-lg'; ?> fs-6" style="<?php echo $is_member ? 'color:#fff;' : 'color:#0b301f;'; ?>"></i>
                        <span><?php echo $is_member ? 'JOINED' : 'JOIN COMMUNITY'; ?></span>
                      </button>
                    </div>
                  </div>
                </div>
              </div>

              <div class="app-container container-xxl">

                <!-- 2-column layout: Left feed + Right sidebar -->
                <div class="discourse-dashboard-layout" id="discourse-dashboard">

                  <!-- ── LEFT COLUMN ──────────────────────────────────────── -->
                  <div class="discourse-feed-col">

                    <!-- Community Highlights -->
                    <div class="mb-6 mt-5">
                      <div class="d-flex align-items-center gap-2 mb-4">
                        <i class="bi bi-bookmark-fill text-gray-700 fs-6"></i>
                        <h6 class="fs-5 fw-bold text-gray-800 mb-0">Community Highlights</h6>
                      </div>

                      <?php
                      // Fetch top 2 posts in this community for the Highlights section
                      $highlight_posts = [];
                      if ($EDITH) {
                          $esc_cn = $EDITH->real_escape_string($community_name);
                          $h_res = $EDITH->query(
                              "SELECT p.id, p.title, p.topic, p.upvotes,
                                      (SELECT COUNT(*) FROM comments c WHERE c.post_id=p.id) AS cc
                               FROM posts p WHERE p.community='$esc_cn'
                               ORDER BY p.upvotes DESC LIMIT 2"
                          );
                          if ($h_res) while ($hr = $h_res->fetch_assoc()) $highlight_posts[] = $hr;
                      }
                      if (!empty($highlight_posts)) { ?>
                      <div class="row g-4 mb-5">
                        <?php foreach ($highlight_posts as $hp) {
                            $hpBadge = getCategoryBadgeStyle($hp['topic'] ?? 'GENERAL');
                        ?>
                        <div class="col-6">
                          <a href="/Discourse/pages/version/view-post.php?id=<?php echo $hp['id']; ?>" class="card border-0 shadow-sm rounded-3 h-100 text-decoration-none d-block" style="transition: box-shadow 0.2s;" onmouseover="this.style.boxShadow='0 4px 20px rgba(0,0,0,0.12)'" onmouseout="this.style.boxShadow=''">
                            <div class="card-body p-5">
                              <h5 class="fw-bolder text-gray-900 fs-6 mb-2 lh-sm"><?php echo htmlspecialchars(mb_substr($hp['title'], 0, 55)) . (mb_strlen($hp['title']) > 55 ? '…' : ''); ?></h5>
                              <div class="d-flex align-items-center gap-3 mb-4">
                                <span class="text-muted fs-8"><?php echo $hp['upvotes']; ?> votes</span>
                                <span class="text-muted fs-8">·</span>
                                <span class="text-muted fs-8"><?php echo $hp['cc']; ?> Comments</span>
                              </div>
                              <span class="badge <?php echo $hpBadge['class']; ?> rounded-pill px-4 py-2 fs-8 fw-bold">
                                <i class="bi <?php echo $hpBadge['icon']; ?> me-1"></i><?php echo htmlspecialchars(strtoupper($hp['topic'] ?? 'GENERAL')); ?>
                              </span>
                            </div>
                          </a>
                        </div>
                        <?php } ?>
                      </div>
                      <?php } ?>

                      <!-- Separator -->
                      <hr class="border-gray-200 my-4">
                    </div>

                    <!-- Search and New Post Row -->
                    <div class="d-flex flex-column flex-sm-row align-items-stretch align-items-sm-center gap-3 mb-5">
                      <div class="position-relative flex-grow-1">
                        <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-4 text-gray-500 pe-none fs-6"></i>
                        <input type="text" class="form-control bg-white rounded-pill ps-12 fs-6 text-gray-700 search-input-v2 shadow-sm" placeholder="Search discussions, topics, people...">
                      </div>
                      <a href="/Discourse/pages/view/create-post.php?c=<?php echo urlencode($community_name); ?>" class="btn btn-sm rounded-pill fw-bold fs-7 px-5 py-3 d-inline-flex align-items-center justify-content-center gap-1" style="background:#0b301f; color:#fff;">
                        <i class="bi bi-plus-lg me-1 fs-7"></i> New Post
                      </a>
                    </div>

                    <!-- Filters Row -->
                    <div class="d-flex align-items-center justify-content-between border-bottom border-2 border-gray-200 mb-5">
                      <ul class="nav nav-line-tabs nav-line-tabs-2x border-transparent fs-6 fw-bold mb-0" id="discoursePostTabs" role="tablist">
                        <li class="nav-item">
                          <button class="nav-link active px-3 py-2 px-sm-4 py-sm-3 fs-7 fs-sm-6" data-bs-toggle="tab" href="#hot"><i class="bi bi-fire me-1"></i> HOT</button>
                        </li>
                        <li class="nav-item">
                          <button class="nav-link px-3 py-2 px-sm-4 py-sm-3 fs-7 fs-sm-6" data-bs-toggle="tab" href="#new"><i class="bi bi-lightning-charge me-1"></i> NEW</button>
                        </li>
                        <li class="nav-item">
                          <button class="nav-link px-3 py-2 px-sm-4 py-sm-3 fs-7 fs-sm-6" data-bs-toggle="tab" href="#top"><i class="bi bi-trophy me-1"></i> TOP</button>
                        </li>
                        <li class="nav-item">
                          <button class="nav-link px-3 py-2 px-sm-4 py-sm-3 fs-7 fs-sm-6" data-bs-toggle="tab" href="#rising"><i class="bi bi-graph-up-arrow me-1"></i> RISING</button>
                        </li>
                      </ul>
                      <div class="dropdown">
                        <button class="btn btn-sm btn-light rounded-pill border border-gray-300 text-gray-700 fs-7 px-4 py-2 dropdown-toggle" type="button" id="topicsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                          All Topics
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 p-2 fs-7 min-w-150px" aria-labelledby="topicsDropdown">
                          <?php
                          // Show custom topics first, then fallback to general topics
                          $display_topics = !empty($custom_topics_list)
                              ? $custom_topics_list
                              : ['Technology','Academics','Lifestyle','Issues','FEU','Creative','Sports','News'];
                          foreach ($display_topics as $dt) { ?>
                          <li><a class="dropdown-item rounded-2 py-2 px-4 text-gray-700 text-hover-success bg-hover-light-success fs-7"
                                 href="/Discourse/pages/view/topic.php?t=<?php echo urlencode(strtoupper($dt)); ?>"><?php echo htmlspecialchars($dt); ?></a></li>
                          <?php } ?>
                        </ul>
                      </div>
                    </div>

                    <!-- Feed -->
                    <?php
                    // Map DB posts; show empty state when none
                    $posts = array_map(function($r) {
                        $isAnon = ($r['is_anonymous'] == 1);
                        return [
                            "id"             => $r['id'],
                            "author_id"      => $r['author_id'],
                            "author"         => $isAnon ? 'Anonymous' : ($r['display_name'] ?? 'User'),
                            "is_anonymous"   => $isAnon,
                            "avatar"         => $isAnon ? '/Discourse/assets/images/anonymous.png' : ($r['avatar_md'] ?? '/Discourse/assets/images/anonymous.png'),
                            "time"           => get_relative_time($r['created_at']),
                            "tag"            => $r['topic'] ?? 'GENERAL',
                            "tags"           => $r['tags'] ?? '',
                            "title"          => $r['title'],
                            "body"           => $r['body'],
                            "votes"          => $r['upvotes'] ?? 0,
                            "comments_count" => $r['comments_count'] ?? 0,
                            "first_comment"  => $r['first_comment'] ?? '',
                        ];
                    }, $db_posts);

                    if (empty($posts)) { ?>
                      <div class="text-center py-10 text-muted">
                        <i class="bi bi-chat-square-text fs-1 d-block mb-3 opacity-50"></i>
                        <p class="fs-5 fw-bold mb-1">No posts yet</p>
                        <p class="fs-7">Be the first to post in <?php echo htmlspecialchars($community_name); ?>!</p>
                        <a href="/Discourse/pages/view/create-post.php?c=<?php echo urlencode($community_name); ?>" class="btn btn-sm mt-3" style="background:#0b301f;color:#fff;">
                          <i class="bi bi-plus-lg me-1"></i> Create Post
                        </a>
                      </div>
                    <?php }
                    foreach ($posts as $post) {
                      $c_isAnon = (!empty($post['is_anonymous']));
                      $c_avatar = $c_isAnon ? '/Discourse/assets/images/anonymous.png' : (!empty($post['avatar']) ? $post['avatar'] : '/Discourse/assets/images/anonymous.png');
                      $c_author = $c_isAnon ? 'Anonymous' : ($post['author'] ?? 'User');
                      $c_profileHref = ($c_isAnon || empty($post['author_id'])) ? 'javascript:void(0)' : '/Discourse/pages/version/profile-other.php?id=' . urlencode($post['author_id']);
                      $c_commDetails = getCommunityIconDetails($community_name);
                      $c_saved = IS_POST_SAVED($post['id'], $identification);
                      $c_commentCount = $post['comments_count'] ?? 0;
                    ?>
                      <!-- ── Post Card ── -->
                      <div class="card border-0 shadow mb-5" data-dc="post-card" data-post-id="<?php echo $post['id']; ?>">
                        <div class="d-flex">

                          <!-- Vote Column -->
                          <div class="d-flex flex-column align-items-center gap-1 p-3" style="width:55px;flex-shrink:0;background-color:#e8ede9;">
                            <button class="btn btn-sm btn-tertiary dc-vote-up" title="Upvote">
                              <i class="bi bi-hand-thumbs-up p-0"></i>
                            </button>
                            <span class="fs-7 fw-bold text-gray-600 dc-vote-count"><?php echo $post['votes']; ?></span>
                            <button class="btn btn-sm btn-tertiary dc-vote-down" title="Downvote">
                              <i class="bi bi-hand-thumbs-down p-0"></i>
                            </button>
                          </div>

                          <!-- Post Content -->
                          <div class="d-flex flex-column py-5 flex-grow-1">
                            <div class="row g-0 px-5">

                              <!-- Row 1: Community badge + Report button -->
                              <div class="col-12 mb-2">
                                <div class="d-flex justify-content-between align-items-center">
                                  <a href="/Discourse/pages/version/community.php?c=<?php echo urlencode($community_name); ?>" class="d-flex align-items-center gap-2 text-decoration-none">
                                    <div class="d-flex align-items-center justify-content-center rounded-2 <?php echo $c_commDetails['bg_class']; ?>"
                                         style="width: 24px; height: 24px;">
                                      <i class="bi <?php echo $c_commDetails['icon']; ?> fs-8 <?php echo $c_commDetails['text_class']; ?>"></i>
                                    </div>
                                    <span class="fw-bold text-gray-800 text-hover-primary fs-7">c/<?php echo htmlspecialchars($community_name); ?></span>
                                  </a>
                                  <button class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#modalReportPost">
                                    <i class="bi bi-flag me-1"></i> Report
                                  </button>
                                </div>
                              </div>

                              <!-- Row 2: Avatar + Author name + Timestamp -->
                              <div class="col-12 mb-2">
                                <div class="d-flex gap-3 align-items-center">
                                  <img src="<?php echo $c_avatar; ?>" alt="<?php echo htmlspecialchars($c_author); ?>" class="h-40px w-40px rounded-circle" />
                                  <div class="d-flex flex-column">
                                    <a href="<?php echo $c_profileHref; ?>" class="fs-6 fw-bold text-gray-800 text-hover-primary"><?php echo htmlspecialchars($c_author); ?></a>
                                    <span class="text-muted fs-8"><i class="bi bi-clock me-1 fs-8"></i><?php echo $post['time']; ?></span>
                                  </div>
                                </div>
                              </div>

                              <!-- Row 3: Topic badge + Title + Excerpt + Hashtags -->
                              <div class="col-12 mb-2">
                                <div class="d-flex flex-column gap-2 text-start">
                                  <div class="d-flex flex-wrap align-items-center gap-1">
                                    <?php echo renderTopicBadge($post['tag']); ?>
                                  </div>
                                  <a href="/Discourse/pages/version/view-post.php?id=<?php echo $post['id']; ?>" class="text-gray-800 text-hover-primary fs-5 fw-bold dc-post-title-link">
                                    <?php echo htmlspecialchars($post['title']); ?>
                                  </a>
                                  <div class="dc-body-wrap">
                                    <span class="fs-7 text-gray-700 dc-body-clamp"><?php echo strip_tags($post['body']); ?></span>
                                    <a href="#" class="dc-see-more-link fw-semibold cursor-pointer d-none" onclick="dcToggleBody(event, this)">See More</a>
                                  </div>
                                  <?php $c_htags = renderHashtagBadges($post['tags'] ?? ''); if ($c_htags): ?>
                                  <div class="d-flex flex-wrap align-items-center gap-1 mt-1">
                                    <?php echo $c_htags; ?>
                                  </div>
                                  <?php endif; ?>
                                </div>
                              </div>

                            </div>

                            <!-- Actions Row -->
                            <div class="row">
                              <div class="d-flex justify-content-start align-items-center w-100 px-5">
                                <button class="btn btn-sm dc-post-comment"><i class="bi bi-chat me-1"></i> <?php echo $c_commentCount; ?> Comment<?php echo $c_commentCount == 1 ? '' : 's'; ?></button>
                                <button class="btn btn-sm dc-post-share"><i class="bi bi-share me-1"></i> Share</button>
                                <button class="btn btn-sm dc-post-save"
                                        data-on="<?php echo $c_saved ? '1' : '0'; ?>"
                                        style="<?php echo $c_saved ? 'background:rgba(13,110,253,.12);color:#0d6efd;border-color:#0d6efd;' : ''; ?>">
                                  <i class="bi <?php echo $c_saved ? 'bi-bookmark-fill' : 'bi-bookmark'; ?> me-1"></i>
                                  <?php echo $c_saved ? 'Saved' : 'Save'; ?>
                                </button>
                              </div>
                            </div>

                            <!-- Inline Quick Comment Drawer -->
                            <div class="dc-quick-comment-drawer border-top border-gray-200 mt-4 pt-4 px-5" style="display: none; background-color: #fcfdfc;">
                              <div class="dc-quick-comments-list mb-4 d-flex flex-column gap-3" style="max-height: 180px; overflow-y: auto;">
                                <?php if (!empty($post['first_comment'])): ?>
                                <div class="d-flex align-items-start gap-2 fs-7">
                                  <img src="https://ui-avatars.com/api/?name=User&background=f3f4f6&color=d97706&rounded=true" class="h-25px w-25px rounded-circle" alt="User">
                                  <div class="bg-light p-2 rounded-3 flex-grow-1 text-start">
                                    <p class="text-gray-700 m-0"><?php echo htmlspecialchars($post['first_comment']); ?></p>
                                  </div>
                                </div>
                                <?php endif; ?>
                              </div>
                              <form class="dc-quick-comment-form">
                                <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>" />
                                <div class="d-flex align-items-center gap-2">
                                  <img src="<?php echo !empty($ACCOUNT['avatar_md']) ? $ACCOUNT['avatar_md'] : '/Discourse/assets/images/anonymous.png'; ?>" class="h-30px w-30px rounded-circle" alt="User avatar" />
                                  <input type="text" class="form-control form-control-sm rounded-pill px-4 fs-7 bg-white border border-gray-300" placeholder="Write a quick comment..." required />
                                  <button type="submit" class="btn btn-sm btn-success rounded-pill px-4 fw-bold" style="background:#0b301f; color:#fff;">Post</button>
                                </div>
                              </form>
                            </div>
                          </div>

                        </div>
                      </div>
                    <?php } ?>

                  </div>

                  <div class="discourse-sidebar-col">

                    <!-- Widget: Community Stats -->
                    <div class="card border-0 shadow-sm rounded-4 mb-4 mt-10">
                      <div class="card-body p-4">
                        <h6 class="fs-6 fw-bold text-gray-800 mb-3">Community Stats</h6>
                        <div class="d-flex flex-column gap-3">

                          <div class="d-flex align-items-center justify-content-between pb-2 border-bottom border-gray-100">
                            <div class="d-flex align-items-center gap-3">
                              <div class="d-flex align-items-center justify-content-center bg-light-success rounded-2" style="width:36px;height:36px;flex-shrink:0;">
                                <i class="bi bi-people-fill text-success"></i>
                              </div>
                              <span class="fs-7 fw-bold text-gray-800 text-uppercase" style="letter-spacing:0.06em;">Members</span>
                            </div>
                            <div class="d-flex flex-column text-end">
                              <span class="fs-5 fw-bolder text-gray-800 comm-members-sidebar"><?php echo number_format($comm_member_count); ?></span>
                              <span class="fs-9 text-muted">Joined</span>
                            </div>
                          </div>

                          <div class="d-flex align-items-center justify-content-between pb-2 border-bottom border-gray-100">
                            <div class="d-flex align-items-center gap-3">
                              <div class="d-flex align-items-center justify-content-center bg-light-primary rounded-2" style="width:36px;height:36px;flex-shrink:0;">
                                <i class="bi bi-file-text-fill text-primary"></i>
                              </div>
                              <span class="fs-7 fw-bold text-gray-800 text-uppercase" style="letter-spacing:0.06em;">Posts</span>
                            </div>
                            <div class="d-flex flex-column text-end">
                              <span class="fs-5 fw-bolder text-gray-800"><?php echo number_format($comm_post_count); ?></span>
                              <span class="fs-9 text-muted">Total Posts</span>
                            </div>
                          </div>

                        </div>
                      </div>
                    </div>

                    <!-- Widget: Community Rules -->
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                      <div class="card-body p-4">
                        <h6 class="fs-6 fw-bold text-gray-800 mb-4">Community Rules</h6>
                        <div class="d-flex flex-column gap-4">

                          <?php
                          $rules = [
                            "Be respectful to all members. Harassment, hate speech, and bullying will not be tolerated.",
                            "Stay on topic. Posts should be relevant to the community's focus.",
                            "No spam or self-promotion. Repeated advertising will lead to removal.",
                            "Protect privacy. Do not share personal information of other members without consent.",
                          ];
                          foreach ($rules as $i => $rule): ?>
                            <div class="d-flex align-items-start gap-3">
                              <div class="d-flex align-items-center justify-content-center rounded-circle fw-bold fs-7 flex-shrink-0"
                                style="width:28px;height:28px;min-width:28px;background-color:#d1fae5;color:#065f46;border:2px solid #a7f3d0;">
                                <?php echo $i + 1; ?>
                              </div>
                              <p class="fs-7 text-gray-700 mb-0 lh-base"><?php echo $rule; ?></p>
                            </div>
                          <?php endforeach; ?>

                        </div>
                      </div>
                    </div>

                    <!-- Widget: Top Contributors -->
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                      <div class="card-body p-4">
                        <h6 class="fs-6 fw-bold text-gray-800 mb-4">Top Contributors</h6>
                        <div class="d-flex flex-column gap-3">

                          <?php if (empty($top_contributors)) { ?>
                            <p class="text-muted fs-8 text-center py-2">No posts yet. Be the first!</p>
                          <?php }
                          foreach ($top_contributors as $c):
                            $c_avatar = !empty($c['avatar_md']) ? $c['avatar_md'] : 'https://ui-avatars.com/api/?name=' . urlencode($c['display_name']) . '&background=e8ede9&color=0b301f&rounded=true';
                          ?>
                            <div class="d-flex align-items-center justify-content-between">
                              <a href="/Discourse/pages/version/profile-other.php?id=<?php echo urlencode($c['identification']); ?>" class="d-flex align-items-center gap-3 text-decoration-none">
                                <img src="<?php echo htmlspecialchars($c_avatar); ?>" alt="<?php echo htmlspecialchars($c['display_name']); ?>"
                                  class="rounded-circle" style="width:42px;height:42px;object-fit:cover;border:2px solid #e5e7eb;">
                                <div class="d-flex flex-column">
                                  <span class="fs-7 fw-bold text-gray-800 text-hover-primary">
                                    <?php echo htmlspecialchars($c['display_name']); ?>
                                    <?php if ($c['identification'] === $comm_admin_id) { ?>
                                      <span class="badge ms-1 px-2 py-1 fs-9 fw-bold rounded-pill" style="background:#d1fae5;color:#065f46;">Admin</span>
                                    <?php } ?>
                                  </span>
                                  <span class="fs-9 text-muted"><?php echo htmlspecialchars($c['role'] ?? 'Student'); ?></span>
                                </div>
                              </a>
                              <span class="rounded-pill px-3 py-1 fs-8 fw-bold" style="background-color:#d1fae5;color:#065f46;">
                                <?php echo $c['post_count']; ?> Posts
                              </span>
                            </div>
                          <?php endforeach; ?>

                        </div>
                      </div>
                    </div>

                    <!-- Widget: Discover other communities -->
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                      <div class="card-body p-4">
                        <h6 class="fs-6 fw-bold text-gray-800 mb-4">Discover other communities</h6>
                        <div class="d-flex flex-column gap-2">
                        <?php
                        // Show 3 other communities from DB, excluding current
                        $disc_comm = [];
                        if ($EDITH) {
                            $esc_cur = $EDITH->real_escape_string($community_name);
                            $dc_res = $EDITH->query("SELECT title, members, bg_class, icon, text_class FROM communities WHERE title != '$esc_cur' ORDER BY members DESC LIMIT 3");
                            if ($dc_res) while ($dc = $dc_res->fetch_assoc()) $disc_comm[] = $dc;
                        }
                        foreach ($disc_comm as $dc) { ?>
                          <a href="/Discourse/pages/version/community.php?c=<?php echo urlencode($dc['title']); ?>" class="d-flex align-items-center gap-3 p-2 rounded-3 text-decoration-none" style="transition:background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                            <div class="d-flex align-items-center justify-content-center rounded-2 flex-shrink-0 <?php echo $dc['bg_class']; ?>"
                              style="width:42px;height:42px;">
                              <i class="bi <?php echo $dc['icon']; ?> <?php echo $dc['text_class']; ?>" style="font-size:1.1rem;"></i>
                            </div>
                            <div class="d-flex flex-column flex-grow-1">
                              <span class="fs-7 fw-bold text-gray-800"><?php echo htmlspecialchars($dc['title']); ?></span>
                              <span class="fs-9 text-muted"><i class="bi bi-people-fill me-1"></i><?php echo number_format($dc['members']); ?></span>
                            </div>
                            <i class="bi bi-arrow-right text-muted fs-7"></i>
                          </a>
                        <?php } ?>
                        </div>
                      </div>
                    </div>

                  </div>

                </div>

                <?php include(dirname(dirname(__DIR__)) . "/partials/_discourse-modals.php"); ?>

              </div>
            </main>
          </div>
          <?php include(dirname(dirname(__DIR__)) . "/partials/_footer.php"); ?>
        </div>
      </div>
    </div>
  </div>
  <?php include(dirname(dirname(__DIR__)) . "/partials/_scrolltop.php"); ?>

  <!-- Scripts -->
  <script src="/Discourse/assets/js/dashboard.js"></script>
  <script src="/Discourse/assets/js/sec-sidebar.js"></script>
  <script src="/Discourse/assets/js/sec-modals.js"></script>

  <script>
    $(document).ready(function() {

      // 0. Join / Leave Community
      $('#comm-join-btn').on('click', function() {
        const btn = $(this);
        const comm = btn.data('comm');
        const joined = btn.data('joined') == '1';
        btn.prop('disabled', true);
        $.ajax({
          url: '/Discourse/pages/version/join-community-action.php',
          method: 'POST',
          data: { community_title: comm, action: joined ? 'leave' : 'join' },
          dataType: 'json',
          success: function(res) {
            if (res.success) {
              const nowJoined = !joined;
              btn.data('joined', nowJoined ? '1' : '0');
              if (nowJoined) {
                btn.css({'background':'transparent','color':'#fff','border':'2px solid rgba(255,255,255,0.7)'});
              } else {
                btn.css({'background':'#fff','color':'#0b301f','border':'2px solid #fff'});
              }
              btn.find('i').attr('class', nowJoined ? 'bi bi-check-lg fs-6' : 'bi bi-plus-lg fs-6')
                           .css('color', nowJoined ? '#fff' : '#0b301f');
              btn.find('span').text(nowJoined ? 'JOINED' : 'JOIN COMMUNITY');
              // Update member counts
              if (res.members_count !== undefined) {
                const mc = res.members_count.toLocaleString();
                $('.comm-members-banner').text(mc);
                $('.comm-members-sidebar').text(mc);
              }
            }
          },
          complete: function() { btn.prop('disabled', false); }
        });
      });

      // 1. Voting Logic
      $(document).on('click', '.dc-vote-up, .dc-vote-down', function(e) {
        e.preventDefault();
        const btn = $(this);
        const isUpvote = btn.hasClass('dc-vote-up');
        const container = btn.closest('[data-dc="post-card"]');
        const scoreSpan = container.find('.dc-vote-count');
        const otherBtn = isUpvote ? container.find('.dc-vote-down') : container.find('.dc-vote-up');

        let currentScore = parseInt(scoreSpan.text()) || 0;

        if (btn.hasClass('active-vote-up') || btn.hasClass('active-vote-down')) {
          btn.removeClass('active-vote-up active-vote-down');
          btn.find('i').attr('class', isUpvote ? 'bi bi-hand-thumbs-up p-0' : 'bi bi-hand-thumbs-down p-0');
          scoreSpan.text(currentScore - (isUpvote ? 1 : -1));
        } else {
          if (otherBtn.hasClass('active-vote-up') || otherBtn.hasClass('active-vote-down')) {
            otherBtn.removeClass('active-vote-up active-vote-down');
            otherBtn.find('i').attr('class', isUpvote ? 'bi bi-hand-thumbs-down p-0' : 'bi bi-hand-thumbs-up p-0');
            currentScore += (isUpvote ? 1 : -1);
          }

          if (isUpvote) {
            btn.addClass('active-vote-up');
            btn.find('i').attr('class', 'bi bi-hand-thumbs-up-fill p-0');
            scoreSpan.text(currentScore + 1);
          } else {
            btn.addClass('active-vote-down');
            btn.find('i').attr('class', 'bi bi-hand-thumbs-down-fill p-0');
            scoreSpan.text(currentScore - 1);
          }
        }
      });

      // 2. Real-time Search Filtering
      $('.search-input-v2').on('keyup', function() {
        const searchTerm = $(this).val().toLowerCase();
        $('[data-dc="post-card"]').each(function() {
          const title = $(this).find('.dc-post-title-link').text().toLowerCase();
          const content = $(this).find('.dc-body-clamp').text().toLowerCase();

          if (title.includes(searchTerm) || content.includes(searchTerm)) {
            $(this).show();
          } else {
            $(this).hide();
          }
        });
      });

      // 3. Filter Tabs (Visual Only)
      $('.nav-line-tabs .nav-link').on('click', function() {
        $('.nav-line-tabs .nav-link').removeClass('active');
        $(this).addClass('active');
      });

      // 4. Quick Comment Toggle
      $(document).on('click', '.dc-post-comment', function(e) {
        e.preventDefault();
        const card = $(this).closest('[data-dc="post-card"]');
        const drawer = card.find('.dc-quick-comment-drawer');
        drawer.slideToggle(200);
        drawer.find('input').focus();
      });

      // 5. Quick Comment Submit
      $(document).on('submit', '.dc-quick-comment-form', function(e) {
        e.preventDefault();
        const form = $(this);
        const input = form.find('input');
        const commentText = input.val().trim();
        if (!commentText) return;

        const card = form.closest('[data-dc="post-card"]');
        const commentsList = card.find('.dc-quick-comments-list');
        const commentCountBtn = card.find('.dc-post-comment');

        function escapeHtml(text) {
          return text
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
        }

        const newCommentHtml = `
                <div class="d-flex align-items-start gap-2 fs-7 animate__animated animate__fadeIn">
                    <img src="/Discourse/assets/images/catalina.webp" class="h-25px w-25px rounded-circle" alt="User avatar">
                    <div class="bg-light p-2 rounded-3 flex-grow-1 text-start">
                        <div class="d-flex justify-content-between">
                            <span class="fw-bold text-gray-800">You (Catalina)</span>
                            <span class="text-muted fs-9">just now</span>
                        </div>
                        <p class="text-gray-700 m-0 mt-1">${escapeHtml(commentText)}</p>
                    </div>
                </div>
            `;

        commentsList.append(newCommentHtml);
        commentsList.scrollTop(commentsList[0].scrollHeight);
        input.val('');

        // Increment comment count on button text
        if (commentCountBtn.length) {
          const btnText = commentCountBtn.text().trim();
          const match = btnText.match(/^(\d+)/);
          const currentCount = match ? parseInt(match[1]) : 0;
          const newCount = currentCount + 1;
          commentCountBtn.html('<i class="bi bi-chat me-1"></i> ' + newCount + ' Comment' + (newCount === 1 ? '' : 's'));
        }

        // Show Toast
        showFeedToast('Comment posted!');
      });

      // Toast function
      const feedToast = $('#dc-feed-toast');

      function showFeedToast(msg) {
        if (!feedToast.length) return;
        feedToast.find('span').text(msg);
        feedToast.fadeIn(200);
        clearTimeout(window._dcFeedToast);
        window._dcFeedToast = setTimeout(function() {
          feedToast.fadeOut(200);
        }, 2200);
      }
    });

    // See More Toggle
    (function() {
      function initSeeMore() {
        document.querySelectorAll('.dc-body-clamp').forEach(function(span) {
          var link = span.nextElementSibling;
          if (!link || !link.classList.contains('dc-see-more-link')) return;
          if (span.scrollHeight > span.clientHeight + 2) {
            link.classList.remove('d-none');
          }
        });
      }
      if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initSeeMore);
      } else {
        initSeeMore();
      }
    })();

    function dcToggleBody(e, link) {
      e.preventDefault();
      var span = link.previousElementSibling;
      if (!span) return;
      var expanded = span.classList.toggle('dc-expanded');
      link.textContent = expanded ? 'See Less' : 'See More';
    }
  </script>

  <!-- Feed Toast (Feedback) -->
  <div id="dc-feed-toast" style="display:none;position:fixed;bottom:1.5rem;right:1.5rem;z-index:1090;" class="d-flex align-items-center gap-2 px-4 py-2 bg-light border rounded-2 fs-6 text-gray-700 shadow-sm">
    <i class="bi bi-check-circle-fill text-success fs-6"></i><span></span>
  </div>
</body>

</html>