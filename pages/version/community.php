<?php
$META_TITLE = "FEU LIFE - Discourse Community (Alvaran)";
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

  <link href="/Discourse/assets/css/discourse-css/community.css" rel="stylesheet" type="text/css" />
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
              <div class="community-banner w-100 mb-8 py-8">
                <div class="container-xxl">
                    <div class="d-flex align-items-center">
                      <!-- Community Logo -->
                      <div class="me-6 flex-shrink-0">
                        <div class="w-100px h-100px w-lg-120px h-lg-120px d-flex align-items-center justify-content-center community-logo-container shadow-sm">
                          <img src="/Discourse/assets/img/logo/feu-tech.webp" class="h-80px" alt="FEU LIFE" onerror="this.style.display='none'">
                        </div>
                      </div>
                      <!-- Community Info -->
                      <div class="flex-grow-1">
                        <h1 class="text-white fw-bolder fs-2tx mb-2">FEU LIFE</h1>
                        <p class="text-white text-opacity-75 fs-6 mb-4 mw-600px">Connect with fellow Tamaraws, share academic resources, discuss campus events, and build lasting friendships.</p>
                        <div class="d-flex gap-3">
                          <div class="border border-white border-opacity-25 rounded px-3 py-1 d-flex align-items-center gap-2">
                            <i class="ki-duotone ki-people text-white fs-8"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                            <span class="text-white fw-bold fs-7">4894</span>
                            <span class="text-white text-opacity-75 fs-9">Members</span>
                          </div>
                          <div class="border border-white border-opacity-25 rounded px-3 py-1 d-flex align-items-center gap-2">
                            <i class="ki-duotone ki-pencil text-white fs-8"><span class="path1"></span><span class="path2"></span></i>
                            <span class="text-white fw-bold fs-7">4894</span>
                            <span class="text-white text-opacity-75 fs-9">Posts</span>
                          </div>
                        </div>
                      </div>
                      <!-- Join Button -->
                      <div class="flex-shrink-0 ms-auto d-none d-lg-block">
                        <button class="btn btn-warning fw-bolder text-white px-8 py-3 d-flex align-items-center gap-2 rounded-1">
                          <i class="ki-duotone ki-plus text-white"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i> JOIN COMMUNITY
                        </button>
                      </div>
                    </div>
                </div>
              </div>

              <div class="app-container container-xxl">

                <!-- Search and Filters -->
                <div class="row g-6 mb-6">
                    <div class="col-lg-8">
                        
                        <!-- Search Bar Row -->
                        <div class="d-flex align-items-center mb-6 gap-4">
                            <div class="position-relative flex-grow-1">
                                <i class="ki-duotone ki-magnifier position-absolute top-50 translate-middle-y ms-4 text-muted"><span class="path1"></span><span class="path2"></span></i>
                                <input type="text" class="form-control form-control-solid ps-12 search-input-v2 py-3" placeholder="Search discussions, topics, people, communities...">
                            </div>
                            <button class="btn btn-new-post fw-bolder d-flex align-items-center gap-2 px-6 py-3 rounded-1" onclick="window.location.href='/Discourse/pages/version/create-post.php'">
                                <i class="ki-duotone ki-plus"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i> New Post
                            </button>
                        </div>
                        
                        <!-- Filters Row -->
                        <div class="d-flex align-items-center justify-content-between mb-6 border-bottom pb-1">
                            <ul class="nav nav-tabs nav-line-tabs border-0 fs-6 fw-bold">
                                <li class="nav-item">
                                    <a class="nav-link active px-4 py-2" data-bs-toggle="tab" href="#hot"><i class="ki-duotone ki-fire me-2 fs-7"><span class="path1"></span><span class="path2"></span></i> HOT</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link px-4 py-2" data-bs-toggle="tab" href="#new"><i class="ki-duotone ki-abstract-26 me-2 fs-7"><span class="path1"></span><span class="path2"></span></i> NEW</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link px-4 py-2" data-bs-toggle="tab" href="#top"><i class="ki-duotone ki-award me-2 fs-7"><span class="path1"></span><span class="path2"></span></i> TOP</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link px-4 py-2" data-bs-toggle="tab" href="#rising"><i class="ki-duotone ki-graph-up me-2 fs-7"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span></i> RISING</a>
                                </li>
                            </ul>
                            <button class="btn btn-sm btn-light bg-white border border-gray-300 btn-color-gray-700 fw-bold d-flex align-items-center gap-2 rounded-1 mb-2">
                                All Topics <i class="ki-duotone ki-down fs-8"><span class="path1"></span><span class="path2"></span></i>
                            </button>
                        </div>
                        
                        <!-- Feed -->
                        <?php for($i=0; $i<3; $i++) { ?>
                        <div class="card border border-gray-300 shadow-none mb-4 post-card overflow-hidden rounded-2">
                            <div class="d-flex">
                                <!-- Vote Section -->
                                <div class="vote-section d-flex flex-column align-items-center py-4 border-end border-gray-200">
                                    <button class="vote-btn-v2 mb-2"><i class="ki-duotone ki-up fs-8"><span class="path1"></span><span class="path2"></span></i></button>
                                    <span class="fw-bolder text-dark fs-6 mb-2">90</span>
                                    <button class="vote-btn-v2"><i class="ki-duotone ki-down fs-8"><span class="path1"></span><span class="path2"></span></i></button>
                                </div>
                                
                                <!-- Content Section -->
                                <div class="p-4 flex-grow-1 bg-white">
                                    <!-- Tag & Time -->
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div class="d-flex align-items-center">
                                            <span class="badge rounded-pill bg-secondary text-dark border border-gray-300 fw-bold px-3 py-1 d-flex align-items-center gap-1 tag-badge">
                                                <i class="ki-duotone ki-book-open text-muted fs-9"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i> FEUTech
                                            </span>
                                        </div>
                                        <span class="text-muted fs-8 fw-medium">2w ago</span>
                                    </div>
                                    
                                    <!-- User -->
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="symbol symbol-25px me-2">
                                            <img src="https://ui-avatars.com/api/?name=Sofia+Karim&background=f3f4f6&color=d97706&rounded=true" alt="Sofia Karim" class="border">
                                        </div>
                                        <a href="/Discourse/pages/version/profile-other.php" class="fw-bolder text-dark text-hover-primary fs-7">Sofia Karim</a>
                                    </div>
                                    
                                    <!-- Title & Body -->
                                    <h3 class="fw-bold fs-5 mb-2"><a href="/Discourse/pages/version/view-post.php" class="text-dark text-hover-primary">Lorem ipsum dolor sit amet consectetur adipiscing elit.</a></h3>
                                    <p class="text-gray-600 fs-7 mb-4 line-clamp-2">
                                        Lorem ipsum dolor sit amet consectetur adipiscing elit. Quisque faucibus ex sapien vitae pellentesque sem placerat. In id cursus mi pretium tellus duis convallis. Tempus leo eu aenean sed diam urna tempor. Pulvinar vivamus fringilla lacus nec metus bibendum egestas...
                                    </p>
                                    
                                    <!-- Actions -->
                                    <div class="d-flex align-items-center gap-2">
                                        <button class="btn action-btn px-3 py-2 d-flex align-items-center gap-2">
                                            <i class="ki-duotone ki-message-text-2 fs-8"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i> 0 Comments
                                        </button>
                                        <button class="btn action-btn px-3 py-2 d-flex align-items-center gap-2">
                                            <i class="ki-duotone ki-share fs-8"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span></i> Share
                                        </button>
                                        <button class="btn action-btn px-3 py-2 d-flex align-items-center gap-2">
                                            <i class="ki-duotone ki-bookmark fs-8"><span class="path1"></span><span class="path2"></span></i> Save
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>

                    </div>

                    <!-- Sidebar -->
                    <div class="col-lg-4">
                        
                        <!-- Community Rules -->
                        <div class="card border border-gray-300 shadow-none mb-6 rounded-2">
                            <div class="card-body p-5">
                                <h5 class="fw-bolder text-dark mb-4 fs-6">Community Rules</h5>
                                <div class="d-flex flex-column gap-3">
                                    <?php for($i=1; $i<=4; $i++) { ?>
                                    <div class="d-flex align-items-start gap-3">
                                        <div class="rule-number flex-shrink-0"><?php echo $i; ?></div>
                                        <p class="text-gray-700 community-rule-text mb-0">Be respectful to all members. Harassment, hate speech, and bullying will not be tolerated.</p>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Top Contributors -->
                        <div class="card border border-gray-300 shadow-none mb-6 rounded-2">
                            <div class="card-body p-5">
                                <h5 class="fw-bolder text-dark mb-4 fs-6">Top Contributors</h5>
                                <div class="d-flex flex-column gap-4">
                                    
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="symbol symbol-35px">
                                                <img src="https://ui-avatars.com/api/?name=Sofia+Karim&background=f3f4f6&color=d97706&rounded=true" alt="">
                                            </div>
                                            <div class="d-flex flex-column">
                                                <a href="/Discourse/pages/version/profile-other.php" class="fw-bolder text-dark text-hover-primary fs-7">Sofia Karim</a>
                                                <span class="text-muted fs-9 fw-medium">BSCSE</span>
                                            </div>
                                        </div>
                                        <span class="badge bg-light-warning text-warning fw-bold px-3 py-1 fs-9 rounded-1">13 Posts</span>
                                    </div>
                                    
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="symbol symbol-35px">
                                                <img src="https://ui-avatars.com/api/?name=Maria+Clara&background=e0f2fe&color=0369a1&rounded=true" alt="">
                                            </div>
                                            <div class="d-flex flex-column">
                                                <span class="fw-bolder text-dark fs-7">Maria Clara</span>
                                                <span class="text-muted fs-9 fw-medium">Moderator</span>
                                            </div>
                                        </div>
                                        <span class="badge bg-light-primary text-primary fw-bold px-3 py-1 fs-9 rounded-1">5 Posts</span>
                                    </div>
                                    
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="symbol symbol-35px">
                                                <img src="https://ui-avatars.com/api/?name=John+Doe&background=fce7f3&color=be185d&rounded=true" alt="">
                                            </div>
                                            <div class="d-flex flex-column">
                                                <span class="fw-bolder text-dark fs-7">John Doe</span>
                                                <span class="text-muted fs-9 fw-medium">Associate</span>
                                            </div>
                                        </div>
                                        <span class="badge bg-light-danger text-danger fw-bold px-3 py-1 fs-9 rounded-1">2 Posts</span>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        
                        <!-- Discover Other Communities -->
                        <div class="card border border-gray-300 shadow-none mb-6 rounded-2">
                            <div class="card-body p-5">
                                <h5 class="fw-bolder text-dark mb-4 fs-6">Discover other communities</h5>
                                <div class="d-flex flex-column">
                                    
                                    <a href="#" class="d-flex align-items-center justify-content-between text-decoration-none py-2 border-bottom border-gray-200">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="w-30px h-30px d-flex align-items-center justify-content-center community-logo-container rounded-1 flex-shrink-0">
                                                <img src="/Discourse/assets/img/logo/feu-tech.webp" class="h-20px" alt="" onerror="this.style.display='none'">
                                            </div>
                                            <div class="d-flex flex-column">
                                                <span class="fw-bolder text-dark fs-7">FEU TECH</span>
                                                <span class="text-muted fs-9"><i class="ki-duotone ki-user fs-9"><span class="path1"></span><span class="path2"></span></i> 4874</span>
                                            </div>
                                        </div>
                                        <i class="ki-duotone ki-arrow-right text-muted fs-8"><span class="path1"></span><span class="path2"></span></i>
                                    </a>
                                    
                                    <a href="#" class="d-flex align-items-center justify-content-between text-decoration-none py-2 border-bottom border-gray-200">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="w-30px h-30px d-flex align-items-center justify-content-center community-logo-container rounded-1 flex-shrink-0">
                                                <img src="/Discourse/assets/img/logo/feu-tech.webp" class="h-20px" alt="" onerror="this.style.display='none'">
                                            </div>
                                            <div class="d-flex flex-column">
                                                <span class="fw-bolder text-dark fs-7">FEU ALABANG</span>
                                                <span class="text-muted fs-9"><i class="ki-duotone ki-user fs-9"><span class="path1"></span><span class="path2"></span></i> 6623</span>
                                            </div>
                                        </div>
                                        <i class="ki-duotone ki-arrow-right text-muted fs-8"><span class="path1"></span><span class="path2"></span></i>
                                    </a>
                                    
                                    <a href="#" class="d-flex align-items-center justify-content-between text-decoration-none py-2">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="w-30px h-30px d-flex align-items-center justify-content-center community-logo-container rounded-1 flex-shrink-0">
                                                <img src="/Discourse/assets/img/logo/feu-tech.webp" class="h-20px" alt="" onerror="this.style.display='none'">
                                            </div>
                                            <div class="d-flex flex-column">
                                                <span class="fw-bolder text-dark fs-7">FEU DILIMAN</span>
                                                <span class="text-muted fs-9"><i class="ki-duotone ki-user fs-9"><span class="path1"></span><span class="path2"></span></i> 16573</span>
                                            </div>
                                        </div>
                                        <i class="ki-duotone ki-arrow-right text-muted fs-8"><span class="path1"></span><span class="path2"></span></i>
                                    </a>
                                    
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

  <script>
    $(document).ready(function() {
        // 1. Voting Logic
        $(document).on('click', '.vote-btn-v2', function(e) {
            e.preventDefault();
            const btn = $(this);
            const isUpvote = btn.find('.ki-up').length > 0;
            const container = btn.closest('.vote-section');
            const scoreSpan = container.find('span.fw-bolder');
            const otherBtn = isUpvote ? container.find('.vote-btn-v2:has(.ki-down)') : container.find('.vote-btn-v2:has(.ki-up)');
            
            let currentScore = parseInt(scoreSpan.text()) || 0;

            // If already active, toggle off
            if (btn.hasClass('active-vote')) {
                btn.removeClass('active-vote');
                btn.css({'background-color': '', 'color': '', 'border-color': ''});
                scoreSpan.text(currentScore - (isUpvote ? 1 : -1));
            } 
            // Toggle on
            else {
                // If the other was active, remove it and adjust score by 2
                if (otherBtn.hasClass('active-vote')) {
                    otherBtn.removeClass('active-vote');
                    otherBtn.css({'background-color': '', 'color': '', 'border-color': ''});
                    currentScore += (isUpvote ? 1 : -1); // Remove previous vote effect
                }
                
                btn.addClass('active-vote');
                if (isUpvote) {
                    btn.css({'background-color': '#dcfce7', 'color': '#166534', 'border-color': '#166534'});
                    scoreSpan.text(currentScore + 1);
                } else {
                    btn.css({'background-color': '#fee2e2', 'color': '#991b1b', 'border-color': '#991b1b'});
                    scoreSpan.text(currentScore - 1);
                }
            }
        });

        // 2. Real-time Search Filtering
        $('.search-input-v2').on('keyup', function() {
            const searchTerm = $(this).val().toLowerCase();
            $('.post-card').each(function() {
                const title = $(this).find('h3 a').text().toLowerCase();
                const content = $(this).find('p.text-gray-600').text().toLowerCase();
                
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
    });
  </script>
</body>

</html>
