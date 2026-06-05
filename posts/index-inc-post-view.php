<?php
define('MBG', TRUE);
include_once(dirname(__DIR__) . '/functions-new.php');

if (!function_exists('get_relative_time')) {
    function get_relative_time($datetime) {
        $time = strtotime($datetime);
        if (!$time) return '1d ago';
        $now = time();
        $diff = $now - $time;
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

// ── DB loading ──────────────────────────────────────────────
$post      = null;
$post_id   = isset($_GET['id']) ? intval($_GET['id']) : 0;
$comments  = [];

if ($EDITH && $post_id > 0) {
    $stmt = $EDITH->prepare("SELECT p.*, a.display_name, a.avatar_md, a.role as author_role
                             FROM posts p
                             LEFT JOIN accounts a ON p.author_id = a.identification
                             WHERE p.id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $post_id);
        $stmt->execute();
        $post = $stmt->get_result()->fetch_assoc();
        $stmt->close();
    }
    if ($post) {
        $stmt_c = $EDITH->prepare("SELECT c.*, a.display_name as author_name, a.avatar_md
                                   FROM comments c
                                   LEFT JOIN accounts a ON c.author_id = a.identification
                                   WHERE c.post_id = ? ORDER BY c.created_at ASC");
        if ($stmt_c) {
            $stmt_c->bind_param("i", $post['id']);
            $stmt_c->execute();
            $res_c = $stmt_c->get_result();
            while ($row_c = $res_c->fetch_assoc()) $comments[] = $row_c;
            $stmt_c->close();
        }
        if ($post['is_poll']) {
            $stmt_opt = $EDITH->prepare("SELECT * FROM poll_options WHERE post_id = ?");
            $stmt_opt->bind_param("i", $post['id']);
            $stmt_opt->execute();
            $opt_res = $stmt_opt->get_result();
            $post['poll_options'] = [];
            $total_votes = 0;
            while ($opt = $opt_res->fetch_assoc()) { $post['poll_options'][] = $opt; $total_votes += $opt['votes']; }
            $post['total_poll_votes'] = $total_votes;
            $stmt_opt->close();
        }
    }
}

// Session mock-post fallback
if (!$post && isset($_SESSION['mock_posts']) && is_array($_SESSION['mock_posts'])) {
    $slug_param = $_GET['slug'] ?? '';
    foreach ($_SESSION['mock_posts'] as $mp) {
        if (($post_id > 0 && $mp['id'] === $post_id) || (!empty($slug_param) && $mp['slug'] === $slug_param)) {
            $post     = $mp;
            $comments = $mp['comments'] ?? [];
            break;
        }
    }
}

// ── Override static vars from DB post if found ──────────────
$db_post_loaded = false;
if ($post) {
    $db_post_loaded  = true;
    $isAnon          = ($post['is_anonymous'] == 1);
    $META_TITLE      = htmlspecialchars($post['title']) . " - Discourse";
    $showImage       = !empty($post['image_url']);
    $showPoll        = ($post['is_poll'] == 1);
    $showAnon        = $isAnon;
    $showSample      = false;
    $postTitle       = $post['title'];
    $postDesc        = $post['body'];
    
    $authorAccount   = GET_ACCOUNT_DETAILS($post['author_id']);
    $dbDisplayName   = $post['display_name'] ?? $authorAccount['display_name'] ?? 'User';
    $dbAvatar        = $post['avatar_md'] ?? $authorAccount['avatar_md'] ?? '';
    
    $authorName      = $isAnon ? 'Anonymous' : $dbDisplayName;
    $authorInitials  = $isAnon ? 'A' : implode('', array_map(fn($w) => $w[0] ?? '', explode(' ', $authorName)));
    $authorAvatar    = $isAnon ? '/Discourse/assets/images/anonymous.png' : $dbAvatar;
    $authorProfileLink = $isAnon ? 'javascript:void(0)' : '/Discourse/profiles/index.php?id=' . $post['author_id'];
    $bannerMeta      = $post['community'] . ' • Posted by ' . $authorName . ' • ' . get_relative_time($post['created_at']);
    $tag             = !empty($post['tags']) ? $post['tags'] : $post['topic'];
    $community       = $post['community'];
    $can_edit        = isset($_SESSION['identification']) && $post['author_id'] === $_SESSION['identification'];
}

$loggedInName      = $ACCOUNT['display_name'] ?? 'User';
$loggedInInitials  = implode('', array_map(fn($w) => $w[0] ?? '', explode(' ', $loggedInName)));

if (!$db_post_loaded) {
$META_TITLE = "View Post - Discourse";
$showImage = isset($_GET['img']) && $_GET['img'] == '1';
$showPoll = isset($_GET['poll']) && $_GET['poll'] == '1';
$showAnon = isset($_GET['anon']) && $_GET['anon'] == '1';
$showSample = isset($_GET['sample']) && $_GET['sample'] == '1';
$can_edit = false;
$authorAvatar = '';
$authorProfileLink = 'javascript:void(0)';
}

$communityMeta = [
    'FEU Tech'    => ['members' => '12.3k', 'type' => 'Public Group'],
    'FEU Life'    => ['members' => '4.8k',  'type' => 'Public Group'],
    'FEU Alabang' => ['members' => '3.1k',  'type' => 'Public Group'],
    'FEU Diliman' => ['members' => '2.7k',  'type' => 'Public Group'],
];

if (!$db_post_loaded && $showImage) {
    $postTitle   = "Review: FEU Tech library study rooms — worth booking or just use the hallway?";
    $postDesc    = "Finally tried booking one of the new study rooms in the library. Honest review: the booking system is clunky, the AC is questionable, but the soundproofing is actually great. Worth it for group study if you plan ahead.<br><br>Not ideal for solo cramming though — the chairs are surprisingly uncomfortable for long sessions.";
    $authorName  = "Catalina Smith";
    $authorInitials = "CS";
    $bannerMeta  = "ACADEMICS • Posted by Catalina Smith • 5d ago";
    $tag         = "ACADEMICS";
    $community   = "FEU Tech";
    $can_edit    = true;
} elseif (!$db_post_loaded && $showPoll) {
    $postTitle   = "📊 Poll: How do you actually study for finals? Be honest.";
    $postDesc    = "Curious how my fellow FEU Tech students survive finals season. Drop your honest answer below 👇";
    $authorName  = "Marco Torres";
    $authorInitials = "MT";
    $bannerMeta  = "FEU • Posted by Marco Torres • 4h ago";
    $tag         = "FEU";
    $community   = "FEU Life";
} elseif (!$db_post_loaded && $showAnon) {
    $postTitle   = "What if FEU had a no-grade-penalty mental health leave policy?";
    $postDesc    = "Just thinking — a lot of students I know failed a whole semester because they were dealing with severe anxiety during midterms. The university had no mechanism to help them — just a strict drop policy or failure. Other universities have mental health leaves where students can pause without academic penalty. Should FEU implement something similar?";
    $authorName  = "Anonymous";
    $authorInitials = "A";
    $bannerMeta  = "Issues • Posted anonymously • 1d ago";
    $tag         = "ISSUES";
    $community   = "FEU Tech";
} elseif (!$db_post_loaded && $showSample) {
    $postTitle   = "Lorem ipsum dolor sit amet consectetur adipiscing elit.";
    $postDesc    = "Lorem ipsum dolor sit amet consectetur adipiscing elit. Quisque faucibus ex sapien vitae pellentesque sem placerat. In id cursus mi pretium tellus duis convallis. Tempus leo eu aenean sed diam uma tempor. Pulvinar vivamus fringilla lacus nec metus bibendum egestas.";
    $authorName  = "John Doe";
    $authorInitials = "JD";
    $bannerMeta  = "Entertainment • Posted by John Doe • 1d ago";
    $tag         = "ENTERTAINMENT";
    $community   = "FEU Tech";
} elseif (!$db_post_loaded) {
    $postTitle   = "The silent revolution in edge AI — why on-device inference is changing everything";
    $postDesc    = "Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc, quis gravida magna mi a libero. Fusce vulputate eleifend sapien. Vestibulum purus quam, scelerisque ut, mollis sed, nonummy id, metus. Nullam accumsan lorem in dui. Cras ultricies mi eu turpis hendrerit fringilla. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; In ac dui quis mi consectetuer lacinia. Nam pretium turpis et arcu. Duis arcu tortor, suscipit eget, imperdiet nec, imperdiet iaculis, ipsum. Sed aliquam ultrices mauris. Integer ante arcu, accumsan a, consectetuer eget, posuere ut, mauris. Praesent adipiscing. Phasellus ullamcorper ipsum rutrum nunc. Nunc nonummy metus. Vestib";
    $authorName  = "Ravi Joshi";
    $authorInitials = "RJ";
    $bannerMeta  = "Technology • Posted by Ravi Joshi • 3h ago";
    $tag         = "TECHNOLOGY";
    $community   = "FEU Tech";
}

// ── Back URL: context-aware navigation ──────────────────────
$backParam = $_GET['back'] ?? '';
switch ($backParam) {
    case 'dashboard':
        $backUrl   = '/Discourse/index.php';
        $backLabel = 'Back to Dashboard';
        break;
    case 'community':
        $backCommunity = $_GET['community'] ?? ($community ?? '');
        $backUrl   = '/Discourse/communities/index.php?c=' . urlencode($backCommunity);
        $backLabel = 'Back to Community';
        break;
    case 'topic':
        $backTopic = $_GET['topic'] ?? '';
        $backUrl   = '/Discourse/topics/index.php?t=' . urlencode($backTopic);
        $backLabel = 'Back to Topic';
        break;
    case 'hashtag':
        $backTag = $_GET['tag'] ?? '';
        $backUrl = '/Discourse/hashtags/index.php?tag=' . urlencode($backTag);
        $backLabel = 'Back to Feed';
        break;
    case 'profile':
        $backProfile = $_GET['profile'] ?? '';
        $backUrl  = '/Discourse/profiles/index.php?id=' . urlencode($backProfile);
        $backLabel = 'Back to Profile';
        break;
    default:
        // Default: go back to the community the post belongs to
        $backUrl   = '/Discourse/communities/index.php?c=' . urlencode($community ?? 'FEU LIFE');
        $backLabel = 'Back to Feed';
        break;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php echo $META_TITLE; ?></title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" type="image/x-icon" href="/Discourse/assets/img/favicon.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="/Discourse/assets/plugins/global/plugins.bundle.css">
    <link rel="stylesheet" href="/Discourse/assets/css/style.keenicons.css">
    <link rel="stylesheet" href="/Discourse/assets/css/style.bundle.v2.full.css">

    <script src="/Discourse/assets/js/jquery.js"></script>
    <link href="/Discourse/assets/css/discourse-css/view-post.css" rel="stylesheet" type="text/css" />
    <link href="/Discourse/assets/css/sec-modals.css?v=1.0.1" rel="stylesheet" type="text/css" />
    <link href="/Discourse/assets/css/sec-posts.css?v=1.0.7" rel="stylesheet" type="text/css" />
    <link href="/Discourse/assets/css/dc-editor.css" rel="stylesheet" type="text/css" />
    <style>
        .anon-toggle-wrapper {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 4px 10px;
            border-radius: 20px;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            cursor: pointer;
            user-select: none;
            transition: background 0.15s ease, border-color 0.15s ease;
        }

        .anon-toggle-wrapper:hover {
            background: #f3f4f6;
            border-color: #d1d5db;
        }

        .anon-toggle-wrapper.is-anon {
            background: #fff7ed;
            border-color: #fed7aa;
        }

        .anon-toggle-wrapper .anon-label {
            font-size: 11px;
            font-weight: 600;
            color: #6b7280;
            transition: color 0.15s;
        }

        .anon-toggle-wrapper.is-anon .anon-label {
            color: #c2410c;
        }

        .anon-toggle-wrapper .anon-icon {
            font-size: 13px;
            color: #9ca3af;
            transition: color 0.15s;
        }

        .anon-toggle-wrapper.is-anon .anon-icon {
            color: #ea580c;
        }

        .anon-switch {
            position: relative;
            width: 30px;
            height: 16px;
            flex-shrink: 0;
        }

        .anon-switch input {
            display: none;
        }

        .anon-switch-slider {
            position: absolute;
            inset: 0;
            background: #d1d5db;
            border-radius: 99px;
            transition: background 0.2s;
        }

        .anon-switch-slider::before {
            content: '';
            position: absolute;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #fff;
            top: 2px;
            left: 2px;
            transition: transform 0.2s;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .15);
        }

        .anon-switch input:checked+.anon-switch-slider {
            background: #ea580c;
        }

        .anon-switch input:checked+.anon-switch-slider::before {
            transform: translateX(14px);
        }

        .comment-input-row {
            display: flex;
            flex-direction: column;
            gap: 8px;
            flex-grow: 1;
        }

        .comment-input-controls {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .btn-save.saved {
            color: #f59e0b !important;
        }

        .btn-save.saved i {
            font-weight: 900;
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

                            <!-- ── Banner ─────────────────────────────────────────────── -->
                            <?php
                            $bannerComm    = getCommunityIconDetails($community);
                            $bannerMembers = isset($communityMeta[$community]) ? $communityMeta[$community]['members'] : '—';
                            $bannerType    = isset($communityMeta[$community]) ? $communityMeta[$community]['type']    : 'Public Group';
                            $communityLabel = strtoupper($community) . ' Community';
                            ?>
                            <div class="page-banner w-100 py-4 mb-5">
                                <div class="app-container container-xxl d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center gap-4">
                                        <!-- FIX 1: text_class moved to <i> tag -->
                                        <div class="w-40px h-40px d-flex align-items-center justify-content-center rounded-1 shadow-sm <?php echo $bannerComm['bg_class']; ?>"
                                            style="flex-shrink:0;">
                                            <i class="bi <?php echo $bannerComm['icon']; ?> fs-5 <?php echo $bannerComm['text_class']; ?>"></i>
                                        </div>
                                        <div>
                                            <h2 class="text-white fw-bolder fs-4 mb-0"><?php echo $communityLabel; ?></h2>
                                            <span class="text-white text-opacity-75 fs-8"><?php echo $bannerType; ?> • <?php echo $bannerMembers; ?> Members</span>
                                        </div>
                                    </div>
                                    <a href="<?php echo htmlspecialchars($backUrl); ?>"
                                        class="btn btn-sm btn-outline btn-outline-white text-white border-white border-opacity-25 px-4 py-2 d-flex align-items-center gap-2 text-decoration-none">
                                        <i class="ki-duotone ki-arrow-left text-white fs-8"><span class="path1"></span><span class="path2"></span></i> <?php echo htmlspecialchars($backLabel); ?>
                                    </a>
                                </div>
                            </div>

                            <div class="app-container container-xxl pb-5">
                                <div class="row g-5">

                                    <!-- ── Main Post Content ──────────────────────────────── -->
                                    <div class="col-lg-8">
                                        <div class="card border border-gray-300 shadow-none mb-5 post-card overflow-hidden rounded-2">
                                            <div class="card-body p-6">

                                                <!-- Author Info -->
                                                <div class="d-flex align-items-center justify-content-between mb-6">
                                                    <div class="d-flex align-items-center gap-3">
                                                        <div class="symbol symbol-35px symbol-circle">
                                                            <?php if ($isAnon) { ?>
                                                                <div class="symbol-label text-white fw-bold fs-6" style="background-color: #ea580c !important;">A</div>
                                                            <?php } elseif (!empty($dbAvatar)) { ?>
                                                                <img src="<?php echo htmlspecialchars($dbAvatar); ?>" alt="Author Avatar" class="h-35px w-35px rounded-circle" style="object-fit:cover;">
                                                            <?php } else { ?>
                                                                <div class="symbol-label text-white fw-bold fs-6" style="background-color: #17c653 !important;"><?php echo htmlspecialchars($authorInitials); ?></div>
                                                            <?php } ?>
                                                        </div>
                                                        <div class="d-flex align-items-center gap-2">
                                                            <a href="<?php echo $authorProfileLink ?? '/Discourse/profiles/index.php'; ?>" class="fw-bolder text-dark text-hover-primary fs-6"><?php echo htmlspecialchars($authorName); ?></a>
                                                            <span class="text-muted fs-8">in</span>
                                                            <?php $commDetails = getCommunityIconDetails($community); ?>
                                                            <!-- FIX 2: text_class moved to <i> tag -->
                                                            <a href="/Discourse/communities/index.php?c=<?php echo urlencode($community); ?>" class="d-inline-flex align-items-center gap-1 text-decoration-none">
                                                                <div class="d-flex align-items-center justify-content-center rounded-2 <?php echo $commDetails['bg_class']; ?>"
                                                                    style="width:20px;height:20px;">
                                                                    <i class="bi <?php echo $commDetails['icon']; ?> <?php echo $commDetails['text_class']; ?>" style="font-size:8px;"></i>
                                                                </div>
                                                                <span class="fw-bold text-gray-800 text-hover-primary" style="font-size:11px;">c/<?php echo htmlspecialchars($community); ?></span>
                                                            </a>
                                                            <?php if ($can_edit) { ?>
                                                                <span class="tag-badge rounded-pill d-inline-flex align-items-center gap-1" style="font-size:9px;padding:2px 8px;background-color:#dcfce7;color:#166534;">
                                                                    <i class="ki-duotone ki-check fs-10 text-success"><span class="path1"></span><span class="path2"></span></i> MINE
                                                                </span>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                    <div class="text-muted fs-8 fw-medium">
                                                        <?php echo $post ? get_relative_time($post['created_at']) : ($showImage ? '1d ago' : '3h ago'); ?>
                                                    </div>
                                                </div>

                                                <!-- Post Title & Body -->
                                                <div class="mb-2 text-start d-flex flex-wrap align-items-center gap-1">
                                                    <?php
                                                    $is_post_announcement = ($post && !empty($post['is_announcement']));
                                                    // Topic = post['topic'], hashtags = post['tags'] (separate from topic)
                                                    $post_topic = $post ? ($post['topic'] ?? $tag) : $tag;
                                                    $post_tags  = $post ? ($post['tags']  ?? '') : '';
                                                    echo renderTopicBadge($is_post_announcement ? 'ANNOUNCEMENT' : $post_topic);
                                                    if (!$is_post_announcement) {
                                                        echo renderHashtagBadges($post_tags, 6);
                                                    }
                                                    ?>
                                                </div>
                                                <h1 class="fw-bolder text-dark fs-2x mb-4"><?php echo $postTitle; ?></h1>
                                                <?php if ($post && !empty($post['image_url'])): ?>
                                                <div class="mt-2 mb-4">
                                                    <img src="<?php echo htmlspecialchars($post['image_url']); ?>" alt="Post image" class="img-fluid rounded shadow-sm" style="max-height: 450px; width: auto; object-fit: cover;">
                                                </div>
                                                <?php endif; ?>
                                                <div class="text-gray-800 fs-6 lh-lg mb-6">
                                                    <?php
                                                    if ($post && !empty($post['image_url'])) {
                                                        echo "<p class='mb-4'>" . linkHashtags($postDesc) . "</p>";
                                                    } elseif ($showImage) {
                                                        $parts = explode("<br><br>", $postDesc);
                                                        echo "<p class='mb-6'>" . linkHashtags($parts[0]) . "</p>";
                                                        if (isset($parts[1])) {
                                                            echo "<p class='mb-0'>" . linkHashtags($parts[1]) . "</p>";
                                                        }
                                                    } elseif ($showPoll) {
                                                        echo "<p class='mb-4'>" . linkHashtags($postDesc) . "</p>";
                                                    ?>
                                                        <div class="d-flex flex-column gap-2 mb-4 discourse-poll-options" style="max-width:500px;">
                                                            <button class="discourse-poll-option" data-poll-id="finals-poll" data-option="0" style="--target-width:28%;">
                                                                <span class="fs-7 fw-bold text-gray-800">Start early, study consistently</span>
                                                                <span class="fs-7 fw-bold text-gray-800 discourse-poll-percentage">28%</span>
                                                            </button>
                                                            <button class="discourse-poll-option" data-poll-id="finals-poll" data-option="1" style="--target-width:45%;">
                                                                <span class="fs-7 fw-bold text-gray-800">Cram the night before</span>
                                                                <span class="fs-7 fw-bold text-gray-800 discourse-poll-percentage">45%</span>
                                                            </button>
                                                            <button class="discourse-poll-option" data-poll-id="finals-poll" data-option="2" style="--target-width:19%;">
                                                                <span class="fs-7 fw-bold text-gray-800">Rely on group chats and past papers</span>
                                                                <span class="fs-7 fw-bold text-gray-800 discourse-poll-percentage">19%</span>
                                                            </button>
                                                            <button class="discourse-poll-option" data-poll-id="finals-poll" data-option="3" style="--target-width:8%;">
                                                                <span class="fs-7 fw-bold text-gray-800">Pray and submit anyway</span>
                                                                <span class="fs-7 fw-bold text-gray-800 discourse-poll-percentage">8%</span>
                                                            </button>
                                                        </div>
                                                        <span class="fs-8 text-muted d-block mb-4">442 votes · 3 days left</span>
                                                    <?php
                                                    } else {
                                                        echo "<p>" . linkHashtags($postDesc) . "</p>";
                                                    }
                                                    ?>
                                                </div>

                                                <!-- Toolbar Actions -->
                                                <div class="d-flex align-items-center justify-content-between mb-8 mt-2">
                                                    <div class="d-flex align-items-center gap-1">
                                                        <button type="button" class="btn btn-sm btn-light-muted vote-btn d-flex align-items-center gap-1 px-3 py-2 rounded-pill">
                                                            <i class="bi bi-hand-thumbs-up fs-7"></i> <span class="fw-bold fs-8"><?php echo $post ? ($post['upvotes'] ?? 0) : ($showImage ? '49' : '12'); ?></span>
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-light-muted vote-btn d-flex align-items-center gap-1 px-3 py-2 rounded-pill">
                                                            <i class="bi bi-hand-thumbs-down fs-7"></i> <span class="fw-bold fs-8">1</span>
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-light-muted vote-btn d-flex align-items-center gap-1 px-3 py-2 rounded-pill">
                                                            <i class="bi bi-chat fs-7"></i> <span class="fw-bold fs-8" id="comment-count-text-btn"><?php echo $post ? count($comments) : ($showImage ? '1' : '3'); ?></span>
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-light-muted vote-btn d-flex align-items-center gap-1 px-3 py-2 rounded-pill">
                                                             <i class="bi bi-share fs-7"></i> <span class="fw-bold fs-8">Share</span>
                                                         </button>
                                                        <?php
                                                         $is_saved = ($post && IS_POST_SAVED($post['id'], $identification));
                                                         ?>
                                                         <button type="button" class="btn btn-sm <?php echo $is_saved ? 'saved btn-light-primary' : 'btn-light-muted'; ?> vote-btn btn-save d-flex align-items-center gap-1 px-3 py-2 rounded-pill" id="save-post-btn">
                                                             <i class="bi <?php echo $is_saved ? 'bi-bookmark-fill' : 'bi-bookmark'; ?> fs-7"></i> <span class="fw-bold fs-8"><?php echo $is_saved ? 'Saved' : 'Save'; ?></span>
                                                         </button>
                                                    </div>
                                                    <div class="d-flex align-items-center gap-1">
                                                        <?php if ($can_edit ?? $showImage) { ?>
                                                            <a href="/Discourse/posts/index.php?action=edit<?php echo $post ? '?id=' . $post['id'] : ''; ?>" class="btn btn-sm btn-light-primary d-flex align-items-center gap-1 px-3 py-2 rounded-pill">
                                                                <i class="bi bi-pencil-square fs-7 text-primary"></i> <span class="fw-bold fs-8">Edit Post</span>
                                                            </a>
                                                            <?php if ($post) { ?>
                                                            <button id="delete-post-btn" data-post-id="<?php echo $post['id']; ?>" class="btn btn-sm btn-light-danger d-flex align-items-center gap-1 px-3 py-2 rounded-pill">
                                                                <i class="bi bi-trash fs-7 text-danger"></i> <span class="fw-bold fs-8">Delete Post</span>
                                                            </button>
                                                            <?php } ?>
                                                        <?php } ?>
                                                        <button type="button" class="btn btn-sm btn-light-muted vote-btn text-danger dc-post-report d-flex align-items-center gap-1 px-3 py-2 rounded-pill"
                                                            data-bs-toggle="modal" data-bs-target="#modalReportPost">
                                                            <i class="bi bi-flag fs-7 text-danger"></i> <span class="fw-bold fs-8">Report</span>
                                                        </button>
                                                    </div>
                                                </div>

                                                <div class="separator separator-dashed mb-8"></div>

                                                <!-- Comments Section -->
                                                <div class="mb-6" id="comments-container">
                                                    <div class="d-flex align-items-center gap-2 mb-6">
                                                        <h4 class="fw-bolder text-dark m-0 fs-5">Comments</h4>
                                                        <span class="badge bg-light-success text-success fw-bold rounded-circle w-20px h-20px d-flex align-items-center justify-content-center p-0"
                                                            id="comment-count-badge" style="font-size:10px;"><?php echo $post ? count($comments) : ($showImage || $showPoll || $showAnon || $showSample ? '1' : '3'); ?></span>
                                                    </div>

                                                    <?php if ($post) {
                                                        if (!empty($comments)) {
                                                            $topLevelComments = [];
                                                            $repliesByParent = [];
                                                            foreach ($comments as $comment) {
                                                                if (!empty($comment['parent_id'])) {
                                                                    $repliesByParent[$comment['parent_id']][] = $comment;
                                                                } else {
                                                                    $topLevelComments[] = $comment;
                                                                }
                                                            }
                                                            
                                                            if (!empty($topLevelComments)) {
                                                                foreach ($topLevelComments as $comment) {
                                                                    $isCommentAnon = ($comment['is_anonymous'] == 1);
                                                                    $cName = $isCommentAnon ? 'Anonymous' : ($comment['author_name'] ?? 'User');
                                                                    $cInitials = $isCommentAnon ? 'A' : implode('', array_map(fn($w) => $w[0] ?? '', explode(' ', $cName)));
                                                                    $cAvatar = $isCommentAnon ? '' : (!empty($comment['avatar_md']) ? $comment['avatar_md'] : '');
                                                                    $cBg = $isCommentAnon ? '#ea580c' : '#17c653';
                                                    ?>
                                                    <div class="mb-4" data-cid="<?php echo $comment['id']; ?>">
                                                        <div class="d-flex">
                                                            <div class="symbol symbol-30px symbol-circle me-3 flex-shrink-0">
                                                                <?php if ($cAvatar) { ?>
                                                                    <img src="<?php echo htmlspecialchars($cAvatar); ?>" class="h-30px w-30px rounded-circle" alt="<?php echo htmlspecialchars($cName); ?>">
                                                                <?php } else { ?>
                                                                    <div class="symbol-label text-white fw-bold fs-7" style="background-color: <?php echo $cBg; ?> !important;"><?php echo htmlspecialchars($cInitials ?: 'U'); ?></div>
                                                                <?php } ?>
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                <div class="d-flex align-items-center gap-2 mb-1">
                                                                    <span class="fw-bolder text-dark fs-7"><?php echo htmlspecialchars($cName); ?></span>
                                                                    <?php if ($isCommentAnon) { ?>
                                                                        <span class="badge ms-1 rounded-pill" style="font-size:9px;background:#fff7ed;color:#c2410c;border:1px solid #fed7aa;"><i class="bi bi-incognito me-1" style="font-size:8px;color:inherit !important;"></i>Anonymous</span>
                                                                    <?php } ?>
                                                                    <span class="text-muted fs-9"><?php echo get_relative_time($comment['created_at']); ?></span>
                                                                </div>
                                                                <p class="text-gray-800 fs-7 mb-2"><?php echo htmlspecialchars($comment['body']); ?></p>
                                                                <div class="d-flex align-items-center gap-1 mt-2">
                                                                    <button class="btn btn-sm btn-light-muted vote-btn d-flex align-items-center gap-1 px-2 py-1 rounded-pill"><i class="bi bi-hand-thumbs-up fs-9"></i> <span class="fw-bold fs-9">0</span></button>
                                                                    <button class="btn btn-sm btn-light-muted vote-btn d-flex align-items-center gap-1 px-2 py-1 rounded-pill"><i class="bi bi-hand-thumbs-down fs-9"></i> <span class="fw-bold fs-9">0</span></button>
                                                                    <button class="btn btn-sm btn-light-muted reply-btn d-flex align-items-center gap-1 px-2 py-1 rounded-pill"
                                                                        data-author="<?php echo htmlspecialchars($cName); ?>"
                                                                        data-comment-id="<?php echo $comment['id']; ?>">
                                                                        <i class="bi bi-chat fs-9"></i> <span class="fw-bold fs-9">Reply</span>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Inline reply thread area -->
                                                        <div class="reply-thread-area ps-5 mt-2" id="thread-<?php echo $comment['id']; ?>">
                                                            <?php
                                                            if (isset($repliesByParent[$comment['id']])) {
                                                                foreach ($repliesByParent[$comment['id']] as $reply) {
                                                                    $isReplyAnon = ($reply['is_anonymous'] == 1);
                                                                    $rName = $isReplyAnon ? 'Anonymous' : ($reply['author_name'] ?? 'User');
                                                                    $rInitials = $isReplyAnon ? 'A' : implode('', array_map(fn($w) => $w[0] ?? '', explode(' ', $rName)));
                                                                    $rAvatar = $isReplyAnon ? '' : (!empty($reply['avatar_md']) ? $reply['avatar_md'] : '');
                                                                    $rBg = $isReplyAnon ? '#ea580c' : '#17c653';
                                                                    $replyingToName = $cName;
                                                            ?>
                                                            <div class="mb-3 pb-2 border-start border-2 ps-3" style="border-color:#d1fae5!important;">
                                                                <div class="d-flex gap-3">
                                                                    <div class="flex-shrink-0">
                                                                        <?php if ($rAvatar) { ?>
                                                                            <img src="<?php echo htmlspecialchars($rAvatar); ?>" class="rounded-circle" style="width: 28px; height: 28px; object-fit: cover;" alt="<?php echo htmlspecialchars($rName); ?>">
                                                                        <?php } else { ?>
                                                                            <div class="symbol-label text-white fw-bold fs-8 rounded-circle d-flex align-items-center justify-content-center" style="width:28px;height:28px;background:<?php echo $rBg; ?>;"><?php echo htmlspecialchars($rInitials); ?></div>
                                                                        <?php } ?>
                                                                    </div>
                                                                    <div class="flex-grow-1">
                                                                        <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                                                                            <span class="fw-bolder text-dark fs-7"><?php echo htmlspecialchars($rName); ?></span>
                                                                            <span class="text-muted fs-9 me-1">replying to</span><span class="fw-bold text-success fs-9">@<?php echo htmlspecialchars($replyingToName); ?></span>
                                                                            <?php if ($isReplyAnon) { ?>
                                                                                <span class="badge ms-1 rounded-pill" style="font-size:9px;background:#fff7ed;color:#c2410c;border:1px solid #fed7aa;"><i class="bi bi-incognito me-1" style="font-size:8px;color:inherit !important;"></i>Anonymous</span>
                                                                            <?php } ?>
                                                                            <span class="text-muted fs-9"><?php echo get_relative_time($reply['created_at']); ?></span>
                                                                        </div>
                                                                        <p class="text-gray-800 fs-7 mb-2"><?php echo htmlspecialchars($reply['body']); ?></p>
                                                                        <div class="d-flex align-items-center gap-1 mt-1">
                                                                            <button class="btn btn-sm btn-light-muted vote-btn d-flex align-items-center gap-1 px-2 py-1 rounded-pill"><i class="bi bi-hand-thumbs-up fs-9"></i> <span class="fw-bold fs-9">0</span></button>
                                                                            <button class="btn btn-sm btn-light-muted vote-btn d-flex align-items-center gap-1 px-2 py-1 rounded-pill"><i class="bi bi-hand-thumbs-down fs-9"></i> <span class="fw-bold fs-9">0</span></button>
                                                                            <button class="btn btn-sm btn-light-muted reply-btn d-flex align-items-center gap-1 px-2 py-1 rounded-pill"
                                                                                data-author="<?php echo htmlspecialchars($rName); ?>"
                                                                                data-comment-id="<?php echo $comment['id']; ?>">
                                                                                <i class="bi bi-chat fs-9"></i> <span class="fw-bold fs-9">Reply</span>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </div>
                                                        <!-- Inline reply composer (hidden by default) -->
                                                        <div class="reply-composer ps-5 mt-2" id="composer-<?php echo $comment['id']; ?>" style="display:none;"></div>
                                                    </div>
                                                    <?php 
                                                                }
                                                            } else {
                                                    ?>
                                                        <div class="text-muted fs-7 py-4 text-center" id="no-comments-msg">No comments yet. Be the first to start the conversation!</div>
                                                    <?php
                                                            }
                                                        } else { 
                                                    ?>
                                                        <div class="text-muted fs-7 py-4 text-center" id="no-comments-msg">No comments yet. Be the first to start the conversation!</div>
                                                    <?php } ?>
                                                    <?php } else { ?>
                                                    <!-- Comment Thread 1 -->
                                                    <div class="mb-2">
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
                                                                    <button class="btn btn-sm btn-light-muted vote-btn d-flex align-items-center gap-1 px-2 py-1 rounded-pill"><i class="bi bi-hand-thumbs-up fs-9"></i> <span class="fw-bold fs-9"><?php echo $showImage ? '6' : '12'; ?></span></button>
                                                                    <button class="btn btn-sm btn-light-muted vote-btn d-flex align-items-center gap-1 px-2 py-1 rounded-pill"><i class="bi bi-hand-thumbs-down fs-9"></i> <span class="fw-bold fs-9">0</span></button>
                                                                    <button class="btn btn-sm btn-light-muted reply-btn d-flex align-items-center gap-1 px-2 py-1 rounded-pill"><i class="bi bi-chat fs-9"></i> <span class="fw-bold fs-9">Reply</span></button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php if (!$showImage && !$showPoll && !$showAnon && !$showSample) { ?>
                                                            <div class="comment-thread-line mt-3 mb-4">
                                                                <div class="d-flex">
                                                                    <div class="symbol symbol-30px symbol-circle me-3 flex-shrink-0"><div class="symbol-label bg-light text-muted fw-bold fs-7"><i class="ki-duotone ki-profile-circle"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i></div></div>
                                                                    <div class="flex-grow-1">
                                                                        <div class="d-flex align-items-center gap-2 mb-1"><span class="fw-bolder text-dark fs-7">Anonymous</span><span class="text-muted fs-9">1h ago</span></div>
                                                                        <p class="text-gray-800 fs-7 mb-2">What about power consumption on mobile devices though? Battery drain is still a real concern for everyday users.</p>
                                                                        <div class="d-flex align-items-center gap-1 mt-2">
                                                                            <button class="btn btn-sm btn-light-muted vote-btn d-flex align-items-center gap-1 px-2 py-1 rounded-pill"><i class="bi bi-hand-thumbs-up fs-9"></i> <span class="fw-bold fs-9">5</span></button>
                                                                            <button class="btn btn-sm btn-light-muted vote-btn d-flex align-items-center gap-1 px-2 py-1 rounded-pill"><i class="bi bi-hand-thumbs-down fs-9"></i> <span class="fw-bold fs-9">0</span></button>
                                                                            <button class="btn btn-sm btn-light-muted reply-btn d-flex align-items-center gap-1 px-2 py-1 rounded-pill"><i class="bi bi-chat fs-9"></i> <span class="fw-bold fs-9">Reply</span></button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                    <?php if (!$showImage && !$showPoll && !$showAnon && !$showSample) { ?>
                                                        <div class="mb-2 mt-6">
                                                            <div class="d-flex">
                                                                <div class="symbol symbol-30px symbol-circle me-3 flex-shrink-0"><div class="symbol-label bg-success text-white fw-bold fs-7">MT</div></div>
                                                                <div class="flex-grow-1">
                                                                    <div class="d-flex align-items-center gap-2 mb-1"><span class="fw-bolder text-dark fs-7">Marco Torres</span><span class="text-muted fs-9">45m ago</span></div>
                                                                    <p class="text-gray-800 fs-7 mb-2">The TPU integration in Apple Silicon is basically proof of concept already.</p>
                                                                    <div class="d-flex align-items-center gap-1 mt-2">
                                                                        <button class="btn btn-sm btn-light-muted vote-btn d-flex align-items-center gap-1 px-2 py-1 rounded-pill"><i class="bi bi-hand-thumbs-up fs-9"></i> <span class="fw-bold fs-9">8</span></button>
                                                                        <button class="btn btn-sm btn-light-muted vote-btn d-flex align-items-center gap-1 px-2 py-1 rounded-pill"><i class="bi bi-hand-thumbs-down fs-9"></i> <span class="fw-bold fs-9">0</span></button>
                                                                        <button class="btn btn-sm btn-light-muted reply-btn d-flex align-items-center gap-1 px-2 py-1 rounded-pill"><i class="bi bi-chat fs-9"></i> <span class="fw-bold fs-9">Reply</span></button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                    <?php } ?>
                                                </div>

                                                <!-- Write Comment -->
                                                <div class="d-flex align-items-start mt-8" id="comment-composer">
                                                    <div class="symbol symbol-35px symbol-circle me-3 flex-shrink-0 mt-1" id="commenter-avatar">
                                                        <?php 
                                                        $hasRealAvatar = !empty($ACCOUNT['avatar_md']);
                                                        ?>
                                                        <img src="<?php echo htmlspecialchars($ACCOUNT['avatar_md'] ?? ''); ?>" 
                                                             alt="User Avatar" 
                                                             id="commenter-img" 
                                                             class="h-35px w-35px rounded-circle <?php echo $hasRealAvatar ? '' : 'd-none'; ?>">
                                                        <div class="symbol-label text-white fw-bold fs-6 <?php echo $hasRealAvatar ? 'd-none' : ''; ?>" 
                                                             id="commenter-initials" 
                                                             style="background-color: #17c653 !important;"><?php echo htmlspecialchars($loggedInInitials); ?></div>
                                                    </div>
                                                    <div class="comment-input-row flex-grow-1">
                                                        <div class="comment-input-wrapper">
                                                            <input type="text" id="main-comment-input" class="comment-input" placeholder="Write a comment...">
                                                            <button id="post-comment-btn" class="btn btn-sm btn-green px-4 py-1 me-1 fs-8 fw-bold">
                                                                <i class="ki-duotone ki-send me-1 fs-9"><span class="path1"></span><span class="path2"></span></i> Post
                                                            </button>
                                                        </div>
                                                        <div class="comment-input-controls">
                                                            <label class="anon-toggle-wrapper" id="anon-toggle-wrapper" for="anon-toggle-checkbox">
                                                                <i class="bi bi-incognito anon-icon"></i>
                                                                <span class="anon-label">Post anonymously</span>
                                                                <div class="anon-switch">
                                                                    <input type="checkbox" id="anon-toggle-checkbox">
                                                                    <span class="anon-switch-slider"></span>
                                                                </div>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <!-- ── Sidebar ─────────────────────────────────────────── -->
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

                                                <?php if ($showImage) { ?>
                                                    <div class="mb-5">
                                                        <span class="badge badge-light-success fw-bold px-3 py-1">
                                                            <i class="ki-duotone ki-check text-success fs-9 me-1"><span class="path1"></span><span class="path2"></span></i> YOUR POST
                                                        </span>
                                                    </div>
                                                <?php } ?>

                                                <div class="d-flex justify-content-center gap-6 mb-6">
                                                    <div class="d-flex flex-column align-items-center">
                                                        <span class="fw-bolder text-dark fs-4"><?php
                                                                                                if ($showImage) echo '3';
                                                                                                elseif ($showPoll) echo '14';
                                                                                                elseif ($showAnon) echo '0';
                                                                                                elseif ($showSample) echo '2';
                                                                                                else echo '48';
                                                                                                ?></span>
                                                        <span class="text-muted fs-9 fw-bold text-uppercase">POSTS</span>
                                                    </div>
                                                    <div class="d-flex flex-column align-items-center">
                                                        <span class="fw-bolder text-dark fs-4"><?php
                                                                                                if ($showImage) echo '304';
                                                                                                elseif ($showPoll) echo '894';
                                                                                                elseif ($showAnon) echo '0';
                                                                                                elseif ($showSample) echo '45';
                                                                                                else echo '1.2k';
                                                                                                ?></span>
                                                        <span class="text-muted fs-9 fw-bold text-uppercase">KARMA</span>
                                                    </div>
                                                    <div class="d-flex flex-column align-items-center">
                                                        <span class="fw-bolder text-dark fs-4"><?php
                                                                                                if ($showImage) echo '7';
                                                                                                elseif ($showPoll) echo '12';
                                                                                                elseif ($showAnon) echo '0';
                                                                                                elseif ($showSample) echo '12';
                                                                                                else echo '132';
                                                                                                ?></span>
                                                        <span class="text-muted fs-9 fw-bold text-uppercase">COMMENTS</span>
                                                    </div>
                                                </div>

                                                <?php
                                                $show_follow = !$showAnon && $post && $post['author_id'] !== ($identification ?? '');
                                                $is_following = false;
                                                $follow_target = $post ? $post['author_id'] : '';
                                                if ($show_follow && $EDITH && $identification && $follow_target) {
                                                    $stmt_f = $EDITH->prepare("SELECT id FROM followers WHERE follower_id=? AND following_id=?");
                                                    $stmt_f->bind_param("ss", $identification, $follow_target);
                                                    $stmt_f->execute();
                                                    $stmt_f->store_result();
                                                    $is_following = $stmt_f->num_rows > 0;
                                                    $stmt_f->close();
                                                }
                                                if ($show_follow) { ?>
                                                    <button id="follow-btn"
                                                        class="btn w-100 btn-sm fw-bold"
                                                        data-target="<?php echo htmlspecialchars($follow_target); ?>"
                                                        data-following="<?php echo $is_following ? '1' : '0'; ?>"
                                                        style="<?php echo $is_following
                                                            ? 'background:transparent;color:#1A8B44;border:2px solid #1A8B44;'
                                                            : 'background:#1A8B44;color:#fff;border:2px solid #1A8B44;'; ?>">
                                                        <i class="bi <?php echo $is_following ? 'bi-check-lg' : 'bi-person-plus-fill'; ?> me-1"></i>
                                                        <?php echo $is_following ? 'Followed' : 'Follow'; ?>
                                                    </button>
                                                <?php } ?>
                                            </div>
                                        </div>

                                        <!-- Related Posts -->
                                        <?php
                                        $related_posts = [];
                                        if ($EDITH && $post) {
                                            $excl = (int)$post['id'];
                                            $comm_esc = $EDITH->real_escape_string($community);
                                            $topic_esc = $EDITH->real_escape_string($tag);
                                            $res_rel = $EDITH->query(
                                                "SELECT id, title, topic, upvotes, created_at FROM posts
                                                 WHERE id != $excl AND (community='$comm_esc' OR topic='$topic_esc')
                                                 ORDER BY upvotes DESC LIMIT 3"
                                            );
                                            if ($res_rel) {
                                                while ($rr = $res_rel->fetch_assoc()) $related_posts[] = $rr;
                                            }
                                        }
                                        if (!empty($related_posts)) { ?>
                                        <div class="card sidebar-card mb-5">
                                            <div class="card-header border-0 pt-5 pb-0 min-h-auto">
                                                <h3 class="card-title text-gray-700 fs-8 fw-bold text-uppercase m-0">RELATED POSTS</h3>
                                            </div>
                                            <div class="card-body p-5">
                                                <div class="d-flex flex-column gap-4">
                                                    <?php foreach ($related_posts as $idx => $rp) {
                                                        if ($idx > 0) echo '<div class="separator separator-dashed my-1"></div>';
                                                    ?>
                                                    <a href="/Discourse/posts/index.php?id=<?php echo $rp['id']; ?>" class="d-flex align-items-start gap-3 text-decoration-none">
                                                        <div class="d-flex align-items-center gap-1 mt-1 text-success">
                                                            <i class="ki-duotone ki-arrow-up fs-9"><span class="path1"></span><span class="path2"></span></i>
                                                            <span class="vote-count-up"><?php echo $rp['upvotes']; ?></span>
                                                        </div>
                                                        <div>
                                                            <h5 class="text-dark fw-bold fs-7 mb-1 text-hover-primary lh-sm"><?php echo htmlspecialchars(mb_substr($rp['title'], 0, 60)) . (mb_strlen($rp['title']) > 60 ? '…' : ''); ?></h5>
                                                            <div class="d-flex align-items-center gap-2">
                                                                <i class="ki-duotone ki-flash text-warning fs-10"><span class="path1"></span><span class="path2"></span></i>
                                                                <span class="text-muted fs-9"><?php echo htmlspecialchars($rp['topic']); ?></span>
                                                            </div>
                                                        </div>
                                                    </a>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } ?>

                                        <!-- Community Rules -->
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
                    <?php include(dirname(__DIR__) . "/partials/_footer.php"); ?>
                </div>
            </div>
        </div>
    </div>
    <?php include(dirname(__DIR__) . "/partials/_discourse-modals.php"); ?>
    <?php include(dirname(__DIR__) . "/partials/_scrolltop.php"); ?>
    <script src="/Discourse/assets/js/sec-modals.js"></script>
    <script src="/Discourse/assets/js/sec-posts.js?v=1.0.5"></script>

    <script>
        $(document).ready(function() {
            let commentCount = parseInt($('#comment-count-badge').text()) || 0;
            let replyingToThread = null;
            let isAnonymous = false;
            const postId = <?php echo json_encode($post ? $post['id'] : 0); ?>;
            const realName = '<?php echo addslashes($loggedInName); ?>';
            const realInitials = '<?php echo $loggedInInitials; ?>';
            const realAvatar = <?php echo json_encode($ACCOUNT['avatar_md'] ?? ''); ?>;
            const hasRealAvatar = <?php echo json_encode(!empty($ACCOUNT['avatar_md'])); ?>;

            $('#anon-toggle-checkbox').on('change', function() {
                isAnonymous = $(this).is(':checked');
                const wrapper = $('#anon-toggle-wrapper');
                const initials = $('#commenter-initials');
                const img = $('#commenter-img');
                if (isAnonymous) {
                    wrapper.addClass('is-anon');
                    img.addClass('d-none');
                    initials.removeClass('d-none').text('A').attr('style', 'background-color: #ea580c !important;');
                } else {
                    wrapper.removeClass('is-anon');
                    if (hasRealAvatar) {
                        img.removeClass('d-none');
                        initials.addClass('d-none');
                    } else {
                        img.addClass('d-none');
                        initials.removeClass('d-none').text(realInitials).attr('style', 'background-color: #17c653 !important;');
                    }
                }
            });

             // Comment button scroll to composer
             $('#comment-count-text-btn').closest('button').on('click', function(e) {
                 e.preventDefault();
                 $('html, body').animate({
                     scrollTop: $('#main-comment-input').offset().top - 150
                 }, 300);
                 $('#main-comment-input').focus();
             });

            // Follow / Unfollow
            $('#follow-btn').on('click', function() {
                const btn = $(this);
                const target = btn.data('target');
                const following = btn.data('following') == '1';
                btn.prop('disabled', true);
                $.ajax({
                    url: '/Discourse/profiles/index-ajax-follow.php',
                    method: 'POST',
                    data: { target_id: target },
                    dataType: 'json',
                    success: function(res) {
                        if (res.success) {
                            const nowFollowing = res.following;
                            btn.data('following', nowFollowing ? '1' : '0');
                            if (nowFollowing) {
                                btn.css({'background':'transparent','color':'#1A8B44','border':'2px solid #1A8B44'});
                                btn.html('<i class="bi bi-check-lg me-1"></i> Followed');
                            } else {
                                btn.css({'background':'#1A8B44','color':'#fff','border':'2px solid #1A8B44'});
                                btn.html('<i class="bi bi-person-plus-fill me-1"></i> Follow');
                            }
                        }
                    },
                    complete: function() { btn.prop('disabled', false); }
                });
            });

            $('#save-post-btn').on('click', function() {
                const btn = $(this);
                const postId = '<?php echo $post ? $post['id'] : 0; ?>';
                if (!postId || postId == 0) return;

                $.ajax({
                    url: '/Discourse/posts/index-ajax-save-post.php',
                    method: 'POST',
                    data: { post_id: postId },
                    dataType: 'json',
                    success: function(res) {
                        if (res.success) {
                            const saved = res.saved;
                            if (saved) {
                                btn.removeClass('btn-light-muted').addClass('saved btn-light-primary');
                                btn.find('i').removeClass('bi-bookmark').addClass('bi-bookmark-fill');
                                btn.find('span').text('Saved');
                            } else {
                                btn.removeClass('saved btn-light-primary').addClass('btn-light-muted');
                                btn.find('i').removeClass('bi-bookmark-fill').addClass('bi-bookmark');
                                btn.find('span').text('Save');
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

            $(document).on('click', '.vote-btn:has(.bi-hand-thumbs-up), .vote-btn:has(.bi-hand-thumbs-down)', function(e) {
                e.preventDefault();
                const btn = $(this);
                const isUpvote = btn.find('.bi-hand-thumbs-up, .bi-hand-thumbs-up-fill').length > 0;
                const container = btn.parent();
                const otherBtn = isUpvote ?
                    container.find('.vote-btn:has(.bi-hand-thumbs-down), .vote-btn:has(.bi-hand-thumbs-down-fill)') :
                    container.find('.vote-btn:has(.bi-hand-thumbs-up), .vote-btn:has(.bi-hand-thumbs-up-fill)');
                let countSpan = btn.find('.fw-bold');
                let currentCount = parseInt(countSpan.text()) || 0;
                if (btn.hasClass('btn-light-success') || btn.hasClass('btn-light-danger')) {
                    btn.removeClass(isUpvote ? 'btn-light-success text-success' : 'btn-light-danger text-danger').addClass('btn-light-muted');
                    countSpan.text(currentCount - 1);
                    btn.find('i').removeClass('bi-hand-thumbs-up-fill bi-hand-thumbs-down-fill').addClass(isUpvote ? 'bi-hand-thumbs-up' : 'bi-hand-thumbs-down');
                } else {
                    btn.removeClass('btn-light-muted').addClass(isUpvote ? 'btn-light-success text-success' : 'btn-light-danger text-danger');
                    countSpan.text(currentCount + 1);
                    btn.find('i').removeClass('bi-hand-thumbs-up bi-hand-thumbs-down').addClass(isUpvote ? 'bi-hand-thumbs-up-fill' : 'bi-hand-thumbs-down-fill');
                    if (otherBtn.hasClass('btn-light-success') || otherBtn.hasClass('btn-light-danger')) {
                        let otherSpan = otherBtn.find('.fw-bold');
                        otherSpan.text(parseInt(otherSpan.text()) - 1);
                        otherBtn.removeClass('btn-light-success text-success btn-light-danger text-danger').addClass('btn-light-muted');
                        otherBtn.find('i').removeClass('bi-hand-thumbs-up-fill bi-hand-thumbs-down-fill').addClass(isUpvote ? 'bi-hand-thumbs-down' : 'bi-hand-thumbs-up');
                    }
                }
            });

            // ── Reply System ────────────────────────────────────────────
            function buildCommentHtml(displayName, displayInitials, avatarBg, text, replyingTo) {
                const replyTag = replyingTo
                    ? `<span class="text-muted fs-9 me-1">replying to</span><span class="fw-bold text-success fs-9">@${replyingTo}</span>`
                    : '';
                return `
                <div class="d-flex gap-3">
                    <div class="flex-shrink-0">
                        <div class="symbol-label w-28px h-28px rounded-circle d-flex align-items-center justify-content-center text-white fw-bold fs-8" style="width:28px;height:28px;background:${avatarBg};">${displayInitials}</div>
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                            <span class="fw-bolder text-dark fs-7">${displayName}</span>
                            ${replyTag}
                            <span class="text-muted fs-9">Just now</span>
                        </div>
                        <p class="text-gray-800 fs-7 mb-2">${text}</p>
                        <div class="d-flex align-items-center gap-1 mt-1">
                            <button class="btn btn-sm btn-light-muted vote-btn d-flex align-items-center gap-1 px-2 py-1 rounded-pill"><i class="bi bi-hand-thumbs-up fs-9"></i> <span class="fw-bold fs-9">0</span></button>
                            <button class="btn btn-sm btn-light-muted vote-btn d-flex align-items-center gap-1 px-2 py-1 rounded-pill"><i class="bi bi-hand-thumbs-down fs-9"></i> <span class="fw-bold fs-9">0</span></button>
                            <button class="btn btn-sm btn-light-muted reply-btn d-flex align-items-center gap-1 px-2 py-1 rounded-pill"><i class="bi bi-chat fs-9"></i> <span class="fw-bold fs-9">Reply</span></button>
                        </div>
                    </div>
                </div>`;
            }

            function buildInlineComposer(commentId, replyingToName) {
                const initials = isAnonymous ? 'A' : realInitials;
                const bg       = isAnonymous ? '#ea580c' : '#17c653';
                const uid      = 'reply-anon-' + commentId;
                const imgHideClass = (isAnonymous || !realAvatar) ? 'd-none' : '';
                const initialsHideClass = (!isAnonymous && realAvatar) ? 'd-none' : '';
                return `
                <div class="d-flex align-items-start gap-2 inline-composer" data-for="${commentId}" data-reply-anon="${isAnonymous ? '1' : '0'}">
                    <div class="flex-shrink-0" style="width:26px;height:26px;">
                        <img src="${realAvatar}" alt="User Avatar" class="reply-composer-img rounded-circle ${imgHideClass}" style="width:26px;height:26px;object-fit:cover;">
                        <div class="reply-composer-avatar symbol-label rounded-circle d-flex align-items-center justify-content-center text-white fw-bold fs-9 ${initialsHideClass}"
                             style="width:26px;height:26px;background:${bg};flex-shrink:0;">${initials}</div>
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex align-items-center gap-2 mb-2 flex-wrap">
                            <span class="text-muted fs-9">Replying to <strong class="text-success">@${replyingToName}</strong></span>
                            <!-- Anon toggle -->
                            <label class="anon-toggle-wrapper reply-anon-toggle ${isAnonymous ? 'is-anon' : ''}" for="${uid}" style="cursor:pointer;">
                                <i class="bi bi-incognito anon-icon"></i>
                                <span class="anon-label">${isAnonymous ? 'Anonymous' : 'Post anonymously'}</span>
                                <div class="anon-switch">
                                    <input type="checkbox" id="${uid}" class="reply-anon-checkbox" ${isAnonymous ? 'checked' : ''}>
                                    <span class="anon-switch-slider"></span>
                                </div>
                            </label>
                        </div>
                        <div class="d-flex gap-2">
                            <input type="text" class="form-control form-control-sm rounded-pill px-3 fs-8 bg-white border border-gray-300 reply-input" placeholder="Write a reply..." style="flex:1;" />
                            <button class="btn btn-sm fw-bold rounded-pill px-3 submit-reply-btn" style="background:#0b301f;color:#fff;white-space:nowrap;">Post</button>
                            <button class="btn btn-sm btn-light-muted rounded-pill px-2 cancel-reply-btn">Cancel</button>
                        </div>
                    </div>
                </div>`;
            }

            $(document).on('change', '.reply-anon-checkbox', function() {
                const composer  = $(this).closest('.inline-composer');
                const wrapper   = $(this).closest('.reply-anon-toggle');
                const initialsEl = composer.find('.reply-composer-avatar');
                const imgEl      = composer.find('.reply-composer-img');
                const label     = wrapper.find('.anon-label');
                const isAnon    = $(this).is(':checked');
                composer.attr('data-reply-anon', isAnon ? '1' : '0');
                if (isAnon) {
                    wrapper.addClass('is-anon');
                    label.text('Anonymous');
                    imgEl.addClass('d-none');
                    initialsEl.removeClass('d-none').text('A').css('background-color', '#ea580c');
                } else {
                    wrapper.removeClass('is-anon');
                    label.text('Post anonymously');
                    if (realAvatar) {
                        imgEl.removeClass('d-none');
                        initialsEl.addClass('d-none');
                    } else {
                        imgEl.addClass('d-none');
                        initialsEl.removeClass('d-none').text(realInitials).css('background-color', '#17c653');
                    }
                }
            });

            // Open inline reply composer
            $(document).on('click', '.reply-btn', function(e) {
                e.preventDefault();
                const btn = $(this);

                // Find the parent comment block and its IDs
                const commentBlock = btn.closest('.mb-4, .mb-3, .d-flex.gap-3').closest('[id^=""], .mb-4');
                const composerTarget = btn.closest('.mb-4');
                const commentId = composerTarget.find('[id^="composer-"]').attr('id')?.replace('composer-', '')
                                || composerTarget.attr('data-cid')
                                || ('dyn-' + Date.now());
                const authorName = btn.closest('.flex-grow-1').find('.fw-bolder.text-dark.fs-7').first().text().trim()
                                || btn.closest('.d-flex').find('.fw-bolder.text-dark.fs-7').first().text().trim()
                                || 'User';

                // Close any other open composers
                $('.inline-composer').closest('.reply-composer').hide().empty();

                // Find the reply-composer slot or create one right after this comment block
                let composerSlot = composerTarget.find('.reply-composer').first();
                if (composerSlot.length === 0) {
                    composerTarget.append('<div class="reply-composer ps-5 mt-2"></div>');
                    composerSlot = composerTarget.find('.reply-composer');
                }

                composerSlot.html(buildInlineComposer(commentId, authorName)).show();
                composerSlot.find('.reply-input').focus();

                $('html, body').animate({ scrollTop: composerSlot.offset().top - 120 }, 250);
            });

            // Cancel reply
            $(document).on('click', '.cancel-reply-btn', function() {
                $(this).closest('.reply-composer').hide().empty();
            });

            // Submit inline reply
            $(document).on('click', '.submit-reply-btn', function() {
                const composer = $(this).closest('.inline-composer');
                const input = composer.find('.reply-input');
                const text = input.val().trim();
                if (!text) return;

                const replyingToName = composer.find('.text-success').text().replace('@','').trim();
                // Read anon state from THIS composer's own toggle (not global)
                const replyIsAnon = composer.find('.reply-anon-checkbox').is(':checked');
                const parentId = composer.attr('data-for');

                if (postId > 0) {
                    $.ajax({
                        url: '/Discourse/posts/index-ajax-add-comment.php',
                        method: 'POST',
                        data: {
                            post_id: postId,
                            body: text,
                            parent_id: parentId,
                            is_anonymous: replyIsAnon ? 1 : 0
                        },
                        dataType: 'json',
                        success: function(res) {
                            if (res.success) {
                                window.location.reload();
                            } else {
                                alert(res.message || 'Failed to post reply.');
                            }
                        },
                        error: function() {
                            alert('Error communicating with database.');
                        }
                    });
                    return;
                }

                const displayName = replyIsAnon ? 'Anonymous' : realName;
                const displayInitials = replyIsAnon ? 'A' : realInitials;
                const avatarBg = replyIsAnon ? '#ea580c' : '#17c653';
                const anonBadgeHtml = replyIsAnon
                    ? `<span class="badge ms-1 rounded-pill" style="font-size:9px;background:#fff7ed;color:#c2410c;border:1px solid #fed7aa;"><i class="bi bi-incognito me-1" style="font-size:8px;color:inherit !important;"></i>Anonymous</span>`
                    : '';

                const replyHtml = `<div class="mb-3 pb-2 border-start border-2 ps-3" style="border-color:#d1fae5!important;">${buildCommentHtml(displayName, displayInitials, avatarBg, text, anonBadgeHtml, replyingToName)}</div>`;

                // Find or create thread area right above the composer
                const composerSlot = composer.closest('.reply-composer');
                const commentBlock = composerSlot.closest('.mb-4');
                let threadArea = commentBlock.find('.reply-thread-area').first();
                if (threadArea.length === 0) {
                    composerSlot.before('<div class="reply-thread-area ps-5 mt-2"></div>');
                    threadArea = commentBlock.find('.reply-thread-area');
                }
                threadArea.append(replyHtml);
                composerSlot.hide().empty();

                commentCount++;
                $('#comment-count-badge').text(commentCount);
                $('#comment-count-text-btn').text(commentCount);
            });

            // Enter key in reply input
            $(document).on('keypress', '.reply-input', function(e) {
                if (e.which === 13) {
                    e.preventDefault();
                    $(this).closest('.inline-composer').find('.submit-reply-btn').click();
                }
            });

            // ── Main Comment Submit ──────────────────────────────────────
            $('#post-comment-btn').click(function(e) {
                e.preventDefault();
                submitMainComment();
            });
            $('#main-comment-input').keypress(function(e) {
                if (e.which == 13) {
                    e.preventDefault();
                    submitMainComment();
                }
            });

            function submitMainComment() {
                const input = $('#main-comment-input');
                const text = input.val().trim();
                if (!text) return;
                if (postId > 0) {
                    $.ajax({
                        url: '/Discourse/posts/index-ajax-add-comment.php',
                        method: 'POST',
                        data: { post_id: postId, body: text, is_anonymous: isAnonymous ? 1 : 0 },
                        dataType: 'json',
                        success: function(res) {
                            if (res.success) { window.location.reload(); }
                            else { alert(res.message || 'Failed to post comment.'); }
                        },
                        error: function() { alert('Error communicating with database.'); }
                    });
                    return;
                }
                const displayName = isAnonymous ? 'Anonymous' : realName;
                const displayInitials = isAnonymous ? 'A' : realInitials;
                const avatarBg = isAnonymous ? '#ea580c' : '#17c653';
                const anonBadgeHtml = isAnonymous
                    ? `<span class="badge ms-1 rounded-pill" style="font-size:9px;background:#fff7ed;color:#c2410c;border:1px solid #fed7aa;"><i class="bi bi-incognito me-1" style="font-size:8px;color:inherit !important;"></i>Anonymous</span>`
                    : '';
                const newBlockHtml = `<div class="mb-4">${buildCommentHtml(displayName, displayInitials, avatarBg, text, null)}<div class="reply-thread-area ps-5 mt-2"></div><div class="reply-composer ps-5 mt-1" style="display:none;"></div></div>`;
                $('#comments-container').append(newBlockHtml);
                input.val('');
                commentCount++;
                $('#comment-count-badge').text(commentCount);
                $('#comment-count-text-btn').text(commentCount);
                $('html, body').animate({ scrollTop: $('#comments-container').offset().top + $('#comments-container').height() - 200 }, 300);
            }

            $(document).on('click', '.discourse-poll-option', function(e) {
                e.preventDefault();
                const container = $(this).closest('.discourse-poll-options');
                container.find('.discourse-poll-option').removeClass('selected');
                $(this).addClass('selected');
                container.addClass('show-results');
            });

            // Delete post handler
            $('#delete-post-btn').on('click', function() {
                const postId = $(this).data('post-id');
                if (confirm('Are you sure you want to permanently delete this post? This cannot be undone.')) {
                    if (typeof KTApp !== 'undefined') KTApp.showPageLoading();
                    $.ajax({
                        url: '/Discourse/posts/index-ajax-delete-post.php',
                        method: 'POST',
                        data: { id: postId },
                        dataType: 'json',
                        success: function(res) {
                            if (res.status === 'success') {
                                alert(res.message);
                                window.location.href = '/Discourse/index.php';
                            } else {
                                if (typeof KTApp !== 'undefined') KTApp.hidePageLoading();
                                alert(res.message || 'Failed to delete post.');
                            }
                        },
                        error: function() {
                            if (typeof KTApp !== 'undefined') KTApp.hidePageLoading();
                            alert('Error communicating with database.');
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>