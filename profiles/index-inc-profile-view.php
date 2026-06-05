<?php
define('MBG', TRUE);
include_once(dirname(__DIR__) . '/functions-new.php');

if (isset($_GET['id']) && trim($_GET['id']) !== $identification) {
    header("Location: /Discourse/profiles/index.php?id=" . urlencode(trim($_GET['id'])));
    exit;
}

$META_TITLE = htmlspecialchars($ACCOUNT['display_name']) . " - Discourse Profile";
$active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'overview';

// ── Real DB stats ────────────────────────────────────────────
$post_count    = 0;
$comment_count = 0;
$karma         = 0;
$joined_count  = 0;
$my_posts      = [];
$my_comments   = [];
$my_communities = [];

if ($EDITH && $identification) {
    $id = $identification;
    $r = $EDITH->query("SELECT COUNT(*) as c FROM posts WHERE author_id='$id' AND is_anonymous=0");
    $post_count = $r ? (int)$r->fetch_assoc()['c'] : 0;

    $r = $EDITH->query("SELECT COUNT(*) as c FROM comments WHERE author_id='$id'");
    $comment_count = $r ? (int)$r->fetch_assoc()['c'] : 0;

    $r = $EDITH->query("SELECT COALESCE(SUM(upvotes),0) as k FROM posts WHERE author_id='$id'");
    $karma = $r ? (int)$r->fetch_assoc()['k'] : 0;

    $r = $EDITH->query("SELECT COUNT(*) as c FROM community_members WHERE identification='$id'");
    $joined_count = $r ? (int)$r->fetch_assoc()['c'] : 0;

    // Posts tab
    $stmt = $EDITH->prepare(
        "SELECT p.id, p.title, p.body, p.topic, p.tags, p.community, p.upvotes, p.downvotes, p.created_at, p.is_announcement, p.image_url, p.is_anonymous,
                (SELECT COUNT(*) FROM comments c WHERE c.post_id=p.id) AS comment_count
         FROM posts p WHERE p.author_id=? AND p.is_anonymous=0
         ORDER BY p.created_at DESC LIMIT 20"
    );
    if ($stmt) {
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $my_posts = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
    }

    // Comments tab
    $stmt = $EDITH->prepare(
        "SELECT c.id, c.body, c.created_at, p.id as post_id, p.title as post_title, p.community
         FROM comments c JOIN posts p ON c.post_id = p.id
         WHERE c.author_id=?
         ORDER BY c.created_at DESC LIMIT 20"
    );
    if ($stmt) {
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $my_comments = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
    }

    // Communities tab
    $stmt = $EDITH->prepare(
        "SELECT cm.community_title, COALESCE(c.members,0) as members
         FROM community_members cm
         LEFT JOIN communities c ON c.title = cm.community_title
         WHERE cm.identification=? ORDER BY cm.id ASC"
    );
    if ($stmt) {
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $my_communities = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
    }
}

if (!function_exists('profile_relative_time')) {
    function profile_relative_time($dt) {
        $t = strtotime($dt); if (!$t) return '1d ago';
        $d = time() - $t;
        if ($d < 60) return 'Just now';
        $d = round($d/60); if ($d < 60) return $d.'m ago';
        $d = round($d/60); if ($d < 24) return $d.'h ago';
        $d = round($d/24); return $d.'d ago';
    }
}
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
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">

  <!-- Metronic Core CSS -->
  <link rel="stylesheet" href="/Discourse/assets/plugins/global/plugins.bundle.css">
  <link rel="stylesheet" href="/Discourse/assets/css/style.keenicons.css">
  <link rel="stylesheet" href="/Discourse/assets/css/style.bundle.v2.full.css">

  <!-- jQuery -->
  <script src="/Discourse/assets/js/jquery.js"></script>

  <link href="/Discourse/assets/css/discourse-css/profile.css" rel="stylesheet" type="text/css" />
  <link href="/Discourse/assets/css/sec-posts.css?v=1.0.7" rel="stylesheet" type="text/css" />
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
              
              <div class="app-container container-xxl">

                <div class="row justify-content-center">
                  <div class="col-lg-8">

                    <!-- Profile Header Card -->
                    <div class="card border-0 shadow-sm mb-6 overflow-hidden">
                      <!-- Cover Photo -->
                      <?php 
                      $coverStyle = 'background: linear-gradient(135deg, #1e7145 0%, #155d38 100%);';
                      if (!empty($ACCOUNT['cover_md'])) {
                          $coverStyle = 'background-image: url(\'' . htmlspecialchars($ACCOUNT['cover_md']) . '\'); background-size: cover; background-position: center;';
                      }
                      ?>
                      <div class="h-150px w-100 position-relative" style="<?php echo $coverStyle; ?>">
                        <!-- Decorative patterns -->
                        <div class="position-absolute top-0 end-0 mt-n10 me-n10 opacity-25">
                          <i class="ki-duotone ki-abstract-14 text-white" style="font-size: 150px;"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                      </div>
                      
                      <div class="card-body p-6 p-lg-8 pt-0 position-relative">
                        <!-- Avatar & Header Info -->
                        <div class="d-flex flex-sm-row flex-column align-items-sm-end mb-6" style="margin-top: -50px;">
                          <div class="me-5 mb-3 mb-sm-0 flex-shrink-0">
                            <div class="w-120px h-120px w-lg-150px h-lg-150px rounded-3 border border-4 border-white shadow-sm d-flex align-items-center justify-content-center avatar-circle bg-white">
                              <img src="<?php echo htmlspecialchars(getUserAvatar($identification)); ?>" alt="Profile" style="object-fit: cover;">
                            </div>
                          </div>
                          <!-- Info -->
                          <div class="flex-grow-1 d-flex justify-content-between align-items-sm-center flex-column flex-sm-row pb-2 gap-4">
                            <div>
                              <h2 class="fw-bolder text-dark fs-1 mb-1 d-flex align-items-center">
                                <?php echo htmlspecialchars(strtoupper($ACCOUNT['display_name'])); ?> 
                                <i class="ki-duotone ki-verify text-success fs-4 ms-2" title="Verified Student"><span class="path1"></span><span class="path2"></span></i>
                              </h2>
                              <div class="d-flex align-items-center flex-wrap gap-2 text-muted fw-semibold fs-6">
                                <span><i class="ki-duotone ki-book-open text-gray-500 me-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i> <?php echo htmlspecialchars($ACCOUNT['program'] ?? 'BS Computer Science'); ?></span>
                                <span>·</span>
                                <span><i class="ki-duotone ki-geolocation text-gray-500 me-1"><span class="path1"></span><span class="path2"></span></i> <?php echo htmlspecialchars($ACCOUNT['campus'] ?? 'FEU Tech'); ?></span>
                              </div>
                            </div>
                            <!-- Actions (Settings) -->
                            <div class="flex-shrink-0">
                              <button class="btn btn-light fw-bold text-gray-700 d-flex align-items-center gap-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#edit_profile_modal">
                                <i class="ki-duotone ki-setting-2 text-gray-700"><span class="path1"></span><span class="path2"></span></i> Edit Profile
                              </button>
                            </div>
                          </div>
                        </div>

                        <!-- Bio and Stats -->
                        <div class="row g-5">
                          <div class="col-md-7">
                            <div class="mb-4">
                              <h4 class="fw-bolder text-dark fs-6 mb-2">About Me</h4>
                              <p class="text-gray-600 fs-6 lh-lg mb-0">
                                <?php echo nl2br(htmlspecialchars($ACCOUNT['bio'] ?? 'Enthusiastic computer science student passionate about web development, AI, and building communities. Always eager to help out fellow Tamaraws! 💚💛')); ?>
                              </p>
                            </div>
                          </div>
                          <div class="col-md-5 d-flex justify-content-md-end align-items-start gap-4">
                            <div class="border border-dashed border-gray-300 rounded px-5 py-3 text-center flex-grow-1 flex-md-grow-0">
                              <div class="fs-2 fw-bolder text-dark mb-1"><?php echo $joined_count; ?></div>
                              <div class="fw-bold text-gray-500 fs-8 text-uppercase tracking-wider">Communities</div>
                            </div>
                            <div class="border border-dashed border-gray-300 rounded px-5 py-3 text-center flex-grow-1 flex-md-grow-0">
                              <div class="fs-2 fw-bolder text-dark mb-1"><?php echo $karma >= 1000 ? round($karma/1000, 1).'k' : $karma; ?></div>
                              <div class="fw-bold text-gray-500 fs-8 text-uppercase tracking-wider">Karma</div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- Tabs -->
                    <div class="d-flex align-items-center gap-6 mb-6 border-bottom border-gray-200 pb-0 overflow-auto flex-nowrap">
                      <a class="profile-tab fw-bolder fs-6 text-muted <?php echo $active_tab === 'overview' ? 'active' : ''; ?> py-3 text-nowrap" data-tab="overview">Overview</a>
                      <a class="profile-tab fw-bolder fs-6 text-muted <?php echo $active_tab === 'posts' ? 'active' : ''; ?> py-3 text-nowrap" data-tab="posts">Posts</a>
                      <a class="profile-tab fw-bolder fs-6 text-muted <?php echo $active_tab === 'comments' ? 'active' : ''; ?> py-3 text-nowrap" data-tab="comments">Comments</a>
                      <a class="profile-tab fw-bolder fs-6 text-muted <?php echo $active_tab === 'upvoted' ? 'active' : ''; ?> py-3 text-nowrap" data-tab="upvoted">Upvoted</a>
                      <a class="profile-tab fw-bolder fs-6 text-muted <?php echo $active_tab === 'downvoted' ? 'active' : ''; ?> py-3 text-nowrap" data-tab="downvoted">Downvoted</a>
                      <a class="profile-tab fw-bolder fs-6 text-muted <?php echo $active_tab === 'saved' ? 'active' : ''; ?> py-3 text-nowrap" data-tab="saved">Saved</a>
                      <a class="profile-tab fw-bolder fs-6 text-muted <?php echo $active_tab === 'communities' ? 'active' : ''; ?> py-3 text-nowrap" data-tab="communities">Communities</a>
                    </div>

                    <!-- Tab Content -->

                    <!-- Overview Tab -->
                    <div class="tab-pane <?php echo $active_tab === 'overview' ? 'active' : ''; ?>" id="tab-overview">
                      <?php if (empty($my_comments) && empty($my_posts)) { ?>
                      <div class="text-center py-10 text-muted">
                        <i class="bi bi-journal-text fs-1 d-block mb-3 opacity-50"></i>
                        <p class="fs-6">No activity yet. Start posting or commenting!</p>
                      </div>
                      <?php } ?>
                      <?php
                      // Show recent comments as activity
                      $overview_items = array_slice($my_comments, 0, 5);
                      foreach ($overview_items as $act) {
                      $act['action'] = 'Commented'; $act['action_target'] = ''; $act['upvotes'] = 0; $act['downvotes'] = 0; $act['comments'] = 0;
                      ?>
                      <div class="card border border-gray-300 shadow-none mb-5 highlight-card rounded-2">
                        <div class="card-body p-6">
                          <!-- Header: Action Context -->
                          <div class="d-flex align-items-center mb-4">
                            <div class="symbol symbol-40px me-3">
                              <div class="symbol-label fs-7 fw-bold bg-light-primary text-primary">
                                <i class="ki-duotone <?php echo $act['action'] == 'Replied to' ? 'ki-message-add' : 'ki-message-text-2'; ?> fs-4"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                              </div>
                            </div>
                            <div class="flex-grow-1">
                              <div class="d-flex align-items-center">
                                <span class="fw-bolder text-dark fs-6 me-1"><?php echo htmlspecialchars(explode(' ', $ACCOUNT['display_name'])[0]); ?></span>
                                <span class="text-muted fs-7"><?php echo $act['action']; ?></span>
                                <?php if (!empty($act['action_target'])) { ?>
                                <span class="fw-bolder text-primary fs-7 ms-1"><?php echo $act['action_target']; ?></span>
                                <?php } ?>
                              </div>
                              <span class="text-muted fs-8"><?php echo profile_relative_time($act['created_at']); ?></span>
                            </div>
                          </div>

                          <!-- Original Post Reference -->
                          <div class="bg-light rounded p-4 mb-4 border border-gray-200">
                            <div class="d-flex align-items-center gap-2 mb-1">
                              <div class="symbol symbol-20px avatar-circle shadow-sm" style="background-color: #8C9933;">
                                <img src="/Discourse/assets/img/logo/feu-tech.webp" alt="" class="w-100 p-1">
                              </div>
                              <span class="fw-bolder text-dark fs-8">D/<?php echo htmlspecialchars($act['community'] ?? ''); ?></span>
                            </div>
                            <a href="/Discourse/posts/index.php?id=<?php echo $act['post_id'] ?? ''; ?>" class="fw-bold text-dark text-hover-primary fs-6 d-block mb-1 text-truncate"><?php echo htmlspecialchars($act['post_title'] ?? ''); ?></a>
                          </div>

                          <!-- Body -->
                          <p class="text-gray-700 fs-6 lh-lg mb-4"><?php echo htmlspecialchars($act['body'] ?? ''); ?></p>
                          
                          <!-- Actions -->
                          <div class="d-flex align-items-center gap-1">
                            <button class="btn btn-sm btn-light-muted vote-btn d-flex align-items-center gap-1 px-3 py-2 rounded-pill">
                              <i class="bi bi-hand-thumbs-up fs-8"></i> <span class="fw-bold fs-8"><?php echo $act['upvotes']; ?></span>
                            </button>
                            <button class="btn btn-sm btn-light-muted vote-btn d-flex align-items-center gap-1 px-3 py-2 rounded-pill">
                              <i class="bi bi-hand-thumbs-down fs-8"></i> <span class="fw-bold fs-8"><?php echo $act['downvotes']; ?></span>
                            </button>
                            <a href="/Discourse/posts/index.php?id=<?php echo $act['post_id'] ?? ''; ?>" class="btn btn-sm btn-light-muted vote-btn d-flex align-items-center gap-1 px-3 py-2 rounded-pill text-decoration-none">
                              <i class="bi bi-chat fs-8"></i> <span class="fw-bold fs-8"><?php echo $act['comments']; ?></span>
                            </a>
                            <button class="btn btn-sm btn-light-muted vote-btn d-flex align-items-center gap-1 px-3 py-2 rounded-pill">
                              <i class="bi bi-share fs-8"></i> <span class="fw-bold fs-8">Share</span>
                            </button>
                          </div>
                        </div>
                      </div>
                      <?php } ?>
                    </div>

                    <!-- Posts Tab -->
                    <div class="tab-pane <?php echo $active_tab === 'posts' ? 'active' : ''; ?>" id="tab-posts">
                      <?php if (empty($my_posts)) { ?>
                      <div class="text-center py-10 text-muted">
                        <i class="bi bi-pencil-square fs-1 d-block mb-3 opacity-50"></i>
                        <p class="fs-6">No posts yet.</p>
                      </div>
                      <?php }
                      foreach ($my_posts as $post) {
                        $post['tag']      = $post['topic'] ?? 'GENERAL';
                        $post['time']     = profile_relative_time($post['created_at']);
                        $post['comments'] = $post['comment_count'] ?? 0;
                        $p_commDetails = getCommunityIconDetails($post['community'] ?? '');
                        $p_saved = IS_POST_SAVED($post['id'], $identification);
                      ?>
                      <!-- ── Post Card ── -->
                      <div class="card border-0 shadow mb-5" data-dc="post-card" data-post-id="<?php echo $post['id']; ?>">
                        <div class="d-flex">

                          <!-- Vote Column -->
                          <div class="d-flex flex-column align-items-center gap-1 p-3" style="width:55px;flex-shrink:0;background-color:#e8ede9;">
                            <button type="button" class="btn btn-sm btn-tertiary dc-vote-up" title="Upvote">
                              <i class="bi bi-hand-thumbs-up p-0"></i>
                            </button>
                            <span class="fs-7 fw-bold text-gray-600 dc-vote-count"><?php echo $post['upvotes']; ?></span>
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
                                  <a href="/Discourse/communities/index.php?c=<?php echo urlencode($post['community'] ?? ''); ?>" class="d-flex align-items-center gap-2 text-decoration-none">
                                    <div class="d-flex align-items-center justify-content-center rounded-2 <?php echo $p_commDetails['bg_class']; ?>"
                                         style="width: 24px; height: 24px;">
                                      <i class="bi <?php echo $p_commDetails['icon']; ?> fs-8 <?php echo $p_commDetails['text_class']; ?>"></i>
                                    </div>
                                    <span class="fw-bold text-gray-800 text-hover-primary fs-7">c/<?php echo htmlspecialchars($post['community'] ?? ''); ?></span>
                                  </a>
                                  <button class="btn btn-sm dc-post-report" data-bs-toggle="modal" data-bs-target="#modalReportPost">
                                    <i class="bi bi-flag me-1"></i> Report
                                  </button>
                                </div>
                              </div>

                              <!-- Row 2: Avatar + Author name + Timestamp -->
                              <div class="col-12 mb-2">
                                <div class="d-flex gap-3 align-items-center">
                                  <img src="<?php echo !empty($ACCOUNT['avatar_md']) ? $ACCOUNT['avatar_md'] : '/Discourse/assets/images/anonymous.png'; ?>" alt="<?php echo htmlspecialchars($ACCOUNT['display_name'] ?? 'User'); ?>" class="h-40px w-40px rounded-circle" />
                                  <div class="d-flex flex-column">
                                    <span class="fs-6 fw-bold text-gray-800"><?php echo htmlspecialchars($ACCOUNT['display_name'] ?? 'User'); ?></span>
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
                                  <a href="/Discourse/posts/index.php?id=<?php echo $post['id']; ?>" class="text-gray-800 text-hover-primary fs-5 fw-bold dc-post-title-link">
                                    <?php echo htmlspecialchars($post['title']); ?>
                                  </a>
                                  <?php if (!empty($post['body'])): ?>
                                  <div class="dc-body-wrap">
                                    <span class="fs-7 text-gray-700 dc-body-clamp"><?php echo linkHashtags(strip_tags($post['body'])); ?></span>
                                    <a href="#" class="dc-see-more-link fw-semibold cursor-pointer d-none" onclick="dcToggleBody(event, this)">See More</a>
                                  </div>
                                  <?php endif; ?>
                                  <?php if (!$is_post_announcement): ?>
                                  <?php $p_htags = renderHashtagBadges($post['tags'] ?? ''); if ($p_htags): ?>
                                  <div class="d-flex flex-wrap align-items-center gap-1 mt-1">
                                    <?php echo $p_htags; ?>
                                  </div>
                                  <?php endif; ?>
                                  <?php endif; ?>
                                </div>
                              </div>

                            </div>

                            <!-- Actions Row -->
                            <div class="row">
                              <div class="d-flex justify-content-start align-items-center w-100 px-5">
                                <button type="button" class="btn btn-sm dc-post-comment"><i class="bi bi-chat me-1"></i> <?php echo $post['comments']; ?> Comment<?php echo $post['comments'] == 1 ? '' : 's'; ?></button>
                                <button type="button" class="btn btn-sm dc-post-share"><i class="bi bi-share me-1"></i> Share</button>
                                 <button type="button" class="btn btn-sm dc-post-save"
                                         data-on="<?php echo $p_saved ? '1' : '0'; ?>">
                                  <i class="bi <?php echo $p_saved ? 'bi-bookmark-fill' : 'bi-bookmark'; ?> me-1"></i>
                                  <?php echo $p_saved ? 'Saved' : 'Save'; ?>
                                </button>
                              </div>
                            </div>

                            <!-- Inline Quick Comment Drawer -->
                            <div class="dc-quick-comment-drawer border-top border-gray-200 mt-4 pt-4 px-5" style="display: none; background-color: #fcfdfc;">
                              <div class="dc-quick-comments-list mb-4 d-flex flex-column gap-3" style="max-height: 180px; overflow-y: auto;"></div>
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

                    <!-- Comments Tab -->
                    <div class="tab-pane <?php echo $active_tab === 'comments' ? 'active' : ''; ?>" id="tab-comments">
                      <?php if (empty($my_comments)) { ?>
                      <div class="text-center py-10 text-muted">
                        <i class="bi bi-chat-left-text fs-1 d-block mb-3 opacity-50"></i>
                        <p class="fs-6">No comments yet.</p>
                      </div>
                      <?php }
                      foreach ($my_comments as $c) {
                        $c['post']      = $c['post_title'];
                        $c['time']      = profile_relative_time($c['created_at']);
                      ?>
                      <div class="card border border-gray-300 shadow-none mb-5 highlight-card rounded-2">
                        <div class="card-body p-6">
                          <!-- Header: Action Context -->
                          <div class="d-flex align-items-center mb-4">
                            <div class="symbol symbol-40px me-3">
                              <div class="symbol-label fs-7 fw-bold bg-light-info text-info">
                                <i class="ki-duotone ki-message-text-2 fs-4"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                              </div>
                            </div>
                            <div class="flex-grow-1">
                              <div class="d-flex align-items-center">
                                <span class="fw-bolder text-dark fs-6 me-1"><?php echo htmlspecialchars(explode(' ', $ACCOUNT['display_name'])[0]); ?></span>
                                <span class="text-muted fs-7">Commented on a post</span>
                              </div>
                              <span class="text-muted fs-8"><?php echo $c['time']; ?></span>
                            </div>
                          </div>

                          <!-- Original Post Reference -->
                          <div class="bg-light rounded p-4 mb-4 border border-gray-200">
                            <div class="d-flex align-items-center gap-2 mb-1">
                              <div class="symbol symbol-20px avatar-circle shadow-sm" style="background-color: #8C9933;">
                                <img src="/Discourse/assets/img/logo/feu-tech.webp" alt="" class="w-100 p-1">
                              </div>
                              <span class="fw-bolder text-dark fs-8">D/<?php echo htmlspecialchars($c['community'] ?? ''); ?></span>
                            </div>
                            <a href="/Discourse/posts/index.php?id=<?php echo $c['post_id'] ?? ''; ?>" class="fw-bold text-dark text-hover-primary fs-6 d-block mb-1 text-truncate"><?php echo htmlspecialchars($c['post'] ?? ''); ?></a>
                          </div>

                          <!-- Body -->
                          <p class="text-gray-700 fs-6 lh-lg mb-4"><?php echo htmlspecialchars($c['body'] ?? ''); ?></p>
                          
                          <!-- Actions -->
                          <div class="d-flex align-items-center gap-1 mt-2">
                            <button class="btn btn-sm btn-light-muted vote-btn d-flex align-items-center gap-1 px-3 py-2 rounded-pill">
                              <i class="bi bi-hand-thumbs-up fs-8"></i> <span class="fw-bold fs-8">3</span>
                            </button>
                            <button class="btn btn-sm btn-light-muted vote-btn d-flex align-items-center gap-1 px-3 py-2 rounded-pill">
                              <i class="bi bi-hand-thumbs-down fs-8"></i> <span class="fw-bold fs-8">1</span>
                            </button>
                            <a href="/Discourse/posts/index.php?id=<?php echo $c['post_id'] ?? ''; ?>" class="btn btn-sm btn-light-muted vote-btn d-flex align-items-center gap-1 px-3 py-2 rounded-pill text-decoration-none">
                              <i class="bi bi-chat fs-8"></i> <span class="fw-bold fs-8">Comments</span>
                            </a>
                            <button class="btn btn-sm btn-light-muted vote-btn d-flex align-items-center gap-1 px-3 py-2 rounded-pill">
                              <i class="bi bi-share fs-8"></i> <span class="fw-bold fs-8">Share</span>
                            </button>
                          </div>
                        </div>
                      </div>
                      <?php } ?>
                    </div>

                    <!-- Upvoted Tab -->
                    <div class="tab-pane <?php echo $active_tab === 'upvoted' ? 'active' : ''; ?>" id="tab-upvoted">
                      <div class="text-center py-10 text-muted">
                        <i class="bi bi-hand-thumbs-up fs-1 d-block mb-3 opacity-50"></i>
                        <p class="fs-6">Upvote tracking coming soon.</p>
                      </div>
                    </div>

                    <!-- Downvoted Tab -->
                    <div class="tab-pane <?php echo $active_tab === 'downvoted' ? 'active' : ''; ?>" id="tab-downvoted">
                      <div class="text-center py-10 text-muted">
                        <i class="bi bi-hand-thumbs-down fs-1 d-block mb-3 opacity-50"></i>
                        <p class="fs-6">Downvote tracking coming soon.</p>
                      </div>
                    </div>
                    
                    <!-- Saved Tab -->
                    <div class="tab-pane <?php echo $active_tab === 'saved' ? 'active' : ''; ?>" id="tab-saved">
                      <?php
                      $saved_posts_list = [];
                      if ($EDITH) {
                          $stmt_s = $EDITH->prepare("SELECT p.*, a.display_name, a.avatar_md, a.role as author_role
                                                     FROM saved_posts sp
                                                     JOIN posts p ON sp.post_id = p.id
                                                     JOIN accounts a ON p.author_id = a.identification
                                                     WHERE sp.identification = ?
                                                     ORDER BY sp.created_at DESC");
                          if ($stmt_s) {
                              $stmt_s->bind_param("s", $identification);
                              $stmt_s->execute();
                              $res_s = $stmt_s->get_result();
                              while ($row = $res_s->fetch_assoc()) {
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
                                                            JOIN accounts a ON c.author_id = a.identification
                                                            WHERE c.post_id = ? AND c.parent_id IS NULL
                                                            ORDER BY c.created_at ASC");
                                  if ($stmt_c) {
                                      $stmt_c->bind_param("i", $row['id']);
                                      $stmt_c->execute();
                                      $res_c = $stmt_c->get_result();
                                      while ($c_row = $res_c->fetch_assoc()) {
                                          $row['comments'][] = $c_row;
                                      }
                                      $stmt_c->close();
                                  }

                                  $saved_posts_list[] = $row;
                              }
                              $stmt_s->close();
                          }
                      }

                      if (empty($saved_posts_list)) {
                      ?>
                          <div class="text-center py-10">
                              <i class="bi bi-bookmark fs-1 text-muted d-block mb-3"></i>
                              <h4 class="fw-bold text-gray-700">No saved posts yet</h4>
                              <p class="text-muted fs-7">Tap the bookmark button on any post to save it here.</p>
                          </div>
                      <?php
                      } else {
                          foreach ($saved_posts_list as $post) {
                              $commDetails = getCommunityIconDetails($post['community']);
                              $isAnon = (isset($post['is_anonymous']) && $post['is_anonymous'] == 1);
                              $avatar = $isAnon ? '/Discourse/assets/images/anonymous.png' : (!empty($post['avatar_md']) ? $post['avatar_md'] : '/Discourse/assets/images/anonymous.png');
                              $authorName = $isAnon ? 'Anonymous' : ($post['display_name'] ?? 'User');
                              $authorLink = $isAnon ? 'javascript:void(0)' : '/Discourse/profiles/index.php?id=' . $post['author_id'];
                              ?>
                              <div class="card border border-gray-300 shadow-none mb-5 post-card overflow-hidden" data-dc="post-card" data-post-id="<?php echo $post['id']; ?>">
                                  <div class="d-flex">
                                      <!-- Vote Column (Dashboard Style) -->
                                      <div class="d-flex flex-column align-items-center gap-1 p-3" style="width:55px;flex-shrink:0;background-color:#e8ede9;">
                                          <button type="button" class="btn btn-sm btn-tertiary vote-btn-v2 vote-up-btn" title="Upvote">
                                              <i class="bi bi-hand-thumbs-up p-0"></i>
                                          </button>
                                          <span class="fs-7 fw-bold text-gray-600 vote-count-text"><?php echo $post['upvotes']; ?></span>
                                          <button type="button" class="btn btn-sm btn-tertiary vote-btn-v2 vote-down-btn" title="Downvote">
                                              <i class="bi bi-hand-thumbs-down p-0"></i>
                                          </button>
                                      </div>
                                      
                                      <!-- Content Section -->
                                      <div class="d-flex flex-column py-5 flex-grow-1 bg-white text-start">
                                          <div class="row g-0 px-5">
                                              <!-- Row 1: Tag Badge & Report -->
                                              <div class="col-12 mb-2">
                                                  <div class="d-flex justify-content-between align-items-center">
                                                      <a href="/Discourse/communities/index.php?c=<?php echo urlencode($post['community']); ?>" class="d-flex align-items-center gap-2 text-decoration-none">
                                                          <div class="d-flex align-items-center justify-content-center rounded-2 <?php echo $commDetails['bg_class']; ?>"
                                                               style="width: 24px; height: 24px;">
                                                              <i class="bi <?php echo $commDetails['icon']; ?> fs-8 <?php echo $commDetails['text_class']; ?>"></i>
                                                          </div>
                                                          <span class="fw-bold text-gray-800 text-hover-primary fs-7">c/<?php echo htmlspecialchars($post['community']); ?></span>
                                                      </a>
                                                      <button type="button" class="btn btn-sm dc-post-report" data-bs-toggle="modal" data-bs-target="#modalReportPost">
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
                                                      <div class="d-flex flex-wrap align-items-center gap-1">
                                                          <?php 
                                                          $is_post_announcement = !empty($post['is_announcement']);
                                                          echo renderTopicBadge($is_post_announcement ? 'ANNOUNCEMENT' : $post['topic']); 
                                                          ?>
                                                          <?php if (!$is_post_announcement): ?>
                                                          <?php echo renderHashtagBadges($post['tags'] ?? ''); ?>
                                                          <?php endif; ?>
                                                      </div>
                                                      <h3 class="fw-bold fs-5 mb-0">
                                                          <a href="/Discourse/posts/index.php?id=<?php echo $post['id']; ?>" class="text-gray-800 text-hover-primary dc-post-title-link">
                                                              <?php echo htmlspecialchars($post['title']); ?>
                                                          </a>
                                                      </h3>
                                                      <div class="dc-body-wrap">
                                                          <span class="fs-7 text-gray-700 dc-body-clamp"><?php echo linkHashtags(strip_tags($post['body'])); ?></span>
                                                          <a href="#" class="dc-see-more-link fw-semibold cursor-pointer d-none" onclick="dcToggleBody(event, this)">See More</a>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                          
                                          <!-- Actions Row -->
                                          <div class="row">
                                              <div class="d-flex justify-content-start align-items-center w-100 px-5">
                                                  <button type="button" class="btn btn-sm dc-post-comment"><i class="bi bi-chat me-1"></i> <span class="comment-count-btn-text"><?php echo $post['comment_count']; ?> Comment<?php echo $post['comment_count'] == 1 ? '' : 's'; ?></span></button>
                                                  <button type="button" class="btn btn-sm dc-post-share"><i class="bi bi-share me-1"></i> Share</button>
                                                  <?php 
                                                  $is_saved = IS_POST_SAVED($post['id'], $identification);
                                                  ?>
                                                   <button type="button" class="btn btn-sm dc-post-save" 
                                                           data-on="<?php echo $is_saved ? '1' : '0'; ?>">
                                                      <i class="bi <?php echo $is_saved ? 'bi-bookmark-fill' : 'bi-bookmark'; ?> me-1"></i>
                                                      <?php echo $is_saved ? 'Saved' : 'Save'; ?>
                                                  </button>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <?php
                          }
                      }
                      ?>
                    </div>

                    <!-- Communities Tab -->
                    <div class="tab-pane <?php echo $active_tab === 'communities' ? 'active' : ''; ?>" id="tab-communities">
                      <div class="row g-4">
                        <?php if (empty($my_communities)) { ?>
                        <div class="col-12 text-center py-10 text-muted">
                          <i class="bi bi-people fs-1 d-block mb-3 opacity-50"></i>
                          <p class="fs-6">You haven't joined any communities yet.</p>
                        </div>
                        <?php }
                        foreach ($my_communities as $comm) {
                          $mCount = $comm['members'] >= 1000 ? round($comm['members']/1000,1).'k' : $comm['members'];
                          $c_commDetails = getCommunityIconDetails($comm['community_title']);
                        ?>
                        <div class="col-md-6">
                          <div class="card border border-gray-300 shadow-none rounded-2" style="cursor:pointer;" onclick="window.location.href='/Discourse/communities/index.php?c=<?php echo urlencode($comm['community_title']); ?>'">
                            <div class="card-body p-5 d-flex align-items-center gap-4">
                              <div class="w-50px h-50px rounded-3 d-flex align-items-center justify-content-center flex-shrink-0 <?php echo $c_commDetails['bg_class']; ?>">
                                <i class="bi <?php echo $c_commDetails['icon']; ?> fs-3 <?php echo $c_commDetails['text_class']; ?>"></i>
                              </div>
                              <div class="flex-grow-1">
                                <h5 class="fw-bolder text-dark fs-5 mb-1"><?php echo htmlspecialchars($comm['community_title']); ?></h5>
                                <div class="d-flex align-items-center gap-1 text-muted fs-8">
                                  <i class="ki-duotone ki-people fs-9"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                                  <span><?php echo $mCount; ?> members</span>
                                </div>
                              </div>
                              <i class="ki-duotone ki-arrow-right text-muted fs-8"><span class="path1"></span><span class="path2"></span></i>
                            </div>
                          </div>
                        </div>
                        <?php } ?>
                      </div>
                    </div>

                  </div>
                </div>

              </div>

              <!-- Edit Profile Modal -->
              <div class="modal fade" id="edit_profile_modal" tabindex="-1" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered mw-650px">
                      <div class="modal-content">
                          <div class="modal-header pb-0 border-0 justify-content-end" style="position: absolute; right: 0; z-index: 10;">
                              <div class="btn btn-sm btn-icon btn-active-color-primary mt-2 me-2" data-bs-dismiss="modal">
                                  <i class="ki-duotone ki-cross fs-2"><span class="path1"></span><span class="path2"></span></i>
                              </div>
                          </div>
                          <div class="modal-header border-0 mb-3 pt-8 px-8">
                              <h2 class="fw-bolder text-dark m-0">Edit Profile</h2>
                          </div>
                          <div class="modal-body px-8 pt-0 pb-8">
                              <form id="edit-profile-form" enctype="multipart/form-data">
                                  <!-- Cover Photo and Avatar Update -->
                                  <div class="mb-8 text-center position-relative">
                                    <?php 
                                    $mCoverStyle = 'background: linear-gradient(135deg, #1e7145 0%, #155d38 100%);';
                                    if (!empty($ACCOUNT['cover_md'])) {
                                        $mCoverStyle = 'background-image: url(\'' . htmlspecialchars($ACCOUNT['cover_md']) . '\'); background-size: cover; background-position: center;';
                                    }
                                    ?>
                                    <div class="h-100px w-100 rounded-3 mb-4" style="<?php echo $mCoverStyle; ?>"></div>
                                    <div class="position-absolute" style="top: 30px; left: 50%; transform: translateX(-50%);">
                                      <div class="image-input image-input-outline image-input-empty" data-kt-image-input="true">
                                          <div class="image-input-wrapper w-100px h-100px rounded-circle shadow-sm border border-4 border-white" style="background-image: url(<?php echo htmlspecialchars(getUserAvatar($identification)); ?>); background-position: center; background-size: cover;"></div>
                                          <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar" style="position: absolute; bottom: 0; right: 0;">
                                              <i class="ki-duotone ki-pencil fs-7"><span class="path1"></span><span class="path2"></span></i>
                                              <input type="file" name="avatar" accept=".png, .jpg, .jpeg, .webp" />
                                          </label>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="mt-12 fv-row mb-6 pt-5">
                                      <label class="fs-6 fw-bold mb-2 text-dark">Name</label>
                                      <input type="text" name="display_name" class="form-control form-control-solid border bg-light" value="<?php echo htmlspecialchars($ACCOUNT['display_name'] ?? ''); ?>" required />
                                  </div>
                                  <div class="fv-row mb-6">
                                      <label class="fs-6 fw-bold mb-2 text-dark">Cover Photo</label>
                                      <input type="file" name="cover" class="form-control form-control-solid border bg-light" accept=".png, .jpg, .jpeg, .webp" />
                                  </div>
                                  <div class="fv-row mb-6">
                                      <label class="fs-6 fw-bold mb-2 text-dark">Program & Campus</label>
                                      <div class="row g-3">
                                        <div class="col-md-6">
                                          <input type="text" name="program" class="form-control form-control-solid border bg-light" value="<?php echo htmlspecialchars($ACCOUNT['program'] ?? 'BS Computer Science'); ?>" />
                                        </div>
                                        <div class="col-md-6">
                                          <input type="text" name="campus" class="form-control form-control-solid border bg-light" value="<?php echo htmlspecialchars($ACCOUNT['campus'] ?? 'FEU Tech'); ?>" />
                                        </div>
                                      </div>
                                  </div>
                                  <div class="fv-row mb-8">
                                      <label class="fs-6 fw-bold mb-2 text-dark">About Me</label>
                                      <textarea name="bio" class="form-control form-control-solid border bg-light" rows="4"><?php echo htmlspecialchars($ACCOUNT['bio'] ?? 'Enthusiastic computer science student passionate about web development, AI, and building communities. Always eager to help out fellow Tamaraws! 💚💛'); ?></textarea>
                                  </div>
                                  <div class="d-flex flex-stack gap-4">
                                      <button type="button" class="btn btn-light bg-white border border-gray-300 fw-bold flex-grow-1" data-bs-dismiss="modal">Cancel</button>
                                      <button type="submit" class="btn fw-bolder text-white flex-grow-1" style="background-color: #1e7145;">Save Changes</button>
                                  </div>
                              </form>
                          </div>
                      </div>
                  </div>
              </div>
            </main>
          </div>
          <?php include(dirname(__DIR__) . "/partials/_footer.php"); ?>
        </div>
      </div>
    </div>
  </div>
  <?php include(dirname(__DIR__) . "/partials/_scrolltop.php"); ?>

  <script>
    $(document).ready(function() {
      $('.profile-tab').on('click', function() {
        $('.profile-tab').removeClass('active');
        $(this).addClass('active');
        var tab = $(this).data('tab');
        $('.tab-pane').removeClass('active');
        $('#tab-' + tab).addClass('active');
      });

      // Submit Profile Changes via AJAX
      $('#edit-profile-form').on('submit', function(e) {
        e.preventDefault();
        const form = $(this);
        const submitBtn = form.find('button[type="submit"]');
        submitBtn.prop('disabled', true);
        
        var formData = new FormData(this);
        
        $.ajax({
          url: '/Discourse/profiles/index-ajax-update-profile.php',
          method: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          dataType: 'json',
          success: function(res) {
            if (res.status === 'success') {
              showFeedToast('Profile updated successfully!');
              $('#edit_profile_modal').modal('hide');
              setTimeout(function() {
                location.reload();
              }, 1000);
            } else {
              alert(res.message || 'Failed to update profile.');
              submitBtn.prop('disabled', false);
            }
          },
          error: function() {
            alert('An error occurred. Please try again.');
            submitBtn.prop('disabled', false);
          }
        });
      });
    });
  </script>
  <script src="/Discourse/assets/js/sec-posts.js?v=1.0.5"></script>
</body>

</html>