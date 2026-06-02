<?php
define('MBG', TRUE);
include_once(dirname(dirname(__DIR__)) . '/functions-new.php');

$community_name = isset($_GET['c']) ? trim($_GET['c']) : 'FEU LIFE';

// Fetch community info dynamically from database or session fallback
$community_info = null;

if ($EDITH) {
    // Try exact or case-insensitive match
    $stmt = $EDITH->prepare("SELECT * FROM communities WHERE LOWER(title) = LOWER(?)");
    if ($stmt) {
        $stmt->bind_param("s", $community_name);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res && $res->num_rows > 0) {
            $community_info = $res->fetch_assoc();
        }
        $stmt->close();
    }
    
    // If not found, search space-insensitively
    if (!$community_info) {
        $res = $EDITH->query("SELECT * FROM communities");
        if ($res) {
            $search_clean = strtolower(str_replace(' ', '', $community_name));
            while ($row = $res->fetch_assoc()) {
                $db_clean = strtolower(str_replace(' ', '', $row['title']));
                if ($db_clean === $search_clean) {
                    $community_info = $row;
                    break;
                }
            }
        }
    }
}

// Session mockups fallback
if (!$community_info && isset($_SESSION['mock_communities']) && is_array($_SESSION['mock_communities'])) {
    $search_clean = strtolower(str_replace(' ', '', $community_name));
    foreach ($_SESSION['mock_communities'] as $mc) {
        $mc_clean = strtolower(str_replace(' ', '', $mc['title']));
        if (strtolower($mc['title']) === strtolower($community_name) || $mc_clean === $search_clean) {
            $community_info = $mc;
            break;
        }
    }
}

// Default fallbacks if still not found
if (!$community_info) {
    $fallback_communities = [
        ["title" => "FEU LIFE", "desc" => "Campus life, events, enrollment tips, and all things FEU Institute of Technology.", "category" => "FEU TECH", "members" => 4894, "posts" => 12450, "theme_color" => "#1A8B44"],
        ["title" => "FEU ALABANG LIFE", "desc" => "Campus life, events, enrollment tips, and all things FEU Alabang.", "category" => "FEU ALABANG", "members" => 3201, "posts" => 8400, "theme_color" => "#1A8B44"],
        ["title" => "Freshies", "desc" => "A community for all the newcomers to share their thoughts and get advice.", "category" => "my-communities", "members" => 1500, "posts" => 320, "theme_color" => "#1A8B44"],
        ["title" => "Enrollment", "desc" => "Everything you need to know about enrollment in FEU Diliman.", "category" => "FEU DILIMAN", "members" => 890, "posts" => 120, "theme_color" => "#1A8B44"],
        ["title" => "Cosplaying", "desc" => "A place for cosplayers to meet and share their passion.", "category" => "FEU TECH", "members" => 450, "posts" => 201, "theme_color" => "#1A8B44"],
        ["title" => "FEU TECH DEV", "desc" => "For aspiring developers and software engineers in FEU Tech.", "category" => "FEU TECH", "members" => 2100, "posts" => 5400, "theme_color" => "#1A8B44"],
        ["title" => "Food Trip Around TECH", "desc" => "Best spots to eat around the campus.", "category" => "FEU TECH", "members" => 3400, "posts" => 670, "theme_color" => "#1A8B44"],
        ["title" => "Thesis Advice", "desc" => "Help and resources for your final year project.", "category" => "FEU DILIMAN", "members" => 600, "posts" => 450, "theme_color" => "#1A8B44"],
        ["title" => "Alabang Innovators", "desc" => "Tech startup and innovation community in Alabang.", "category" => "FEU ALABANG", "members" => 210, "posts" => 80, "theme_color" => "#1A8B44"],
        ["title" => "Diliman Artists", "desc" => "Art and creative works from FEU Diliman.", "category" => "FEU DILIMAN", "members" => 750, "posts" => 340, "theme_color" => "#1A8B44"],
        ["title" => "Study Group", "desc" => "Find study partners across all campuses.", "category" => "my-communities", "members" => 1200, "posts" => 890, "theme_color" => "#1A8B44"],
        ["title" => "Tech Support", "desc" => "IT support and discussions for students.", "category" => "FEU TECH", "members" => 850, "posts" => 230, "theme_color" => "#1A8B44"]
    ];
    $search_clean = strtolower(str_replace(' ', '', $community_name));
    foreach ($fallback_communities as $fc) {
        $fc_clean = strtolower(str_replace(' ', '', $fc['title']));
        if (strtolower($fc['title']) === strtolower($community_name) || $fc_clean === $search_clean) {
            $community_info = $fc;
            break;
        }
    }
}

if (!$community_info) {
    $community_info = [
        "title" => $community_name,
        "desc" => "Share academic resources, discuss campus events, and build lasting friendships with fellow students.",
        "category" => "FEU TECH",
        "members" => 1,
        "posts" => 0,
        "theme_color" => "#1A8B44"
    ];
}

$display_community_name = $community_info['title'];
$META_TITLE = $display_community_name . " - Discourse Community";
?>

<!DOCTYPE html>
<html lang="en">

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
      background-color: #0b3220;
      position: relative;
      overflow: hidden;
      border-bottom: 3px solid #fbc501;
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
              <div class="community-banner w-100 mb-8 py-10 position-relative" style="background-color: <?php echo htmlspecialchars($community_info['theme_color'] ?? '#0b3220'); ?> !important;">
                <div class="community-banner-glow"></div>
                <div class="container-xxl position-relative z-index-1">
                    <div class="d-flex align-items-center flex-wrap gap-6">
                      <!-- Community Logo -->
                      <?php
                      $commHeaderDetails = getCommunityIconDetails($community_info['title'], $community_info['category'] ?? null);
                      $commDescription = $community_info['desc'];
                      ?>
                      <div class="flex-shrink-0">
                        <div class="w-100px h-100px w-lg-120px h-lg-120px d-flex align-items-center justify-content-center community-logo-container shadow rounded-3 fs-1"
                             style="background-color: <?php echo $commHeaderDetails['bg_hex']; ?>; color: <?php echo $commHeaderDetails['color_hex']; ?>;">
                          <i class="bi <?php echo $commHeaderDetails['icon']; ?> fs-2hx"></i>
                        </div>
                      </div>
                      <!-- Community Info -->
                      <div class="flex-grow-1 text-start">
                        <h1 class="text-white fw-bolder fs-2tx mb-2"><?php echo htmlspecialchars($display_community_name); ?></h1>
                        <p class="text-white text-opacity-75 fs-6 mb-4 mw-600px"><?php echo htmlspecialchars($commDescription); ?></p>
                        <div class="d-flex gap-3">
                          <div class="border border-white border-opacity-25 rounded px-3 py-1 d-flex align-items-center gap-2">
                            <i class="bi bi-people text-white fs-7"></i>
                            <span class="text-white fw-bold fs-7 dc-members-count-val">
                              <?php echo number_format($community_info['members']); ?>
                            </span>
                            <span class="text-white text-opacity-75 fs-9">Members</span>
                          </div>
                          <div class="border border-white border-opacity-25 rounded px-3 py-1 d-flex align-items-center gap-2">
                            <i class="bi bi-pencil-square text-white fs-7"></i>
                            <span class="text-white fw-bold fs-7">
                              <?php echo number_format($community_info['posts']); ?>
                            </span>
                            <span class="text-white text-opacity-75 fs-9">Posts</span>
                          </div>
                        </div>
                      </div>
                      <!-- Join Button -->
                      <div class="flex-shrink-0 ms-auto">
                        <?php 
                        $is_joined = IS_COMMUNITY_MEMBER($community_info['title'], $identification);
                        ?>
                        <button class="btn fw-bolder text-white px-8 py-3 d-flex align-items-center gap-2 rounded-pill dc-join-btn" 
                                data-comm-title="<?php echo htmlspecialchars($community_info['title']); ?>"
                                style="<?php echo $is_joined ? 'background-color: transparent; border: 1px solid #ffffff; box-shadow: none;' : 'background-color:#fbc501; box-shadow:0 4px 14px rgba(245,166,35,0.3); border: none;'; ?>">
                          <?php if ($is_joined) { ?>
                            <i class="bi bi-check-lg text-white fs-6"></i> JOINED
                          <?php } else { ?>
                            <i class="bi bi-plus-lg text-white fs-6"></i> JOIN COMMUNITY
                          <?php } ?>
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

                          <div class="row g-4 mb-5">
                            <!-- Announcement Card 1 -->
                            <div class="col-6">
                              <a href="/Discourse/pages/version/view-post.php" class="card border-0 shadow-sm rounded-3 h-100 text-decoration-none d-block" style="transition: box-shadow 0.2s;" onmouseover="this.style.boxShadow='0 4px 20px rgba(0,0,0,0.12)'" onmouseout="this.style.boxShadow=''">
                                <div class="card-body p-5">
                                  <h5 class="fw-bolder text-gray-900 fs-4 mb-2">Announcement!</h5>
                                  <div class="d-flex align-items-center gap-3 mb-4">
                                    <span class="text-muted fs-8">8 votes</span>
                                    <span class="text-muted fs-8">·</span>
                                    <span class="text-muted fs-8">100 Comments</span>
                                  </div>
                                  <span class="badge badge-light-warning rounded-pill px-4 py-2 fs-8 fw-bold">Announcements</span>
                                </div>
                              </a>
                            </div>
                            <!-- Announcement Card 2 -->
                            <div class="col-6">
                              <a href="/Discourse/pages/version/view-post.php" class="card border-0 shadow-sm rounded-3 h-100 text-decoration-none d-block" style="transition: box-shadow 0.2s;" onmouseover="this.style.boxShadow='0 4px 20px rgba(0,0,0,0.12)'" onmouseout="this.style.boxShadow=''">
                                <div class="card-body p-5">
                                  <h5 class="fw-bolder text-gray-900 fs-4 mb-2">How to enroll using solar with the help...</h5>
                                  <div class="d-flex align-items-center gap-3 mb-4">
                                    <span class="text-muted fs-8">7 votes</span>
                                    <span class="text-muted fs-8">·</span>
                                    <span class="text-muted fs-8">5 Comments</span>
                                  </div>
                                  <span class="badge badge-light-warning rounded-pill px-4 py-2 fs-8 fw-bold">Announcements</span>
                                </div>
                              </a>
                            </div>
                          </div>

                          <!-- Separator -->
                          <hr class="border-gray-200 my-4">
                        </div>

                        <?php
                        $community_posts = [];
                        if ($EDITH) {
                            $stmt_p = $EDITH->prepare("SELECT p.*, a.display_name, a.avatar_md, a.role as author_role
                                                       FROM posts p
                                                       JOIN accounts a ON p.author_id = a.identification
                                                       WHERE REPLACE(LOWER(p.community), ' ', '') = REPLACE(LOWER(?), ' ', '')
                                                       ORDER BY p.created_at DESC");
                            if ($stmt_p) {
                                $stmt_p->bind_param("s", $community_name);
                                $stmt_p->execute();
                                $res_p = $stmt_p->get_result();
                                while ($row = $res_p->fetch_assoc()) {
                                    // Load comment count
                                    $stmt_cc = $EDITH->prepare("SELECT COUNT(*) as cc FROM comments WHERE post_id = ?");
                                    $stmt_cc->bind_param("i", $row['id']);
                                    $stmt_cc->execute();
                                    $cc_res = $stmt_cc->get_result()->fetch_assoc();
                                    $row['comment_count'] = $cc_res['cc'] ?? 0;
                                    $stmt_cc->close();
                        
                                    // Load comments list
                                    $row['comments'] = [];
                                    $stmt_c = $EDITH->prepare("SELECT c.*, a.avatar_md 
                                                               FROM comments c 
                                                               LEFT JOIN accounts a ON c.author_id = a.identification 
                                                               WHERE c.post_id = ? AND c.parent_id IS NULL
                                                               ORDER BY c.created_at ASC LIMIT 5");
                                    $stmt_c->bind_param("i", $row['id']);
                                    $stmt_c->execute();
                                    $c_res = $stmt_c->get_result();
                                    while ($c_row = $c_res->fetch_assoc()) {
                                        $row['comments'][] = $c_row;
                                    }
                                    $stmt_c->close();
                        
                                    // Load poll options if is_poll
                                    if ($row['is_poll']) {
                                        $options_query = "SELECT * FROM poll_options WHERE post_id = ?";
                                        $stmt_opt = $EDITH->prepare($options_query);
                                        $stmt_opt->bind_param("i", $row['id']);
                                        $stmt_opt->execute();
                                        $opt_res = $stmt_opt->get_result();
                                        $row['poll_options'] = [];
                                        $total_votes = 0;
                                        while ($opt = $opt_res->fetch_assoc()) {
                                            $row['poll_options'][] = $opt;
                                            $total_votes += $opt['votes'];
                                        }
                                        $row['total_poll_votes'] = $total_votes;
                                        $stmt_opt->close();
                                    }
                                    $community_posts[] = $row;
                                }
                                $stmt_p->close();
                            }
                        }
                        
                        // Add session mock posts if any match this community
                        if (isset($_SESSION['mock_posts']) && is_array($_SESSION['mock_posts'])) {
                            $existing_ids = array_column($community_posts, 'id');
                            $existing_slugs = array_column($community_posts, 'slug');
                            foreach ($_SESSION['mock_posts'] as $mp) {
                                if (str_replace(' ', '', strtolower($mp['community'])) === str_replace(' ', '', strtolower($community_name))) {
                                    if (!in_array($mp['id'], $existing_ids) && !in_array($mp['slug'], $existing_slugs)) {
                                        array_unshift($community_posts, $mp);
                                    }
                                }
                            }
                        }
                        
                        if (empty($community_posts)) {
                            // Mock fallback matching exactly the existing design (with some dynamic enhancements)
                            $community_posts = [
                                [
                                    'id' => 10,
                                    'title' => 'Lorem ipsum dolor sit amet consectetur adipiscing elit.',
                                    'body' => 'Lorem ipsum dolor sit amet consectetur adipiscing elit. Quisque faucibus ex sapien vitae pellentesque sem placerat. In id cursus mi pretium tellus duis convallis. Tempus leo eu aenean sed diam urna tempor. Pulvinar vivamus fringilla lacus nec metus bibendum egestas...',
                                    'author_id' => 'T202210344',
                                    'display_name' => 'Sofia Karim',
                                    'avatar_md' => 'https://ui-avatars.com/api/?name=Sofia+Karim&background=f3f4f6&color=d97706&rounded=true',
                                    'community' => $community_name,
                                    'topic' => 'FEUTech',
                                    'tags' => 'FEUTech',
                                    'slug' => 'lorem-ipsum-community-mock-1',
                                    'upvotes' => 90,
                                    'downvotes' => 0,
                                    'comment_count' => 1,
                                    'is_anonymous' => 0,
                                    'is_poll' => 0,
                                    'created_at' => date('Y-m-d H:i:s', strtotime('-2 weeks')),
                                    'comments' => [
                                        [
                                            'author_name' => 'Sofia Karim',
                                            'avatar_md' => 'https://ui-avatars.com/api/?name=Sofia+Karim&background=f3f4f6&color=d97706&rounded=true',
                                            'body' => 'This discussion thread is super helpful! Thanks for posting.',
                                            'created_at' => date('Y-m-d H:i:s', strtotime('-2 days'))
                                        ]
                                    ]
                                ],
                                [
                                    'id' => 11,
                                    'title' => "How to handle thesis group members who don't contribute?",
                                    'body' => "It's defense week and one of our members hasn't updated their part in over a month. We've reached out multiple times but keep getting left on read. Should we remove their name or just talk to the advisor?",
                                    'author_id' => 'T202102837',
                                    'display_name' => 'Marco Torres',
                                    'avatar_md' => 'https://ui-avatars.com/api/?name=Marco+Torres&background=e0f2fe&color=0369a1&rounded=true',
                                    'community' => $community_name,
                                    'topic' => 'FEULife',
                                    'tags' => 'FEULife',
                                    'slug' => 'handle-thesis-group-members-no-contribution',
                                    'upvotes' => 45,
                                    'downvotes' => 0,
                                    'comment_count' => 1,
                                    'is_anonymous' => 0,
                                    'is_poll' => 0,
                                    'created_at' => date('Y-m-d H:i:s', strtotime('-4 hours')),
                                    'comments' => [
                                        [
                                            'author_name' => 'Marco Torres',
                                            'avatar_md' => 'https://ui-avatars.com/api/?name=Marco+Torres&background=e0f2fe&color=0369a1&rounded=true',
                                            'body' => "Definitely talk to your advisor. Document everything so you have proof of your attempts to contact them.",
                                            'created_at' => date('Y-m-d H:i:s', strtotime('-2 hours'))
                                        ]
                                    ]
                                ],
                                [
                                    'id' => 6,
                                    'title' => 'FEU Tech library study rooms — worth booking or just use the hallway?',
                                    'body' => 'Finally tried booking one of the new study rooms in the library. Honest review: the booking system is clunky, the AC is questionable, but the whiteboard is excellent. Hallway is always too noisy for group discussions.',
                                    'author_id' => 'T202210202',
                                    'display_name' => 'Catalina Smith',
                                    'avatar_md' => '/Discourse/assets/images/catalina.webp',
                                    'community' => $community_name,
                                    'topic' => 'FEUTech',
                                    'tags' => 'FEUTech',
                                    'slug' => 'feu-tech-library-study-rooms',
                                    'upvotes' => 124,
                                    'downvotes' => 0,
                                    'comment_count' => 1,
                                    'is_anonymous' => 0,
                                    'is_poll' => 0,
                                    'created_at' => date('Y-m-d H:i:s', strtotime('-1 day')),
                                    'comments' => [
                                        [
                                            'author_name' => 'Catalina Smith',
                                            'avatar_md' => '/Discourse/assets/images/catalina.webp',
                                            'body' => 'Booking a room is definitely worth it if you can secure one! Whiteboards make study sessions much easier.',
                                            'created_at' => date('Y-m-d H:i:s', strtotime('-30 minutes'))
                                        ]
                                    ]
                                ]
                            ];
                        }

                        // Extract unique topics for this community from its posts
                        $available_topics = [];
                        foreach ($community_posts as $post) {
                            if (!empty($post['topic'])) {
                                $available_topics[] = strtoupper(trim($post['topic']));
                            }
                        }
                        $available_topics = array_unique($available_topics);
                        asort($available_topics);

                        // Save total count of posts before filtering
                        $total_posts_count = count($community_posts);

                        // Filter posts by selected topic if set
                        $selected_topic = '';
                        if (isset($_GET['topic'])) {
                            $selected_topic = strtoupper(trim($_GET['topic']));
                        } elseif (isset($_GET['t'])) {
                            $selected_topic = strtoupper(trim($_GET['t']));
                        }

                        if ($selected_topic !== '') {
                            $filtered_posts = [];
                            foreach ($community_posts as $post) {
                                if (isset($post['topic']) && strtoupper(trim($post['topic'])) === $selected_topic) {
                                    $filtered_posts[] = $post;
                                }
                            }
                            $community_posts = $filtered_posts;
                        }
                        ?>

                        <!-- Search and New Post Row -->
                        <div class="d-flex flex-column flex-sm-row align-items-stretch align-items-sm-center gap-3 mb-5">
                            <div class="position-relative flex-grow-1">
                                <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-4 text-gray-500 pe-none fs-6"></i>
                                <input type="text" class="form-control bg-white rounded-pill ps-12 fs-6 text-gray-700 search-input-v2 shadow-sm" placeholder="Search discussions, topics, people...">
                            </div>
                            <a href="/Discourse/pages/version/create-post.php?c=<?php echo urlencode($community_name); ?>" class="btn btn-sm rounded-pill fw-bold fs-7 px-5 py-3 d-inline-flex align-items-center justify-content-center gap-1" style="background:#0b301f; color:#fff;">
                                <i class="bi bi-plus-lg me-1 fs-7"></i> New Post
                            </a>
                        </div>
                        
                        <!-- Filters Row -->
                        <div class="d-flex align-items-center justify-content-between border-bottom border-2 border-gray-200 mb-5">
                            <ul class="nav nav-line-tabs nav-line-tabs-2x border-transparent fs-6 fw-bold mb-0" id="discoursePostTabs" role="tablist">
                                <li class="nav-item">
                                    <button class="nav-link active px-3 py-2 px-sm-4 py-sm-3 fs-7 fs-sm-6" data-bs-toggle="tab" data-bs-target="#hot"><i class="bi bi-fire me-1"></i> HOT</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link px-3 py-2 px-sm-4 py-sm-3 fs-7 fs-sm-6" data-bs-toggle="tab" data-bs-target="#new"><i class="bi bi-lightning-charge me-1"></i> NEW</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link px-3 py-2 px-sm-4 py-sm-3 fs-7 fs-sm-6" data-bs-toggle="tab" data-bs-target="#top"><i class="bi bi-trophy me-1"></i> TOP</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link px-3 py-2 px-sm-4 py-sm-3 fs-7 fs-sm-6" data-bs-toggle="tab" data-bs-target="#rising"><i class="bi bi-graph-up-arrow me-1"></i> RISING</button>
                                </li>
                            </ul>
                            <div class="dropdown">
                              <button class="btn btn-sm btn-light rounded-pill border border-gray-300 text-gray-700 fs-7 px-4 py-2 dropdown-toggle" type="button" id="topicsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php echo ($selected_topic !== '') ? htmlspecialchars(ucfirst(strtolower($selected_topic))) : 'All Topics'; ?>
                              </button>
                              <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 p-2 fs-7 min-w-150px" aria-labelledby="topicsDropdown">
                                <li>
                                  <a class="dropdown-item rounded-2 py-2 px-4 text-gray-700 text-hover-success bg-hover-light-success fs-7 <?php echo ($selected_topic === '') ? 'active fw-bold' : ''; ?>" 
                                     href="/Discourse/pages/version/community.php?c=<?php echo urlencode($community_name); ?>">
                                    All Topics
                                  </a>
                                </li>
                                <?php foreach ($available_topics as $top): ?>
                                <li>
                                  <a class="dropdown-item rounded-2 py-2 px-4 text-gray-700 text-hover-success bg-hover-light-success fs-7 <?php echo ($selected_topic === $top) ? 'active fw-bold' : ''; ?>" 
                                     href="/Discourse/pages/version/community.php?c=<?php echo urlencode($community_name); ?>&topic=<?php echo urlencode($top); ?>">
                                    <?php echo htmlspecialchars(ucfirst(strtolower($top))); ?>
                                  </a>
                                </li>
                                <?php endforeach; ?>
                              </ul>
                            </div>
                        </div>
                        
                        <!-- Feed -->
                        <?php
                        // Generate sorted variants
                        $comm_posts_hot = sort_discourse_posts($community_posts, 'hot');
                        $comm_posts_new = sort_discourse_posts($community_posts, 'new');
                        $comm_posts_top = sort_discourse_posts($community_posts, 'top');
                        $comm_posts_rising = sort_discourse_posts($community_posts, 'rising');
                        
                        if (!function_exists('renderCommunityPostCard')) {
                            function renderCommunityPostCard($post, $ACCOUNT) {
                                global $identification;
                                $commDetails = getCommunityIconDetails($post['community']);
                                $isAnon = (isset($post['is_anonymous']) && $post['is_anonymous'] == 1);
                                $avatar = $isAnon ? '/Discourse/assets/images/anonymous.png' : (!empty($post['avatar_md']) ? $post['avatar_md'] : '/Discourse/assets/images/anonymous.png');
                                $authorName = $isAnon ? 'Anonymous' : ($post['display_name'] ?? 'User');
                                $authorLink = $isAnon ? 'javascript:void(0)' : '/Discourse/pages/version/profile-other.php?id=' . $post['author_id'];
                                ?>
                                <div class="card border-0 shadow mb-5 post-card overflow-hidden" data-dc="post-card" data-post-id="<?php echo $post['id']; ?>">
                                    <div class="d-flex">
                                        <!-- Vote Column (Dashboard Style) -->
                                        <div class="d-flex flex-column align-items-center gap-1 p-3" style="width:55px;flex-shrink:0;background-color:#e8ede9;">
                                            <button class="btn btn-sm btn-tertiary vote-btn-v2 vote-up-btn" title="Upvote">
                                                <i class="bi bi-hand-thumbs-up p-0"></i>
                                            </button>
                                            <span class="fs-7 fw-bold text-gray-600 vote-count-text"><?php echo $post['upvotes']; ?></span>
                                            <button class="btn btn-sm btn-tertiary vote-btn-v2 vote-down-btn" title="Downvote">
                                                <i class="bi bi-hand-thumbs-down p-0"></i>
                                            </button>
                                        </div>
                                        
                                        <!-- Content Section -->
                                        <div class="d-flex flex-column py-5 flex-grow-1 bg-white text-start">
                                            <div class="row g-0 px-5">
                                                <!-- Row 1: Tag Badge & Report -->
                                                <div class="col-12 mb-2">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <a href="/Discourse/pages/version/community.php?c=<?php echo urlencode($post['community']); ?>" class="d-flex align-items-center gap-2 text-decoration-none">
                                                            <div class="d-flex align-items-center justify-content-center rounded-2 <?php echo $commDetails['bg_class']; ?>"
                                                                 style="width: 24px; height: 24px;">
                                                                <i class="bi <?php echo $commDetails['icon']; ?> fs-8 <?php echo $commDetails['text_class']; ?>"></i>
                                                            </div>
                                                            <span class="fw-bold text-gray-800 text-hover-primary fs-7">c/<?php echo htmlspecialchars($post['community']); ?></span>
                                                        </a>
                                                        <button class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#modalReportPost">
                                                            <i class="bi bi-flag me-1"></i> Report
                                                        </button>
                                                    </div>
                                                </div>
                                                
                                                <!-- Row 2: User avatar, name, time -->
                                                <div class="col-12 mb-2">
                                                    <div class="d-flex gap-3 align-items-center">
                                                        <img src="<?php echo $avatar; ?>" alt="<?php echo htmlspecialchars($authorName); ?>" class="h-40px w-40px rounded-circle" />
                                                        <div class="d-flex flex-column">
                                                            <a href="<?php echo $authorLink; ?>" class="fs-6 fw-bold text-gray-800 text-hover-primary"><?php echo htmlspecialchars($authorName); ?></a>
                                                            <span class="text-muted fs-8"><i class="bi bi-clock me-1 fs-8"></i><?php echo get_relative_time($post['created_at']); ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <!-- Row 3: Title & Excerpt -->
                                                <div class="col-12 mb-2">
                                                    <div class="d-flex flex-column gap-2 text-start">
                                                        <div>
                                                            <?php echo renderCategoryBadge($post['topic']); ?>
                                                        </div>
                                                        <h3 class="fw-bold fs-5 mb-0">
                                                            <a href="/Discourse/pages/version/view-post.php?id=<?php echo $post['id']; ?>" class="text-gray-800 text-hover-primary dc-post-title-link">
                                                                <?php echo htmlspecialchars($post['title']); ?>
                                                            </a>
                                                        </h3>
                                                        <div class="dc-body-wrap">
                                                            <span class="fs-7 text-gray-700 dc-body-clamp"><?php echo strip_tags($post['body']); ?></span>
                                                            <a href="#" class="dc-see-more-link fw-semibold cursor-pointer d-none" onclick="dcToggleBody(event, this)">See More</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <!-- Poll Options (If applicable) -->
                                                <?php if (isset($post['is_poll']) && $post['is_poll'] == 1 && !empty($post['poll_options'])) { ?>
                                                <div class="col-12 mb-2">
                                                  <div class="d-flex flex-column gap-2 mb-2 discourse-poll-options">
                                                    <?php foreach ($post['poll_options'] as $opt) { 
                                                        $pct = ($post['total_poll_votes'] > 0) ? round(($opt['votes'] / $post['total_poll_votes']) * 100) : 0;
                                                    ?>
                                                    <button class="discourse-poll-option" data-poll-id="finals-poll" data-option="<?php echo $opt['id']; ?>" style="--target-width: <?php echo $pct; ?>%;">
                                                      <span class="fs-7 fw-bold text-gray-800"><?php echo htmlspecialchars($opt['option_text']); ?></span>
                                                      <span class="fs-7 fw-bold text-gray-800 discourse-poll-percentage"><?php echo $pct; ?>%</span>
                                                    </button>
                                                    <?php } ?>
                                                  </div>
                                                  <span class="fs-8 text-muted"><?php echo $post['total_poll_votes']; ?> votes · 3 days left</span>
                                                </div>
                                                <?php } ?>
                                            </div>
                                            
                                            <!-- Actions Row -->
                                            <div class="row">
                                                <div class="d-flex justify-content-start align-items-center w-100 px-5">
                                                    <button class="btn btn-sm dc-post-comment"><i class="bi bi-chat me-1"></i> <span class="comment-count-btn-text"><?php echo $post['comment_count']; ?> Comment<?php echo $post['comment_count'] == 1 ? '' : 's'; ?></span></button>
                                                    <button class="btn btn-sm dc-post-share"><i class="bi bi-share me-1"></i> Share</button>
                                                    <?php 
                                                    $is_saved = IS_POST_SAVED($post['id'], $identification);
                                                    ?>
                                                    <button class="btn btn-sm dc-post-save" 
                                                            data-on="<?php echo $is_saved ? '1' : '0'; ?>"
                                                            style="<?php echo $is_saved ? 'background:rgba(13,110,253,.12);color:#0d6efd;border-color:#0d6efd;' : ''; ?>">
                                                        <i class="bi <?php echo $is_saved ? 'bi-bookmark-fill' : 'bi-bookmark'; ?> me-1"></i>
                                                        <?php echo $is_saved ? 'Saved' : 'Save'; ?>
                                                    </button>
                                                </div>
                                            </div>
                        
                                            <!-- Inline Quick Comment Drawer (Dashboard style) -->
                                            <div class="dc-quick-comment-drawer border-top border-gray-200 mt-4 pt-4 px-5 w-100" style="display: none; background-color: #fcfdfc;">
                                                <div class="dc-quick-comments-list mb-4 d-flex flex-column gap-3" style="max-height: 180px; overflow-y: auto;">
                                                  <?php if (!empty($post['comments'])) {
                                                      foreach ($post['comments'] as $comment) { 
                                                          $c_avatar = !empty($comment['avatar_md']) ? $comment['avatar_md'] : 'https://ui-avatars.com/api/?name=' . urlencode($comment['author_name']) . '&background=f3f4f6&color=d97706&rounded=true';
                                                      ?>
                                                      <div class="d-flex align-items-start gap-2 fs-7">
                                                          <img src="<?php echo $c_avatar; ?>" class="h-25px w-25px rounded-circle" alt="<?php echo htmlspecialchars($comment['author_name']); ?>">
                                                          <div class="bg-light p-2 rounded-3 flex-grow-1 text-start">
                                                              <div class="d-flex justify-content-between">
                                                                  <span class="fw-bold text-gray-800"><?php echo htmlspecialchars($comment['author_name']); ?></span>
                                                                  <span class="text-muted fs-9"><?php echo get_relative_time($comment['created_at']); ?></span>
                                                              </div>
                                                              <p class="text-gray-700 m-0 mt-1"><?php echo htmlspecialchars($comment['body']); ?></p>
                                                          </div>
                                                      </div>
                                                      <?php }
                                                  } ?>
                                                </div>
                                                <form class="dc-quick-comment-form">
                                                    <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>" />
                                                    <div class="d-flex align-items-center gap-2">
                                                        <img src="<?php echo !empty($ACCOUNT['avatar_md']) ? $ACCOUNT['avatar_md'] : '/Discourse/assets/images/anonymous.png'; ?>" class="h-30px w-30px rounded-circle" alt="User avatar" />
                                                        <input type="text" class="form-control form-control-sm rounded-pill px-4 fs-7 bg-white border border-gray-300" placeholder="Write a quick comment..." required style="height: 35px;" />
                                                        <button type="submit" class="btn btn-sm btn-success rounded-pill px-4 fw-bold" style="background:#0b301f; color:#fff; border: none; height: 35px;">Post</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                        
                        <div class="tab-content" id="discoursePostTabsContent">
                          <!-- HOT Tab -->
                          <div class="tab-pane fade show active" id="hot" role="tabpanel">
                              <?php if (empty($comm_posts_hot)) { ?>
                                <div class="text-center text-muted py-5 bg-white rounded-3 shadow-sm border border-gray-200">
                                  <i class="bi bi-fire fs-1 d-block mb-2 text-warning"></i>
                                  No hot posts in this community yet.
                                </div>
                              <?php } else {
                                foreach ($comm_posts_hot as $post) { renderCommunityPostCard($post, $ACCOUNT); } 
                              } ?>
                          </div>
                          <!-- NEW Tab -->
                          <div class="tab-pane fade" id="new" role="tabpanel">
                              <?php if (empty($comm_posts_new)) { ?>
                                <div class="text-center text-muted py-5 bg-white rounded-3 shadow-sm border border-gray-200">
                                  <i class="bi bi-lightning-charge fs-1 d-block mb-2 text-primary"></i>
                                  No new posts in this community yet.
                                </div>
                              <?php } else {
                                foreach ($comm_posts_new as $post) { renderCommunityPostCard($post, $ACCOUNT); } 
                              } ?>
                          </div>
                          <!-- TOP Tab -->
                          <div class="tab-pane fade" id="top" role="tabpanel">
                              <?php if (empty($comm_posts_top)) { ?>
                                <div class="text-center text-muted py-5 bg-white rounded-3 shadow-sm border border-gray-200">
                                  <i class="bi bi-trophy fs-1 d-block mb-2 text-success"></i>
                                  No top posts in this community yet.
                                </div>
                              <?php } else {
                                foreach ($comm_posts_top as $post) { renderCommunityPostCard($post, $ACCOUNT); } 
                              } ?>
                          </div>
                          <!-- RISING Tab -->
                          <div class="tab-pane fade" id="rising" role="tabpanel">
                              <?php if (empty($comm_posts_rising)) { ?>
                                <div class="text-center text-muted py-5 bg-white rounded-3 shadow-sm border border-gray-200">
                                  <i class="bi bi-graph-up-arrow fs-1 d-block mb-2 text-danger"></i>
                                  No rising posts in this community yet.
                                </div>
                              <?php } else {
                                foreach ($comm_posts_rising as $post) { renderCommunityPostCard($post, $ACCOUNT); } 
                              } ?>
                          </div>
                        </div>

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
                              <span class="fs-5 fw-bolder text-gray-800">4,894</span>
                              <span class="fs-9 text-muted">+56 This Week</span>
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
                              <span class="fs-5 fw-bolder text-gray-800"><?php echo number_format($total_posts_count); ?></span>
                              <span class="fs-9 text-muted">Across <?php echo count($available_topics); ?> <?php echo (count($available_topics) === 1) ? 'Topic' : 'Topics'; ?></span>
                            </div>
                          </div>

                          <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-3">
                              <div class="d-flex align-items-center justify-content-center bg-light-warning rounded-2" style="width:36px;height:36px;flex-shrink:0;">
                                <i class="bi bi-wifi text-warning"></i>
                              </div>
                              <span class="fs-7 fw-bold text-gray-800 text-uppercase" style="letter-spacing:0.06em;">Online Now</span>
                            </div>
                            <div class="d-flex flex-column text-end">
                              <span class="fs-5 fw-bolder text-gray-800">318</span>
                              <span class="fs-9 text-muted">Active Users</span>
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

                          <?php
                          $contributors = [
                            ["name" => "Sofia Karim",  "role" => "BSCSSE",    "avatar" => "https://ui-avatars.com/api/?name=Sofia+Karim&background=f3f4f6&color=d97706&rounded=true",  "posts" => 13, "badge_bg" => "#fef3c7", "badge_color" => "#92400e"],
                            ["name" => "Maria Clara",  "role" => "Moderator", "avatar" => "https://ui-avatars.com/api/?name=Maria+Clara&background=fce7f3&color=9d174d&rounded=true", "posts" => 5,  "badge_bg" => "#dbeafe", "badge_color" => "#1e3a8a"],
                            ["name" => "John Doe",     "role" => "Associate", "avatar" => "https://ui-avatars.com/api/?name=John+Doe&background=fce7f3&color=be185d&rounded=true",    "posts" => 2,  "badge_bg" => "#fce7f3", "badge_color" => "#9d174d"],
                          ];
                          foreach ($contributors as $c): ?>
                          <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-3">
                              <img src="<?php echo $c['avatar']; ?>" alt="<?php echo $c['name']; ?>"
                                   class="rounded-circle" style="width:42px;height:42px;object-fit:cover;border:2px solid #e5e7eb;">
                              <div class="d-flex flex-column">
                                <span class="fs-7 fw-bold text-gray-800"><?php echo $c['name']; ?></span>
                                <span class="fs-9 text-muted"><?php echo $c['role']; ?></span>
                              </div>
                            </div>
                            <span class="rounded-pill px-3 py-1 fs-8 fw-bold"
                                  style="background-color:<?php echo $c['badge_bg']; ?>;color:<?php echo $c['badge_color']; ?>;">
                              <?php echo $c['posts']; ?> Posts
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

                          <a href="/Discourse/pages/version/community.php" class="d-flex align-items-center gap-3 p-2 rounded-3 text-decoration-none" style="transition:background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                            <div class="d-flex align-items-center justify-content-center rounded-2 flex-shrink-0"
                                 style="width:42px;height:42px;background-color:#d1fae5;">
                              <i class="bi bi-cpu" style="color:#065f46;font-size:1.1rem;"></i>
                            </div>
                            <div class="d-flex flex-column flex-grow-1">
                              <span class="fs-7 fw-bold text-gray-800">FEU TECH</span>
                              <span class="fs-9 text-muted"><i class="bi bi-people-fill me-1"></i>4,874</span>
                            </div>
                            <i class="bi bi-arrow-right text-muted fs-7"></i>
                          </a>

                          <a href="/Discourse/pages/version/community.php" class="d-flex align-items-center gap-3 p-2 rounded-3 text-decoration-none" style="transition:background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                            <div class="d-flex align-items-center justify-content-center rounded-2 flex-shrink-0"
                                 style="width:42px;height:42px;background-color:#fef9c3;">
                              <i class="bi bi-building-fill" style="color:#713f12;font-size:1.1rem;"></i>
                            </div>
                            <div class="d-flex flex-column flex-grow-1">
                              <span class="fs-7 fw-bold text-gray-800">FEU ALABANG</span>
                              <span class="fs-9 text-muted"><i class="bi bi-people-fill me-1"></i>5,623</span>
                            </div>
                            <i class="bi bi-arrow-right text-muted fs-7"></i>
                          </a>

                          <a href="/Discourse/pages/version/community.php" class="d-flex align-items-center gap-3 p-2 rounded-3 text-decoration-none" style="transition:background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                            <div class="d-flex align-items-center justify-content-center rounded-2 flex-shrink-0"
                                 style="width:42px;height:42px;background-color:#dbeafe;">
                              <i class="bi bi-mortarboard-fill" style="color:#1e3a8a;font-size:1.1rem;"></i>
                            </div>
                            <div class="d-flex flex-column flex-grow-1">
                              <span class="fs-7 fw-bold text-gray-800">FEU DILIMAN</span>
                              <span class="fs-9 text-muted"><i class="bi bi-people-fill me-1"></i>16,575</span>
                            </div>
                            <i class="bi bi-arrow-right text-muted fs-7"></i>
                          </a>

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
  <script src="/Discourse/assets/js/sec-posts.js"></script>

  <script>
    $(document).ready(function() {
        // 1. Voting Logic
        $(document).on('click', '.vote-btn-v2', function(e) {
            e.preventDefault();
            const btn = $(this);
            const isUpvote = btn.hasClass('vote-up-btn');
            const container = btn.closest('.post-card');
            const scoreSpan = container.find('.vote-count-text');
            const otherBtn = isUpvote ? container.find('.vote-down-btn') : container.find('.vote-up-btn');
            
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
            $('.post-card').each(function() {
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
            const input = form.find('input[type="text"]');
            const commentText = input.val().trim();
            const postId = form.find('input[name="post_id"]').val();
            if (!commentText || !postId) return;

            const card = form.closest('[data-dc="post-card"]');
            const commentsList = card.find('.dc-quick-comments-list');
            const commentCountSpan = card.find('.comment-count-btn-text');

            $.ajax({
                url: '/Discourse/pages/version/add-comment-action.php',
                method: 'POST',
                data: {
                    post_id: postId,
                    body: commentText
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        const avatar = window.currentUser ? window.currentUser.avatar : '/Discourse/assets/images/anonymous.png';
                        const displayName = window.currentUser ? window.currentUser.displayName : 'You';
                        
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
                                <img src="${avatar}" class="h-25px w-25px rounded-circle" alt="User avatar">
                                <div class="bg-light p-2 rounded-3 flex-grow-1 text-start">
                                    <div class="d-flex justify-content-between">
                                        <span class="fw-bold text-gray-800">${displayName}</span>
                                        <span class="text-muted fs-9">just now</span>
                                    </div>
                                    <p class="text-gray-700 m-0 mt-1">${escapeHtml(commentText)}</p>
                                </div>
                            </div>
                        `;

                        commentsList.append(newCommentHtml);
                        commentsList.scrollTop(commentsList[0].scrollHeight);
                        input.val('');

                        // Increment comment count
                        let currentCount = parseInt(commentCountSpan.text()) || 0;
                        currentCount++;
                        commentCountSpan.text(currentCount + (currentCount === 1 ? ' Comment' : ' Comments'));

                        // Show Toast
                        showFeedToast('Comment posted!');
                    } else {
                        alert(response.message || 'Failed to post comment.');
                    }
                },
                error: function() {
                    alert('Error communicating with database.');
                }
            });
        });

        // Toast function
        const feedToast = $('#dc-feed-toast');
        function showFeedToast(msg) {
            if (!feedToast.length) return;
            feedToast.find('span').text(msg);
            feedToast.css('display', 'flex').hide().fadeIn(200);
            clearTimeout(window._dcFeedToast);
            window._dcFeedToast = setTimeout(function () { 
                feedToast.fadeOut(200); 
            }, 2200);
        }

        // Join Community button toggle on detail page
        $(document).on('click', '.dc-join-btn', function(e) {
            e.preventDefault();
            const btn = $(this);
            const commTitle = btn.attr('data-comm-title');

            $.ajax({
                url: '/Discourse/pages/version/join-community-action.php',
                method: 'POST',
                data: { community_title: commTitle },
                dataType: 'json',
                success: function(res) {
                    if (res.success) {
                        if (res.joined) {
                            btn.html('<i class="bi bi-check-lg text-white fs-6"></i> JOINED');
                            btn.css({
                                'background-color': 'transparent',
                                'border': '1px solid #ffffff',
                                'box-shadow': 'none'
                            });
                        } else {
                            btn.html('<i class="bi bi-plus-lg text-white fs-6"></i> JOIN COMMUNITY');
                            btn.css({
                                'background-color': '#fbc501',
                                'border': 'none',
                                'box-shadow': '0 4px 14px rgba(245,166,35,0.3)'
                            });
                        }
                        if (res.members_count !== null) {
                            $('.dc-members-count-val').text(res.members_count.toLocaleString());
                        }
                    } else {
                        alert(res.message || 'Error processing request.');
                    }
                },
                error: function() {
                    alert('Error communicating with database.');
                }
            });
        });
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
  <div id="dc-feed-toast" style="display:none;position:fixed;bottom:1.5rem;right:1.5rem;z-index:1090;" class="align-items-center gap-2 px-4 py-2 bg-light border rounded-2 fs-6 text-gray-700 shadow-sm">
    <i class="bi bi-check-circle-fill text-success fs-6"></i><span></span>
  </div>
</body>

</html>