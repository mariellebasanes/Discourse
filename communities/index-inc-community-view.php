<?php
define('MBG', TRUE);
include_once(dirname(__DIR__) . '/functions-new.php');
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
         ORDER BY p.is_announcement DESC, p.created_at DESC LIMIT 20"
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
  <link href="/Discourse/assets/css/sec-posts.css?v=1.0.7" rel="stylesheet">
  <link href="/Discourse/assets/css/sec-modals.css?v=1.0.1" rel="stylesheet">

  <!-- jQuery -->
  <script src="/Discourse/assets/js/jquery.js"></script>

  <style>
    /* Premium Community Banner design using dashboard green gradient system */
    .community-banner {
      background-color: <?php echo htmlspecialchars($comm_theme_color); ?>;
      position: relative;
      overflow: visible;
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
  <?php include(dirname(__DIR__) . "/partials/_page-loader.php"); ?>
  <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
    <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
      <?php include(dirname(__DIR__) . "/partials/_header.php"); ?>
      <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
        <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
          <div class="d-flex flex-column flex-column-fluid">
            <main>

              <!-- Full-width Community Banner -->
              <div class="community-banner w-100 mb-8 py-10 position-relative">
                <div class="community-banner-glow"></div>
                <div class="app-container container-xxl position-relative z-index-1">
                  <div class="d-flex align-items-center flex-wrap gap-6">
                    <!-- Community Logo -->
                    <div class="flex-shrink-0">
                      <div class="w-100px h-100px w-lg-120px h-lg-120px d-flex align-items-center justify-content-center community-logo-container shadow rounded-3 fs-1" style="<?php echo !empty($comm_data['logo_url']) ? 'background-image: url(\'' . htmlspecialchars($comm_data['logo_url']) . '\'); background-size: cover; background-position: center;' : 'background-color: #ffffff !important;'; ?>">
                        <?php if (empty($comm_data['logo_url'])) { ?>
                        <i class="bi <?php echo htmlspecialchars($comm_icon); ?> fs-2hx" style="color: <?php echo htmlspecialchars($comm_theme_color); ?> !important;"></i>
                        <?php } ?>
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
                      <div class="dropdown">
                        <button class="btn btn-icon btn-active-color-primary btn-light-success btn-sm rounded-circle d-flex align-items-center justify-content-center" type="button" id="adminSettingsDropdown" data-bs-toggle="dropdown" data-bs-popper-config='{"strategy":"fixed"}' aria-expanded="false" style="width: 42px; height: 42px; background: rgba(255,255,255,0.2); color: #fff; border: 1px solid rgba(255,255,255,0.4);">
                          <i class="bi bi-gear-fill fs-5 text-white"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-3 p-2 min-w-200px" aria-labelledby="adminSettingsDropdown">
                          <li class="dropdown-header text-gray-800 fw-bold fs-7 px-4 py-2">Community Admin Settings</li>
                          <li><hr class="dropdown-divider my-1"></li>
                          <li>
                            <a class="dropdown-item rounded-2 py-2 px-4 text-gray-700 text-hover-success bg-hover-light-success fs-7 d-flex align-items-center gap-2" href="#" data-bs-toggle="modal" data-bs-target="#editCommunityModal">
                              <i class="bi bi-pencil-square fs-6"></i>Edit Community
                            </a>
                          </li>
                          <li>
                            <a class="dropdown-item rounded-2 py-2 px-4 text-gray-700 text-hover-success bg-hover-light-success fs-7 d-flex align-items-center gap-2" href="#" data-bs-toggle="modal" data-bs-target="#addAnnouncementModal">
                              <i class="bi bi-megaphone fs-6"></i>Add Announcement
                            </a>
                          </li>
                          <li><hr class="dropdown-divider my-1"></li>
                          <li>
                            <a class="dropdown-item rounded-2 py-2 px-4 text-danger text-hover-white bg-hover-danger fs-7 d-flex align-items-center gap-2" href="#" data-bs-toggle="modal" data-bs-target="#deleteCommunityModal">
                              <i class="bi bi-trash3 fs-6"></i>Delete Community
                            </a>
                          </li>
                        </ul>
                      </div>
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
                               FROM posts p WHERE p.community='$esc_cn' AND p.is_highlighted=1
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
                          <a href="/Discourse/posts/index.php?id=<?php echo $hp['id']; ?>&back=community&community=<?php echo urlencode($community_name); ?>" class="card border-0 shadow-sm rounded-3 h-100 text-decoration-none d-block" style="transition: box-shadow 0.2s;" onmouseover="this.style.boxShadow='0 4px 20px rgba(0,0,0,0.12)'" onmouseout="this.style.boxShadow=''">
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
                      <a href="/Discourse/posts/index.php?action=create&c=<?php echo urlencode($community_name); ?>" class="btn btn-sm rounded-pill fw-bold fs-7 px-5 py-3 d-inline-flex align-items-center justify-content-center gap-1" style="background:#0b301f; color:#fff;">
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
                           // Show custom topics first, then fallback to seed defaults or GENERAL
                           $display_topics = !empty($custom_topics_list) ? $custom_topics_list : [];
                           if (empty($display_topics)) {
                               $seed_defaults = [
                                   "FEU LIFE" => ["FEULife", "CampusLife", "Enrollment", "Events"],
                                   "FEU ALABANG LIFE" => ["AlabangLife", "CampusLife", "Enrollment", "Events"],
                                   "Freshies" => ["Freshies", "Advice", "General"],
                                   "Enrollment" => ["Enrollment", "Diliman", "Requirements"],
                                   "Cosplaying" => ["Cosplay", "Anime", "Gaming", "Events"],
                                   "FEU TECH DEV" => ["Development", "Programming", "WebDev", "Projects"],
                                   "Food Trip Around TECH" => ["Food", "Restaurants", "TechArea"],
                                   "Thesis Advice" => ["Thesis", "Advice", "Research", "Defense"],
                                   "Alabang Innovators" => ["Startups", "Innovation", "Tech"],
                                   "Diliman Artists" => ["Art", "Creative", "Design"],
                                   "Tech Support" => ["TechSupport", "IT", "Help"],
                                   "Study Group" => ["Study", "Groups", "Academics"]
                               ];
                               $title_key = str_replace(' ', '', strtolower($community_name));
                               foreach ($seed_defaults as $s_title => $s_topics) {
                                   if (str_replace(' ', '', strtolower($s_title)) === $title_key) {
                                       $display_topics = $s_topics;
                                       break;
                                   }
                               }
                               if (empty($display_topics)) {
                                   $display_topics = ["GENERAL"];
                               }
                           }
                           foreach ($display_topics as $dt) { ?>
                           <li><a class="dropdown-item rounded-2 py-2 px-4 text-gray-700 text-hover-success bg-hover-light-success fs-7"
                                  href="/Discourse/topics/index.php?t=<?php echo urlencode(strtoupper($dt)); ?>"><?php echo htmlspecialchars($dt); ?></a></li>
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
                            "is_announcement"=> $r['is_announcement'] ?? 0,
                            "is_highlighted" => $r['is_highlighted'] ?? 0,
                            "image_url"      => $r['image_url'] ?? null,
                        ];
                    }, $db_posts);

                    if (empty($posts)) { ?>
                      <div class="text-center py-10 text-muted">
                        <i class="bi bi-chat-square-text fs-1 d-block mb-3 opacity-50"></i>
                        <p class="fs-5 fw-bold mb-1">No posts yet</p>
                        <p class="fs-7">Be the first to post in <?php echo htmlspecialchars($community_name); ?>!</p>
                        <a href="/Discourse/posts/index.php?action=create&c=<?php echo urlencode($community_name); ?>" class="btn btn-sm mt-3" style="background:#0b301f;color:#fff;">
                          <i class="bi bi-plus-lg me-1"></i> Create Post
                        </a>
                      </div>
                    <?php }
                    foreach ($posts as $post) {
                      $c_isAnon = (!empty($post['is_anonymous']));
                      $c_avatar = $c_isAnon ? '/Discourse/assets/images/anonymous.png' : (!empty($post['avatar']) ? $post['avatar'] : '/Discourse/assets/images/anonymous.png');
                      $c_author = $c_isAnon ? 'Anonymous' : ($post['author'] ?? 'User');
                      $c_profileHref = ($c_isAnon || empty($post['author_id'])) ? 'javascript:void(0)' : '/Discourse/profiles/index.php?id=' . urlencode($post['author_id']);
                      $c_commDetails = getCommunityIconDetails($community_name);
                      $c_saved = IS_POST_SAVED($post['id'], $identification);
                      $c_commentCount = $post['comments_count'] ?? 0;
                    ?>
                      <!-- ── Post Card ── -->
                      <?php 
                      $c_highlighted = ($post['is_highlighted'] == 1);
                      $card_classes = 'card border-0 shadow mb-5';
                      if (!empty($post['is_announcement'])) {
                          $card_classes .= ' post-card-announcement border-start border-4 border-success';
                      } elseif ($c_highlighted) {
                          $card_classes .= ' post-card-highlighted border-start border-4 border-warning';
                      }
                      $card_style = '';
                      if (!empty($post['is_announcement'])) {
                          $card_style = 'background: #f4faf6;';
                      } elseif ($c_highlighted) {
                          $card_style = 'background: #fffdf5;';
                      }
                      ?>
                      <div class="<?php echo $card_classes; ?>" data-dc="post-card" data-post-id="<?php echo $post['id']; ?>" style="<?php echo $card_style; ?>">
                        <div class="d-flex">

                          <?php
                          $vote_bg = '#e8ede9';
                          if (!empty($post['is_announcement'])) {
                              $vote_bg = '#e2f0e7';
                          } elseif ($c_highlighted) {
                              $vote_bg = '#fff8e1';
                          }
                          ?>
                          <!-- Vote Column -->
                          <div class="d-flex flex-column align-items-center gap-1 p-3" style="width:55px;flex-shrink:0;background-color:<?php echo $vote_bg; ?>;">
                            <button type="button" class="btn btn-sm btn-tertiary dc-vote-up" title="Upvote">
                              <i class="bi bi-hand-thumbs-up p-0"></i>
                            </button>
                            <span class="fs-7 fw-bold text-gray-600 dc-vote-count"><?php echo $post['votes']; ?></span>
                            <button type="button" class="btn btn-sm btn-tertiary dc-vote-down" title="Downvote">
                              <i class="bi bi-hand-thumbs-down p-0"></i>
                            </button>
                          </div>

                          <!-- Post Content -->
                          <div class="d-flex flex-column py-5 flex-grow-1">
                            <div class="row g-0 px-5">

                              <!-- Row 1: Community badge + Report button -->
                              <div class="col-12 mb-2">
                                <div class="d-flex justify-content-between align-items-center">
                                  <div class="d-flex align-items-center gap-2">
                                    <a href="/Discourse/communities/index.php?c=<?php echo urlencode($community_name); ?>" class="d-flex align-items-center gap-2 text-decoration-none">
                                      <div class="d-flex align-items-center justify-content-center rounded-2 <?php echo $c_commDetails['bg_class']; ?>"
                                           style="width: 24px; height: 24px;">
                                        <i class="bi <?php echo $c_commDetails['icon']; ?> fs-8 <?php echo $c_commDetails['text_class']; ?>"></i>
                                      </div>
                                      <span class="fw-bold text-gray-800 text-hover-primary fs-7">c/<?php echo htmlspecialchars($community_name); ?></span>
                                    </a>
                                    <?php if (!empty($post['is_announcement'])) { ?>
                                    <span class="badge badge-light-success d-flex align-items-center gap-1 px-3 py-1 fw-bolder fs-8 rounded-pill">
                                      <i class="bi bi-megaphone-fill fs-9 text-success"></i> ANNOUNCEMENT
                                    </span>
                                    <?php } elseif ($c_highlighted) { ?>
                                    <span class="badge badge-light-warning d-flex align-items-center gap-1 px-3 py-1 fw-bolder fs-8 rounded-pill text-warning" style="background-color: rgba(255, 193, 7, 0.15); color: #b58105 !important;">
                                      <i class="bi bi-star-fill fs-9 text-warning"></i> HIGHLIGHTED
                                    </span>
                                    <?php } ?>
                                  </div>
                                  <button class="btn btn-sm dc-post-report" data-bs-toggle="modal" data-bs-target="#modalReportPost">
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
                                    <?php 
                                    $is_post_announcement = !empty($post['is_announcement']);
                                    echo renderTopicBadge($is_post_announcement ? 'ANNOUNCEMENT' : $post['tag']); 
                                    ?>
                                  </div>
                                  <a href="/Discourse/posts/index.php?id=<?php echo $post['id']; ?>&back=community&community=<?php echo urlencode($community_name); ?>" class="text-gray-800 text-hover-primary fs-5 fw-bold dc-post-title-link">
                                    <?php echo htmlspecialchars($post['title']); ?>
                                  </a>
                                  <div class="dc-body-wrap">
                                    <span class="fs-7 text-gray-700 dc-body-clamp"><?php echo linkHashtags(strip_tags($post['body'])); ?></span>
                                    <a href="#" class="dc-see-more-link fw-semibold cursor-pointer d-none" onclick="dcToggleBody(event, this)">See More</a>
                                  </div>
                                  <?php if (!empty($post['image_url'])): ?>
                                  <div class="mt-4 mb-2">
                                      <img src="<?php echo htmlspecialchars($post['image_url']); ?>" alt="Post image" class="img-fluid rounded shadow-sm" style="max-height: 350px; width: auto; object-fit: cover;">
                                  </div>
                                  <?php endif; ?>
                                  <?php if (!$is_post_announcement): ?>
                                  <?php $c_htags = renderHashtagBadges($post['tags'] ?? ''); if ($c_htags): ?>
                                  <div class="d-flex flex-wrap align-items-center gap-1 mt-1">
                                    <?php echo $c_htags; ?>
                                  </div>
                                  <?php endif; ?>
                                  <?php endif; ?>
                                </div>
                              </div>

                            </div>

                            <!-- Actions Row -->
                            <div class="row">
                              <div class="d-flex justify-content-start align-items-center w-100 px-5">
                                <button type="button" class="btn btn-sm dc-post-comment"><i class="bi bi-chat me-1"></i> <?php echo $c_commentCount; ?> Comment<?php echo $c_commentCount == 1 ? '' : 's'; ?></button>
                                <button type="button" class="btn btn-sm dc-post-share"><i class="bi bi-share me-1"></i> Share</button>
                                <button type="button" class="btn btn-sm dc-post-save"
                                        data-on="<?php echo $c_saved ? '1' : '0'; ?>">
                                  <i class="bi <?php echo $c_saved ? 'bi-bookmark-fill' : 'bi-bookmark'; ?> me-1"></i>
                                  <?php echo $c_saved ? 'Saved' : 'Save'; ?>
                                </button>
                                <?php if ($is_community_admin) { 
                                  $c_highlighted = ($post['is_highlighted'] == 1);
                                ?>
                                <button type="button" class="btn btn-sm dc-post-highlight text-warning"
                                        data-post-id="<?php echo $post['id']; ?>"
                                        data-highlighted="<?php echo $c_highlighted ? '1' : '0'; ?>"
                                        style="<?php echo $c_highlighted ? 'background:rgba(255,193,7,.12);color:#b58105;border-color:#ffc107;' : ''; ?>">
                                  <i class="bi <?php echo $c_highlighted ? 'bi-star-fill' : 'bi-star'; ?> me-1"></i>
                                  <?php echo $c_highlighted ? 'Highlighted' : 'Highlight'; ?>
                                </button>
                                <?php } ?>
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
                              <a href="/Discourse/profiles/index.php?id=<?php echo urlencode($c['identification']); ?>" class="d-flex align-items-center gap-3 text-decoration-none">
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
                          <a href="/Discourse/communities/index.php?c=<?php echo urlencode($dc['title']); ?>" class="d-flex align-items-center gap-3 p-2 rounded-3 text-decoration-none" style="transition:background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
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

                <?php include(dirname(__DIR__) . "/partials/_discourse-modals.php"); ?>

                <?php if ($is_community_admin) { ?>
                <!-- Edit Community Modal -->
                <div class="modal fade" id="editCommunityModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered mw-600px">
                        <div class="modal-content border-0 shadow">
                            <div class="modal-header border-0 p-0 rounded-top" style="background-color: <?php echo htmlspecialchars($comm_theme_color); ?>; transition: background-color 0.3s ease;">
                                <h2 class="fw-bolder text-white px-8 py-6 m-0 w-100 d-flex align-items-center gap-2">
                                    <i class="bi bi-pencil-square"></i> Edit Community Settings
                                </h2>
                                <button type="button" class="btn btn-sm btn-icon btn-active-color-primary position-absolute end-0 top-0 mt-4 me-4" data-bs-dismiss="modal">
                                    <i class="bi bi-x-lg fs-4 text-white"></i>
                                </button>
                            </div>
                            <div class="modal-body px-8 py-8">
                                <form id="edit-community-form" enctype="multipart/form-data">
                                    <input type="hidden" id="edit-comm-title" name="title" value="<?php echo htmlspecialchars($community_name); ?>" />
                                    
                                    <div class="fv-row mb-6">
                                        <label class="fs-6 fw-bold mb-2 text-dark">Community Name</label>
                                        <input type="text" class="form-control form-control-solid bg-light text-muted" value="<?php echo htmlspecialchars($community_name); ?>" readonly />
                                        <span class="fs-9 text-muted mt-1 d-block">Community name cannot be modified to preserve links.</span>
                                    </div>
                                    
                                    <div class="fv-row mb-6">
                                        <label class="fs-6 fw-bold mb-2 text-dark">Description</label>
                                        <textarea id="edit-comm-desc" name="desc" class="form-control form-control-solid bg-light" rows="4" required><?php echo htmlspecialchars($comm_desc); ?></textarea>
                                    </div>
                                    
                                    <div class="row mb-6">
                                        <div class="col-6">
                                            <label class="fs-6 fw-bold mb-2 text-dark">Category</label>
                                            <select id="edit-comm-cat" name="category" class="form-select form-select-solid bg-light" required>
                                                <option value="FEU TECH" <?php echo ($comm_data['category'] ?? '') === 'FEU TECH' ? 'selected' : ''; ?>>FEU TECH</option>
                                                <option value="FEU ALABANG" <?php echo ($comm_data['category'] ?? '') === 'FEU ALABANG' ? 'selected' : ''; ?>>FEU ALABANG</option>
                                                <option value="FEU DILIMAN" <?php echo ($comm_data['category'] ?? '') === 'FEU DILIMAN' ? 'selected' : ''; ?>>FEU DILIMAN</option>
                                                <option value="my-communities" <?php echo ($comm_data['category'] ?? '') === 'my-communities' ? 'selected' : ''; ?>>My Communities</option>
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <label class="fs-6 fw-bold mb-2 text-dark">Community Icon</label>
                                            <select id="edit-comm-icon" name="icon" class="form-select form-select-solid bg-light" required>
                                                <option value="bi-people-fill" <?php echo $comm_icon === 'bi-people-fill' ? 'selected' : ''; ?>>People / General</option>
                                                <option value="bi-heart-fill" <?php echo $comm_icon === 'bi-heart-fill' ? 'selected' : ''; ?>>Life / Health</option>
                                                <option value="bi-cup-hot-fill" <?php echo $comm_icon === 'bi-cup-hot-fill' ? 'selected' : ''; ?>>Food / Cafe</option>
                                                <option value="bi-palette-fill" <?php echo $comm_icon === 'bi-palette-fill' ? 'selected' : ''; ?>>Art / Creative</option>
                                                <option value="bi-journal-bookmark-fill" <?php echo $comm_icon === 'bi-journal-bookmark-fill' ? 'selected' : ''; ?>>Academics / Library</option>
                                                <option value="bi-lightbulb-fill" <?php echo $comm_icon === 'bi-lightbulb-fill' ? 'selected' : ''; ?>>Startup / Ideas</option>
                                                <option value="bi-building-fill" <?php echo $comm_icon === 'bi-building-fill' ? 'selected' : ''; ?>>Campus / Buildings</option>
                                                <option value="bi-cpu-fill" <?php echo $comm_icon === 'bi-cpu-fill' ? 'selected' : ''; ?>>Dev / Tech</option>
                                                <option value="bi-mortarboard-fill" <?php echo $comm_icon === 'bi-mortarboard-fill' ? 'selected' : ''; ?>>Graduation</option>
                                                <option value="bi-trophy-fill" <?php echo $comm_icon === 'bi-trophy-fill' ? 'selected' : ''; ?>>Sports / Gaming</option>
                                                <option value="bi-music-note-beamed" <?php echo $comm_icon === 'bi-music-note-beamed' ? 'selected' : ''; ?>>Music / Ent.</option>
                                                <option value="bi-exclamation-circle" <?php echo $comm_icon === 'bi-exclamation-circle' ? 'selected' : ''; ?>>Support / Issues</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="fv-row mb-6">
                                        <label class="fs-6 fw-bold mb-2 text-dark">Theme Color</label>
                                        <div class="d-flex align-items-center gap-3 edit-theme-color-picker flex-wrap">
                                            <?php 
                                            $colors = ['#1A8B44', '#0b5ed7', '#6610f2', '#d63384', '#dc3545', '#6c757d', '#212529', '#198754', '#0dcaf0', '#20c997'];
                                            foreach ($colors as $c) {
                                                $isActive = ($comm_theme_color === $c);
                                            ?>
                                            <div class="w-30px h-30px rounded-circle cursor-pointer border border-2 border-white shadow-sm edit-theme-color-btn <?php echo $isActive ? 'active' : ''; ?>" style="background-color: <?php echo $c; ?>;" data-color="<?php echo $c; ?>"></div>
                                            <?php } ?>
                                            <input type="color" id="edit-comm-theme-color-custom" class="form-control form-control-solid p-0 border-0 cursor-pointer rounded-circle" style="width: 30px; height: 30px;" value="<?php echo htmlspecialchars($comm_theme_color); ?>" title="Choose custom color" />
                                            <input type="hidden" id="edit-comm-color" name="theme_color" value="<?php echo htmlspecialchars($comm_theme_color); ?>" />
                                        </div>
                                    </div>

                                    <div class="fv-row mb-6">
                                        <label class="fs-6 fw-bold mb-2 text-dark">Community Logo / Photo</label>
                                        <input type="file" id="edit-comm-logo" name="logo" class="form-control form-control-solid bg-light" accept="image/*" />
                                    </div>

                                    <div class="fv-row mb-6">
                                        <label class="fs-6 fw-bold mb-2 text-dark">Assign New Admin (Transfer Ownership)</label>
                                        <select id="edit-comm-new-admin" name="new_admin_id" class="form-select form-select-solid bg-light">
                                            <option value="">-- Keep current admin --</option>
                                            <?php 
                                            if ($EDITH) {
                                                $esc_title = $EDITH->real_escape_string($community_name);
                                                $members_res = $EDITH->query(
                                                    "SELECT cm.identification, a.display_name 
                                                     FROM community_members cm
                                                     JOIN accounts a ON cm.identification = a.identification
                                                     WHERE cm.community_title = '$esc_title' AND cm.identification != '$identification'"
                                                );
                                                if ($members_res) {
                                                    while ($member_row = $members_res->fetch_assoc()) {
                                                        echo '<option value="' . htmlspecialchars($member_row['identification']) . '">' . htmlspecialchars($member_row['display_name']) . ' (' . htmlspecialchars($member_row['identification']) . ')</option>';
                                                    }
                                                }
                                            }
                                            ?>
                                        </select>
                                        <span class="fs-9 text-muted mt-1 d-block">Warning: Assigning a new admin will transfer ownership. You will become a regular member.</span>
                                    </div>
                                    
                                    <div class="fv-row mb-8">
                                        <label class="fs-6 fw-bold mb-2 text-dark">Custom Topics (comma-separated)</label>
                                        <input type="text" id="edit-comm-topics" name="custom_topics" class="form-control form-control-solid bg-light" value="<?php echo htmlspecialchars($comm_data['custom_topics'] ?? ''); ?>" placeholder="E.g. Technology, Academics, Gaming" />
                                        <span class="fs-9 text-muted mt-1 d-block">These will appear in the filter dropdown. Leave empty to use default topics.</span>
                                    </div>
                                    
                                    <div class="d-flex flex-stack gap-4">
                                        <button type="button" class="btn btn-light-secondary flex-grow-1 fw-bold bg-white" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-warning flex-grow-1 text-white fw-bolder">SAVE CHANGES</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Add Announcement Modal -->
                <div class="modal fade" id="addAnnouncementModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered mw-600px">
                        <div class="modal-content border-0 shadow">
                            <div class="modal-header border-0 p-0 rounded-top" style="background-color: <?php echo htmlspecialchars($comm_theme_color); ?>;">
                                <h2 class="fw-bolder text-white px-8 py-6 m-0 w-100 d-flex align-items-center gap-2">
                                    <i class="bi bi-megaphone-fill"></i> Post Announcement
                                </h2>
                                <button type="button" class="btn btn-sm btn-icon btn-active-color-primary position-absolute end-0 top-0 mt-4 me-4" data-bs-dismiss="modal">
                                    <i class="bi bi-x-lg fs-4 text-white"></i>
                                </button>
                            </div>
                            <div class="modal-body px-8 py-8">
                                <form id="add-announcement-form">
                                    <input type="hidden" name="community" value="<?php echo htmlspecialchars($community_name); ?>" />
                                    
                                    <div class="fv-row mb-6">
                                        <label class="fs-6 fw-bold mb-2 text-dark">Announcement Title</label>
                                        <input type="text" name="title" class="form-control form-control-solid bg-light" placeholder="E.g. Schedule for Midterm Examinations" required />
                                    </div>
                                    
                                    <div class="fv-row mb-6">
                                        <label class="fs-6 fw-bold mb-2 text-dark">Content</label>
                                        <textarea name="body" class="form-control form-control-solid bg-light" rows="6" placeholder="Write details about the announcement..." required></textarea>
                                    </div>
                                    
                                    <div class="row mb-8">
                                        <div class="col-6">
                                            <label class="fs-6 fw-bold mb-2 text-dark">Topic</label>
                                            <select name="topic" class="form-select form-select-solid bg-light" required>
                                                <?php
                                                $ann_topics = !empty($custom_topics_list) ? $custom_topics_list : ['GENERAL', 'FEU', 'ACADEMICS', 'NEWS', 'TECHNOLOGY', 'LIFESTYLE'];
                                                foreach ($ann_topics as $t) {
                                                ?>
                                                <option value="<?php echo htmlspecialchars(strtoupper($t)); ?>"><?php echo htmlspecialchars($t); ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <label class="fs-6 fw-bold mb-2 text-dark">Tags</label>
                                            <div class="d-flex flex-wrap align-items-center gap-2 form-control form-control-solid bg-light border p-2" id="ann-tag-wrap" onclick="document.getElementById('ann-tag-input').focus()" style="min-height: 42px; cursor: text;">
                                                <input type="text" id="ann-tag-input" class="border-0 bg-transparent flex-grow-1" placeholder="Type tag & press Enter..." style="outline: none; min-width: 100px; font-size: 13px;">
                                            </div>
                                            <input type="hidden" name="tags" id="ann-tags-hidden" value="">
                                        </div>
                                    </div>
                                    
                                    <div class="d-flex flex-stack gap-4">
                                        <button type="button" class="btn btn-light-secondary flex-grow-1 fw-bold bg-white" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-success flex-grow-1 text-white fw-bolder" style="background-color: <?php echo htmlspecialchars($comm_theme_color); ?>; border-color: <?php echo htmlspecialchars($comm_theme_color); ?>;">POST ANNOUNCEMENT</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Delete Community Modal -->
                <div class="modal fade" id="deleteCommunityModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered mw-500px">
                        <div class="modal-content border-0 shadow">
                            <div class="modal-header border-0 pb-0 justify-content-end" style="position: absolute; right: 0; z-index: 10;">
                                <button type="button" class="btn btn-sm btn-icon btn-active-color-danger mt-2 me-2" data-bs-dismiss="modal">
                                    <i class="bi bi-x-lg fs-4 text-gray-500"></i>
                                </button>
                            </div>
                            <div class="modal-body px-8 py-10 text-center">
                                <div class="mb-6">
                                    <div class="w-70px h-70px rounded-circle bg-light-danger d-flex align-items-center justify-content-center mx-auto mb-4">
                                        <i class="bi bi-exclamation-triangle-fill fs-1 text-danger"></i>
                                    </div>
                                    <h2 class="fw-bolder text-gray-900 mb-2">Delete Community</h2>
                                    <p class="text-muted fs-6 mb-6">
                                        This action is <strong>permanent</strong> and cannot be undone.<br>
                                        It will permanently delete the community <strong><?php echo htmlspecialchars($community_name); ?></strong>, along with all posts, comments, memberships, and tags.
                                    </p>
                                </div>
                                
                                <form id="delete-community-form">
                                    <input type="hidden" name="title" value="<?php echo htmlspecialchars($community_name); ?>" />
                                    
                                    <div class="fv-row mb-8 text-start">
                                        <label class="fs-7 fw-bold mb-2 text-gray-700">Type <strong><?php echo htmlspecialchars($community_name); ?></strong> to confirm:</label>
                                        <input type="text" id="delete-confirm-name" class="form-control form-control-solid bg-light" placeholder="Type name here" required />
                                    </div>
                                    
                                    <div class="d-flex gap-4">
                                        <button type="button" class="btn btn-light-secondary flex-grow-1 fw-bold bg-white" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-danger flex-grow-1 fw-bolder">DELETE PERMANENTLY</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>

              </div>
            </main>
          </div>
          <?php include(dirname(__DIR__) . "/partials/_footer.php"); ?>
        </div>
      </div>
    </div>
  </div>
  <?php include(dirname(__DIR__) . "/partials/_scrolltop.php"); ?>

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
        const isAdmin = <?php echo ($is_community_admin) ? 'true' : 'false'; ?>;
        if (joined && isAdmin) {
            alert('You cannot leave this community because you are the admin. Please assign a new admin first.');
            return;
        }
        btn.prop('disabled', true);
        $.ajax({
          url: '/Discourse/communities/index-ajax-join-community.php',
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

      // Theme Color Selection in Edit Modal
      $('.edit-theme-color-btn').on('click', function() {
        $('.edit-theme-color-btn').removeClass('active');
        $('#edit-comm-theme-color-custom').removeClass('active');
        $(this).addClass('active');
        const selectedColor = $(this).attr('data-color');
        $('#edit-comm-color').val(selectedColor);
        $(this).closest('.modal-content').find('.modal-header').css('background-color', selectedColor);
      });
      $('#edit-comm-theme-color-custom').on('input change', function() {
        $('.edit-theme-color-btn').removeClass('active');
        $(this).addClass('active');
        const selectedColor = $(this).val();
        $('#edit-comm-color').val(selectedColor);
        $(this).closest('.modal-content').find('.modal-header').css('background-color', selectedColor);
      });

      // Edit Community Submit Handler
      $('#edit-community-form').on('submit', function(e) {
        e.preventDefault();
        const form = $(this);
        const submitBtn = form.find('button[type="submit"]');
        submitBtn.prop('disabled', true);
        
        var formData = new FormData(this);
        
        $.ajax({
          url: '/Discourse/communities/index-ajax-update-community.php',
          method: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          dataType: 'json',
          success: function(res) {
            if (res.status === 'success') {
              showFeedToast('Community updated successfully!');
              setTimeout(function() {
                location.reload();
              }, 1000);
            } else {
              alert(res.message || 'Failed to update community details.');
              submitBtn.prop('disabled', false);
            }
          },
          error: function() {
            alert('An error occurred. Please try again.');
            submitBtn.prop('disabled', false);
          }
        });
      });

      // Add Announcement Submit Handler
      $('#add-announcement-form').on('submit', function(e) {
        e.preventDefault();
        const form = $(this);
        const submitBtn = form.find('button[type="submit"]');
        submitBtn.prop('disabled', true);
        
        $.ajax({
          url: '/Discourse/posts/index-ajax-add-announcement.php',
          method: 'POST',
          data: form.serialize(),
          dataType: 'json',
          success: function(res) {
            if (res.status === 'success') {
              showFeedToast('Announcement posted!');
              setTimeout(function() {
                location.reload();
              }, 1000);
            } else {
              alert(res.message || 'Failed to post announcement.');
              submitBtn.prop('disabled', false);
            }
          },
          error: function() {
            alert('An error occurred. Please try again.');
            submitBtn.prop('disabled', false);
          }
        });
      });

      // Delete Community Submit Handler
      $('#delete-community-form').on('submit', function(e) {
        e.preventDefault();
        const form = $(this);
        const confirmInput = $('#delete-confirm-name').val().trim();
        const actualName = form.find('input[name="title"]').val().trim();
        
        if (confirmInput !== actualName) {
          alert('Please type the community name exactly as shown to confirm deletion.');
          return;
        }
        
        const submitBtn = form.find('button[type="submit"]');
        submitBtn.prop('disabled', true);
        
        $.ajax({
          url: '/Discourse/communities/index-ajax-delete-community.php',
          method: 'POST',
          data: form.serialize(),
          dataType: 'json',
          success: function(res) {
            if (res.status === 'success') {
              alert('Community deleted successfully. Redirecting to home.');
              location.href = '/Discourse/index.php';
            } else {
              alert(res.message || 'Failed to delete community.');
              submitBtn.prop('disabled', false);
            }
          },
          error: function() {
            alert('An error occurred. Please try again.');
            submitBtn.prop('disabled', false);
          }
        });
      });

      // Announcement hashtag chips logic
      (function() {
          const tagInput = $('#ann-tag-input');
          const tagWrap = $('#ann-tag-wrap');
          const tagsHidden = $('#ann-tags-hidden');
          if (!tagInput.length || !tagWrap.length) return;
          
          let tags = [];

          tagInput.on('keydown', function(e) {
              if ((e.key === 'Enter' || e.key === ',') && tagInput.val().trim()) {
                  e.preventDefault();
                  let val = tagInput.val().trim().replace(/,/g, '');
                  if (val) {
                      if (!val.startsWith('#')) {
                          val = '#' + val;
                      }
                      if (!tags.includes(val)) {
                          tags.push(val);
                          renderTags();
                      }
                  }
                  tagInput.val('');
              }
              if (e.key === 'Backspace' && !tagInput.val() && tags.length) {
                  tags.pop();
                  renderTags();
              }
          });

          function renderTags() {
              tagWrap.find('.badge').remove();
              tags.forEach(function(tag, i) {
                  const badge = $('<span class="badge rounded-pill px-3 py-2 fs-8 d-inline-flex align-items-center gap-1"></span>')
                      .css({'background-color': '#dce8df', 'color': '#3a5c45'})
                      .text(tag);
                  const closeBtn = $('<button type="button" class="btn-close btn-close-sm ms-1" style="font-size:9px; cursor: pointer;"></button>')
                      .on('click', function(e) {
                          e.stopPropagation();
                          tags.splice(i, 1);
                          renderTags();
                      });
                  badge.append(closeBtn);
                  badge.insertBefore(tagInput);
              });
              tagsHidden.val(tags.join(','));
          }

          // Clear tags when modal is hidden or form reset
          $('#addAnnouncementModal').on('hidden.bs.modal', function() {
              tags = [];
              renderTags();
              tagInput.val('');
          });
      })();

      // Highlight Post AJAX
      $(document).on('click', '.dc-post-highlight', function(e) {
        e.preventDefault();
        const btn = $(this);
        const postId = btn.data('post-id');
        const highlighted = btn.data('highlighted') == '1';
        btn.prop('disabled', true);
        
        $.ajax({
          url: '/Discourse/posts/index-ajax-highlight-post.php',
          method: 'POST',
          data: { post_id: postId, action: highlighted ? 'unhighlight' : 'highlight' },
          dataType: 'json',
          success: function(res) {
            if (res.status === 'success') {
              showFeedToast(res.message);
              setTimeout(function() {
                location.reload();
              }, 1000);
            } else {
              alert(res.message || 'Failed to update highlight status.');
              btn.prop('disabled', false);
            }
          },
          error: function() {
            alert('An error occurred. Please try again.');
            btn.prop('disabled', false);
          }
        });
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

      // Check for URL status parameters on load
      const urlParams = new URLSearchParams(window.location.search);
      if (urlParams.get('status') === 'success') {
          showFeedToast('Post created successfully!');
          window.history.replaceState({}, document.title, window.location.pathname + (urlParams.get('c') ? '?c=' + encodeURIComponent(urlParams.get('c')) : ''));
      } else if (urlParams.get('status') === 'error') {
          alert('Failed to create post. Please try again.');
          window.history.replaceState({}, document.title, window.location.pathname + (urlParams.get('c') ? '?c=' + encodeURIComponent(urlParams.get('c')) : ''));
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
  <script src="/Discourse/assets/js/sec-posts.js?v=1.0.5"></script>
</body>

</html>