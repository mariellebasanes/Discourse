<?php
$META_TITLE = "Marielle Basanes - Discourse Profile";
$active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'overview';
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
                              <img src="/Discourse/assets/img/logo/feu-tech.webp" alt="Profile" style="object-fit: cover;">
                            </div>
                          </div>
                          <!-- Info -->
                          <div class="flex-grow-1 d-flex justify-content-between align-items-sm-center flex-column flex-sm-row pb-2 gap-4">
                            <div>
                              <h2 class="fw-bolder text-dark fs-1 mb-1 d-flex align-items-center">
                                MARIELLE BASANES 
                                <i class="ki-duotone ki-verify text-success fs-4 ms-2" title="Verified Student"><span class="path1"></span><span class="path2"></span></i>
                              </h2>
                              <div class="d-flex align-items-center flex-wrap gap-2 text-muted fw-semibold fs-6">
                                <span><i class="ki-duotone ki-book-open text-gray-500 me-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i> BS Computer Science</span>
                                <span>·</span>
                                <span><i class="ki-duotone ki-geolocation text-gray-500 me-1"><span class="path1"></span><span class="path2"></span></i> FEU Tech</span>
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
                      <a class="profile-tab fw-bolder fs-6 text-muted py-3 text-nowrap" data-tab="downvoted">Downvoted</a>
                    </div>

                    <!-- Tab Content -->

                    <!-- Overview Tab -->
                    <div class="tab-pane active" id="tab-overview">
                      <?php
                      $activities = [
                        [
                          "community" => "FEU-LIFE",
                          "post_title" => "Is there a possibility that our tuition will get high?",
                          "action" => "Replied to",
                          "action_target" => "User1234",
                          "time" => "2 hrs ago",
                          "body" => "Based on the recent student council meeting, they mentioned that any tuition increase would be capped at 5% for the next academic year. However, nothing is official until the board approves it next month.",
                          "upvotes" => 14, "downvotes" => 1, "comments" => 3
                        ],
                        [
                          "community" => "FEU TECH DEV",
                          "post_title" => "Best way to learn Python for Data Science?",
                          "action" => "Commented",
                          "action_target" => "",
                          "time" => "1 day ago",
                          "body" => "I highly recommend starting with the Pandas documentation and completing the Kaggle micro-courses. They are free and provide hands-on experience which is much better than just watching tutorials.",
                          "upvotes" => 32, "downvotes" => 0, "comments" => 5
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
                                <span class="fw-bolder text-dark fs-6 me-1">Marielle</span>
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
                          "community" => "FEU ALABANG",
                          "title" => "Looking for a study group for Calculus 2",
                          "body" => "Hey everyone! I'm struggling a bit with integration techniques. Is there an existing study group I can join, or would anyone be interested in forming one for this semester?",
                          "tag" => "Discussion", "tag_color" => "primary",
                          "time" => "3 days ago",
                          "image" => "",
                          "upvotes" => 12, "downvotes" => 0, "comments" => 8
                        ],
                        [
                          "community" => "FEU-LIFE",
                          "title" => "Tamaraw Pride! What a game last night!",
                          "body" => "",
                          "tag" => "Sports", "tag_color" => "success",
                          "time" => "1 week ago",
                          "image" => "https://images.unsplash.com/photo-1541534741688-6078c6bfb5c5?w=800&q=80",
                          "upvotes" => 156, "downvotes" => 3, "comments" => 42
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
                        ["community" => "Enrollment", "post" => "When does late enrollment end?", "time" => "4 days ago",
                         "body" => "According to the registrar's memo sent to our emails, late enrollment will officially close this Friday at 5:00 PM. Make sure to settle your accounts before then!"],
                        ["community" => "Food Trip Around TECH", "post" => "Best budget meals near campus?", "time" => "1 week ago",
                         "body" => "You should definitely check out the karinderya behind the main building. You can get a full meal with two viands for under 80 pesos, and it actually tastes like home-cooked food."]
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
                                <span class="fw-bolder text-dark fs-6 me-1">Marielle</span>
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
                        ["community" => "FEU TECH", "user" => "Sofia Karim", "title" => "Tips for surviving thesis defense", "time" => "1 day ago",
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
                                <span class="fw-bolder text-dark fs-6 me-1">Marielle</span>
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

                    <!-- Downvoted Tab -->
                    <div class="tab-pane" id="tab-downvoted">
                      <?php
                      $downvoted = [
                        ["community" => "FEU-LIFE", "user" => "Anon123", "title" => "Unpopular opinion: online classes are better", "time" => "3 days ago",
                         "body" => "I actually prefer online classes over face-to-face. The commute is terrible and I learn better at my own pace.", "downvotes" => 28, "comments" => 45],
                      ];
                      foreach ($downvoted as $d) {
                      ?>
                      <div class="card border border-gray-300 shadow-none mb-5 highlight-card rounded-2">
                        <div class="card-body p-6">
                          <div class="d-flex align-items-center mb-4">
                            <div class="symbol symbol-40px me-3">
                              <div class="symbol-label fs-7 fw-bold bg-light-danger">
                                <i class="bi bi-hand-thumbs-down-fill fs-4 text-danger"></i>
                              </div>
                            </div>
                            <div class="flex-grow-1">
                              <div class="d-flex align-items-center">
                                <span class="fw-bolder text-dark fs-6 me-1">Marielle</span>
                                <span class="text-muted fs-7">Downvoted a post</span>
                              </div>
                              <span class="text-muted fs-8"><?php echo $d['time']; ?></span>
                            </div>
                          </div>

                          <div class="bg-light rounded p-4 mb-4 border border-gray-200">
                            <div class="d-flex align-items-center gap-2 mb-1">
                              <div class="symbol symbol-20px avatar-circle shadow-sm" style="background-color: #8C9933;">
                                <img src="/Discourse/assets/img/logo/feu-tech.webp" alt="" class="w-100 p-1">
                              </div>
                              <span class="fw-bolder text-dark fs-8">D/<?php echo $d['community']; ?></span>
                              <span class="text-muted fs-9">· Posted by <?php echo $d['user']; ?></span>
                            </div>
                            <h5 class="fw-bolder fs-5 mb-2 mt-2">
                              <a href="/Discourse/pages/version/view-post.php" class="text-dark text-hover-primary"><?php echo $d['title']; ?></a>
                            </h5>
                            <p class="text-gray-700 fs-6 lh-base mb-0"><?php echo $d['body']; ?></p>
                          </div>

                          <div class="d-flex align-items-center gap-1">
                            <button class="btn btn-sm btn-danger vote-btn active d-flex align-items-center gap-1 px-3 py-2 rounded-pill">
                              <i class="bi bi-hand-thumbs-down-fill fs-8 text-white"></i> <span class="fw-bold fs-8 text-white"><?php echo $d['downvotes']; ?></span>
                            </button>
                            <a href="/Discourse/pages/version/view-post.php" class="btn btn-sm btn-light-muted vote-btn d-flex align-items-center gap-1 px-3 py-2 rounded-pill text-decoration-none">
                              <i class="bi bi-chat fs-8"></i> <span class="fw-bold fs-8"><?php echo $d['comments']; ?></span>
                            </a>
                            <button class="btn btn-sm btn-light-muted vote-btn d-flex align-items-center gap-1 px-3 py-2 rounded-pill">
                              <i class="bi bi-share fs-8"></i> <span class="fw-bold fs-8">Share</span>
                            </button>
                          </div>
                        </div>
                      </div>
                      <?php } ?>
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
                              <form class="form" action="#" method="POST" onsubmit="event.preventDefault(); $('#edit_profile_modal').modal('hide');">
                                  <!-- Cover Photo and Avatar Update -->
                                  <div class="mb-8 text-center position-relative">
                                    <div class="h-100px w-100 rounded-3 mb-4" style="background: linear-gradient(135deg, #1e7145 0%, #155d38 100%);"></div>
                                    <div class="position-absolute" style="top: 30px; left: 50%; transform: translateX(-50%);">
                                      <div class="image-input image-input-outline image-input-empty" data-kt-image-input="true">
                                          <div class="image-input-wrapper w-100px h-100px rounded-circle shadow-sm border border-4 border-white" style="background-image: url(/Discourse/assets/img/logo/feu-tech.webp); background-position: center; background-size: cover;"></div>
                                          <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar" style="position: absolute; bottom: 0; right: 0;">
                                              <i class="ki-duotone ki-pencil fs-7"><span class="path1"></span><span class="path2"></span></i>
                                              <input type="file" name="avatar" accept=".png, .jpg, .jpeg" />
                                          </label>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="mt-12 fv-row mb-6 pt-5">
                                      <label class="fs-6 fw-bold mb-2 text-dark">Name</label>
                                      <input type="text" class="form-control form-control-solid border bg-light" value="MARIELLE BASANES" />
                                  </div>
                                  <div class="fv-row mb-6">
                                      <label class="fs-6 fw-bold mb-2 text-dark">Program & Campus</label>
                                      <div class="row g-3">
                                        <div class="col-md-6">
                                          <input type="text" class="form-control form-control-solid border bg-light" value="BS Computer Science" />
                                        </div>
                                        <div class="col-md-6">
                                          <input type="text" class="form-control form-control-solid border bg-light" value="FEU Tech" />
                                        </div>
                                      </div>
                                  </div>
                                  <div class="fv-row mb-8">
                                      <label class="fs-6 fw-bold mb-2 text-dark">About Me</label>
                                      <textarea class="form-control form-control-solid border bg-light" rows="4">Enthusiastic computer science student passionate about web development, AI, and building communities. Always eager to help out fellow Tamaraws! 💚💛</textarea>
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
