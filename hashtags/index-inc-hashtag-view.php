<?php
include_once(dirname(__DIR__) . '/functions-new.php');

$rawTag = isset($_GET['tag']) ? trim($_GET['tag']) : '';
if (empty($rawTag)) {
    header("Location: /Discourse/communities/index.php"); exit;
}

$tag          = $rawTag;
$tagDisplay   = '#' . strtolower($tag);
$tagUpper     = strtoupper($tag);

// ── Load posts from DB that contain this tag ──────────────────────────────
$posts = [];

if (!function_exists('get_relative_time')) {
    function get_relative_time($dt) {
        $t = strtotime($dt); if (!$t) return '1d ago';
        $d = time() - $t;
        if ($d < 60) return 'Just now';
        $d = round($d/60); if ($d < 60) return $d.'m ago';
        $d = round($d/60); if ($d < 24) return $d.'h ago';
        $d = round($d/24); return $d.'d ago';
    }
}

if ($EDITH) {
    $stmt_p = $EDITH->prepare(
        "SELECT DISTINCT p.*, a.display_name, a.avatar_md, a.identification as author_identification
         FROM posts p
         JOIN accounts a ON p.author_id = a.identification
         LEFT JOIN post_hashtags ph ON p.id = ph.post_id
         LEFT JOIN hashtags h ON ph.hashtag_id = h.id
         WHERE (h.name = ? OR p.topic = ?)
           AND p.is_anonymous = 0
         ORDER BY p.upvotes DESC, p.created_at DESC
         LIMIT 30"
    );
    if ($stmt_p) {
        $stmt_p->bind_param("ss", $tag, $tag);
        $stmt_p->execute();
        $res_p = $stmt_p->get_result();
        while ($row = $res_p->fetch_assoc()) {
            $stmt_cc = $EDITH->prepare("SELECT COUNT(*) as cc FROM comments WHERE post_id = ?");
            $stmt_cc->bind_param("i", $row['id']);
            $stmt_cc->execute();
            $row['comments_count'] = (int)$stmt_cc->get_result()->fetch_assoc()['cc'];
            $stmt_cc->close();

            $stmt_fc = $EDITH->prepare("SELECT body FROM comments WHERE post_id = ? ORDER BY created_at ASC LIMIT 1");
            $stmt_fc->bind_param("i", $row['id']);
            $stmt_fc->execute();
            $fc = $stmt_fc->get_result()->fetch_assoc();
            $row['first_comment'] = $fc['body'] ?? '';
            $stmt_fc->close();

            $row['author'] = $row['display_name'] ?? 'User';
            $row['avatar'] = !empty($row['avatar_md'])
                ? $row['avatar_md']
                : 'https://ui-avatars.com/api/?name=' . urlencode($row['display_name'] ?? 'U') . '&background=f3f4f6&color=d97706&rounded=true';
            $row['time'] = get_relative_time($row['created_at']);
            $posts[] = $row;
        }
        $stmt_p->close();
    }
}

$postCount = count($posts);
$META_TITLE = $tagDisplay . ' — Discourse Hashtag';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo htmlspecialchars($META_TITLE); ?></title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="/Discourse/assets/img/favicon.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Discourse/assets/plugins/global/plugins.bundle.css">
    <link rel="stylesheet" href="/Discourse/assets/css/style.keenicons.css">
    <link rel="stylesheet" href="/Discourse/assets/css/style.bundle.v2.full.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="/Discourse/assets/css/dashboard.css" rel="stylesheet">
    <link href="/Discourse/assets/css/sec-sidebar.css" rel="stylesheet">
    <link href="/Discourse/assets/css/sec-posts.css?v=1.0.7" rel="stylesheet">
    <link href="/Discourse/assets/css/sec-modals.css?v=1.0.1" rel="stylesheet">
    <script src="/Discourse/assets/js/jquery.js"></script>
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

                            <!-- Banner -->
                            <div class="w-100 mb-8 py-10 position-relative" style="background:#0b3220;border-bottom:3px solid #fbc501;overflow:hidden;">
                                <div class="position-absolute w-100 h-100 top-0 start-0" style="background:radial-gradient(circle at 75% 50%,rgba(5,177,102,.15) 0%,transparent 60%);pointer-events:none;"></div>
                                <div class="app-container container-xxl position-relative" style="z-index:1;">
                                    <div class="d-flex align-items-center flex-wrap gap-6">

                                        <!-- Hashtag icon -->
                                        <div class="flex-shrink-0">
                                            <div class="w-90px h-90px d-flex align-items-center justify-content-center rounded-3 shadow-sm"
                                                style="background:rgba(255,255,255,0.12);border:2px solid rgba(255,255,255,0.2);">
                                                <span class="fw-bolder text-white" style="font-size:2.5rem;line-height:1;">#</span>
                                            </div>
                                        </div>

                                        <!-- Info -->
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center gap-3 mb-1">
                                                <a href="/Discourse/communities/index.php" class="text-white text-opacity-60 fs-7 text-decoration-none text-hover-white"><i class="bi bi-house me-1"></i>Home</a>
                                                <i class="bi bi-chevron-right text-white text-opacity-40 fs-9"></i>
                                                <span class="text-white text-opacity-60 fs-7">Hashtags</span>
                                                <i class="bi bi-chevron-right text-white text-opacity-40 fs-9"></i>
                                                <span class="text-white fs-7 fw-bold"><?php echo htmlspecialchars($tagDisplay); ?></span>
                                            </div>
                                            <h1 class="text-white fw-bolder fs-2tx mb-2"><?php echo htmlspecialchars($tagDisplay); ?></h1>
                                            <p class="text-white text-opacity-75 fs-6 mb-4">Posts tagged with <strong><?php echo htmlspecialchars($tagDisplay); ?></strong></p>
                                            <div class="d-flex gap-3 flex-wrap">
                                                <div class="border border-white border-opacity-25 rounded px-3 py-1 d-flex align-items-center gap-2">
                                                    <i class="bi bi-pencil-square text-white fs-7"></i>
                                                    <span class="text-white fw-bold fs-7"><?php echo $postCount; ?></span>
                                                    <span class="text-white text-opacity-75 fs-9">Posts</span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- New Post button -->
                                        <div class="flex-shrink-0 ms-auto">
                                            <a href="/Discourse/posts/index.php?action=create" class="btn fw-bolder px-8 py-3 d-flex align-items-center gap-2 rounded-pill"
                                                style="background:#fff;color:#0b301f;border:2px solid #fff;">
                                                <i class="bi bi-plus-lg fs-6"></i> New Post
                                            </a>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="app-container container-xxl">
                                <div class="discourse-dashboard-layout" id="discourse-dashboard">

                                    <!-- LEFT: Feed -->
                                    <div class="discourse-feed-col">

                                        <!-- Search row -->
                                        <div class="d-flex flex-column flex-sm-row align-items-stretch align-items-sm-center gap-3 mb-5 mt-2">
                                            <div class="position-relative flex-grow-1">
                                                <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-4 text-gray-500 pe-none fs-6"></i>
                                                <input type="text" id="hashtagSearchInput" class="form-control bg-white rounded-pill ps-12 fs-6 text-gray-700 shadow-sm" placeholder="Search in <?php echo htmlspecialchars($tagDisplay); ?>...">
                                            </div>
                                        </div>

                                        <!-- Post feed -->
                                        <div id="hashtagPostFeed">
                                        <?php if (empty($posts)): ?>
                                            <div class="text-center py-16">
                                                <div class="mb-3" style="font-size:3rem;">🏷️</div>
                                                <h4 class="fw-bold text-gray-700 mb-2">No posts yet for <?php echo htmlspecialchars($tagDisplay); ?></h4>
                                                <p class="text-muted fs-6">Be the first to post with this tag!</p>
                                                <a href="/Discourse/posts/index.php?action=create" class="btn btn-sm rounded-pill fw-bold px-6 py-3 mt-2" style="background:#0b301f;color:#fff;">
                                                    <i class="bi bi-plus-lg me-1"></i> Create Post
                                                </a>
                                            </div>
                                        <?php else: ?>
                                            <?php foreach ($posts as $post):
                                                $commDetails = getCommunityIconDetails($post['community'] ?? '');
                                                $is_saved    = IS_POST_SAVED($post['id'], $identification);
                                                $authorHref  = '/Discourse/profiles/index.php?id=' . urlencode($post['author_id'] ?? '');
                                                $commHref    = '/Discourse/communities/index.php?c=' . urlencode($post['community'] ?? '');
                                                $postHref    = '/Discourse/posts/index.php?id=' . $post['id'] . '&back=hashtag&tag=' . urlencode($_GET['tag'] ?? '');
                                            ?>
                                            <div class="card border-0 shadow mb-5 post-card overflow-hidden" data-dc="post-card" data-post-id="<?php echo $post['id']; ?>">
                                                <div class="d-flex">
                                                    <!-- Vote column -->
                                                    <div class="d-flex flex-column align-items-center gap-1 p-3" style="width:55px;flex-shrink:0;background-color:#e8ede9;">
                                                        <button type="button" class="btn btn-sm btn-tertiary dc-vote-up" title="Upvote"><i class="bi bi-hand-thumbs-up p-0"></i></button>
                                                        <span class="fs-7 fw-bold text-gray-600 dc-vote-count"><?php echo $post['upvotes'] ?? 0; ?></span>
                                                        <button type="button" class="btn btn-sm btn-tertiary dc-vote-down" title="Downvote"><i class="bi bi-hand-thumbs-down p-0"></i></button>
                                                    </div>

                                                    <!-- Content -->
                                                    <div class="d-flex flex-column py-5 flex-grow-1 bg-white text-start">
                                                        <div class="row g-0 px-5">

                                                            <!-- Community + Report -->
                                                            <div class="col-12 mb-2">
                                                                <div class="d-flex justify-content-between align-items-center">
                                                                    <a href="<?php echo $commHref; ?>" class="d-flex align-items-center gap-2 text-decoration-none">
                                                                        <div class="d-flex align-items-center justify-content-center rounded-2 <?php echo $commDetails['bg_class']; ?>" style="width:24px;height:24px;">
                                                                            <i class="bi <?php echo $commDetails['icon']; ?> fs-8 <?php echo $commDetails['text_class']; ?>"></i>
                                                                        </div>
                                                                        <span class="fw-bold text-gray-800 text-hover-primary fs-7">c/<?php echo htmlspecialchars($post['community'] ?? ''); ?></span>
                                                                    </a>
                                                                    <button class="btn btn-sm dc-post-report" data-bs-toggle="modal" data-bs-target="#modalReportPost">
                                                                        <i class="bi bi-flag me-1"></i> Report
                                                                    </button>
                                                                </div>
                                                            </div>

                                                            <!-- Author -->
                                                            <div class="col-12 mb-2">
                                                                <div class="d-flex gap-3 align-items-center">
                                                                    <img src="<?php echo htmlspecialchars($post['avatar']); ?>" alt="<?php echo htmlspecialchars($post['author']); ?>" class="h-40px w-40px rounded-circle" />
                                                                    <div class="d-flex flex-column">
                                                                        <a href="<?php echo $authorHref; ?>" class="fs-6 fw-bold text-gray-800 text-hover-primary"><?php echo htmlspecialchars($post['author']); ?></a>
                                                                        <span class="text-muted fs-8"><i class="bi bi-clock me-1 fs-8"></i><?php echo $post['time']; ?></span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Topic badge + Title + Body + Hashtags below -->
                                                            <div class="col-12 mb-2">
                                                                <div class="d-flex flex-column gap-2 text-start">
                                                                    <div class="d-flex flex-wrap align-items-center gap-1">
                                                                        <?php 
                                                                        $is_post_announcement = !empty($post['is_announcement']);
                                                                        echo renderTopicBadge($is_post_announcement ? 'ANNOUNCEMENT' : ($post['topic'] ?? '')); 
                                                                        ?>
                                                                    </div>
                                                                    <a href="<?php echo $postHref; ?>" class="text-gray-800 text-hover-primary fs-5 fw-bold dc-post-title-link"><?php echo htmlspecialchars($post['title']); ?></a>
                                                                    <div class="dc-body-wrap">
                                                                        <span class="fs-7 text-gray-700 dc-body-clamp"><?php echo linkHashtags(htmlspecialchars(strip_tags($post['body'] ?? ''))); ?></span>
                                                                        <a href="#" class="dc-see-more-link fw-semibold cursor-pointer d-none" onclick="dcToggleBody(event, this)">See More</a>
                                                                    </div>
                                                                    <?php
                                                                    if (!$is_post_announcement) {
                                                                        $tagsRaw = $post['tags'] ?? '';
                                                                        $tagArr  = array_filter(array_map('trim', preg_split('/[,•]+/', $tagsRaw)));
                                                                        if (!empty($tagArr)): ?>
                                                                        <div class="d-flex flex-wrap align-items-center gap-1 mt-1">
                                                                            <?php foreach ($tagArr as $ht) {
                                                                                $isActive = (strtolower($ht) === strtolower($tag));
                                                                                $url = '/Discourse/hashtags/index.php?tag=' . urlencode($ht);
                                                                                echo '<a href="' . $url . '" class="badge rounded-pill px-2 py-1 fs-9 fw-semibold text-decoration-none" '
                                                                                   . 'style="' . ($isActive ? 'background:#0b301f;color:#fff;border:1px solid #0b301f;' : 'background:#f1f3f4;color:#555;border:1px solid #e0e0e0;') . '">'
                                                                                   . '#' . htmlspecialchars(strtolower($ht)) . '</a> ';
                                                                            } ?>
                                                                        </div>
                                                                        <?php endif;
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Actions -->
                                                        <div class="row">
                                                            <div class="d-flex justify-content-start align-items-center w-100 px-5">
                                                                <button type="button" class="btn btn-sm dc-post-comment"><i class="bi bi-chat me-1"></i> <?php echo $post['comments_count']; ?> Comment<?php echo $post['comments_count'] !== 1 ? 's' : ''; ?></button>
                                                                <button type="button" class="btn btn-sm dc-post-share"><i class="bi bi-share me-1"></i> Share</button>
                                                                <button type="button" class="btn btn-sm dc-post-save"
                                                                    data-on="<?php echo $is_saved ? '1' : '0'; ?>">
                                                                    <i class="bi <?php echo $is_saved ? 'bi-bookmark-fill' : 'bi-bookmark'; ?> me-1"></i>
                                                                    <?php echo $is_saved ? 'Saved' : 'Save'; ?>
                                                                </button>
                                                            </div>
                                                        </div>

                                                        <!-- Quick comment drawer -->
                                                        <div class="dc-quick-comment-drawer border-top border-gray-200 mt-4 pt-4 px-5" style="display:none;background:#fcfdfc;">
                                                            <div class="dc-quick-comments-list mb-4 d-flex flex-column gap-3" style="max-height:180px;overflow-y:auto;">
                                                                <?php if (!empty($post['first_comment'])): ?>
                                                                <div class="d-flex align-items-start gap-2 fs-7">
                                                                    <img src="<?php echo htmlspecialchars($post['avatar']); ?>" class="h-25px w-25px rounded-circle" alt="<?php echo htmlspecialchars($post['author']); ?>">
                                                                    <div class="bg-light p-2 rounded-3 flex-grow-1">
                                                                        <p class="text-gray-700 m-0"><?php echo htmlspecialchars($post['first_comment']); ?></p>
                                                                    </div>
                                                                </div>
                                                                <?php endif; ?>
                                                            </div>
                                                            <form class="dc-quick-comment-form">
                                                                <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>" />
                                                                <div class="d-flex align-items-center gap-2">
                                                                    <img src="<?php echo !empty($ACCOUNT['avatar_md']) ? $ACCOUNT['avatar_md'] : '/Discourse/assets/images/anonymous.png'; ?>" class="h-30px w-30px rounded-circle" alt="You" />
                                                                    <input type="text" class="form-control form-control-sm rounded-pill px-4 fs-7 bg-white border border-gray-300" placeholder="Write a quick comment..." required />
                                                                    <button type="submit" class="btn btn-sm rounded-pill px-4 fw-bold" style="background:#0b301f;color:#fff;">Post</button>
                                                                </div>
                                                            </form>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                        </div>

                                        <!-- Empty search state -->
                                        <div id="hashtagEmptyState" class="text-center py-16 d-none">
                                            <h4 class="fw-bold text-gray-700 mb-2">No posts found</h4>
                                            <p class="text-muted fs-6">Try a different search term.</p>
                                        </div>

                                    </div><!-- /feed -->

                                    <!-- RIGHT: Sidebar -->
                                    <div class="discourse-sidebar-col">

                                        <!-- About this hashtag -->
                                        <div class="card border-0 shadow-sm rounded-4 mb-4 mt-2" style="overflow:hidden;">
                                            <div class="p-5 d-flex align-items-center gap-3" style="background:#f0faf5;">
                                                <div class="d-flex align-items-center justify-content-center rounded-3 shadow-sm"
                                                    style="width:52px;height:52px;background:#0b3220;">
                                                    <span class="fw-bolder text-white fs-3">#</span>
                                                </div>
                                                <div>
                                                    <h6 class="fw-bolder mb-0 fs-5 text-dark"><?php echo htmlspecialchars($tagDisplay); ?></h6>
                                                    <span class="text-muted fs-8"><?php echo $postCount; ?> post<?php echo $postCount !== 1 ? 's' : ''; ?> tagged</span>
                                                </div>
                                            </div>
                                            <div class="card-body p-4 pt-3">
                                                <p class="fs-7 text-gray-600 mb-3">All posts tagged with <strong><?php echo htmlspecialchars($tagDisplay); ?></strong> across all communities.</p>
                                                <a href="/Discourse/posts/index.php?action=create" class="btn btn-sm w-100 fw-bold rounded-pill" style="background:#0b301f;color:#fff;">
                                                    <i class="bi bi-plus-lg me-1"></i> Post with this tag
                                                </a>
                                            </div>
                                        </div>

                                        <!-- Browse Topics -->
                                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                                            <div class="card-body p-4">
                                                <h6 class="fs-6 fw-bold text-gray-800 mb-3">Browse Topics</h6>
                                                <div class="d-flex flex-wrap gap-2">
                                                    <?php
                                                    $topics = ['TECHNOLOGY','CULTURE','GAMING','FEU','IDEAS','CREATIVE','SCIENCE','NEWS','AI','ACADEMICS','LIFESTYLE','ENTERTAINMENT','MUSIC','POLITICS','ISSUES','SPORTS'];
                                                    foreach ($topics as $t) {
                                                        $b = getCategoryBadgeStyle($t);
                                                        echo '<a href="/Discourse/topics/index.php?t=' . $t . '" class="badge ' . $b['class'] . ' rounded-pill px-3 py-2 fs-8 text-decoration-none fw-bold">'
                                                           . $t . '</a>';
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>

                                    </div><!-- /sidebar -->

                                </div><!-- /layout -->
                            </div><!-- /container -->

                        </main>
                    </div>
                    <?php include(dirname(__DIR__) . "/partials/_footer.php"); ?>
                </div>
            </div>
        </div>
    </div>

    <?php include(dirname(__DIR__) . "/partials/_scrolltop.php"); ?>
    <?php include(dirname(__DIR__) . "/partials/_discourse-modals.php"); ?>

    <script src="/Discourse/assets/js/dashboard.js"></script>
    <script src="/Discourse/assets/js/sec-posts.js?v=1.0.5"></script>
    <script src="/Discourse/assets/js/sec-modals.js"></script>

    <script>
    $(document).ready(function() {
        // Search filter
        $('#hashtagSearchInput').on('keyup', function() {
            const q = $(this).val().toLowerCase();
            let visible = 0;
            $('#hashtagPostFeed [data-dc="post-card"]').each(function() {
                const text = $(this).find('.dc-post-title-link, .dc-body-clamp').text().toLowerCase();
                const show = text.includes(q);
                $(this).toggle(show);
                if (show) visible++;
            });
            $('#hashtagEmptyState').toggleClass('d-none', visible > 0);
        });

        // Voting
        $(document).on('click', '.dc-vote-up, .dc-vote-down', function(e) {
            e.preventDefault();
            const btn = $(this);
            const isUp = btn.hasClass('dc-vote-up');
            const card = btn.closest('[data-dc="post-card"]');
            const score = card.find('.dc-vote-count');
            const other = isUp ? card.find('.dc-vote-down') : card.find('.dc-vote-up');
            let n = parseInt(score.text()) || 0;
            if (btn.hasClass('active-vote-up') || btn.hasClass('active-vote-down')) {
                btn.removeClass('active-vote-up active-vote-down');
                btn.find('i').attr('class', isUp ? 'bi bi-hand-thumbs-up p-0' : 'bi bi-hand-thumbs-down p-0');
                score.text(n - (isUp ? 1 : -1));
            } else {
                if (other.hasClass('active-vote-up') || other.hasClass('active-vote-down')) {
                    other.removeClass('active-vote-up active-vote-down');
                    other.find('i').attr('class', isUp ? 'bi bi-hand-thumbs-down p-0' : 'bi bi-hand-thumbs-up p-0');
                    n += isUp ? 1 : -1;
                }
                btn.addClass(isUp ? 'active-vote-up' : 'active-vote-down');
                btn.find('i').attr('class', isUp ? 'bi bi-hand-thumbs-up-fill p-0' : 'bi bi-hand-thumbs-down-fill p-0');
                score.text(n + (isUp ? 1 : -1));
            }
        });

        // Comment Drawer
        $(document).on('click', '.dc-post-comment', function(e) {
            e.preventDefault();
            const drawer = $(this).closest('[data-dc="post-card"]').find('.dc-quick-comment-drawer');
            drawer.slideToggle(200);
            drawer.find('input[type="text"]').focus();
        });

        // Comment Submit
        $(document).on('submit', '.dc-quick-comment-form', function(e) {
            e.preventDefault();
            const input = $(this).find('input[type="text"]');
            const text = input.val().trim();
            if (!text) return;
            const card = $(this).closest('[data-dc="post-card"]');
            const list = card.find('.dc-quick-comments-list');
            const commentBtn = card.find('.dc-post-comment');
            function esc(t) { return t.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;'); }
            list.append(`
                <div class="d-flex align-items-start gap-2 fs-7">
                  <img src="/Discourse/assets/images/anonymous.png" class="h-25px w-25px rounded-circle">
                  <div class="bg-light p-2 rounded-3 flex-grow-1 text-start">
                    <div class="d-flex justify-content-between">
                      <span class="fw-bold text-gray-800">You</span>
                      <span class="text-muted fs-9">just now</span>
                    </div>
                    <p class="text-gray-700 m-0 mt-1">${esc(text)}</p>
                  </div>
                </div>`);
            list.scrollTop(list[0].scrollHeight);
            input.val('');
            const btnText = commentBtn.text().trim();
            const match = btnText.match(/^(\d+)/);
            const n = (match ? parseInt(match[1]) : 0) + 1;
            commentBtn.html('<i class="bi bi-chat me-1"></i> ' + n + ' Comment' + (n === 1 ? '' : 's'));
        });
    });
    </script>
    <script src="/Discourse/assets/js/sec-posts.js?v=1.0.5"></script>
</body>
</html>