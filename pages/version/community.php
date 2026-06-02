<?php
$META_TITLE = "FEU LIFE - Discourse Community (Alvaran)";
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
              <div class="community-banner w-100 mb-8 py-10 position-relative">
                <div class="community-banner-glow"></div>
                <div class="container-xxl position-relative z-index-1">
                  <div class="d-flex align-items-center flex-wrap gap-6">
                    <!-- Community Logo -->
                    <div class="flex-shrink-0">
                      <div class="w-100px h-100px w-lg-120px h-lg-120px d-flex align-items-center justify-content-center community-logo-container shadow rounded-3 bg-light-danger text-danger fs-1">
                        <i class="bi bi-heart-fill fs-2hx"></i>
                      </div>
                    </div>
                    <!-- Community Info -->
                    <div class="flex-grow-1 text-start">
                      <h1 class="text-white fw-bolder fs-2tx mb-2">FEU LIFE</h1>
                      <p class="text-white text-opacity-75 fs-6 mb-4 mw-600px">Connect with fellow Tamaraws, share academic resources, discuss campus events, and build lasting friendships.</p>
                      <div class="d-flex gap-3">
                        <div class="border border-white border-opacity-25 rounded px-3 py-1 d-flex align-items-center gap-2">
                          <i class="bi bi-people text-white fs-7"></i>
                          <span class="text-white fw-bold fs-7">4,894</span>
                          <span class="text-white text-opacity-75 fs-9">Members</span>
                        </div>
                        <div class="border border-white border-opacity-25 rounded px-3 py-1 d-flex align-items-center gap-2">
                          <i class="bi bi-pencil-square text-white fs-7"></i>
                          <span class="text-white fw-bold fs-7">1,245</span>
                          <span class="text-white text-opacity-75 fs-9">Posts</span>
                        </div>
                      </div>
                    </div>
                    <!-- Join Button -->
                    <div class="flex-shrink-0 ms-auto">
                      <button class="btn btn-warning fw-bolder text-white px-8 py-3 d-flex align-items-center gap-2 rounded-pill" style="background-color:#fbc501; box-shadow:0 4px 14px rgba(245,166,35,0.3);">
                        <i class="bi bi-plus-lg text-white fs-6"></i> JOIN COMMUNITY
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

                    <!-- Search and New Post Row -->
                    <div class="d-flex flex-column flex-sm-row align-items-stretch align-items-sm-center gap-3 mb-5">
                      <div class="position-relative flex-grow-1">
                        <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-4 text-gray-500 pe-none fs-6"></i>
                        <input type="text" class="form-control bg-white rounded-pill ps-12 fs-6 text-gray-700 search-input-v2 shadow-sm" placeholder="Search discussions, topics, people...">
                      </div>
                      <a href="/Discourse/pages/view/create-post.php" class="btn btn-sm rounded-pill fw-bold fs-7 px-5 py-3 d-inline-flex align-items-center justify-content-center gap-1" style="background:#0b301f; color:#fff;">
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
                          <li><a class="dropdown-item rounded-2 py-2 px-4 text-gray-700 text-hover-success bg-hover-light-success fs-7" href="#">Technology</a></li>
                          <li><a class="dropdown-item rounded-2 py-2 px-4 text-gray-700 text-hover-success bg-hover-light-success fs-7" href="#">Academics</a></li>
                          <li><a class="dropdown-item rounded-2 py-2 px-4 text-gray-700 text-hover-success bg-hover-light-success fs-7" href="#">Lifestyle</a></li>
                        </ul>
                      </div>
                    </div>

                    <!-- Feed -->
                    <?php
                    $posts = [
                      [
                        "author" => "Catalina Smith",
                        "avatar" => "/Discourse/assets/images/catalina.webp",
                        "time" => "2h ago",
                        "tag" => "LIFESTYLE",
                        "title" => "Honest review of every FEU canteen — ranked by someone who eats there every day",
                        "body" => "After two semesters of trial and error, I've eaten at literally every food stall in FEU. From the silog station near the gym to the overpriced pasta place by the lib — here's my honest tier list with prices, wait times, and what to actually order.",
                        "votes" => 312,
                        "comments_count" => 27,
                        "first_comment" => "The goto place near the SHS building hits different at 7am. Underrated pick!"
                      ],
                      [
                        "author" => "Marco Torres",
                        "avatar" => "https://ui-avatars.com/api/?name=Marco+Torres&background=e0f2fe&color=0369a1&rounded=true",
                        "time" => "5h ago",
                        "tag" => "ISSUES",
                        "title" => "Can we talk about how bad the WiFi is during enrollment week?",
                        "body" => "Every single semester. The moment enrollment opens, the portal crashes, the WiFi dies, and somehow it's always our fault for not enrolling on time. I have screenshots of the loading screen timing out 14 times in a row. At this point it feels intentional.",
                        "votes" => 890,
                        "comments_count" => 104,
                        "first_comment" => "Filed a ticket last semester. They said it was 'under monitoring.' Still broken."
                      ],
                      [
                        "author" => "Anonymous",
                        "avatar" => "/Discourse/assets/images/anonymous.png",
                        "time" => "1d ago",
                        "tag" => "ISSUES",
                        "title" => "Does anyone else feel completely burned out halfway through the semester?",
                        "body" => "It's not even midterms yet and I already feel like I'm running on empty. Four major outputs due this week, a group project with unresponsive members, and I haven't slept more than 5 hours in days. Is this just the FEU experience or is something wrong with me?",
                        "votes" => 674,
                        "comments_count" => 58,
                        "first_comment" => "You're not alone. I think half the campus feels this way and nobody talks about it."
                      ],
                    ];

                    foreach ($posts as $post) {
                    ?>
                      <div class="card border-0 shadow mb-5 post-card overflow-hidden" data-dc="post-card">
                        <div class="d-flex">
                          <!-- Vote Column (Dashboard Style) -->
                          <div class="d-flex flex-column align-items-center gap-1 p-3" style="width:55px;flex-shrink:0;background-color:#e8ede9;">
                            <button class="btn btn-sm btn-tertiary vote-btn-v2 vote-up-btn" title="Upvote">
                              <i class="bi bi-hand-thumbs-up p-0"></i>
                            </button>
                            <span class="fs-7 fw-bold text-gray-600 vote-count-text"><?php echo $post['votes']; ?></span>
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
                                  <?php
                                  $commDetails = getCommunityIconDetails('FEU Life');
                                  ?>
                                  <a href="/Discourse/pages/version/community.php" class="d-flex align-items-center gap-2 text-decoration-none">
                                    <div class="d-flex align-items-center justify-content-center rounded-2 <?php echo $commDetails['bg_class']; ?>"
                                      style="width: 24px; height: 24px;">
                                      <i class="bi <?php echo $commDetails['icon']; ?> fs-8 <?php echo $commDetails['text_class']; ?>"></i>
                                    </div>
                                    <span class="fw-bold text-gray-800 text-hover-primary fs-7">c/FEU Life</span>
                                  </a>
                                  <button class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#modalReportPost">
                                    <i class="bi bi-flag me-1"></i> Report
                                  </button>
                                </div>
                              </div>

                              <!-- Row 2: User avatar, name, time -->
                              <div class="col-12 mb-2">
                                <div class="d-flex gap-3 align-items-center">
                                  <img src="<?php echo $post['avatar']; ?>" alt="<?php echo $post['author']; ?>" class="h-40px w-40px rounded-circle" />
                                  <div class="d-flex flex-column">
                                    <a href="/Discourse/pages/version/profile-other.php" class="fs-6 fw-bold text-gray-800 text-hover-primary"><?php echo $post['author']; ?></a>
                                    <span class="text-muted fs-8"><i class="bi bi-clock me-1 fs-8"></i><?php echo $post['time']; ?></span>
                                  </div>
                                </div>
                              </div>

                              <!-- Row 3: Title & Excerpt -->
                              <div class="col-12 mb-2">
                                <div class="d-flex flex-column gap-2 text-start">
                                  <div>
                                    <?php $postBadge = getCategoryBadgeStyle($post['tag']); ?>
                                    <a href="/Discourse/pages/view/topic.php?t=<?php echo strtoupper($post['tag']); ?>" class="badge <?php echo $postBadge['class']; ?> rounded-pill px-3 py-2 fs-8 fw-bold text-decoration-none">
                                      <i class="bi <?php echo $postBadge['icon']; ?> <?php echo $postBadge['icon_color']; ?> me-1"></i><?php echo strtoupper($post['tag']); ?>
                                    </a>
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

                            <!-- Actions Row -->
                            <div class="row">
                              <div class="d-flex justify-content-start align-items-center w-100 px-5">
                                <button class="btn btn-sm dc-post-comment"><i class="bi bi-chat me-1"></i> <span class="comment-count-btn-text"><?php echo $post['comments_count']; ?> Comment</span></button>
                                <button class="btn btn-sm dc-post-share"><i class="bi bi-share me-1"></i> Share</button>
                                <button class="btn btn-sm dc-post-save"><i class="bi bi-bookmark me-1"></i> Save</button>
                              </div>
                            </div>

                            <!-- Inline Quick Comment Drawer (Dashboard style) -->
                            <div class="dc-quick-comment-drawer border-top border-gray-200 mt-4 pt-4 px-5 w-100" style="display: none; background-color: #fcfdfc;">
                              <div class="dc-quick-comments-list mb-4 d-flex flex-column gap-3" style="max-height: 180px; overflow-y: auto;">
                                <div class="d-flex align-items-start gap-2 fs-7">
                                  <img src="https://ui-avatars.com/api/?name=Sofia+Karim&background=f3f4f6&color=d97706&rounded=true" class="h-25px w-25px rounded-circle" alt="Sofia Karim">
                                  <div class="bg-light p-2 rounded-3 flex-grow-1 text-start">
                                    <div class="d-flex justify-content-between">
                                      <span class="fw-bold text-gray-800">Sofia Karim</span>
                                      <span class="text-muted fs-9">2d ago</span>
                                    </div>
                                    <p class="text-gray-700 m-0 mt-1"><?php echo $post['first_comment']; ?></p>
                                  </div>
                                </div>
                              </div>
                              <form class="dc-quick-comment-form">
                                <div class="d-flex align-items-center gap-2">
                                  <img src="/Discourse/assets/images/catalina.webp" class="h-30px w-30px rounded-circle" alt="User avatar" />
                                  <input type="text" class="form-control form-control-sm rounded-pill px-4 fs-7 bg-white border border-gray-300" placeholder="Write a quick comment..." required style="height: 35px;" />
                                  <button type="submit" class="btn btn-sm btn-success rounded-pill px-4 fw-bold" style="background:#0b301f; color:#fff; border: none; height: 35px;">Post</button>
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
                              <span class="fs-5 fw-bolder text-gray-800">1,245</span>
                              <span class="fs-9 text-muted">Across 12 Topics</span>
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
        const input = form.find('input');
        const commentText = input.val().trim();
        if (!commentText) return;

        const card = form.closest('[data-dc="post-card"]');
        const commentsList = card.find('.dc-quick-comments-list');
        const commentCountSpan = card.find('.comment-count-btn-text');

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

        // Increment comment count
        let currentCount = parseInt(commentCountSpan.text()) || 0;
        currentCount++;
        commentCountSpan.text(currentCount + (currentCount === 1 ? ' Comment' : ' Comments'));

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