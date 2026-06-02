<?php
define('MBG', TRUE);
include_once(dirname(dirname(__DIR__)) . '/functions-new.php');

$other_id = isset($_GET['id']) ? trim($_GET['id']) : 'T202210344'; // Sofia Karim
if ($other_id === $identification) {
    header("Location: /Discourse/pages/version/profile.php");
    exit;
}
$other_account = GET_ACCOUNT_DETAILS($other_id);

$META_TITLE = htmlspecialchars($other_account['display_name']) . " - Discourse Profile";
$active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'overview';
$profile_user_name = strtoupper($other_account['display_name']);

// ── Real DB stats for other user ─────────────────────────────
$o_post_count    = 0;
$o_comment_count = 0;
$o_karma         = 0;
$o_joined_count  = 0;
$o_posts         = [];
$o_comments      = [];
$o_communities   = [];

if ($EDITH && $other_id) {
    $oid = $EDITH->real_escape_string($other_id);
    $r = $EDITH->query("SELECT COUNT(*) as c FROM posts WHERE author_id='$oid' AND is_anonymous=0");
    $o_post_count = $r ? (int)$r->fetch_assoc()['c'] : 0;

    $r = $EDITH->query("SELECT COUNT(*) as c FROM comments WHERE author_id='$oid'");
    $o_comment_count = $r ? (int)$r->fetch_assoc()['c'] : 0;

    $r = $EDITH->query("SELECT COALESCE(SUM(upvotes),0) as k FROM posts WHERE author_id='$oid'");
    $o_karma = $r ? (int)$r->fetch_assoc()['k'] : 0;

    $r = $EDITH->query("SELECT COUNT(*) as c FROM community_members WHERE identification='$oid'");
    $o_joined_count = $r ? (int)$r->fetch_assoc()['c'] : 0;

    // Posts
    $stmt = $EDITH->prepare(
        "SELECT p.id, p.title, p.body, p.topic, p.community, p.upvotes, p.downvotes, p.created_at,
                (SELECT COUNT(*) FROM comments c WHERE c.post_id=p.id) AS comment_count
         FROM posts p WHERE p.author_id=? AND p.is_anonymous=0
         ORDER BY p.created_at DESC LIMIT 20"
    );
    if ($stmt) { $stmt->bind_param("s", $other_id); $stmt->execute(); $o_posts = $stmt->get_result()->fetch_all(MYSQLI_ASSOC); $stmt->close(); }

    // Comments
    $stmt = $EDITH->prepare(
        "SELECT c.id, c.body, c.created_at, p.id as post_id, p.title as post_title, p.community
         FROM comments c JOIN posts p ON c.post_id = p.id
         WHERE c.author_id=? ORDER BY c.created_at DESC LIMIT 20"
    );
    if ($stmt) { $stmt->bind_param("s", $other_id); $stmt->execute(); $o_comments = $stmt->get_result()->fetch_all(MYSQLI_ASSOC); $stmt->close(); }

    // Communities this user joined
    $stmt = $EDITH->prepare(
        "SELECT cm.community_title, COALESCE(c.members,0) as members
         FROM community_members cm
         LEFT JOIN communities c ON c.title = cm.community_title
         WHERE cm.identification=? ORDER BY cm.id ASC"
    );
    if ($stmt) { $stmt->bind_param("s", $other_id); $stmt->execute(); $o_communities = $stmt->get_result()->fetch_all(MYSQLI_ASSOC); $stmt->close(); }
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

  <link href="/Discourse/assets/css/discourse-css/profile-other.css" rel="stylesheet" type="text/css" />
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

              <div class="app-container container-xxl">

                <div class="row justify-content-center">
                  <div class="col-lg-8">

                    <!-- Profile Header Card -->
                    <div class="card border-0 shadow-sm mb-6 overflow-hidden">
                      <!-- Cover Photo -->
                      <div class="h-150px w-100 position-relative" style="background: linear-gradient(135deg, #1e7145 0%, #155d38 100%);">
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
                              <img src="<?php echo htmlspecialchars(getUserAvatar($other_id)); ?>" alt="Profile" style="object-fit: cover;">
                            </div>
                          </div>
                          <!-- Info -->
                          <div class="flex-grow-1 d-flex justify-content-between align-items-sm-center flex-column flex-sm-row pb-2 gap-4">
                            <div>
                              <h2 class="fw-bolder text-dark fs-1 mb-1 d-flex align-items-center">
                                <?php echo $profile_user_name; ?> 
                                <i class="ki-duotone ki-verify text-success fs-4 ms-2" title="Verified Student"><span class="path1"></span><span class="path2"></span></i>
                              </h2>
                              <div class="d-flex align-items-center flex-wrap gap-2 text-muted fw-semibold fs-6">
                                <span><i class="ki-duotone ki-book-open text-gray-500 me-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i> BS Computer Science</span>
                                <span>·</span>
                                <span><i class="ki-duotone ki-geolocation text-gray-500 me-1"><span class="path1"></span><span class="path2"></span></i> FEU Tech</span>
                              </div>
                            </div>
                            <!-- Actions (Follow) -->
                            <?php
                            $prof_is_following = false;
                            if ($EDITH && $identification && $other_id) {
                                $stmt_pf = $EDITH->prepare("SELECT id FROM followers WHERE follower_id=? AND following_id=?");
                                $stmt_pf->bind_param("ss", $identification, $other_id);
                                $stmt_pf->execute();
                                $stmt_pf->store_result();
                                $prof_is_following = $stmt_pf->num_rows > 0;
                                $stmt_pf->close();
                            }
                            ?>
                            <div class="flex-shrink-0">
                              <button id="profile-follow-btn"
                                class="btn fw-bold px-6 d-flex align-items-center gap-2 shadow-sm"
                                data-target="<?php echo htmlspecialchars($other_id); ?>"
                                data-following="<?php echo $prof_is_following ? '1' : '0'; ?>"
                                style="<?php echo $prof_is_following
                                    ? 'background:transparent;color:#1A8B44;border:2px solid #1A8B44;'
                                    : 'background:#1A8B44;color:#fff;border:2px solid #1A8B44;'; ?>">
                                <i class="bi <?php echo $prof_is_following ? 'bi-check-lg' : 'bi-person-plus-fill'; ?>"></i>
                                <?php echo $prof_is_following ? 'Followed' : 'Follow'; ?>
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
                                Enthusiastic computer science student passionate about web development, AI, and building communities. Always eager to help out fellow Tamaraws! 💚💛
                              </p>
                            </div>
                          </div>
                          <div class="col-md-5 d-flex justify-content-md-end align-items-start gap-4">
                            <div class="border border-dashed border-gray-300 rounded px-5 py-3 text-center flex-grow-1 flex-md-grow-0">
                              <div class="fs-2 fw-bolder text-dark mb-1"><?php echo $o_joined_count; ?></div>
                              <div class="fw-bold text-gray-500 fs-8 text-uppercase tracking-wider">Communities</div>
                            </div>
                            <div class="border border-dashed border-gray-300 rounded px-5 py-3 text-center flex-grow-1 flex-md-grow-0">
                              <div class="fs-2 fw-bolder text-dark mb-1"><?php echo $o_karma >= 1000 ? round($o_karma/1000,1).'k' : $o_karma; ?></div>
                              <div class="fw-bold text-gray-500 fs-8 text-uppercase tracking-wider">Karma</div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- Tabs -->
                    <div class="d-flex align-items-center gap-6 mb-6 border-bottom border-gray-200 pb-0 overflow-auto flex-nowrap">
                      <a class="profile-tab fw-bolder fs-6 text-muted active py-3 text-nowrap" data-tab="overview">Overview</a>
                      <a class="profile-tab fw-bolder fs-6 text-muted py-3 text-nowrap" data-tab="posts">Posts</a>
                      <a class="profile-tab fw-bolder fs-6 text-muted py-3 text-nowrap" data-tab="comments">Comments</a>
                      <a class="profile-tab fw-bolder fs-6 text-muted py-3 text-nowrap" data-tab="upvoted">Upvoted</a>
                      <a class="profile-tab fw-bolder fs-6 text-muted py-3 text-nowrap" data-tab="communities">Communities</a>
                    </div>

                    <!-- Tab Content -->

                    <!-- Overview Tab -->
                    <div class="tab-pane active" id="tab-overview">
                      <?php if (empty($o_comments) && empty($o_posts)) { ?>
                      <div class="text-center py-10 text-muted">
                        <i class="bi bi-journal-text fs-1 d-block mb-3 opacity-50"></i>
                        <p class="fs-6">No activity yet.</p>
                      </div>
                      <?php }
                      $overview_items = array_slice($o_comments, 0, 5);
                      foreach ($overview_items as $act) {
                        $act['action'] = 'Commented'; $act['action_target'] = '';
                        $act['post_title'] = $act['post_title'] ?? '';
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
                                <span class="fw-bolder text-dark fs-6 me-1"><?php echo htmlspecialchars($other_account['display_name']); ?></span>
                                <span class="text-muted fs-7"><?php echo $act['action']; ?></span>
                                <?php if (!empty($act['action_target'])) { ?>
                                <span class="fw-bolder text-primary fs-7 ms-1"><?php echo $act['action_target']; ?></span>
                                <?php } ?>
                              </div>
                              <span class="text-muted fs-8"><?php echo profile_relative_time($act['created_at'] ?? ''); ?></span>
                            </div>
                          </div>
                          <div class="bg-light rounded p-4 mb-4 border border-gray-200">
                            <div class="d-flex align-items-center gap-2 mb-1">
                              <div class="symbol symbol-20px avatar-circle shadow-sm" style="background-color: #8C9933;">
                                <img src="/Discourse/assets/img/logo/feu-tech.webp" alt="" class="w-100 p-1">
                              </div>
                              <span class="fw-bolder text-dark fs-8">D/<?php echo htmlspecialchars($act['community'] ?? ''); ?></span>
                            </div>
                            <a href="/Discourse/pages/version/view-post.php?id=<?php echo $act['post_id'] ?? ''; ?>" class="fw-bold text-dark text-hover-primary fs-6 d-block mb-1 text-truncate"><?php echo htmlspecialchars($act['post_title'] ?? ''); ?></a>
                          </div>
                          <p class="text-gray-700 fs-6 lh-lg mb-4"><?php echo htmlspecialchars($act['body'] ?? ''); ?></p>
                          <div class="d-flex align-items-center gap-1">
                            <button class="btn btn-sm btn-light-muted vote-btn d-flex align-items-center gap-1 px-3 py-2 rounded-pill"><i class="bi bi-hand-thumbs-up fs-8"></i> <span class="fw-bold fs-8">0</span></button>
                            <button class="btn btn-sm btn-light-muted vote-btn d-flex align-items-center gap-1 px-3 py-2 rounded-pill"><i class="bi bi-share fs-8"></i> <span class="fw-bold fs-8">Share</span></button>
                          </div>
                        </div>
                      </div>
                      <?php } ?>
                    </div>

                    <!-- Posts Tab -->
                    <div class="tab-pane" id="tab-posts">
                      <?php if (empty($o_posts)) { ?>
                      <div class="text-center py-10 text-muted">
                        <i class="bi bi-pencil-square fs-1 d-block mb-3 opacity-50"></i>
                        <p class="fs-6">No posts yet.</p>
                      </div>
                      <?php }
                      foreach ($o_posts as $post) { ?>
                      <div class="card border border-gray-300 shadow-none mb-5 rounded-2">
                        <div class="card-body p-5">
                          <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="symbol symbol-20px avatar-circle shadow-sm" style="background-color: #8C9933;">
                              <img src="/Discourse/assets/img/logo/feu-tech.webp" alt="" class="w-100 p-1">
                            </div>
                            <span class="fw-bold text-dark fs-8"><?php echo htmlspecialchars($post['community']); ?></span>
                            <span class="text-muted fs-9">· <?php echo profile_relative_time($post['created_at']); ?></span>
                          </div>
                          <div class="mb-2 d-flex flex-wrap align-items-center gap-1">
                            <?php echo renderTopicBadge($post['topic'] ?? 'GENERAL'); ?>
                            <?php echo renderHashtagBadges($post['tags'] ?? ''); ?>
                          </div>
                          <h4 class="fw-bolder fs-4 mb-2">
                            <a href="/Discourse/pages/version/view-post.php?id=<?php echo $post['id']; ?>" class="text-dark text-hover-primary"><?php echo htmlspecialchars($post['title']); ?></a>
                          </h4>
                          <?php if (!empty($post['body'])) { ?>
                          <p class="text-gray-700 fs-7 mb-3"><?php echo htmlspecialchars(mb_substr(strip_tags($post['body']), 0, 200)) . (mb_strlen(strip_tags($post['body'])) > 200 ? '...' : ''); ?></p>
                          <?php } ?>
                          <div class="d-flex align-items-center gap-1 pt-2 border-top border-gray-200">
                            <button class="btn btn-sm btn-light-muted vote-btn d-flex align-items-center gap-1 px-2 py-1 rounded-pill"><i class="bi bi-hand-thumbs-up fs-9"></i> <span class="fw-bold fs-9"><?php echo $post['upvotes']; ?></span></button>
                            <button class="btn btn-sm btn-light-muted vote-btn d-flex align-items-center gap-1 px-2 py-1 rounded-pill"><i class="bi bi-hand-thumbs-down fs-9"></i> <span class="fw-bold fs-9"><?php echo $post['downvotes']; ?></span></button>
                            <a href="/Discourse/pages/version/view-post.php?id=<?php echo $post['id']; ?>" class="btn btn-sm btn-light-muted vote-btn d-flex align-items-center gap-1 px-2 py-1 rounded-pill text-decoration-none"><i class="bi bi-chat fs-9"></i> <span class="fw-bold fs-9"><?php echo $post['comment_count'] ?? 0; ?></span></a>
                            <button class="btn btn-sm btn-light-muted vote-btn d-flex align-items-center gap-1 px-2 py-1 rounded-pill"><i class="bi bi-share fs-9"></i> <span class="fw-bold fs-9">Share</span></button>
                          </div>
                        </div>
                      </div>
                      <?php } ?>
                    </div>

                    <!-- Comments Tab -->
                    <div class="tab-pane" id="tab-comments">
                      <?php if (empty($o_comments)) { ?>
                      <div class="text-center py-10 text-muted">
                        <i class="bi bi-chat-left-text fs-1 d-block mb-3 opacity-50"></i>
                        <p class="fs-6">No comments yet.</p>
                      </div>
                      <?php }
                      foreach ($o_comments as $c) { ?>
                      <div class="card border border-gray-300 shadow-none mb-5 highlight-card rounded-2">
                        <div class="card-body p-6">
                          <div class="d-flex align-items-center mb-4">
                            <div class="symbol symbol-40px me-3">
                              <div class="symbol-label fs-7 fw-bold bg-light-info text-info">
                                <i class="ki-duotone ki-message-text-2 fs-4"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                              </div>
                            </div>
                            <div class="flex-grow-1">
                              <div class="d-flex align-items-center">
                                <span class="fw-bolder text-dark fs-6 me-1"><?php echo htmlspecialchars($other_account['display_name']); ?></span>
                                <span class="text-muted fs-7">Commented on a post</span>
                              </div>
                              <span class="text-muted fs-8"><?php echo profile_relative_time($c['created_at']); ?></span>
                            </div>
                          </div>
                          <div class="bg-light rounded p-4 mb-4 border border-gray-200">
                            <div class="d-flex align-items-center gap-2 mb-1">
                              <div class="symbol symbol-20px avatar-circle shadow-sm" style="background-color: #8C9933;">
                                <img src="/Discourse/assets/img/logo/feu-tech.webp" alt="" class="w-100 p-1">
                              </div>
                              <span class="fw-bolder text-dark fs-8">D/<?php echo htmlspecialchars($c['community'] ?? ''); ?></span>
                            </div>
                            <a href="/Discourse/pages/version/view-post.php?id=<?php echo $c['post_id'] ?? ''; ?>" class="fw-bold text-dark text-hover-primary fs-6 d-block mb-1 text-truncate"><?php echo htmlspecialchars($c['post_title'] ?? ''); ?></a>
                          </div>
                          <p class="text-gray-700 fs-6 lh-lg mb-4"><?php echo htmlspecialchars($c['body'] ?? ''); ?></p>
                          <div class="d-flex align-items-center gap-1 mt-2">
                            <button class="btn btn-sm btn-light-muted vote-btn d-flex align-items-center gap-1 px-3 py-2 rounded-pill"><i class="bi bi-hand-thumbs-up fs-8"></i> <span class="fw-bold fs-8">0</span></button>
                            <button class="btn btn-sm btn-light-muted vote-btn d-flex align-items-center gap-1 px-3 py-2 rounded-pill"><i class="bi bi-hand-thumbs-down fs-8"></i> <span class="fw-bold fs-8">0</span></button>
                            <button class="btn btn-sm btn-light-muted vote-btn d-flex align-items-center gap-1 px-3 py-2 rounded-pill"><i class="bi bi-share fs-8"></i> <span class="fw-bold fs-8">Share</span></button>
                          </div>
                        </div>
                      </div>
                      <?php } ?>
                    </div>

                    <!-- Upvoted Tab -->
                    <div class="tab-pane" id="tab-upvoted">
                      <div class="text-center py-10 text-muted">
                        <i class="bi bi-hand-thumbs-up fs-1 d-block mb-3 opacity-50"></i>
                        <p class="fs-6">Upvote tracking coming soon.</p>
                      </div>
                    </div>

                    <!-- Communities Tab -->
                    <div class="tab-pane" id="tab-communities">
                      <div class="row g-4">
                        <?php if (empty($o_communities)) { ?>
                        <div class="col-12 text-center py-10 text-muted">
                          <i class="bi bi-people fs-1 d-block mb-3 opacity-50"></i>
                          <p class="fs-6">Not a member of any community yet.</p>
                        </div>
                        <?php }
                        foreach ($o_communities as $comm) {
                          $mCount = $comm['members'] >= 1000 ? round($comm['members']/1000,1).'k' : $comm['members'];
                        ?>
                        <div class="col-md-6">
                          <div class="card border border-gray-300 shadow-none community-card rounded-2" onclick="window.location.href='/Discourse/pages/version/community.php?c=<?php echo urlencode($comm['community_title']); ?>'">
                            <div class="card-body p-5 d-flex align-items-center gap-4">
                              <div class="w-50px h-50px rounded-3 d-flex align-items-center justify-content-center avatar-circle flex-shrink-0" style="background-color: #8C9933;">
                                <img src="/Discourse/assets/img/logo/feu-tech.webp" alt="">
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
            </main>
          </div>
          <?php include(dirname(dirname(__DIR__)) . "/partials/_footer.php"); ?>
        </div>
      </div>
    </div>
  </div>
  <?php include(dirname(dirname(__DIR__)) . "/partials/_scrolltop.php"); ?>

  <script>
    $(document).ready(function() {
      $('.profile-tab').on('click', function() {
        $('.profile-tab').removeClass('active');
        $(this).addClass('active');
        var tab = $(this).data('tab');
        $('.tab-pane').removeClass('active');
        $('#tab-' + tab).addClass('active');
      });

      $('#profile-follow-btn').on('click', function() {
        const btn = $(this);
        const target = btn.data('target');
        const following = btn.data('following') == '1';
        btn.prop('disabled', true);
        $.ajax({
          url: '/Discourse/pages/version/follow-action.php',
          method: 'POST',
          data: { target_id: target },
          dataType: 'json',
          success: function(res) {
            if (res.success) {
              const nowFollowing = res.following;
              btn.data('following', nowFollowing ? '1' : '0');
              if (nowFollowing) {
                btn.css({'background':'transparent','color':'#1A8B44','border':'2px solid #1A8B44'});
                btn.html('<i class="bi bi-check-lg"></i> Followed');
              } else {
                btn.css({'background':'#1A8B44','color':'#fff','border':'2px solid #1A8B44'});
                btn.html('<i class="bi bi-person-plus-fill"></i> Follow');
              }
            }
          },
          complete: function() { btn.prop('disabled', false); }
        });
      });
    });
  </script>
</body>

</html>
