<?php
define('MBG', TRUE);
include(dirname(dirname(__DIR__)) . '/functions-new.php');

if (!function_exists('get_relative_time')) {
    function get_relative_time($datetime) {
        $time = strtotime($datetime);
        if (!$time) return '1d ago';
        $now = time();
        $diff = $now - $time;
        if ($diff < 60) {
            return 'Just now';
        }
        $diff = round($diff / 60);
        if ($diff < 60) {
            return $diff . 'm ago';
        }
        $diff = round($diff / 60);
        if ($diff < 24) {
            return $diff . 'h ago';
        }
        $diff = round($diff / 24);
        if ($diff < 30) {
            return $diff . 'd ago';
        }
        return date('F j, Y', $time);
    }
}

$post = null;
$post_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$comments = [];

if ($EDITH && $post_id > 0) {
    $stmt = $EDITH->prepare("SELECT p.*, a.display_name, a.avatar_md, a.role as author_role
                             FROM posts p
                             JOIN accounts a ON p.author_id = a.identification
                             WHERE p.id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $post_id);
        $stmt->execute();
        $post = $stmt->get_result()->fetch_assoc();
        $stmt->close();
    }
    
    if ($post) {
        // Load comments
        $stmt_c = $EDITH->prepare("SELECT c.*, a.avatar_md 
                                   FROM comments c 
                                   LEFT JOIN accounts a ON c.author_id = a.identification 
                                   WHERE c.post_id = ? 
                                   ORDER BY c.created_at ASC");
        if ($stmt_c) {
            $stmt_c->bind_param("i", $post['id']);
            $stmt_c->execute();
            $res_c = $stmt_c->get_result();
            while ($row_c = $res_c->fetch_assoc()) {
                $comments[] = $row_c;
            }
            $stmt_c->close();
        }
        
        // Load poll options if is_poll
        if ($post['is_poll']) {
            $options_query = "SELECT * FROM poll_options WHERE post_id = ?";
            $stmt_opt = $EDITH->prepare($options_query);
            $stmt_opt->bind_param("i", $post['id']);
            $stmt_opt->execute();
            $opt_res = $stmt_opt->get_result();
            $post['poll_options'] = [];
            $total_votes = 0;
            while ($opt = $opt_res->fetch_assoc()) {
                $post['poll_options'][] = $opt;
                $total_votes += $opt['votes'];
            }
            $post['total_poll_votes'] = $total_votes;
            $stmt_opt->close();
        }
    }
}

if (!$post && isset($_SESSION['mock_posts']) && is_array($_SESSION['mock_posts'])) {
    $slug_param = isset($_GET['slug']) ? $_GET['slug'] : '';
    foreach ($_SESSION['mock_posts'] as $mp) {
        if (($post_id > 0 && $mp['id'] === $post_id) || (!empty($slug_param) && $mp['slug'] === $slug_param)) {
            $post = $mp;
            $comments = $mp['comments'] ?? [];
            break;
        }
    }
}

if ($post) {
    $postTitle = $post['title'];
    $postDesc = $post['body'];
    $isAnon = ($post['is_anonymous'] == 1);
    $authorName = $isAnon ? "Anonymous" : $post['display_name'];
    $authorInitials = $isAnon ? "A" : implode("", array_map(function($v) { return !empty($v) ? $v[0] : ''; }, explode(" ", $authorName)));
    $authorAvatar = $isAnon ? "/Discourse/assets/images/anonymous.png" : (!empty($post['avatar_md']) ? $post['avatar_md'] : '');
    $bannerTitle = $post['title'];
    $bannerMeta = $post['community'] . " • Posted by " . $authorName . " • " . get_relative_time($post['created_at']);
    $tag = $post['tags'] ? $post['tags'] : $post['topic'];
    $showImage = !empty($post['image_url']);
    $showPoll = ($post['is_poll'] == 1);
    $showAnon = $isAnon;
    $showSample = false;
    $META_TITLE = $postTitle . " - Discourse";
} else {
    // Fallback to static mockups
    $META_TITLE = "View Post - Discourse";
    $showImage = isset($_GET['img']) && $_GET['img'] == '1';
    $showPoll = isset($_GET['poll']) && $_GET['poll'] == '1';
    $showAnon = isset($_GET['anon']) && $_GET['anon'] == '1';
    $showSample = isset($_GET['sample']) && $_GET['sample'] == '1';

    if ($showImage) {
        $postTitle = "Review: FEU Tech library study rooms — worth booking or just use the hallway?";
        $postDesc = "Finally tried booking one of the new study rooms in the library. Honest review: the booking system is clunky, the AC is questionable, but the soundproofing is actually great. Worth it for group study if you plan ahead.<br><br>Not ideal for solo cramming though — the chairs are surprisingly uncomfortable for long sessions.";
        $authorName = "Catalina Smith";
        $authorInitials = "CS";
        $authorAvatar = ""; // using initials
        $bannerTitle = "FEU Tech library study rooms — honest review";
        $bannerMeta = "FEU • Posted by Catalina Smith • 5d ago";
        $tag = "FEU • Campus Life";
    } elseif ($showPoll) {
        $postTitle = "📊 Poll: How do you actually study for finals? Be honest.";
        $postDesc = "Curious how my fellow FEU Tech students survive finals season. Drop your honest answer below 👇";
        $authorName = "Marco Torres";
        $authorInitials = "MT";
        $authorAvatar = "";
        $bannerTitle = "Poll: How do you actually study for finals?";
        $bannerMeta = "FEU • Posted by Marco Torres • 4h ago";
        $tag = "FEU • Academics";
    } elseif ($showAnon) {
        $postTitle = "What if FEU had a no-grade-penalty mental health leave policy?";
        $postDesc = "Just thinking — a lot of students I know failed a whole semester because they were dealing with severe anxiety during midterms. The university had no mechanism to help them — just a strict drop policy or failure. Other universities have mental health leaves where students can pause without academic penalty. Should FEU implement something similar?";
        $authorName = "Anonymous";
        $authorInitials = "A";
        $authorAvatar = "";
        $bannerTitle = "What if FEU had a no-grade-penalty mental health leave?";
        $bannerMeta = "Ideas • Posted anonymously • 1d ago";
        $tag = "Ideas";
    } elseif ($showSample) {
        $postTitle = "Lorem ipsum dolor sit amet consectetur adipiscing elit.";
        $postDesc = "Lorem ipsum dolor sit amet consectetur adipiscing elit. Quisque faucibus ex sapien vitae pellentesque sem placerat. In id cursus mi pretium tellus duis convallis. Tempus leo eu aenean sed diam uma tempor. Pulvinar vivamus fringilla lacus nec metus bibendum egestas.";
        $authorName = "John Doe";
        $authorInitials = "JD";
        $authorAvatar = "";
        $bannerTitle = "Lorem ipsum dolor sit amet";
        $bannerMeta = "Technology • Posted by John Doe • 1d ago";
        $tag = "Technology";
    } else {
        $postTitle = "The silent revolution in edge AI — why on-device inference is changing everything";
        $postDesc = "We spent a decade optimizing for server-side compute, but the thermal envelope of modern SoCs has quietly crossed a threshold nobody was paying attention to. Here's why 2025 is the last year data centers dominate AI inference at scale.<br><br>The numbers are staggering — a modern mobile chip can...";
        $authorName = "Ravi Joshi";
        $authorInitials = "RJ";
        $authorAvatar = ""; // using initials
        $bannerTitle = "The silent revolution in edge AI";
        $bannerMeta = "Technology • Posted by Ravi Joshi • 3h ago";
        $tag = "Technology";
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
  <link href="/Discourse/assets/css/discourse-css/view-post.css" rel="stylesheet" type="text/css" />
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
              
              <!-- Banner -->
              <div class="page-banner w-100 py-4 mb-5">
                <div class="container-xxl d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-4">
                        <div class="w-40px h-40px d-flex align-items-center justify-content-center bg-light-danger rounded-1 shadow-sm text-danger">
                            <i class="bi bi-heart-fill fs-5"></i>
                        </div>
                        <div>
                            <h2 class="text-white fw-bolder fs-4 mb-0">FEU LIFE Community</h2>
                            <span class="text-white text-opacity-75 fs-8">Public Group • 4.8k Members</span>
                        </div>
                    </div>
                    <a href="/Discourse/pages/version/community.php" class="btn btn-sm btn-outline btn-outline-white text-white border-white border-opacity-25 px-4 py-2 d-flex align-items-center gap-2 text-decoration-none">
                        <i class="ki-duotone ki-arrow-left text-white fs-8"><span class="path1"></span><span class="path2"></span></i> Back to Feed
                    </a>
                </div>
              </div>

              <div class="app-container container-xxl pb-5">
                <div class="row g-5">
                    <!-- Main Post Content -->
                    <div class="col-lg-8">
                        <div class="card border border-gray-300 shadow-none mb-5 post-card overflow-hidden rounded-2">
                            <div class="card-body p-6">
                                
                                <!-- Author Info -->
                                <div class="d-flex align-items-center justify-content-between mb-6">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="symbol symbol-35px symbol-circle">
                                            <div class="symbol-label bg-success text-white fw-bold fs-6"><?php echo $authorInitials; ?></div>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <a href="/Discourse/pages/version/profile-other.php" class="fw-bolder text-dark text-hover-primary fs-6"><?php echo $authorName; ?></a>
                                            <span class="text-muted fs-8">in</span>
                                            <?php 
                                            $commDetails = getCommunityIconDetails('FEU LIFE'); 
                                            ?>
                                            <a href="/Discourse/pages/version/community.php" class="d-inline-flex align-items-center gap-1.5 text-decoration-none">
                                                <div class="d-flex align-items-center justify-content-center rounded-2"
                                                     style="width: 20px; height: 20px; background-color: <?php echo $commDetails['bg_hex']; ?>;">
                                                    <i class="bi <?php echo $commDetails['icon']; ?>"
                                                       style="font-size: 8px; color: <?php echo $commDetails['color_hex']; ?>;"></i>
                                                </div>
                                                <span class="fw-bold text-gray-800 text-hover-primary" style="font-size: 11px;">c/FEU LIFE</span>
                                            </a>
                                            <?php if($showImage) { ?>
                                            <span class="tag-badge rounded-pill d-inline-flex align-items-center gap-1" style="font-size: 9px; padding: 2px 8px; background-color: #dcfce7; color: #166534;">
                                                <i class="ki-duotone ki-check fs-10 text-success"><span class="path1"></span><span class="path2"></span></i> MINE
                                            </span>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="text-muted fs-8 fw-medium">
                                        <?php echo $showImage ? '1d ago' : '3h ago'; ?>
                                    </div>
                                </div>
                                
                                <!-- Post Title & Body -->
                                                                <div class="mb-2 text-start">
                                                                     <?php echo renderCategoryBadge($tag); ?>
                                                                 </div>
                                <h1 class="fw-bolder text-dark fs-2x mb-4"><?php echo $postTitle; ?></h1>
                                <div class="text-gray-800 fs-6 lh-lg mb-6">
                                    <?php 
                                        if($showImage) {
                                            $parts = explode("<br><br>", $postDesc);
                                            echo "<p class='mb-6'>" . $parts[0] . "</p>";
                                        ?>
                                        <!-- Mock Image -->
                                        <div class="mb-6 rounded-2 overflow-hidden position-relative">
                                            <img src="https://images.unsplash.com/photo-1541829070764-84a7d30dd3f3?q=80&w=1200&auto=format&fit=crop" class="w-100 object-fit-cover" style="height: 300px; filter: brightness(0.8) sepia(0.2) hue-rotate(90deg);" alt="Library">
                                            <div class="position-absolute bottom-0 start-0 p-3">
                                                <span class="text-white fs-9" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.8);"><i class="ki-duotone ki-geolocation text-danger me-1"><span class="path1"></span><span class="path2"></span></i> FEU Tech Main Library - Study Room 3B - 3rd Floor</span>
                                            </div>
                                        </div>
                                        <?php
                                            echo "<p class='mb-0'>" . $parts[1] . "</p>";
                                        } elseif($showPoll) {
                                            echo "<p class='mb-4'>" . $postDesc . "</p>";
                                        ?>
                                            <div class="d-flex flex-column gap-2 mb-4 discourse-poll-options" style="max-width: 500px;">
                                                <button class="discourse-poll-option" data-poll-id="finals-poll" data-option="0" style="--target-width: 28%;">
                                                    <span class="fs-7 fw-bold text-gray-800">Start early, study consistently</span>
                                                    <span class="fs-7 fw-bold text-gray-800 discourse-poll-percentage">28%</span>
                                                </button>
                                                <button class="discourse-poll-option" data-poll-id="finals-poll" data-option="1" style="--target-width: 45%;">
                                                    <span class="fs-7 fw-bold text-gray-800">Cram the night before</span>
                                                    <span class="fs-7 fw-bold text-gray-800 discourse-poll-percentage">45%</span>
                                                </button>
                                                <button class="discourse-poll-option" data-poll-id="finals-poll" data-option="2" style="--target-width: 19%;">
                                                    <span class="fs-7 fw-bold text-gray-800">Rely on group chats and past papers</span>
                                                    <span class="fs-7 fw-bold text-gray-800 discourse-poll-percentage">19%</span>
                                                </button>
                                                <button class="discourse-poll-option" data-poll-id="finals-poll" data-option="3" style="--target-width: 8%;">
                                                    <span class="fs-7 fw-bold text-gray-800">Pray and submit anyway</span>
                                                    <span class="fs-7 fw-bold text-gray-800 discourse-poll-percentage">8%</span>
                                                </button>
                                            </div>
                                            <span class="fs-8 text-muted d-block mb-4">442 votes · 3 days left</span>
                                        <?php
                                        } else {
                                            echo "<p>" . $postDesc . "</p>";
                                        }
                                    ?>
                                </div>
                                
                                <!-- Toolbar Actions -->
                                <div class="d-flex align-items-center justify-content-between mb-8 mt-2">
                                    <div class="d-flex align-items-center gap-1">
                                        <button class="btn btn-sm btn-light-muted vote-btn d-flex align-items-center gap-1 px-3 py-2 rounded-pill">
                                            <i class="bi bi-hand-thumbs-up fs-7"></i> <span class="fw-bold fs-8"><?php echo $showImage ? '49' : '12'; ?></span>
                                        </button>
                                        <button class="btn btn-sm btn-light-muted vote-btn d-flex align-items-center gap-1 px-3 py-2 rounded-pill">
                                            <i class="bi bi-hand-thumbs-down fs-7"></i> <span class="fw-bold fs-8">1</span>
                                        </button>
                                        <button class="btn btn-sm btn-light-muted vote-btn d-flex align-items-center gap-1 px-3 py-2 rounded-pill">
                                            <i class="bi bi-chat fs-7"></i> <span class="fw-bold fs-8"><?php echo $showImage ? '1' : '3'; ?></span>
                                        </button>
                                        <button class="btn btn-sm btn-light-muted vote-btn d-flex align-items-center gap-1 px-3 py-2 rounded-pill">
                                            <i class="bi bi-share fs-7"></i> <span class="fw-bold fs-8">Share</span>
                                        </button>
                                    </div>
                                    <button class="btn btn-sm btn-light-muted vote-btn text-danger d-flex align-items-center gap-1 px-3 py-2 rounded-pill">
                                        <i class="bi bi-flag fs-7 text-danger"></i> <span class="fw-bold fs-8">Report</span>
                                    </button>
                                </div>
                                
                                <div class="separator separator-dashed mb-8"></div>
                                
                                <!-- Comments Section -->
                                <div class="mb-6" id="comments-container">
                                    <div class="d-flex align-items-center gap-2 mb-6">
                                        <h4 class="fw-bolder text-dark m-0 fs-5">Comments</h4>
                                        <span class="badge bg-light-success text-success fw-bold rounded-circle w-20px h-20px d-flex align-items-center justify-content-center p-0" id="comment-count-badge" style="font-size: 10px;"><?php 
                                            if ($post) echo count($comments);
                                            elseif ($showImage) echo '1';
                                            elseif ($showPoll) echo '1';
                                            elseif ($showAnon) echo '1';
                                            elseif ($showSample) echo '1';
                                            else echo '3'; 
                                        ?></span>
                                    </div>
                                    
                                    <?php if ($post) { ?>
                                        <?php if (!empty($comments)) { 
                                            foreach ($comments as $comment) {
                                                $c_initials = implode("", array_map(function($v) { return !empty($v) ? $v[0] : ''; }, explode(" ", $comment['author_name'])));
                                                $c_avatar = !empty($comment['avatar_md']) ? $comment['avatar_md'] : '';
                                        ?>
                                        <div class="mb-4">
                                            <div class="d-flex">
                                                <div class="symbol symbol-30px symbol-circle me-3 flex-shrink-0">
                                                    <?php if ($c_avatar) { ?>
                                                        <img src="<?php echo $c_avatar; ?>" alt="<?php echo htmlspecialchars($comment['author_name']); ?>" class="h-30px w-30px rounded-circle" />
                                                    <?php } else { ?>
                                                        <div class="symbol-label bg-success text-white fw-bold fs-7"><?php echo htmlspecialchars($c_initials ?: 'U'); ?></div>
                                                    <?php } ?>
                                                </div>
                                                <div class="flex-grow-1 text-start">
                                                    <div class="d-flex align-items-center justify-content-between mb-1">
                                                        <div class="d-flex align-items-center gap-2">
                                                            <span class="fw-bolder text-dark fs-7"><?php echo htmlspecialchars($comment['author_name']); ?></span>
                                                            <span class="text-muted fs-9"><?php echo get_relative_time($comment['created_at']); ?></span>
                                                        </div>
                                                    </div>
                                                    <p class="text-gray-800 fs-7 mb-2"><?php echo htmlspecialchars($comment['body']); ?></p>
                                                    <div class="d-flex align-items-center gap-1 mt-2">
                                                         <button class="btn btn-sm btn-light-muted vote-btn d-flex align-items-center gap-1 px-2 py-1 rounded-pill">
                                                             <i class="bi bi-hand-thumbs-up fs-9"></i> <span class="fw-bold fs-9"><?php echo $comment['upvotes']; ?></span>
                                                         </button>
                                                         <button class="btn btn-sm btn-light-muted vote-btn d-flex align-items-center gap-1 px-2 py-1 rounded-pill">
                                                             <i class="bi bi-hand-thumbs-down fs-9"></i> <span class="fw-bold fs-9"><?php echo $comment['downvotes']; ?></span>
                                                         </button>
                                                         <button class="btn btn-sm btn-light-muted vote-btn d-flex align-items-center gap-1 px-2 py-1 rounded-pill">
                                                             <i class="bi bi-chat fs-9"></i> <span class="fw-bold fs-9">Reply</span>
                                                         </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } } else { ?>
                                            <p class="text-muted fs-7 text-start">No comments yet. Be the first to share your thoughts!</p>
                                        <?php } ?>
                                    <?php } else { ?>
                                    <!-- Comment Thread 1 -->
                                    <div class="mb-2">
                                        <!-- Parent Comment -->
                                        <div class="d-flex">
                                            <div class="symbol symbol-30px symbol-circle me-3 flex-shrink-0">
                                                <div class="symbol-label bg-success text-white fw-bold fs-7">SK</div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="d-flex align-items-center justify-content-between mb-1">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <span class="fw-bolder text-dark fs-7">Sofia Karim</span>
                                                        <span class="text-muted fs-9"><?php echo $showImage ? '4d ago' : '2h ago'; ?></span>
                                                    </div>
                                                </div>
                                                <p class="text-gray-800 fs-7 mb-2">
                                                    <?php 
                                                        if ($showImage) echo 'The booking system needs a serious UX overhaul. I gave up twice before figuring it out.';
                                                        elseif ($showPoll) echo 'I cram every single time and somehow still pass. Do not recommend the stress though.';
                                                        elseif ($showAnon) echo 'Absolutely agree. Most other schools already have this. FEU is way behind on mental health support.';
                                                        elseif ($showSample) echo 'Interesting perspective. I think this could be applied to other areas as well.';
                                                        else echo 'Really insightful take! The latency improvements alone justify the switch.'; 
                                                    ?>
                                                </p>
                                                <div class="d-flex align-items-center gap-1 mt-2">
                                                    <button class="btn btn-sm btn-light-muted vote-btn d-flex align-items-center gap-1 px-2 py-1 rounded-pill">
                                                        <i class="bi bi-hand-thumbs-up fs-9"></i> <span class="fw-bold fs-9"><?php echo $showImage ? '6' : '12'; ?></span>
                                                    </button>
                                                    <button class="btn btn-sm btn-light-muted vote-btn d-flex align-items-center gap-1 px-2 py-1 rounded-pill">
                                                        <i class="bi bi-hand-thumbs-down fs-9"></i> <span class="fw-bold fs-9">0</span>
                                                    </button>
                                                    <button class="btn btn-sm btn-light-muted vote-btn d-flex align-items-center gap-1 px-2 py-1 rounded-pill">
                                                        <i class="bi bi-chat fs-9"></i> <span class="fw-bold fs-9">Reply</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <?php if(!$showImage && !$showPoll && !$showAnon && !$showSample) { ?>
                                        <!-- Nested Replies Wrapper -->
                                        <div class="comment-thread-line mt-3 mb-4">
                                            <!-- Child Comment 1 -->
                                            <div class="d-flex">
                                                <div class="symbol symbol-30px symbol-circle me-3 flex-shrink-0">
                                                    <div class="symbol-label bg-light text-muted fw-bold fs-7"><i class="ki-duotone ki-profile-circle"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i></div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="d-flex align-items-center justify-content-between mb-1">
                                                        <div class="d-flex align-items-center gap-2">
                                                            <span class="fw-bolder text-dark fs-7">Anonymous</span>
                                                            <span class="text-muted fs-9">1h ago</span>
                                                        </div>
                                                    </div>
                                                    <p class="text-gray-800 fs-7 mb-2">What about power consumption on mobile devices though? Battery drain is still a real concern for everyday users.</p>
                                                    <div class="d-flex align-items-center gap-1 mt-2">
                                                        <button class="btn btn-sm btn-light-muted vote-btn d-flex align-items-center gap-1 px-2 py-1 rounded-pill">
                                                            <i class="bi bi-hand-thumbs-up fs-9"></i> <span class="fw-bold fs-9">5</span>
                                                        </button>
                                                        <button class="btn btn-sm btn-light-muted vote-btn d-flex align-items-center gap-1 px-2 py-1 rounded-pill">
                                                            <i class="bi bi-hand-thumbs-down fs-9"></i> <span class="fw-bold fs-9">0</span>
                                                        </button>
                                                        <button class="btn btn-sm btn-light-muted vote-btn d-flex align-items-center gap-1 px-2 py-1 rounded-pill">
                                                            <i class="bi bi-chat fs-9"></i> <span class="fw-bold fs-9">Reply</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    
                                    <?php if(!$showImage && !$showPoll && !$showAnon && !$showSample) { ?>
                                    <!-- Comment Thread 2 -->
                                    <div class="mb-2 mt-6">
                                        <div class="d-flex">
                                            <div class="symbol symbol-30px symbol-circle me-3 flex-shrink-0">
                                                <div class="symbol-label bg-success text-white fw-bold fs-7">MT</div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="d-flex align-items-center justify-content-between mb-1">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <span class="fw-bolder text-dark fs-7">Marco Torres</span>
                                                        <span class="text-muted fs-9">45m ago</span>
                                                    </div>
                                                </div>
                                                <p class="text-gray-800 fs-7 mb-2">The TPU integration in Apple Silicon is basically proof of concept already.</p>
                                                <div class="d-flex align-items-center gap-1 mt-2">
                                                    <button class="btn btn-sm btn-light-muted vote-btn d-flex align-items-center gap-1 px-2 py-1 rounded-pill">
                                                        <i class="bi bi-hand-thumbs-up fs-9"></i> <span class="fw-bold fs-9">8</span>
                                                    </button>
                                                    <button class="btn btn-sm btn-light-muted vote-btn d-flex align-items-center gap-1 px-2 py-1 rounded-pill">
                                                        <i class="bi bi-hand-thumbs-down fs-9"></i> <span class="fw-bold fs-9">0</span>
                                                    </button>
                                                    <button class="btn btn-sm btn-light-muted vote-btn d-flex align-items-center gap-1 px-2 py-1 rounded-pill">
                                                        <i class="bi bi-chat fs-9"></i> <span class="fw-bold fs-9">Reply</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <?php } ?>
                                </div>
                                
                                <!-- Write Comment -->
                                <div class="d-flex align-items-start mt-8">
                                    <div class="symbol symbol-35px symbol-circle me-3 flex-shrink-0 mt-1">
                                        <img src="<?php echo !empty($ACCOUNT['avatar_md']) ? $ACCOUNT['avatar_md'] : '/Discourse/assets/images/anonymous.png'; ?>" class="h-35px w-35px rounded-circle" alt="User avatar" />
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="comment-input-wrapper">
                                            <input type="text" id="main-comment-input" class="comment-input" placeholder="Write a comment...">
                                            <button id="post-comment-btn" class="btn btn-sm btn-green px-4 py-1 me-1 fs-8 fw-bold"><i class="ki-duotone ki-send me-1 fs-9"><span class="path1"></span><span class="path2"></span></i> Post</button>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="col-lg-4">
                        
                        <!-- About Author -->
                        <div class="card sidebar-card mb-5">
                            <div class="card-header border-0 pt-5 pb-0 min-h-auto">
                                <h3 class="card-title text-gray-700 fs-8 fw-bold text-uppercase m-0">ABOUT THE AUTHOR</h3>
                            </div>
                            <div class="card-body p-6 text-center">
                                <div class="symbol symbol-50px symbol-circle mb-3">
                                    <div class="symbol-label bg-success text-white fw-bolder fs-3"><?php echo $authorInitials; ?></div>
                                </div>
                                <h4 class="fw-bolder text-dark fs-5 mb-1"><?php echo $authorName; ?></h4>
                                <div class="text-muted fs-8 mb-5">
                                    <?php 
                                        if ($showImage) echo 'T202210202 • Computer Science';
                                        elseif ($showPoll) echo 'T202102837 • Information Technology';
                                        elseif ($showAnon) echo 'Secret • Undergrad';
                                        elseif ($showSample) echo 'T202008123 • Mechanical Engineering';
                                        else echo 'T202110294 • Computer Science'; 
                                    ?>
                                </div>
                                
                                <?php if($showImage) { ?>
                                <div class="mb-5">
                                    <span class="badge badge-light-success fw-bold px-3 py-1"><i class="ki-duotone ki-check text-success fs-9 me-1"><span class="path1"></span><span class="path2"></span></i> YOUR POST</span>
                                </div>
                                <?php } ?>
                                
                                <div class="d-flex justify-content-center gap-6 mb-6">
                                    <div class="d-flex flex-column align-items-center">
                                        <span class="fw-bolder text-dark fs-4">
                                            <?php 
                                                if ($showImage) echo '3';
                                                elseif ($showPoll) echo '14';
                                                elseif ($showAnon) echo '0';
                                                elseif ($showSample) echo '2';
                                                else echo '48'; 
                                            ?>
                                        </span>
                                        <span class="text-muted fs-9 fw-bold text-uppercase">POSTS</span>
                                    </div>
                                    <div class="d-flex flex-column align-items-center">
                                        <span class="fw-bolder text-dark fs-4">
                                            <?php 
                                                if ($showImage) echo '304';
                                                elseif ($showPoll) echo '894';
                                                elseif ($showAnon) echo '0';
                                                elseif ($showSample) echo '45';
                                                else echo '1.2k'; 
                                            ?>
                                        </span>
                                        <span class="text-muted fs-9 fw-bold text-uppercase">KARMA</span>
                                    </div>
                                    <div class="d-flex flex-column align-items-center">
                                        <span class="fw-bolder text-dark fs-4">
                                            <?php 
                                                if ($showImage) echo '7';
                                                elseif ($showPoll) echo '12';
                                                elseif ($showAnon) echo '0';
                                                elseif ($showSample) echo '12';
                                                else echo '132'; 
                                            ?>
                                        </span>
                                        <span class="text-muted fs-9 fw-bold text-uppercase">COMMENTS</span>
                                    </div>
                                </div>
                                
                                <?php if(!$showImage && !$showAnon) { ?>
                                <button class="btn w-100 btn-green btn-sm fw-bold"><i class="ki-duotone ki-user-tick me-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i> Follow</button>
                                <?php } ?>
                            </div>
                        </div>
                        
                        <!-- Related Posts -->
                        <div class="card sidebar-card mb-5">
                            <div class="card-header border-0 pt-5 pb-0 min-h-auto">
                                <h3 class="card-title text-gray-700 fs-8 fw-bold text-uppercase m-0">RELATED POSTS</h3>
                            </div>
                            <div class="card-body p-5">
                                <div class="d-flex flex-column gap-4">
                                    
                                    <a href="/Discourse/pages/version/view-post.php" class="d-flex align-items-start gap-3 text-decoration-none">
                                        <div class="d-flex align-items-center gap-1 mt-1 text-success">
                                            <i class="ki-duotone ki-arrow-up fs-9"><span class="path1"></span><span class="path2"></span></i>
                                            <span class="vote-count-up"><?php echo $showImage ? '189' : '88'; ?></span>
                                        </div>
                                        <div>
                                            <h5 class="text-dark fw-bold fs-7 mb-1 text-hover-primary lh-sm">
                                                <?php echo $showImage ? 'Pro tips for surviving enrollment season at FEU Tech' : 'Is Qualcomm finally catching up to Apple Silicon on AI benchmarks?'; ?>
                                            </h5>
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="ki-duotone ki-flash text-warning fs-10"><span class="path1"></span><span class="path2"></span></i>
                                                <span class="text-muted fs-9"><?php echo $showImage ? 'FEU • 1d ago' : 'Technology • 1d ago'; ?></span>
                                            </div>
                                        </div>
                                    </a>
                                    
                                    <div class="separator separator-dashed my-1"></div>
                                    
                                    <a href="/Discourse/pages/version/view-post.php?img=1" class="d-flex align-items-start gap-3 text-decoration-none">
                                        <div class="d-flex align-items-center gap-1 mt-1 text-success">
                                            <i class="ki-duotone ki-arrow-up fs-9"><span class="path1"></span><span class="path2"></span></i>
                                            <span class="vote-count-up"><?php echo $showImage ? '127' : '72'; ?></span>
                                        </div>
                                        <div>
                                            <h5 class="text-dark fw-bold fs-7 mb-1 text-hover-primary lh-sm">
                                                <?php echo $showImage ? 'What if FEU had a no-grade-penalty mental health leave?' : 'How local LLMs will reshape app development in the next 2 years'; ?>
                                            </h5>
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="ki-duotone ki-flash text-warning fs-10"><span class="path1"></span><span class="path2"></span></i>
                                                <span class="text-muted fs-9"><?php echo $showImage ? 'Ideas • 1w ago' : 'Technology • 2d ago'; ?></span>
                                            </div>
                                        </div>
                                    </a>
                                    
                                    <?php if(!$showImage) { ?>
                                    <div class="separator separator-dashed my-1"></div>
                                    
                                    <a href="/Discourse/pages/version/view-post.php?anon=1" class="d-flex align-items-start gap-3 text-decoration-none">
                                        <div class="d-flex align-items-center gap-1 mt-1 text-success">
                                            <i class="ki-duotone ki-arrow-up fs-9"><span class="path1"></span><span class="path2"></span></i>
                                            <span class="vote-count-up">54</span>
                                        </div>
                                        <div>
                                            <h5 class="text-dark fw-bold fs-7 mb-1 text-hover-primary lh-sm">
                                                Anyone else obsessed with the new Phi-3 Mini benchmarks?
                                            </h5>
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="ki-duotone ki-flash text-warning fs-10"><span class="path1"></span><span class="path2"></span></i>
                                                <span class="text-muted fs-9">AI • 3d ago</span>
                                            </div>
                                        </div>
                                    </a>
                                    <?php } ?>
                                    
                                </div>
                            </div>
                        </div>
                        
                        <!-- Community Rules Sidebar -->
                        <div class="card sidebar-card">
                            <div class="card-header border-0 pt-5 pb-0 min-h-auto">
                                <h3 class="card-title text-gray-700 fs-8 fw-bold text-uppercase m-0">COMMUNITY RULES</h3>
                            </div>
                            <div class="card-body p-5">
                                <div class="d-flex flex-column gap-3">
                                    <div class="d-flex align-items-start gap-3">
                                        <span class="rule-number mt-1">1</span>
                                        <span class="text-dark fs-8 fw-medium">Be respectful and constructive</span>
                                    </div>
                                    <div class="d-flex align-items-start gap-3">
                                        <span class="rule-number mt-1">2</span>
                                        <span class="text-dark fs-8 fw-medium">No personal attacks or harassment</span>
                                    </div>
                                    <div class="d-flex align-items-start gap-3">
                                        <span class="rule-number mt-1">3</span>
                                        <span class="text-dark fs-8 fw-medium">Keep posts relevant to the topic</span>
                                    </div>
                                    <div class="d-flex align-items-start gap-3">
                                        <span class="rule-number mt-1">4</span>
                                        <span class="text-dark fs-8 fw-medium">Verify information before sharing</span>
                                    </div>
                                </div>
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

  <!-- Functional Interactions Script -->
  <script>
    $(document).ready(function() {
        let commentCount = parseInt($('#comment-count-badge').text()) || 0;
        let replyingToThread = null; // Stores the thread container we're replying to
        
        // 1. Voting Logic (Post & Comments)
        $(document).on('click', '.vote-btn:has(.bi-hand-thumbs-up), .vote-btn:has(.bi-hand-thumbs-down)', function(e) {
            e.preventDefault();
            const btn = $(this);
            const isUpvote = btn.find('.bi-hand-thumbs-up, .bi-hand-thumbs-up-fill').length > 0;
            const container = btn.parent();
            const otherBtn = isUpvote ? container.find('.vote-btn:has(.bi-hand-thumbs-down), .vote-btn:has(.bi-hand-thumbs-down-fill)') : container.find('.vote-btn:has(.bi-hand-thumbs-up), .vote-btn:has(.bi-hand-thumbs-up-fill)');
            
            let countSpan = btn.find('.fw-bold');
            let currentCount = parseInt(countSpan.text()) || 0;
            
            // Toggle off
            if (btn.hasClass('btn-light-success') || btn.hasClass('btn-light-danger')) {
                btn.removeClass(isUpvote ? 'btn-light-success text-success' : 'btn-light-danger text-danger');
                btn.addClass('btn-light-muted');
                countSpan.text(currentCount - 1);
                btn.find('i').removeClass('bi-hand-thumbs-up-fill bi-hand-thumbs-down-fill').addClass(isUpvote ? 'bi-hand-thumbs-up' : 'bi-hand-thumbs-down');
            } 
            // Toggle on
            else {
                btn.removeClass('btn-light-muted');
                btn.addClass(isUpvote ? 'btn-light-success text-success' : 'btn-light-danger text-danger');
                countSpan.text(currentCount + 1);
                btn.find('i').removeClass('bi-hand-thumbs-up bi-hand-thumbs-down').addClass(isUpvote ? 'bi-hand-thumbs-up-fill' : 'bi-hand-thumbs-down-fill');
                
                // Remove from other if active
                if (otherBtn.hasClass('btn-light-success') || otherBtn.hasClass('btn-light-danger')) {
                    let otherSpan = otherBtn.find('.fw-bold');
                    otherSpan.text(parseInt(otherSpan.text()) - 1);
                    otherBtn.removeClass('btn-light-success text-success btn-light-danger text-danger').addClass('btn-light-muted');
                    otherBtn.find('i').removeClass('bi-hand-thumbs-up-fill bi-hand-thumbs-down-fill').addClass(isUpvote ? 'bi-hand-thumbs-down' : 'bi-hand-thumbs-up');
                }
            }
        });

        // 2. Click Reply
        $(document).on('click', '.vote-btn:has(.bi-chat)', function(e) {
            e.preventDefault();
            const threadContainer = $(this).closest('.mb-2, .mb-4'); // Get the parent thread container
            replyingToThread = threadContainer.length ? threadContainer : null;
            
            const authorName = $(this).closest('.d-flex').find('.fw-bolder.text-dark.fs-7').first().text();
            
            $('#main-comment-input').val(`@${authorName} `).focus();
        });

        // 3. Post Comment
        $('#post-comment-btn').click(function(e) {
            e.preventDefault();
            submitComment();
        });

        $('#main-comment-input').keypress(function(e) {
            if (e.which == 13) {
                e.preventDefault();
                submitComment();
            }
        });
        function submitComment() {
            const input = $('#main-comment-input');
            const text = input.val().trim();
            if (!text) return;
            
            const postId = "<?= isset($post['id']) ? $post['id'] : 0 ?>";
            if (postId > 0) {
                $.ajax({
                    url: '/Discourse/pages/version/add-comment-action.php',
                    method: 'POST',
                    data: {
                        post_id: postId,
                        body: text
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            window.location.reload();
                        } else {
                            alert(response.message || 'Failed to post comment.');
                        }
                    },
                    error: function() {
                        alert('Error communicating with database.');
                    }
                });
                return;
            }

            const timeNow = "Just now";
            const newCommentHtml = `
                <div class="d-flex mb-3">
                    <div class="symbol symbol-30px symbol-circle me-3 flex-shrink-0">
                        <div class="symbol-label bg-success text-white fw-bold fs-7">CS</div>
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <div class="d-flex align-items-center gap-2">
                                <span class="fw-bolder text-dark fs-7">Catalina Smith</span>
                                <span class="text-muted fs-9">${timeNow}</span>
                            </div>
                        </div>
                        <p class="text-gray-800 fs-7 mb-2">${text}</p>
                        <div class="d-flex align-items-center gap-1 mt-2">
                            <button class="btn btn-sm btn-light-muted vote-btn d-flex align-items-center gap-1 px-2 py-1 rounded-pill">
                                <i class="bi bi-hand-thumbs-up fs-9"></i> <span class="fw-bold fs-9">0</span>
                            </button>
                            <button class="btn btn-sm btn-light-muted vote-btn d-flex align-items-center gap-1 px-2 py-1 rounded-pill">
                                <i class="bi bi-hand-thumbs-down fs-9"></i> <span class="fw-bold fs-9">0</span>
                            </button>
                            <button class="btn btn-sm btn-light-muted vote-btn d-flex align-items-center gap-1 px-2 py-1 rounded-pill">
                                <i class="bi bi-chat fs-9"></i> <span class="fw-bold fs-9">Reply</span>
                            </button>
                        </div>
                    </div>
                </div>
            `;

            // Are we replying to a specific thread?
            if (replyingToThread) {
                // Check if this thread already has a nested replies wrapper
                let nestedWrapper = replyingToThread.find('.comment-thread-line').first();
                if (nestedWrapper.length === 0) {
                    // Create nested wrapper if it doesn't exist
                    replyingToThread.append('<div class="comment-thread-line mt-3 mb-4"></div>');
                    nestedWrapper = replyingToThread.find('.comment-thread-line');
                }
                nestedWrapper.append(newCommentHtml);
            } else {
                // Post as a new top-level thread
                const newThreadHtml = `
                    <div class="mb-2 mt-6">
                        ${newCommentHtml}
                    </div>
                `;
                $('#comments-container').append(newThreadHtml);
            }

            // Reset
            input.val('');
            replyingToThread = null;
            commentCount++;
            $('#comment-count-badge').text(commentCount);
            
            // Scroll to bottom of comments smoothly
            $('html, body').animate({
                scrollTop: $("#comments-container").offset().top + $("#comments-container").height() - 200
            }, 300);
        }

        // 4. Poll Option Click Behavior
        $(document).on('click', '.discourse-poll-option', function(e) {
            e.preventDefault();
            const container = $(this).closest('.discourse-poll-options');
            container.find('.discourse-poll-option').removeClass('selected');
            $(this).addClass('selected');
            container.addClass('show-results');
        });
    });
  </script>
</body>

</html>
