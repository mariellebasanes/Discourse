<?php
$META_TITLE = "Sofia Karim - Discourse Profile";
$active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'overview';
$user_name = "SOFIA KARIM";
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
                              <img src="https://ui-avatars.com/api/?name=Sofia+Karim&background=f3f4f6&color=d97706&rounded=true" alt="Profile" style="object-fit: cover;">
                            </div>
                          </div>
                          <!-- Info -->
                          <div class="flex-grow-1 d-flex justify-content-between align-items-sm-center flex-column flex-sm-row pb-2 gap-4">
                            <div>
                              <h2 class="fw-bolder text-dark fs-1 mb-1 d-flex align-items-center">
                                <?php echo $user_name; ?> 
                                <i class="ki-duotone ki-verify text-success fs-4 ms-2" title="Verified Student"><span class="path1"></span><span class="path2"></span></i>
                              </h2>
                              <div class="d-flex align-items-center flex-wrap gap-2 text-muted fw-semibold fs-6">
                                <span><i class="ki-duotone ki-book-open text-gray-500 me-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i> BS Computer Science</span>
                                <span>·</span>
                                <span><i class="ki-duotone ki-geolocation text-gray-500 me-1"><span class="path1"></span><span class="path2"></span></i> FEU Tech</span>
                              </div>
                            </div>
                            <!-- Actions (Follow) -->
                            <div class="flex-shrink-0">
                              <button class="btn fw-bold text-white follow-btn px-6 d-flex align-items-center gap-2 shadow-sm" style="background-color: #1e7145;">
                                <i class="ki-duotone ki-user-tick text-white"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i> Follow
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
                              <div class="fs-2 fw-bolder text-dark mb-1">4.8k</div>
                              <div class="fw-bold text-gray-500 fs-8 text-uppercase tracking-wider">Followers</div>
                            </div>
                            <div class="border border-dashed border-gray-300 rounded px-5 py-3 text-center flex-grow-1 flex-md-grow-0">
                              <div class="fs-2 fw-bolder text-dark mb-1">24.8k</div>
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
                      <?php
                      $activities = [
                        [
                          "community" => "FEU-LIFE",
                          "post_title" => "Any tips for surviving the midterms week?",
                          "action" => "Replied to",
                          "action_target" => "Freshman22",
                          "time" => "4 hrs ago",
                          "body" => "Make sure to prioritize your sleep! Pulling an all-nighter usually does more harm than good. Create a schedule and stick to it, and don't forget to take short breaks.",
                          "upvotes" => 25, "downvotes" => 1, "comments" => 10
                        ],
                        [
                          "community" => "Enrollment",
                          "post_title" => "System is down again during sectioning",
                          "action" => "Commented",
                          "action_target" => "",
                          "time" => "1 day ago",
                          "body" => "I've been trying to load the page for the last three hours. I hope they extend the deadline for adding subjects because this is completely out of our control.",
                          "upvotes" => 89, "downvotes" => 0, "comments" => 14
                        ]
                      ];
                      foreach ($activities as $act) {
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
                                <span class="fw-bolder text-dark fs-6 me-1">Sofia Karim</span>
                                <span class="text-muted fs-7"><?php echo $act['action']; ?></span>
                                <?php if (!empty($act['action_target'])) { ?>
                                <span class="fw-bolder text-primary fs-7 ms-1"><?php echo $act['action_target']; ?></span>
                                <?php } ?>
                              </div>
                              <span class="text-muted fs-8"><?php echo $act['time']; ?></span>
                            </div>
                          </div>

                          <!-- Original Post Reference -->
                          <div class="bg-light rounded p-4 mb-4 border border-gray-200">
                            <div class="d-flex align-items-center gap-2 mb-1">
                              <div class="symbol symbol-20px avatar-circle shadow-sm" style="background-color: #8C9933;">
                                <img src="/Discourse/assets/img/logo/feu-tech.webp" alt="" class="w-100 p-1">
                              </div>
                              <span class="fw-bolder text-dark fs-8">D/<?php echo $act['community']; ?></span>
                            </div>
                            <a href="/Discourse/pages/version/view-post.php" class="fw-bold text-dark text-hover-primary fs-6 d-block mb-1 text-truncate"><?php echo $act['post_title']; ?></a>
                          </div>
                          
                          <!-- Body -->
                          <p class="text-gray-700 fs-6 lh-lg mb-4"><?php echo $act['body']; ?></p>
                          
                          <!-- Actions -->
                          <div class="d-flex align-items-center gap-1">
                            <button class="btn btn-sm btn-light-muted vote-btn d-flex align-items-center gap-1 px-3 py-2 rounded-pill">
                              <i class="bi bi-hand-thumbs-up fs-8"></i> <span class="fw-bold fs-8"><?php echo $act['upvotes']; ?></span>
                            </button>
                            <button class="btn btn-sm btn-light-muted vote-btn d-flex align-items-center gap-1 px-3 py-2 rounded-pill">
                              <i class="bi bi-hand-thumbs-down fs-8"></i> <span class="fw-bold fs-8"><?php echo $act['downvotes']; ?></span>
                            </button>
                            <a href="/Discourse/pages/version/view-post.php" class="btn btn-sm btn-light-muted vote-btn d-flex align-items-center gap-1 px-3 py-2 rounded-pill text-decoration-none">
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
                    <div class="tab-pane" id="tab-posts">
                      <?php
                      $posts = [
                        [
                          "community" => "FEU TECH",
                          "title" => "Hackathon winners announced!",
                          "body" => "Congratulations to all the teams who participated in the weekend hackathon. The innovative solutions presented were truly inspiring for our tech community.",
                          "tag" => "News", "tag_color" => "info",
                          "time" => "2 days ago",
                          "image" => "",
                          "upvotes" => 210, "downvotes" => 4, "comments" => 35
                        ],
                        [
                          "community" => "Food Trip Around TECH",
                          "title" => "Found a hidden gem near P. Campa",
                          "body" => "If you guys haven't tried the new wings place, you're missing out. It's affordable and perfect for students on a budget.",
                          "tag" => "Review", "tag_color" => "success",
                          "time" => "1 week ago",
                          "image" => "https://images.unsplash.com/photo-1524117074681-31bd4de22ad3?w=800&q=80",
                          "upvotes" => 124, "downvotes" => 2, "comments" => 18
                        ]
                      ];
                      foreach ($posts as $post) {
                      ?>
                      <div class="card border border-gray-300 shadow-none mb-5 rounded-2">
                        <div class="card-body p-5">
                          <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="symbol symbol-20px avatar-circle shadow-sm" style="background-color: #8C9933;">
                              <img src="/Discourse/assets/img/logo/feu-tech.webp" alt="" class="w-100 p-1">
                            </div>
                            <span class="fw-bold text-dark fs-8"><?php echo $post['community']; ?></span>
                            <span class="text-muted fs-9">· <?php echo $post['time']; ?></span>
                          </div>
                          <div class="mb-2">
                            <span class="badge badge-<?php echo $post['tag_color']; ?> fw-bold tag-badge px-3 py-1"><?php echo $post['tag']; ?></span>
                          </div>
                          <h4 class="fw-bolder fs-4 mb-2">
                            <a href="/Discourse/pages/version/view-post.php<?php echo !empty($post['image']) ? '?img=1' : ''; ?>" class="text-dark text-hover-primary"><?php echo $post['title']; ?></a>
                          </h4>
                          <?php if (!empty($post['body'])) { ?>
                          <p class="text-gray-700 fs-7 mb-3"><?php echo $post['body']; ?></p>
                          <?php } ?>
                          <?php if (!empty($post['image'])) { ?>
                          <div class="mb-3 rounded-3 overflow-hidden">
                            <img src="<?php echo $post['image']; ?>" class="w-100 rounded-3" alt="Post image" style="max-height: 300px; object-fit: cover;">
                          </div>
                          <?php } ?>
                          <div class="d-flex align-items-center gap-1 pt-2 border-top border-gray-200">
                            <button class="btn btn-sm btn-light-muted vote-btn d-flex align-items-center gap-1 px-2 py-1 rounded-pill">
                              <i class="bi bi-hand-thumbs-up fs-9"></i> <span class="fw-bold fs-9"><?php echo $post['upvotes']; ?></span>
                            </button>
                            <button class="btn btn-sm btn-light-muted vote-btn d-flex align-items-center gap-1 px-2 py-1 rounded-pill">
                              <i class="bi bi-hand-thumbs-down fs-9"></i> <span class="fw-bold fs-9"><?php echo $post['downvotes']; ?></span>
                            </button>
                            <a href="/Discourse/pages/version/view-post.php" class="btn btn-sm btn-light-muted vote-btn d-flex align-items-center gap-1 px-2 py-1 rounded-pill text-decoration-none">
                              <i class="bi bi-chat fs-9"></i> <span class="fw-bold fs-9"><?php echo $post['comments']; ?></span>
                            </a>
                            <button class="btn btn-sm btn-light-muted vote-btn d-flex align-items-center gap-1 px-2 py-1 rounded-pill">
                              <i class="bi bi-share fs-9"></i> <span class="fw-bold fs-9">Share</span>
                            </button>
                          </div>
                        </div>
                      </div>
                      <?php } ?>
                    </div>

                    <!-- Comments Tab -->
                    <div class="tab-pane" id="tab-comments">
                      <?php
                      $comments = [
                        ["community" => "FEU-LIFE", "post" => "Where can I get the university ID replacement?", "time" => "2 hrs ago",
                         "body" => "You need to go to the Student Affairs office on the 3rd floor. Bring an affidavit of loss and 150 pesos for the processing fee. Usually takes about a week to release."],
                        ["community" => "Thesis Advice", "post" => "How to write a good related literature review?", "time" => "3 days ago",
                         "body" => "Don't just summarize papers one by one. Group them by themes and discuss how they relate to your specific research gap. It should tell a story about the current state of research."]
                      ];
                      foreach ($comments as $c) {
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
                                <span class="fw-bolder text-dark fs-6 me-1">Sofia Karim</span>
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
                              <span class="fw-bolder text-dark fs-8">D/<?php echo $c['community']; ?></span>
                            </div>
                            <a href="/Discourse/pages/version/view-post.php" class="fw-bold text-dark text-hover-primary fs-6 d-block mb-1 text-truncate"><?php echo $c['post']; ?></a>
                          </div>
                          
                          <!-- Body -->
                          <p class="text-gray-700 fs-6 lh-lg mb-4"><?php echo $c['body']; ?></p>
                          
                          <!-- Actions -->
                          <div class="d-flex align-items-center gap-1 mt-2">
                            <button class="btn btn-sm btn-light-muted vote-btn d-flex align-items-center gap-1 px-3 py-2 rounded-pill">
                              <i class="bi bi-hand-thumbs-up fs-8"></i> <span class="fw-bold fs-8">3</span>
                            </button>
                            <button class="btn btn-sm btn-light-muted vote-btn d-flex align-items-center gap-1 px-3 py-2 rounded-pill">
                              <i class="bi bi-hand-thumbs-down fs-8"></i> <span class="fw-bold fs-8">1</span>
                            </button>
                            <a href="/Discourse/pages/version/view-post.php" class="btn btn-sm btn-light-muted vote-btn d-flex align-items-center gap-1 px-3 py-2 rounded-pill text-decoration-none">
                              <i class="bi bi-chat fs-8"></i> <span class="fw-bold fs-8">12</span>
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
                    <div class="tab-pane" id="tab-upvoted">
                      <?php
                      $upvoted = [
                        ["community" => "FEU-LIFE", "user" => "John Doe", "title" => "Is the cafeteria open during weekends?", "time" => "2 hrs ago",
                         "body" => "I've been wondering if the cafeteria has extended hours during exam week. Does anyone know the schedule?", "upvotes" => 15, "comments" => 8],
                        ["community" => "FEU TECH", "user" => "Ravi Joshi", "title" => "Tips for surviving thesis defense", "time" => "1 day ago",
                         "body" => "Just defended my thesis last week. Here are some tips that really helped me prepare and stay calm during the presentation.", "upvotes" => 42, "comments" => 23]
                      ];
                      foreach ($upvoted as $u) {
                      ?>
                      <div class="card border border-gray-300 shadow-none mb-5 highlight-card rounded-2">
                        <div class="card-body p-6">
                          <div class="d-flex align-items-center mb-4">
                            <div class="symbol symbol-40px me-3">
                              <div class="symbol-label fs-7 fw-bold bg-light-success">
                                <i class="bi bi-hand-thumbs-up-fill fs-4 text-success"></i>
                              </div>
                            </div>
                            <div class="flex-grow-1">
                              <div class="d-flex align-items-center">
                                <span class="fw-bolder text-dark fs-6 me-1">Sofia Karim</span>
                                <span class="text-muted fs-7">Upvoted a post</span>
                              </div>
                              <span class="text-muted fs-8"><?php echo $u['time']; ?></span>
                            </div>
                          </div>

                          <div class="bg-light rounded p-4 mb-4 border border-gray-200">
                            <div class="d-flex align-items-center gap-2 mb-1">
                              <div class="symbol symbol-20px avatar-circle shadow-sm" style="background-color: #8C9933;">
                                <img src="/Discourse/assets/img/logo/feu-tech.webp" alt="" class="w-100 p-1">
                              </div>
                              <span class="fw-bolder text-dark fs-8">D/<?php echo $u['community']; ?></span>
                              <span class="text-muted fs-9">· Posted by <?php echo $u['user']; ?></span>
                            </div>
                            <h5 class="fw-bolder fs-5 mb-2 mt-2">
                              <a href="/Discourse/pages/version/view-post.php" class="text-dark text-hover-primary"><?php echo $u['title']; ?></a>
                            </h5>
                            <p class="text-gray-700 fs-6 lh-base mb-0"><?php echo $u['body']; ?></p>
                          </div>

                          <div class="d-flex align-items-center gap-1">
                            <button class="btn btn-sm btn-success vote-btn active d-flex align-items-center gap-1 px-3 py-2 rounded-pill">
                              <i class="bi bi-hand-thumbs-up-fill fs-8 text-white"></i> <span class="fw-bold fs-8 text-white"><?php echo $u['upvotes']; ?></span>
                            </button>
                            <a href="/Discourse/pages/version/view-post.php" class="btn btn-sm btn-light-muted vote-btn d-flex align-items-center gap-1 px-3 py-2 rounded-pill text-decoration-none">
                              <i class="bi bi-chat fs-8"></i> <span class="fw-bold fs-8"><?php echo $u['comments']; ?></span>
                            </a>
                            <button class="btn btn-sm btn-light-muted vote-btn d-flex align-items-center gap-1 px-3 py-2 rounded-pill">
                              <i class="bi bi-share fs-8"></i> <span class="fw-bold fs-8">Share</span>
                            </button>
                          </div>
                        </div>
                      </div>
                      <?php } ?>
                    </div>

                    <!-- Communities Tab -->
                    <div class="tab-pane" id="tab-communities">
                      <div class="row g-4">
                        <?php
                        $communities = [
                          ["name" => "FEU LIFE", "members" => "4.8k", "color" => "#2d6a4f"],
                          ["name" => "FEU TECH", "members" => "3.2k", "color" => "#8C9933"],
                          ["name" => "FEU ALABANG", "members" => "2.1k", "color" => "#b5651d"],
                          ["name" => "FEU DILIMAN", "members" => "1.9k", "color" => "#6a4c93"],
                        ];
                        foreach ($communities as $comm) {
                        ?>
                        <div class="col-md-6">
                          <div class="card border border-gray-300 shadow-none community-card rounded-2" onclick="window.location.href='/Discourse/pages/version/community.php'">
                            <div class="card-body p-5 d-flex align-items-center gap-4">
                              <div class="w-50px h-50px rounded-3 d-flex align-items-center justify-content-center avatar-circle flex-shrink-0" style="background-color: #8C9933;">
                                <img src="/Discourse/assets/img/logo/feu-tech.webp" alt="">
                              </div>
                              <div class="flex-grow-1">
                                <h5 class="fw-bolder text-dark fs-5 mb-1"><?php echo $comm['name']; ?></h5>
                                <div class="d-flex align-items-center gap-1 text-muted fs-8">
                                  <i class="ki-duotone ki-people fs-9"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                                  <span><?php echo $comm['members']; ?> members</span>
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
    });
  </script>
</body>

</html>
