<?php
$META_TITLE = "View Post - Discourse";
$showImage = isset($_GET['img']) && $_GET['img'] == '1';
$showPoll = isset($_GET['poll']) && $_GET['poll'] == '1';
$showAnon = isset($_GET['anon']) && $_GET['anon'] == '1';
$showSample = isset($_GET['sample']) && $_GET['sample'] == '1';

$communityMeta = [
    'FEU Tech'    => ['members' => '12.3k', 'type' => 'Public Group'],
    'FEU Life'    => ['members' => '4.8k',  'type' => 'Public Group'],
    'FEU Alabang' => ['members' => '3.1k',  'type' => 'Public Group'],
    'FEU Diliman' => ['members' => '2.7k',  'type' => 'Public Group'],
];

if ($showImage) {
    $postTitle   = "Review: FEU Tech library study rooms — worth booking or just use the hallway?";
    $postDesc    = "Finally tried booking one of the new study rooms in the library. Honest review: the booking system is clunky, the AC is questionable, but the soundproofing is actually great. Worth it for group study if you plan ahead.<br><br>Not ideal for solo cramming though — the chairs are surprisingly uncomfortable for long sessions.";
    $authorName  = "Catalina Smith";
    $authorInitials = "CS";
    $bannerMeta  = "ACADEMICS • Posted by Catalina Smith • 5d ago";
    $tag         = "ACADEMICS";
    $community   = "FEU Tech";
} elseif ($showPoll) {
    $postTitle   = "📊 Poll: How do you actually study for finals? Be honest.";
    $postDesc    = "Curious how my fellow FEU Tech students survive finals season. Drop your honest answer below 👇";
    $authorName  = "Marco Torres";
    $authorInitials = "MT";
    $bannerMeta  = "FEU • Posted by Marco Torres • 4h ago";
    $tag         = "FEU";
    $community   = "FEU Life";
} elseif ($showAnon) {
    $postTitle   = "What if FEU had a no-grade-penalty mental health leave policy?";
    $postDesc    = "Just thinking — a lot of students I know failed a whole semester because they were dealing with severe anxiety during midterms. The university had no mechanism to help them — just a strict drop policy or failure. Other universities have mental health leaves where students can pause without academic penalty. Should FEU implement something similar?";
    $authorName  = "Anonymous";
    $authorInitials = "A";
    $bannerMeta  = "Issues • Posted anonymously • 1d ago";
    $tag         = "ISSUES";
    $community   = "FEU Tech";
} elseif ($showSample) {
    $postTitle   = "Lorem ipsum dolor sit amet consectetur adipiscing elit.";
    $postDesc    = "Lorem ipsum dolor sit amet consectetur adipiscing elit. Quisque faucibus ex sapien vitae pellentesque sem placerat. In id cursus mi pretium tellus duis convallis. Tempus leo eu aenean sed diam uma tempor. Pulvinar vivamus fringilla lacus nec metus bibendum egestas.";
    $authorName  = "John Doe";
    $authorInitials = "JD";
    $bannerMeta  = "Entertainment • Posted by John Doe • 1d ago";
    $tag         = "ENTERTAINMENT";
    $community   = "FEU Tech";
} else {
    $postTitle   = "The silent revolution in edge AI — why on-device inference is changing everything";
    $postDesc    = "Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc, quis gravida magna mi a libero. Fusce vulputate eleifend sapien. Vestibulum purus quam, scelerisque ut, mollis sed, nonummy id, metus. Nullam accumsan lorem in dui. Cras ultricies mi eu turpis hendrerit fringilla. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; In ac dui quis mi consectetuer lacinia. Nam pretium turpis et arcu. Duis arcu tortor, suscipit eget, imperdiet nec, imperdiet iaculis, ipsum. Sed aliquam ultrices mauris. Integer ante arcu, accumsan a, consectetuer eget, posuere ut, mauris. Praesent adipiscing. Phasellus ullamcorper ipsum rutrum nunc. Nunc nonummy metus. Vestib";
    $authorName  = "Ravi Joshi";
    $authorInitials = "RJ";
    $bannerMeta  = "Technology • Posted by Ravi Joshi • 3h ago";
    $tag         = "TECHNOLOGY";
    $community   = "FEU Tech";
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
    <link href="/Discourse/assets/css/sec-modals.css" rel="stylesheet" type="text/css" />
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

        .posting-as-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 10px;
            font-weight: 600;
            color: #6b7280;
            background: #f3f4f6;
            border-radius: 99px;
            padding: 3px 10px;
            border: 1px solid #e5e7eb;
            transition: all 0.2s;
        }

        .posting-as-badge.anon-mode {
            background: #fff7ed;
            border-color: #fed7aa;
            color: #c2410c;
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
    <?php include(dirname(dirname(__DIR__)) . "/partials/_page-loader.php"); ?>
    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
            <?php include(dirname(dirname(__DIR__)) . "/partials/_header.php"); ?>
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
                                <div class="container-xxl d-flex align-items-center justify-content-between">
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
                                    <a href="/Discourse/pages/version/community.php"
                                        class="btn btn-sm btn-outline btn-outline-white text-white border-white border-opacity-25 px-4 py-2 d-flex align-items-center gap-2 text-decoration-none">
                                        <i class="ki-duotone ki-arrow-left text-white fs-8"><span class="path1"></span><span class="path2"></span></i> Back to Feed
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
                                                            <div class="symbol-label bg-success text-white fw-bold fs-6"><?php echo $authorInitials; ?></div>
                                                        </div>
                                                        <div class="d-flex align-items-center gap-2">
                                                            <a href="/Discourse/pages/version/profile-other.php" class="fw-bolder text-dark text-hover-primary fs-6"><?php echo $authorName; ?></a>
                                                            <span class="text-muted fs-8">in</span>
                                                            <?php $commDetails = getCommunityIconDetails($community); ?>
                                                            <!-- FIX 2: text_class moved to <i> tag -->
                                                            <a href="/Discourse/pages/version/community.php" class="d-inline-flex align-items-center gap-1 text-decoration-none">
                                                                <div class="d-flex align-items-center justify-content-center rounded-2 <?php echo $commDetails['bg_class']; ?>"
                                                                    style="width:20px;height:20px;">
                                                                    <i class="bi <?php echo $commDetails['icon']; ?> <?php echo $commDetails['text_class']; ?>" style="font-size:8px;"></i>
                                                                </div>
                                                                <span class="fw-bold text-gray-800 text-hover-primary" style="font-size:11px;">c/<?php echo $community; ?></span>
                                                            </a>
                                                            <?php if ($showImage) { ?>
                                                                <span class="tag-badge rounded-pill d-inline-flex align-items-center gap-1" style="font-size:9px;padding:2px 8px;background-color:#dcfce7;color:#166534;">
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
                                                    <?php $postBadge = getCategoryBadgeStyle($tag); ?>
                                                    <a href="/Discourse/pages/view/topic.php?t=<?php echo strtoupper($tag); ?>" class="badge <?php echo $postBadge['class']; ?> rounded-pill px-3 py-2 fs-8 fw-bold text-decoration-none">
                                                        <i class="bi <?php echo $postBadge['icon']; ?> <?php echo $postBadge['icon_color']; ?> me-1"></i>
                                                        <?php echo strtoupper($tag); ?>
                                                    </a>
                                                </div>
                                                <h1 class="fw-bolder text-dark fs-2x mb-4"><?php echo $postTitle; ?></h1>
                                                <div class="text-gray-800 fs-6 lh-lg mb-6">
                                                    <?php
                                                    if ($showImage) {
                                                        $parts = explode("<br><br>", $postDesc);
                                                        echo "<p class='mb-6'>" . $parts[0] . "</p>";
                                                    ?>
                                                        <div class="mb-6 rounded-2 overflow-hidden position-relative">
                                                            <img src="https://images.unsplash.com/photo-1541829070764-84a7d30dd3f3?q=80&w=1200&auto=format&fit=crop"
                                                                class="w-100 object-fit-cover" style="height:300px;filter:brightness(0.8) sepia(0.2) hue-rotate(90deg);" alt="Library">
                                                            <div class="position-absolute bottom-0 start-0 p-3">
                                                                <span class="text-white fs-9" style="text-shadow:1px 1px 2px rgba(0,0,0,0.8);">
                                                                    <i class="ki-duotone ki-geolocation text-danger me-1"><span class="path1"></span><span class="path2"></span></i>
                                                                    FEU Tech Main Library - Study Room 3B - 3rd Floor
                                                                </span>
                                                            </div>
                                                        </div>
                                                    <?php
                                                        echo "<p class='mb-0'>" . $parts[1] . "</p>";
                                                    } elseif ($showPoll) {
                                                        echo "<p class='mb-4'>" . $postDesc . "</p>";
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
                                                        <button class="btn btn-sm btn-light-muted vote-btn btn-save d-flex align-items-center gap-1 px-3 py-2 rounded-pill" id="save-post-btn">
                                                            <i class="bi bi-bookmark fs-7"></i> <span class="fw-bold fs-8">Save</span>
                                                        </button>
                                                    </div>
                                                    <div class="d-flex align-items-center gap-1">
                                                        <?php if ($showImage) { ?>
                                                            <a href="/Discourse/pages/view/edit-post.php" class="btn btn-sm btn-light-primary d-flex align-items-center gap-1 px-3 py-2 rounded-pill">
                                                                <i class="bi bi-pencil-square fs-7 text-primary"></i> <span class="fw-bold fs-8">Edit Post</span>
                                                            </a>
                                                        <?php } ?>
                                                        <button class="btn btn-sm btn-light-muted vote-btn text-danger d-flex align-items-center gap-1 px-3 py-2 rounded-pill"
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
                                                            id="comment-count-badge" style="font-size:10px;"><?php
                                                                                                                if ($showImage) echo '1';
                                                                                                                elseif ($showPoll) echo '1';
                                                                                                                elseif ($showAnon) echo '1';
                                                                                                                elseif ($showSample) echo '1';
                                                                                                                else echo '3';
                                                                                                                ?></span>
                                                    </div>

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

                                                        <?php if (!$showImage && !$showPoll && !$showAnon && !$showSample) { ?>
                                                            <div class="comment-thread-line mt-3 mb-4">
                                                                <div class="d-flex">
                                                                    <div class="symbol symbol-30px symbol-circle me-3 flex-shrink-0">
                                                                        <div class="symbol-label bg-light text-muted fw-bold fs-7">
                                                                            <i class="ki-duotone ki-profile-circle"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                                                        </div>
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

                                                    <?php if (!$showImage && !$showPoll && !$showAnon && !$showSample) { ?>
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
                                                </div>

                                                <!-- Write Comment -->
                                                <div class="d-flex align-items-start mt-8" id="comment-composer">
                                                    <div class="symbol symbol-35px symbol-circle me-3 flex-shrink-0 mt-1" id="commenter-avatar">
                                                        <div class="symbol-label bg-success text-white fw-bold fs-6" id="commenter-initials"><?php echo $authorInitials; ?></div>
                                                    </div>
                                                    <div class="comment-input-row flex-grow-1">
                                                        <div class="comment-input-wrapper">
                                                            <input type="text" id="main-comment-input" class="comment-input" placeholder="Write a comment...">
                                                            <button id="post-comment-btn" class="btn btn-sm btn-green px-4 py-1 me-1 fs-8 fw-bold">
                                                                <i class="ki-duotone ki-send me-1 fs-9"><span class="path1"></span><span class="path2"></span></i> Post
                                                            </button>
                                                        </div>
                                                        <div class="comment-input-controls">
                                                            <span class="posting-as-badge" id="posting-as-badge">
                                                                <i class="bi bi-person-fill" style="font-size:10px;"></i>
                                                                Posting as <strong id="posting-as-name"><?php echo $authorName; ?></strong>
                                                            </span>
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

                                                <?php if (!$showImage && !$showAnon) { ?>
                                                    <button class="btn w-100 btn-green btn-sm fw-bold">
                                                        <i class="ki-duotone ki-user-tick me-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i> Follow
                                                    </button>
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

                                                    <?php if (!$showImage) { ?>
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
                    <?php include(dirname(dirname(__DIR__)) . "/partials/_footer.php"); ?>
                </div>
            </div>
        </div>
    </div>
    <?php include(dirname(dirname(__DIR__)) . "/partials/_discourse-modals.php"); ?>
    <?php include(dirname(dirname(__DIR__)) . "/partials/_scrolltop.php"); ?>
    <script src="/Discourse/assets/plugins/global/plugins.bundle.js"></script>
    <script src="/Discourse/assets/js/sec-modals.js"></script>

    <script>
        $(document).ready(function() {
            let commentCount = parseInt($('#comment-count-badge').text()) || 0;
            let replyingToThread = null;
            let isAnonymous = false;
            const realName = '<?php echo $authorName; ?>';
            const realInitials = '<?php echo $authorInitials; ?>';

            $('#anon-toggle-checkbox').on('change', function() {
                isAnonymous = $(this).is(':checked');
                const wrapper = $('#anon-toggle-wrapper');
                const badge = $('#posting-as-badge');
                const avatar = $('#commenter-initials');
                if (isAnonymous) {
                    wrapper.addClass('is-anon');
                    badge.addClass('anon-mode');
                    badge.html('<i class="bi bi-incognito" style="font-size:10px;"></i> Posting as <strong>Anonymous</strong>');
                    avatar.text('A').css('background', '#ea580c');
                } else {
                    wrapper.removeClass('is-anon');
                    badge.removeClass('anon-mode');
                    badge.html('<i class="bi bi-person-fill" style="font-size:10px;"></i> Posting as <strong>' + realName + '</strong>');
                    avatar.text(realInitials).css('background', '');
                }
            });

            $('#save-post-btn').on('click', function() {
                const btn = $(this);
                const isSaved = btn.hasClass('saved');
                if (isSaved) {
                    btn.removeClass('saved btn-light-warning').addClass('btn-light-muted');
                    btn.find('i').removeClass('bi-bookmark-fill').addClass('bi-bookmark');
                    btn.find('span').text('Save');
                } else {
                    btn.removeClass('btn-light-muted').addClass('saved btn-light-warning');
                    btn.find('i').removeClass('bi-bookmark').addClass('bi-bookmark-fill');
                    btn.find('span').text('Saved');
                }
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

            $(document).on('click', '.vote-btn:has(.bi-chat)', function(e) {
                e.preventDefault();
                const threadContainer = $(this).closest('.mb-2');
                replyingToThread = threadContainer.length ? threadContainer : null;
                const authorName = $(this).closest('.d-flex').find('.fw-bolder.text-dark.fs-7').first().text();
                $('#main-comment-input').val(`@${authorName} `).focus();
            });

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
                const displayName = isAnonymous ? 'Anonymous' : realName;
                const displayInitials = isAnonymous ? 'A' : realInitials;
                const avatarBg = isAnonymous ? '#ea580c' : '#198754';
                const anonBadgeHtml = isAnonymous ?
                    `<span class="badge ms-1 rounded-pill" style="font-size:9px;background:#fff7ed;color:#c2410c;border:1px solid #fed7aa;">
                       <i class="bi bi-incognito me-1" style="font-size:8px;"></i>Anonymous
                   </span>` : '';
                const newCommentHtml = `
                <div class="d-flex mb-3">
                    <div class="symbol symbol-30px symbol-circle me-3 flex-shrink-0">
                        <div class="symbol-label text-white fw-bold fs-7" style="background:${avatarBg};">${displayInitials}</div>
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <div class="d-flex align-items-center gap-2">
                                <span class="fw-bolder text-dark fs-7">${displayName}</span>
                                ${anonBadgeHtml}
                                <span class="text-muted fs-9">Just now</span>
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
                </div>`;
                if (replyingToThread) {
                    let nestedWrapper = replyingToThread.find('.comment-thread-line').first();
                    if (nestedWrapper.length === 0) {
                        replyingToThread.append('<div class="comment-thread-line mt-3 mb-4"></div>');
                        nestedWrapper = replyingToThread.find('.comment-thread-line');
                    }
                    nestedWrapper.append(newCommentHtml);
                } else {
                    $('#comments-container').append(`<div class="mb-2 mt-6">${newCommentHtml}</div>`);
                }
                input.val('');
                replyingToThread = null;
                commentCount++;
                $('#comment-count-badge').text(commentCount);
                $('html, body').animate({
                    scrollTop: $("#comments-container").offset().top + $("#comments-container").height() - 200
                }, 300);
            }

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