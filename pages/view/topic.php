<?php

// ── Topic config ────────────────────────────────────────────────────────────
// In production, get this from $_GET['topic'] and validate it.
// Example: topic.php?t=TECHNOLOGY  or  topic.php?t=SCIENCE
$rawTopic = isset($_GET['t']) ? strtoupper(trim($_GET['t'])) : 'TECHNOLOGY';

// All valid topics (mirrors getCategoryBadgeStyle)
$allTopics = [
    'TECHNOLOGY'    => ['icon' => 'bi-cpu',                'bg' => '#dbeafe', 'color' => '#1e40af', 'desc' => 'Programming, hardware, software, gadgets, and all things tech.'],
    'CULTURE'       => ['icon' => 'bi-palette',            'bg' => '#fce7f3', 'color' => '#9d174d', 'desc' => 'Arts, traditions, pop culture, movies, and shared human experience.'],
    'GAMING'        => ['icon' => 'bi-controller',         'bg' => '#fef3c7', 'color' => '#92400e', 'desc' => 'Video games, esports, game reviews, and player communities.'],
    'FEU'           => ['icon' => 'bi-building',           'bg' => '#fef3c7', 'color' => '#92400e', 'desc' => 'Everything about FEU — campus life, announcements, and school matters.'],
    'IDEAS'         => ['icon' => 'bi-lightbulb',          'bg' => '#e0f2fe', 'color' => '#0369a1', 'desc' => 'Brainstorming, innovations, thought experiments, and bold thinking.'],
    'CREATIVE'      => ['icon' => 'bi-stars',              'bg' => '#ede9fe', 'color' => '#5b21b6', 'desc' => 'Design, writing, photography, art, and all forms of creative expression.'],
    'SCIENCE'       => ['icon' => 'bi-droplet-half',       'bg' => '#e0f2fe', 'color' => '#0369a1', 'desc' => 'Biology, physics, chemistry, research, and scientific curiosity.'],
    'NEWS'          => ['icon' => 'bi-newspaper',          'bg' => '#fce7f3', 'color' => '#9d174d', 'desc' => 'Latest news, current events, and breaking stories from around the world.'],
    'AI'            => ['icon' => 'bi-robot',              'bg' => '#d1fae5', 'color' => '#065f46', 'desc' => 'Machine learning, large language models, AI tools, and the future of automation.'],
    'ACADEMICS'     => ['icon' => 'bi-book',               'bg' => '#fef3c7', 'color' => '#92400e', 'desc' => 'Study tips, course discussions, thesis help, and academic resources.'],
    'LIFESTYLE'     => ['icon' => 'bi-emoji-smile',        'bg' => '#e0f2fe', 'color' => '#0369a1', 'desc' => 'Health, hobbies, relationships, self-care, and everyday living.'],
    'ENTERTAINMENT' => ['icon' => 'bi-film',               'bg' => '#ede9fe', 'color' => '#5b21b6', 'desc' => 'TV shows, movies, streaming, celebrities, and fan communities.'],
    'MUSIC'         => ['icon' => 'bi-music-note',         'bg' => '#fce7f3', 'color' => '#9d174d', 'desc' => 'Artists, albums, playlists, concerts, and musical discovery.'],
    'POLITICS'      => ['icon' => 'bi-megaphone',          'bg' => '#f3f4f6', 'color' => '#374151', 'desc' => 'Government, policy, elections, and civic discussions.'],
    'ISSUES'        => ['icon' => 'bi-exclamation-circle', 'bg' => '#fee2e2', 'color' => '#991b1b', 'desc' => 'Social issues, mental health, campus concerns, and important conversations.'],
    'SPORTS'        => ['icon' => 'bi-trophy',             'bg' => '#fef3c7', 'color' => '#92400e', 'desc' => 'Basketball, football, campus leagues, fitness, and athletic achievements.'],
];

// Fallback to TECHNOLOGY if invalid topic
if (!array_key_exists($rawTopic, $allTopics)) {
    $rawTopic = 'TECHNOLOGY';
}

$topic     = $rawTopic;
$topicData = $allTopics[$topic];

// ── Sample posts per topic ───────────────────────────────────────────────────
// In production these come from a DB query: WHERE tag = $topic
$topicPosts = [
    'TECHNOLOGY' => [
        ['author' => 'Sofia Karim',    'avatar' => 'https://ui-avatars.com/api/?name=Sofia+Karim&background=f3f4f6&color=d97706&rounded=true',   'time' => '2h ago',  'community' => 'FEU Tech', 'title' => 'Best VS Code extensions for web dev students in 2025', 'body' => 'I\'ve been compiling a list of must-have extensions for our course projects. Prettier, ESLint, GitLens, and Live Server are obvious ones but I also found some underrated gems worth sharing with everyone.', 'votes' => 112, 'comments_count' => 14, 'first_comment' => 'Definitely add Tabnine or GitHub Copilot if your device can handle it!'],
        ['author' => 'Marco Torres',   'avatar' => 'https://ui-avatars.com/api/?name=Marco+Torres&background=e0f2fe&color=0369a1&rounded=true',   'time' => '5h ago',  'community' => 'FEU Life',  'title' => 'Anyone tried running a local LLM on an old laptop?', 'body' => 'Trying Ollama with Llama 3 on my i5 8th gen. It works but it\'s painfully slow. Has anyone found a sweet spot config for low-end machines?', 'votes' => 78, 'comments_count' => 9, 'first_comment' => 'LM Studio has a good performance mode. Try quantized 4-bit models — way faster on CPU.'],
        ['author' => 'Reyna Santos',   'avatar' => 'https://ui-avatars.com/api/?name=Reyna+Santos&background=fce7f3&color=9d174d&rounded=true',   'time' => '1d ago',  'community' => 'FEU Tech', 'title' => 'Python vs JavaScript — which one to learn first as a CS freshman?', 'body' => 'Our curriculum starts with Python but I keep seeing job posts asking for JavaScript. Should I stick with the school\'s roadmap or parallel-learn both? Looking for honest takes.', 'votes' => 205, 'comments_count' => 31, 'first_comment' => 'Python first — the logic foundation carries over. JavaScript\'s quirks make more sense once you know programming.'],
    ],
    'SCIENCE' => [
        ['author' => 'Leon Reyes',     'avatar' => 'https://ui-avatars.com/api/?name=Leon+Reyes&background=d1fae5&color=065f46&rounded=true',     'time' => '3h ago',  'community' => 'FEU Tech', 'title' => 'Great summary of the 2025 Nobel Physics findings — thread', 'body' => 'Just read through the full Nobel Committee announcement. The work on quantum entanglement verification is genuinely groundbreaking. Happy to break it down for anyone who finds the paper dense.', 'votes' => 89, 'comments_count' => 7, 'first_comment' => 'Please do! The abstract lost me at the second paragraph.'],
        ['author' => 'Ana Cruz',       'avatar' => 'https://ui-avatars.com/api/?name=Ana+Cruz&background=fce7f3&color=9d174d&rounded=true',       'time' => '1d ago',  'community' => 'FEU Life',  'title' => 'Why do energy drinks feel different from coffee even at the same caffeine?', 'body' => 'Started diving into this after my third Red Bull in a day. Turns out taurine, B-vitamins, and the sugar spike create a noticeably different physiological response. Here\'s what the research says.', 'votes' => 134, 'comments_count' => 20, 'first_comment' => 'The carbonation also accelerates gastric emptying so caffeine hits faster. Your body is basically being tricked.'],
        ['author' => 'Diego Lim',      'avatar' => 'https://ui-avatars.com/api/?name=Diego+Lim&background=e0f2fe&color=0369a1&rounded=true',       'time' => '3d ago',  'community' => 'FEU Tech', 'title' => 'Anyone doing independent research outside of class? How do you manage it?', 'body' => 'I\'ve been running small bio-chemistry experiments with a cheap kit at home. Not expecting publishable results — just scratching an itch. Curious if others do something similar.', 'votes' => 56, 'comments_count' => 8, 'first_comment' => 'Same here! I simulate physics models in Python. It\'s amazing what you can explore without lab access.'],
    ],
    'ACADEMICS' => [
        ['author' => 'Bea Flores',     'avatar' => 'https://ui-avatars.com/api/?name=Bea+Flores&background=fef3c7&color=92400e&rounded=true',     'time' => '1h ago',  'community' => 'FEU Life',  'title' => 'Thesis defense survival guide — what nobody tells you', 'body' => 'Just passed mine last Friday. The panel asked questions way outside our scope and I almost panicked. Here\'s how I recovered and what I\'d do differently in prep. Sharing so batchmates don\'t make the same mistakes.', 'votes' => 317, 'comments_count' => 42, 'first_comment' => 'This is gold. The part about anticipating out-of-scope questions is so real — my panel did the exact same.'],
        ['author' => 'Carlo Mendoza',  'avatar' => 'https://ui-avatars.com/api/?name=Carlo+Mendoza&background=dbeafe&color=1e40af&rounded=true',  'time' => '6h ago',  'community' => 'FEU Tech', 'title' => 'Anyone else overwhelmed by the new OBE rubric format?', 'body' => 'Three subjects this semester switched to the new outcome-based rubrics and I honestly can\'t tell what they want. Some criteria feel vague. Has anyone talked to their prof about it and got a useful answer?', 'votes' => 98, 'comments_count' => 17, 'first_comment' => 'Go to your department chair. They\'re supposed to have a standardized guide. Some profs just copy-paste without customizing.'],
        ['author' => 'Mia Villanueva', 'avatar' => 'https://ui-avatars.com/api/?name=Mia+Villanueva&background=ede9fe&color=5b21b6&rounded=true', 'time' => '2d ago',  'community' => 'FEU Life',  'title' => 'Free study resources that actually helped me pass Calculus 2', 'body' => 'Professor Leonard on YouTube saved my grade. Also: Paul\'s Online Notes, Khan Academy for the fundamentals, and Wolfram Alpha to check your manual solutions. Bookmarking all of these is basically a 1-unit advantage.', 'votes' => 441, 'comments_count' => 58, 'first_comment' => 'Professor Leonard really is the goat. I don\'t know why schools don\'t just point students there from day one.'],
    ],
];

// Default posts for any topic not in the sample array
$defaultPosts = [
    ['author' => 'Alex Rivera',    'avatar' => 'https://ui-avatars.com/api/?name=Alex+Rivera&background=f3f4f6&color=6b7280&rounded=true',    'time' => '4h ago',  'community' => 'FEU Life',  'title' => 'Let\'s get this ' . ucfirst(strtolower($topic)) . ' discussion going!', 'body' => 'Kicking off this topic thread. Drop your thoughts, links, and questions below. The best communities start with one brave first post — so here we are.', 'votes' => 24, 'comments_count' => 3, 'first_comment' => 'Finally! I\'ve been waiting for someone to start this.'],
    ['author' => 'Jamie Ocampo',   'avatar' => 'https://ui-avatars.com/api/?name=Jamie+Ocampo&background=e0f2fe&color=0369a1&rounded=true',   'time' => '1d ago',  'community' => 'FEU Tech', 'title' => 'Resources and links megathread — ' . ucfirst(strtolower($topic)), 'body' => 'Compiling everything useful I\'ve found on this topic. Will keep updating as we find more. Feel free to drop your own recommendations in the comments.', 'votes' => 61, 'comments_count' => 12, 'first_comment' => 'Bookmarked immediately. This is exactly what this community needed.'],
    ['author' => 'Sam Dela Cruz',  'avatar' => 'https://ui-avatars.com/api/?name=Sam+Dela+Cruz&background=d1fae5&color=065f46&rounded=true',  'time' => '3d ago',  'community' => 'FEU Life',  'title' => 'Hot take: ' . ucfirst(strtolower($topic)) . ' is more important than most people realize', 'body' => 'Unpopular opinion incoming. I think a lot of students underestimate how much this topic will shape their careers and daily lives. Happy to argue my case in the comments.', 'votes' => 88, 'comments_count' => 19, 'first_comment' => 'Not unpopular at all — I\'ve been saying this for years. Glad someone finally put it into words.'],
];

$posts = isset($topicPosts[$topic]) ? $topicPosts[$topic] : $defaultPosts;

// ── Post count label ─────────────────────────────────────────────────────────
$postCountLabels = [
    'TECHNOLOGY' => '2.4K',
    'CULTURE' => '1.1K',
    'GAMING' => '890',
    'FEU' => '3.2K',
    'IDEAS' => '640',
    'CREATIVE' => '760',
    'SCIENCE' => '1.5K',
    'NEWS' => '4.1K',
    'AI' => '2.8K',
    'ACADEMICS' => '1.9K',
    'LIFESTYLE' => '1.2K',
    'ENTERTAINMENT' => '1.3K',
    'MUSIC' => '980',
    'POLITICS' => '710',
    'ISSUES' => '850',
    'SPORTS' => '1.0K',
];
$postCount = isset($postCountLabels[$topic]) ? $postCountLabels[$topic] : '500+';

$META_TITLE = ucfirst(strtolower($topic)) . " — Discourse Topics";
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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&Libre+Franklin:wght@400;600;800&display=swap" rel="stylesheet">

    <!-- Metronic Core CSS -->
    <link rel="stylesheet" href="/Discourse/assets/plugins/global/plugins.bundle.css">
    <link rel="stylesheet" href="/Discourse/assets/css/style.keenicons.css">
    <link rel="stylesheet" href="/Discourse/assets/css/style.bundle.v2.full.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Discourse CSS -->
    <link href="/Discourse/assets/css/dashboard.css" rel="stylesheet">
    <link href="/Discourse/assets/css/sec-sidebar.css" rel="stylesheet">
    <link href="/Discourse/assets/css/sec-search-filter.css" rel="stylesheet">
    <link href="/Discourse/assets/css/sec-posts.css" rel="stylesheet">
    <link href="/Discourse/assets/css/sec-modals.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="/Discourse/assets/js/jquery.js"></script>
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

                            <!-- ── Topic Banner ─────────────────────────────────────── -->
                            <div class="w-100 mb-8 py-10 position-relative" style="background-color:#0b3220; border-bottom:3px solid #fbc501; overflow:hidden;">
                                <!-- Glow -->
                                <div class="position-absolute w-100 h-100 top-0 start-0" style="background:radial-gradient(circle at 75% 50%, rgba(5,177,102,0.15) 0%, transparent 60%); pointer-events:none;"></div>
                                <!-- Decorative circles -->
                                <div class="position-absolute" style="top:-30px;right:200px;width:160px;height:160px;background:rgba(255,255,255,0.04);border-radius:50%;"></div>
                                <div class="position-absolute" style="bottom:-20px;right:80px;width:100px;height:100px;background:rgba(255,255,255,0.04);border-radius:50%;"></div>

                                <div class="container-xxl position-relative" style="z-index:1;">
                                    <div class="d-flex align-items-center flex-wrap gap-6">

                                        <!-- Topic Icon -->
                                        <div class="flex-shrink-0">
                                            <div class="w-90px h-90px w-lg-110px h-lg-110px d-flex align-items-center justify-content-center rounded-3 shadow-sm"
                                                style="background-color:<?php echo $topicData['bg']; ?>;">
                                                <i class="bi <?php echo $topicData['icon']; ?> fs-2hx" style="color:<?php echo $topicData['color']; ?>;"></i>
                                            </div>
                                        </div>

                                        <!-- Topic Info -->
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center gap-3 mb-1">
                                                <!-- Breadcrumb -->
                                                <a href="/Discourse/pages/version/index.php" class="text-white text-opacity-60 fs-7 text-decoration-none text-hover-white">
                                                    <i class="bi bi-house me-1"></i>Home
                                                </a>
                                                <i class="bi bi-chevron-right text-white text-opacity-40 fs-9"></i>
                                                <span class="text-white text-opacity-60 fs-7">Topics</span>
                                                <i class="bi bi-chevron-right text-white text-opacity-40 fs-9"></i>
                                                <span class="text-white fs-7 fw-bold"><?php echo ucfirst(strtolower($topic)); ?></span>
                                            </div>
                                            <h1 class="text-white fw-bolder fs-2tx mb-2">
                                                <i class="bi <?php echo $topicData['icon']; ?> me-3" style="color:<?php echo $topicData['bg']; ?>;"></i><?php echo ucfirst(strtolower($topic)); ?>
                                            </h1>
                                            <p class="text-white text-opacity-75 fs-6 mb-4 mw-600px"><?php echo $topicData['desc']; ?></p>
                                            <div class="d-flex gap-3 flex-wrap">
                                                <div class="border border-white border-opacity-25 rounded px-3 py-1 d-flex align-items-center gap-2">
                                                    <i class="bi bi-pencil-square text-white fs-7"></i>
                                                    <span class="text-white fw-bold fs-7"><?php echo $postCount; ?></span>
                                                    <span class="text-white text-opacity-75 fs-9">Posts</span>
                                                </div>
                                                <div class="border border-white border-opacity-25 rounded px-3 py-1 d-flex align-items-center gap-2">
                                                    <i class="bi bi-people text-white fs-7"></i>
                                                    <span class="text-white fw-bold fs-7">Active</span>
                                                    <span class="text-white text-opacity-75 fs-9">Community</span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Post Button -->
                                        <div class="flex-shrink-0 ms-auto">
                                            <a href="/Discourse/pages/version/create-post.php" class="btn btn-warning fw-bolder text-white px-8 py-3 d-flex align-items-center gap-2 rounded-pill"
                                                style="background-color:#fbc501; box-shadow:0 4px 14px rgba(245,166,35,0.3);">
                                                <i class="bi bi-plus-lg text-white fs-6"></i> New Post
                                            </a>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="app-container container-xxl">

                                <!-- ── 2-col layout ──────────────────────────────────── -->
                                <div class="discourse-dashboard-layout" id="discourse-dashboard">

                                    <!-- ── LEFT: Feed ───────────────────────────────────── -->
                                    <div class="discourse-feed-col">

                                        <!-- Search + Sort Row -->
                                        <div class="d-flex flex-column flex-sm-row align-items-stretch align-items-sm-center gap-3 mb-5 mt-2">
                                            <div class="position-relative flex-grow-1">
                                                <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-4 text-gray-500 pe-none fs-6"></i>
                                                <input type="text" id="topicSearchInput" class="form-control bg-white rounded-pill ps-12 fs-6 text-gray-700 shadow-sm" placeholder="Search in <?php echo ucfirst(strtolower($topic)); ?>...">
                                            </div>
                                            <a href="/Discourse/pages/version/create-post.php"
                                                class="btn btn-sm rounded-pill fw-bold fs-7 px-5 py-3 d-inline-flex align-items-center justify-content-center gap-1"
                                                style="background:#0b301f; color:#fff;">
                                                <i class="bi bi-plus-lg me-1 fs-7"></i> New Post
                                            </a>
                                        </div>

                                        <!-- Filter Tabs -->
                                        <div class="d-flex align-items-center justify-content-between border-bottom border-2 border-gray-200 mb-5">
                                            <ul class="nav nav-line-tabs nav-line-tabs-2x border-transparent fs-6 fw-bold mb-0" role="tablist">
                                                <li class="nav-item">
                                                    <button class="nav-link active px-3 py-2 px-sm-4 py-sm-3 fs-7" data-bs-toggle="tab" href="#hot">
                                                        <i class="bi bi-fire me-1"></i> HOT
                                                    </button>
                                                </li>
                                                <li class="nav-item">
                                                    <button class="nav-link px-3 py-2 px-sm-4 py-sm-3 fs-7" data-bs-toggle="tab" href="#new">
                                                        <i class="bi bi-lightning-charge me-1"></i> NEW
                                                    </button>
                                                </li>
                                                <li class="nav-item">
                                                    <button class="nav-link px-3 py-2 px-sm-4 py-sm-3 fs-7" data-bs-toggle="tab" href="#top">
                                                        <i class="bi bi-trophy me-1"></i> TOP
                                                    </button>
                                                </li>
                                                <li class="nav-item">
                                                    <button class="nav-link px-3 py-2 px-sm-4 py-sm-3 fs-7" data-bs-toggle="tab" href="#rising">
                                                        <i class="bi bi-graph-up-arrow me-1"></i> RISING
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>

                                        <!-- Post Feed -->
                                        <div id="topicPostFeed">
                                            <?php foreach ($posts as $post): ?>
                                                <div class="card border-0 shadow mb-5 post-card overflow-hidden" data-dc="post-card">
                                                    <div class="d-flex">

                                                        <!-- Vote Column -->
                                                        <div class="d-flex flex-column align-items-center gap-1 p-3" style="width:55px;flex-shrink:0;background-color:#e8ede9;">
                                                            <button class="btn btn-sm btn-tertiary vote-btn-v2 vote-up-btn" title="Upvote">
                                                                <i class="bi bi-hand-thumbs-up p-0"></i>
                                                            </button>
                                                            <span class="fs-7 fw-bold text-gray-600 vote-count-text"><?php echo $post['votes']; ?></span>
                                                            <button class="btn btn-sm btn-tertiary vote-btn-v2 vote-down-btn" title="Downvote">
                                                                <i class="bi bi-hand-thumbs-down p-0"></i>
                                                            </button>
                                                        </div>

                                                        <!-- Content -->
                                                        <div class="d-flex flex-column py-5 flex-grow-1 bg-white text-start">
                                                            <div class="row g-0 px-5">

                                                                <!-- Community tag + Report -->
                                                                <div class="col-12 mb-2">
                                                                    <div class="d-flex justify-content-between align-items-center">
                                                                        <?php $commDetails = getCommunityIconDetails($post['community']); ?>
                                                                        <a href="/Discourse/pages/version/community.php" class="d-flex align-items-center gap-2 text-decoration-none">
                                                                            <div class="d-flex align-items-center justify-content-center rounded-2 <?php echo $commDetails['bg_class']; ?>"
                                                                                style="width:24px;height:24px;">
                                                                                <i class="bi <?php echo $commDetails['icon']; ?> fs-8 <?php echo $commDetails['text_class']; ?>"></i>
                                                                            </div>
                                                                            <span class="fw-bold text-gray-800 text-hover-primary fs-7">c/<?php echo $post['community']; ?></span>
                                                                        </a>
                                                                        <button class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#modalReportPost">
                                                                            <i class="bi bi-flag me-1"></i> Report
                                                                        </button>
                                                                    </div>
                                                                </div>

                                                                <!-- Author row -->
                                                                <div class="col-12 mb-2">
                                                                    <div class="d-flex gap-3 align-items-center">
                                                                        <img src="<?php echo $post['avatar']; ?>" alt="<?php echo $post['author']; ?>" class="h-40px w-40px rounded-circle" />
                                                                        <div class="d-flex flex-column">
                                                                            <a href="/Discourse/pages/version/profile-other.php" class="fs-6 fw-bold text-gray-800 text-hover-primary"><?php echo $post['author']; ?></a>
                                                                            <span class="text-muted fs-8"><i class="bi bi-clock me-1 fs-8"></i><?php echo $post['time']; ?></span>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- Title + Badge + Body -->
                                                                <div class="col-12 mb-2">
                                                                    <div class="d-flex flex-column gap-2 text-start">
                                                                        <div>
                                                                            <?php $b = getCategoryBadgeStyle($topic); ?>
                                                                            <span class="badge <?php echo $b['class']; ?> rounded-pill px-3 py-1 fs-8 fw-bold">
                                                                                <i class="bi <?php echo $b['icon']; ?> <?php echo $b['icon_color']; ?> me-1"></i><?php echo $topic; ?>
                                                                            </span>
                                                                        </div>
                                                                        <h3 class="fw-bold fs-5 mb-0">
                                                                            <a href="/Discourse/pages/version/view-post.php" class="text-gray-800 text-hover-primary dc-post-title-link">
                                                                                <?php echo $post['title']; ?>
                                                                            </a>
                                                                        </h3>
                                                                        <div class="dc-body-wrap">
                                                                            <span class="fs-7 text-gray-700 dc-body-clamp"><?php echo $post['body']; ?></span>
                                                                            <a href="#" class="dc-see-more-link fw-semibold cursor-pointer d-none" onclick="dcToggleBody(event, this)">See More</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Action Row -->
                                                            <div class="row">
                                                                <div class="d-flex justify-content-start align-items-center w-100 px-5">
                                                                    <button class="btn btn-sm dc-post-comment">
                                                                        <i class="bi bi-chat me-1"></i>
                                                                        <span class="comment-count-btn-text"><?php echo $post['comments_count']; ?> Comment<?php echo $post['comments_count'] !== 1 ? 's' : ''; ?></span>
                                                                    </button>
                                                                    <button class="btn btn-sm dc-post-share"><i class="bi bi-share me-1"></i> Share</button>
                                                                    <button class="btn btn-sm dc-post-save"><i class="bi bi-bookmark me-1"></i> Save</button>
                                                                </div>
                                                            </div>

                                                            <!-- Quick Comment Drawer -->
                                                            <div class="dc-quick-comment-drawer border-top border-gray-200 mt-4 pt-4 px-5 w-100" style="display:none;background-color:#fcfdfc;">
                                                                <div class="dc-quick-comments-list mb-4 d-flex flex-column gap-3" style="max-height:180px;overflow-y:auto;">
                                                                    <div class="d-flex align-items-start gap-2 fs-7">
                                                                        <img src="<?php echo $post['avatar']; ?>" class="h-25px w-25px rounded-circle" alt="<?php echo $post['author']; ?>">
                                                                        <div class="bg-light p-2 rounded-3 flex-grow-1 text-start">
                                                                            <div class="d-flex justify-content-between">
                                                                                <span class="fw-bold text-gray-800"><?php echo $post['author']; ?></span>
                                                                                <span class="text-muted fs-9">2d ago</span>
                                                                            </div>
                                                                            <p class="text-gray-700 m-0 mt-1"><?php echo $post['first_comment']; ?></p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <form class="dc-quick-comment-form">
                                                                    <div class="d-flex align-items-center gap-2">
                                                                        <img src="/Discourse/assets/images/catalina.webp" class="h-30px w-30px rounded-circle" alt="You">
                                                                        <input type="text" class="form-control form-control-sm rounded-pill px-4 fs-7 bg-white border border-gray-300"
                                                                            placeholder="Write a quick comment..." required style="height:35px;" />
                                                                        <button type="submit" class="btn btn-sm rounded-pill px-4 fw-bold"
                                                                            style="background:#0b301f;color:#fff;border:none;height:35px;">Post</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div><!-- /content -->

                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div><!-- /#topicPostFeed -->

                                        <!-- Empty state (hidden unless search yields nothing) -->
                                        <div id="topicEmptyState" class="text-center py-16 d-none">
                                            <div class="mb-4" style="font-size:3rem;"><?php echo str_replace('bi-', '', $topicData['icon']); ?></div>
                                            <h4 class="fw-bold text-gray-700 mb-2">No posts found</h4>
                                            <p class="text-muted fs-6">Try a different search term or be the first to post!</p>
                                            <a href="/Discourse/pages/version/create-post.php" class="btn btn-sm rounded-pill fw-bold px-6 py-3 mt-2" style="background:#0b301f;color:#fff;">
                                                <i class="bi bi-plus-lg me-1"></i> Create Post
                                            </a>
                                        </div>

                                    </div><!-- /feed col -->

                                    <!-- ── RIGHT: Sidebar ────────────────────────────────── -->
                                    <div class="discourse-sidebar-col">

                                        <!-- About this Topic -->
                                        <div class="card border-0 shadow-sm rounded-4 mb-4 mt-2" style="overflow:hidden;">
                                            <div class="p-5 d-flex align-items-center gap-3"
                                                style="background-color:<?php echo $topicData['bg']; ?>;">
                                                <div class="d-flex align-items-center justify-content-center rounded-3 shadow-sm"
                                                    style="width:52px;height:52px;background-color:<?php echo $topicData['color']; ?>;">
                                                    <i class="bi <?php echo $topicData['icon']; ?> text-white fs-3"></i>
                                                </div>
                                                <div>
                                                    <h6 class="fw-bolder mb-0 fs-5" style="color:<?php echo $topicData['color']; ?>;"><?php echo ucfirst(strtolower($topic)); ?></h6>
                                                    <span class="text-muted fs-8"><?php echo $postCount; ?> posts · active community</span>
                                                </div>
                                            </div>
                                            <div class="card-body p-4 pt-3">
                                                <p class="fs-7 text-gray-600 mb-0"><?php echo $topicData['desc']; ?></p>
                                            </div>
                                        </div>

                                        <!-- Browse All Topics -->
                                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                                            <div class="card-body p-4">
                                                <div class="d-flex align-items-center justify-content-between mb-3">
                                                    <h6 class="fs-6 fw-bold text-gray-800 mb-0">Browse Topics</h6>
                                                </div>
                                                <div class="d-flex flex-wrap gap-2">
                                                    <?php
                                                    $topicBadgeMap = [
                                                        'TECHNOLOGY'    => ['class' => 'badge-light-primary',   'icon' => 'bi-cpu'],
                                                        'CULTURE'       => ['class' => 'badge-light-danger',    'icon' => 'bi-palette'],
                                                        'GAMING'        => ['class' => 'badge-light-warning',   'icon' => 'bi-controller'],
                                                        'FEU'           => ['class' => 'badge-light-warning',   'icon' => 'bi-building'],
                                                        'IDEAS'         => ['class' => 'badge-light-info',      'icon' => 'bi-lightbulb'],
                                                        'CREATIVE'      => ['class' => 'badge-light-primary',   'icon' => 'bi-stars'],
                                                        'SCIENCE'       => ['class' => 'badge-light-info',      'icon' => 'bi-droplet-half'],
                                                        'NEWS'          => ['class' => 'badge-light-danger',    'icon' => 'bi-newspaper'],
                                                        'AI'            => ['class' => 'badge-light-success',   'icon' => 'bi-robot'],
                                                        'ACADEMICS'     => ['class' => 'badge-light-warning',   'icon' => 'bi-book'],
                                                        'LIFESTYLE'     => ['class' => 'badge-light-info',      'icon' => 'bi-emoji-smile'],
                                                        'ENTERTAINMENT' => ['class' => 'badge-light-primary',   'icon' => 'bi-film'],
                                                        'MUSIC'         => ['class' => 'badge-light-danger',    'icon' => 'bi-music-note'],
                                                        'POLITICS'      => ['class' => 'badge-light-dark',      'icon' => 'bi-megaphone'],
                                                        'ISSUES'        => ['class' => 'badge-light-danger',    'icon' => 'bi-exclamation-circle'],
                                                        'SPORTS'        => ['class' => 'badge-light-warning',   'icon' => 'bi-trophy'],
                                                    ];
                                                    foreach ($topicBadgeMap as $t => $b):
                                                        $isActive = ($t === $topic);
                                                    ?>
                                                        <a href="/Discourse/pages/view/topic.php?t=<?php echo $t; ?>"
                                                            class="badge <?php echo $b['class']; ?> rounded-pill px-3 py-2 fs-8 text-decoration-none dc-topic-tag fw-bold <?php echo $isActive ? 'dc-topic-tag-active' : ''; ?>"
                                                            style="<?php echo $isActive ? 'outline:2px solid currentColor;outline-offset:1px;' : ''; ?>">
                                                            <i class="bi <?php echo $b['icon']; ?> me-1"></i><?php echo $t; ?>
                                                        </a>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Community Stats -->
                                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                                            <div class="card-body p-4">
                                                <h6 class="fs-6 fw-bold text-gray-800 mb-3">Community Stats</h6>
                                                <div class="d-flex flex-column gap-3">
                                                    <div class="discourse-stat-item d-flex align-items-center justify-content-between pb-3">
                                                        <div class="d-flex align-items-center gap-3">
                                                            <div class="d-flex align-items-center justify-content-center bg-light-success rounded-2" style="width:36px;height:36px;flex-shrink:0;">
                                                                <i class="bi bi-people-fill text-success"></i>
                                                            </div>
                                                            <span class="fs-7 fw-bold text-gray-800 text-uppercase" style="letter-spacing:.06em;">Members</span>
                                                        </div>
                                                        <div class="d-flex flex-column text-end">
                                                            <span class="fs-5 fw-bolder text-gray-800">4,819</span>
                                                            <span class="fs-8 text-muted">+143 This Week</span>
                                                        </div>
                                                    </div>
                                                    <div class="discourse-stat-item d-flex align-items-center justify-content-between pb-3">
                                                        <div class="d-flex align-items-center gap-3">
                                                            <div class="d-flex align-items-center justify-content-center bg-light-success rounded-2" style="width:36px;height:36px;flex-shrink:0;">
                                                                <i class="bi bi-file-text-fill text-success"></i>
                                                            </div>
                                                            <span class="fs-7 fw-bold text-gray-800 text-uppercase" style="letter-spacing:.06em;">Posts Today</span>
                                                        </div>
                                                        <div class="d-flex flex-column text-end">
                                                            <span class="fs-5 fw-bolder text-gray-800">390</span>
                                                            <span class="fs-8 text-muted">Across 9 Topics</span>
                                                        </div>
                                                    </div>
                                                    <div class="discourse-stat-item d-flex align-items-center justify-content-between">
                                                        <div class="d-flex align-items-center gap-3">
                                                            <div class="d-flex align-items-center justify-content-center bg-light-success rounded-2" style="width:36px;height:36px;flex-shrink:0;">
                                                                <i class="bi bi-wifi text-success"></i>
                                                            </div>
                                                            <span class="fs-7 fw-bold text-gray-800 text-uppercase" style="letter-spacing:.06em;">Online Now</span>
                                                        </div>
                                                        <div class="d-flex flex-column text-end">
                                                            <span class="fs-5 fw-bolder text-gray-800">1,042</span>
                                                            <span class="fs-8 text-muted">Active Users</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Campus Buzz -->
                                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                                            <div class="card-body p-4">
                                                <h6 class="fs-6 fw-bold text-gray-800 mb-3">Campus Buzz</h6>
                                                <p class="fs-8 fw-bold text-muted text-uppercase mb-2" style="letter-spacing:.08em;">Trending Today</p>
                                                <div class="d-flex flex-wrap gap-2 mb-3">
                                                    <span class="badge badge-light rounded-pill border px-4 py-2 fs-8">#HASHTAG</span>
                                                    <span class="badge badge-light rounded-pill border px-4 py-2 fs-8">#WORLDPEACE</span>
                                                    <span class="badge badge-light rounded-pill border px-4 py-2 fs-8">#VALORANT</span>
                                                    <span class="badge badge-light rounded-pill border px-4 py-2 fs-8">#PETITION</span>
                                                </div>
                                                <p class="fs-8 fw-bold text-muted text-uppercase mb-2" style="letter-spacing:.08em;">Posting Tips</p>
                                                <ul class="list-unstyled d-flex flex-column gap-2 m-0 p-0">
                                                    <li class="fs-7 text-gray-600 d-flex align-items-start gap-2">
                                                        <i class="bi bi-arrow-right-circle-fill text-warning mt-1 flex-shrink-0"></i>
                                                        Tag the right topic for better reach and visibility.
                                                    </li>
                                                    <li class="fs-7 text-gray-600 d-flex align-items-start gap-2">
                                                        <i class="bi bi-arrow-right-circle-fill text-warning mt-1 flex-shrink-0"></i>
                                                        Use anonymous mode for sensitive topics.
                                                    </li>
                                                    <li class="fs-7 text-gray-600 d-flex align-items-start gap-2">
                                                        <i class="bi bi-arrow-right-circle-fill text-warning mt-1 flex-shrink-0"></i>
                                                        Post a poll to settle debates fast.
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                    </div><!-- /sidebar col -->

                                </div><!-- /layout -->

                                <?php include(dirname(dirname(__DIR__)) . "/partials/_discourse-modals.php"); ?>

                            </div><!-- /container -->
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

            // ── Voting ────────────────────────────────────────────────
            $(document).on('click', '.vote-btn-v2', function(e) {
                e.preventDefault();
                const btn = $(this);
                const isUp = btn.hasClass('vote-up-btn');
                const container = btn.closest('.post-card');
                const scoreSpan = container.find('.vote-count-text');
                const otherBtn = isUp ? container.find('.vote-down-btn') : container.find('.vote-up-btn');
                let score = parseInt(scoreSpan.text()) || 0;

                if (btn.hasClass('active-vote-up') || btn.hasClass('active-vote-down')) {
                    btn.removeClass('active-vote-up active-vote-down');
                    btn.find('i').attr('class', isUp ? 'bi bi-hand-thumbs-up p-0' : 'bi bi-hand-thumbs-down p-0');
                    scoreSpan.text(score - (isUp ? 1 : -1));
                } else {
                    if (otherBtn.hasClass('active-vote-up') || otherBtn.hasClass('active-vote-down')) {
                        otherBtn.removeClass('active-vote-up active-vote-down');
                        otherBtn.find('i').attr('class', isUp ? 'bi bi-hand-thumbs-down p-0' : 'bi bi-hand-thumbs-up p-0');
                        score += (isUp ? 1 : -1);
                    }
                    if (isUp) {
                        btn.addClass('active-vote-up');
                        btn.find('i').attr('class', 'bi bi-hand-thumbs-up-fill p-0');
                        scoreSpan.text(score + 1);
                    } else {
                        btn.addClass('active-vote-down');
                        btn.find('i').attr('class', 'bi bi-hand-thumbs-down-fill p-0');
                        scoreSpan.text(score - 1);
                    }
                }
            });

            // ── Search ────────────────────────────────────────────────
            $('#topicSearchInput').on('keyup', function() {
                const q = $(this).val().toLowerCase();
                let visible = 0;
                $('.post-card').each(function() {
                    const title = $(this).find('.dc-post-title-link').text().toLowerCase();
                    const content = $(this).find('.dc-body-clamp').text().toLowerCase();
                    const show = title.includes(q) || content.includes(q);
                    $(this).toggle(show);
                    if (show) visible++;
                });
                $('#topicEmptyState').toggleClass('d-none', visible > 0);
            });

            // ── Sort Tabs (visual only) ───────────────────────────────
            $('.nav-line-tabs .nav-link').on('click', function() {
                $('.nav-line-tabs .nav-link').removeClass('active');
                $(this).addClass('active');
            });

            // ── Comment Drawer ────────────────────────────────────────
            $(document).on('click', '.dc-post-comment', function(e) {
                e.preventDefault();
                const drawer = $(this).closest('[data-dc="post-card"]').find('.dc-quick-comment-drawer');
                drawer.slideToggle(200);
                drawer.find('input').focus();
            });

            // ── Comment Submit ────────────────────────────────────────
            $(document).on('submit', '.dc-quick-comment-form', function(e) {
                e.preventDefault();
                const input = $(this).find('input');
                const text = input.val().trim();
                if (!text) return;
                const card = $(this).closest('[data-dc="post-card"]');
                const list = card.find('.dc-quick-comments-list');
                const countSpan = card.find('.comment-count-btn-text');

                function esc(t) {
                    return t.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
                }

                list.append(`
        <div class="d-flex align-items-start gap-2 fs-7">
          <img src="/Discourse/assets/images/catalina.webp" class="h-25px w-25px rounded-circle">
          <div class="bg-light p-2 rounded-3 flex-grow-1 text-start">
            <div class="d-flex justify-content-between">
              <span class="fw-bold text-gray-800">You (Catalina)</span>
              <span class="text-muted fs-9">just now</span>
            </div>
            <p class="text-gray-700 m-0 mt-1">${esc(text)}</p>
          </div>
        </div>`);
                list.scrollTop(list[0].scrollHeight);
                input.val('');

                let n = parseInt(countSpan.text()) || 0;
                n++;
                countSpan.text(n + (n === 1 ? ' Comment' : ' Comments'));
                showToast('Comment posted!');
            });

            // ── Toast ─────────────────────────────────────────────────
            function showToast(msg) {
                const t = $('#dc-feed-toast');
                if (!t.length) return;
                t.find('span').text(msg);
                t.fadeIn(200);
                clearTimeout(window._dcToast);
                window._dcToast = setTimeout(() => t.fadeOut(200), 2200);
            }

        });

        // ── See More / Less ────────────────────────────────────────
        (function() {
            function init() {
                document.querySelectorAll('.dc-body-clamp').forEach(span => {
                    const link = span.nextElementSibling;
                    if (!link || !link.classList.contains('dc-see-more-link')) return;
                    if (span.scrollHeight > span.clientHeight + 2) link.classList.remove('d-none');
                });
            }
            document.readyState === 'loading' ? document.addEventListener('DOMContentLoaded', init) : init();
        })();

        function dcToggleBody(e, link) {
            e.preventDefault();
            const span = link.previousElementSibling;
            if (!span) return;
            const expanded = span.classList.toggle('dc-expanded');
            link.textContent = expanded ? 'See Less' : 'See More';
        }
    </script>

    <!-- Toast -->
    <div id="dc-feed-toast" style="display:none;position:fixed;bottom:1.5rem;right:1.5rem;z-index:1090;"
        class="d-flex align-items-center gap-2 px-4 py-2 bg-light border rounded-2 fs-6 text-gray-700 shadow-sm">
        <i class="bi bi-check-circle-fill text-success fs-6"></i><span></span>
    </div>

</body>

</html>