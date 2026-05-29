<?php

$META_TITLE = "Discourse - FEU Communities";
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
  <link href="/Discourse/assets/css/discourse-css/index.css" rel="stylesheet" type="text/css" />
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
                
                <!-- Banner -->
                <div class="card mb-10 border-0 page-main-banner" style="background-color: #1A8B44; overflow: hidden; position: relative; transition: background-color 0.3s ease;">
                    <!-- decorative circles -->
                    <div class="position-absolute" style="top: -20px; left: -20px; width: 100px; height: 100px; background-color: rgba(255,255,255,0.1); border-radius: 50%;"></div>
                    <div class="position-absolute" style="bottom: 20px; left: 100px; width: 50px; height: 50px; background-color: rgba(255,255,255,0.1); border-radius: 50%;"></div>
                    <div class="position-absolute" style="top: 50px; right: 50px; width: 80px; height: 80px; background-color: rgba(255,255,255,0.1); border-radius: 50%;"></div>
                    <div class="position-absolute" style="bottom: -10px; right: 150px; width: 120px; height: 120px; background-color: rgba(255,255,255,0.1); border-radius: 50%;"></div>
                    
                    <div class="card-body p-15 text-center position-relative z-index-1">
                        <h1 class="text-white fw-bolder fs-2tx mb-3">Discover Your <span class="text-warning">FEU Communities</span></h1>
                        <p class="text-white fs-5 mb-8">Connect with fellow Tamaraws, share academic resources, discuss campus events, and build lasting friendships.</p>
                        
                        <div class="d-flex justify-content-center">
                            <div class="position-relative w-100 mw-600px text-start">
                                <span class="svg-icon svg-icon-2 svg-icon-gray-500 position-absolute top-50 translate-middle-y ms-5 start-0 z-index-1">
                                    <i class="fas fa-search fs-5 text-muted"></i>
                                </span>
                                <input type="text" id="communitySearch" class="form-control form-control-solid ps-13 rounded-pill bg-white border-0" placeholder="Search a community..." style="height: 50px;">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filters & Action -->
                <div class="d-flex flex-stack flex-wrap gap-4 mb-10">
                    <div class="d-flex align-items-center gap-2 overflow-auto" id="communityFilters">
                        <button class="filter-btn btn btn-success px-6 py-3 fw-bold active" data-filter="all" style="background-color: #1A8B44; color: white;">All</button>
                        <button class="filter-btn btn btn-outline btn-outline-dashed btn-outline-default text-muted bg-white px-6 py-3 fw-bold" data-filter="my-communities">My Communities</button>
                        <button class="filter-btn btn btn-outline btn-outline-dashed btn-outline-default text-muted bg-white px-6 py-3 fw-bold" data-filter="FEU ALABANG">FEU ALABANG</button>
                        <button class="filter-btn btn btn-outline btn-outline-dashed btn-outline-default text-muted bg-white px-6 py-3 fw-bold" data-filter="FEU DILIMAN">FEU DILIMAN</button>
                        <button class="filter-btn btn btn-outline btn-outline-dashed btn-outline-default text-muted bg-white px-6 py-3 fw-bold" data-filter="FEU TECH">FEU TECH</button>
                    </div>
                    <button class="btn btn-warning d-flex align-items-center gap-2 fw-bolder text-white px-6 py-3" data-bs-toggle="modal" data-bs-target="#create_community_modal">
                        <i class="fas fa-plus text-white"></i> CREATE COMMUNITY
                    </button>
                </div>

                <!-- Cards Grid -->
                <div class="row g-6 mb-10" id="communities-grid">
                    <?php
                    $communities = [
                        ["title" => "FEU LIFE", "desc" => "Campus life, events, enrollment tips, and all things FEU Institute of Technology.", "cat" => "FEU TECH", "members" => 4894, "posts" => 12450],
                        ["title" => "FEU ALABANG LIFE", "desc" => "Campus life, events, enrollment tips, and all things FEU Alabang.", "cat" => "FEU ALABANG", "members" => 3201, "posts" => 8400],
                        ["title" => "Freshies", "desc" => "A community for all the newcomers to share their thoughts and get advice.", "cat" => "my-communities", "members" => 1500, "posts" => 320],
                        ["title" => "Enrollment", "desc" => "Everything you need to know about enrollment in FEU Diliman.", "cat" => "FEU DILIMAN", "members" => 890, "posts" => 120],
                        ["title" => "Cosplaying", "desc" => "A place for cosplayers to meet and share their passion.", "cat" => "FEU TECH", "members" => 450, "posts" => 201],
                        ["title" => "FEU TECH DEV", "desc" => "For aspiring developers and software engineers in FEU Tech.", "cat" => "FEU TECH", "members" => 2100, "posts" => 5400],
                        ["title" => "Food Trip Around TECH", "desc" => "Best spots to eat around the campus.", "cat" => "FEU TECH", "members" => 3400, "posts" => 670],
                        ["title" => "Thesis Advice", "desc" => "Help and resources for your final year project.", "cat" => "FEU DILIMAN", "members" => 600, "posts" => 450],
                        ["title" => "Alabang Innovators", "desc" => "Tech startup and innovation community in Alabang.", "cat" => "FEU ALABANG", "members" => 210, "posts" => 80],
                        ["title" => "Diliman Artists", "desc" => "Art and creative works from FEU Diliman.", "cat" => "FEU DILIMAN", "members" => 750, "posts" => 340],
                        ["title" => "Study Group", "desc" => "Find study partners across all campuses.", "cat" => "my-communities", "members" => 1200, "posts" => 890],
                        ["title" => "Tech Support", "desc" => "IT support and discussions for students.", "cat" => "FEU TECH", "members" => 850, "posts" => 230]
                    ];
                    
                    foreach($communities as $community) {
                    ?>
                    <div class="col-md-4 col-lg-3 community-item" data-category="<?php echo $community['cat']; ?>">
                        <div class="card h-100 shadow-sm border-0">
                            <div class="card-body p-6 text-center d-flex flex-column">
                                <div class="mb-4 d-flex justify-content-center">
                                    <?php 
                                    $iconDetails = getCommunityIconDetails($community['title'], $community['cat']);
                                    ?>
                                    <div class="w-60px h-60px rounded-3 d-flex align-items-center justify-content-center shadow-sm"
                                         style="background-color: <?php echo $iconDetails['bg_hex']; ?>;">
                                        <i class="bi <?php echo $iconDetails['icon']; ?> fs-2hx"
                                           style="color: <?php echo $iconDetails['color_hex']; ?>;"></i>
                                    </div>
                                </div>
                                <h3 class="fs-6 fw-bolder mb-2 text-dark">
                                    <a href="/Discourse/pages/version/community.php" class="text-dark text-hover-success"><?php echo $community['title']; ?></a>
                                </h3>
                                <p class="text-muted fs-8 mb-4 flex-grow-1"><?php echo $community['desc']; ?></p>
                                <div class="d-flex justify-content-center gap-4 mb-4">
                                    <div class="border border-dashed border-gray-300 rounded px-3 py-2 w-50">
                                        <div class="fs-7 fw-bold text-dark d-flex align-items-center justify-content-center">
                                            <i class="fas fa-user fs-8 me-1"></i> <?php echo number_format($community['members']); ?>
                                        </div>
                                        <div class="fs-9 text-muted">Members</div>
                                    </div>
                                    <div class="border border-dashed border-gray-300 rounded px-3 py-2 w-50">
                                        <div class="fs-7 fw-bold text-dark d-flex align-items-center justify-content-center">
                                            <i class="fas fa-edit fs-8 me-1"></i> <?php echo number_format($community['posts']); ?>
                                        </div>
                                        <div class="fs-9 text-muted">Posts</div>
                                    </div>
                                </div>
                                <a href="/Discourse/pages/version/community.php" class="btn btn-sm w-100 d-flex align-items-center justify-content-center gap-2" style="background-color: #1A8B44; color: white;">
                                    <i class="fas fa-plus text-white fs-8"></i> JOIN COMMUNITY
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>

                <!-- Create Community Modal -->
                <div class="modal fade" id="create_community_modal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered mw-600px">
                        <div class="modal-content">
                            <div class="modal-header border-0 pb-0 justify-content-end" style="position: absolute; right: 0; z-index: 10;">
                                <div class="btn btn-sm btn-icon btn-active-color-primary mt-2 me-2" data-bs-dismiss="modal">
                                    <i class="fas fa-times fs-2 text-white"></i>
                                </div>
                            </div>
                            <div class="modal-header border-0 p-0 mb-5 rounded-top modal-theme-header" style="background-color: #1A8B44; transition: background-color 0.3s ease;">
                                <h2 class="fw-bolder text-white px-8 py-6 m-0 w-100">Create a community</h2>
                            </div>
                            <div class="modal-body px-8 pt-0 pb-8">
                                <form class="form" action="#" id="create-community-form">
                                    <div class="fv-row mb-6">
                                        <label class="fs-6 fw-bold mb-2 text-dark">Community Name</label>
                                        <input type="text" id="comm-name" class="form-control form-control-solid bg-light" placeholder="E.g FEU TECH" required />
                                    </div>
                                    <div class="fv-row mb-6">
                                        <label class="fs-6 fw-bold mb-2 text-dark">Description</label>
                                        <textarea id="comm-desc" class="form-control form-control-solid bg-light" rows="4" placeholder="Describe the purpose, topics, and audience of this community" required></textarea>
                                    </div>
                                    
                                    <div class="row mb-6">
                                        <div class="col-6">
                                            <label class="fs-6 fw-bold mb-2 text-dark">Category</label>
                                            <select id="comm-cat" class="form-select form-select-solid bg-light" data-control="select2" data-hide-search="true" required>
                                                <option value=""></option>
                                                <option value="FEU TECH">FEU TECH</option>
                                                <option value="FEU ALABANG">FEU ALABANG</option>
                                                <option value="FEU DILIMAN">FEU DILIMAN</option>
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <label class="fs-6 fw-bold mb-2 text-dark">Import profile</label>
                                            <div class="form-control form-control-solid bg-light text-center text-muted py-3 fw-semibold" style="cursor: pointer;">
                                                Upload image
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="fv-row mb-6">
                                        <label class="fs-6 fw-bold mb-2 text-dark">Theme Color</label>
                                        <div class="d-flex align-items-center gap-3 theme-color-picker">
                                            <div class="w-30px h-30px rounded-circle cursor-pointer border border-2 border-white shadow-sm theme-color-btn active" style="background-color: #1A8B44;" data-color="#1A8B44"></div>
                                            <div class="w-30px h-30px rounded-circle cursor-pointer border border-2 border-white shadow-sm theme-color-btn" style="background-color: #0b5ed7;" data-color="#0b5ed7"></div>
                                            <div class="w-30px h-30px rounded-circle cursor-pointer border border-2 border-white shadow-sm theme-color-btn" style="background-color: #6610f2;" data-color="#6610f2"></div>
                                            <div class="w-30px h-30px rounded-circle cursor-pointer border border-2 border-white shadow-sm theme-color-btn" style="background-color: #d63384;" data-color="#d63384"></div>
                                            <div class="w-30px h-30px rounded-circle cursor-pointer border border-2 border-white shadow-sm theme-color-btn" style="background-color: #dc3545;" data-color="#dc3545"></div>
                                            <div class="w-30px h-30px rounded-circle cursor-pointer border border-2 border-white shadow-sm theme-color-btn" style="background-color: #6c757d;" data-color="#6c757d"></div>
                                            <div class="w-30px h-30px rounded-circle cursor-pointer border border-2 border-white shadow-sm theme-color-btn" style="background-color: #212529;" data-color="#212529"></div>
                                        </div>
                                    </div>
                                    
                                    <div class="fv-row mb-8">
                                        <button type="button" class="btn btn-light-secondary text-muted bg-light fw-bold">
                                            <i class="fas fa-plus text-muted"></i> Add Categories
                                        </button>
                                    </div>
                                    
                                    <div class="d-flex flex-stack gap-4">
                                        <button type="button" class="btn btn-outline btn-outline-default flex-grow-1 fw-bold bg-white" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-warning flex-grow-1 text-white fw-bolder">CREATE COMMUNITY</button>
                                    </div>
                                </form>
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

  <!-- Theme Color Picker Script -->
  <script>
    $(document).ready(function() {
        // 1. Handle theme color selection
        $('.theme-color-btn').on('click', function() {
            // Remove active class from all buttons
            $('.theme-color-btn').removeClass('active');
            // Add active class to clicked button
            $(this).addClass('active');
            
            // Get selected color
            const selectedColor = $(this).attr('data-color');
            
            // Apply color to modal header
            $('.modal-theme-header').css('background-color', selectedColor);
        });

        // 2. Filter and search functionality for cards
        function filterAndSearch() {
            const query = $('#communitySearch').val().toLowerCase();
            const activeFilter = $('.filter-btn.active').data('filter');
            
            $('.community-item').each(function() {
                const title = $(this).find('h3').text().toLowerCase();
                const desc = $(this).find('p').text().toLowerCase();
                
                const matchesQuery = title.includes(query) || desc.includes(query);
                const matchesFilter = (activeFilter === 'all') || ($(this).data('category') === activeFilter);
                
                if (matchesQuery && matchesFilter) {
                    $(this).fadeIn(200);
                } else {
                    $(this).hide();
                }
            });
        }

        $('#communitySearch').on('keyup', filterAndSearch);

        $('.filter-btn').on('click', function(e) {
            e.preventDefault();
            $('.filter-btn').removeClass('active btn-success').css({'background-color': '', 'color': ''}).addClass('bg-white text-muted btn-outline btn-outline-dashed btn-outline-default');
            $(this).addClass('active btn-success').removeClass('bg-white text-muted btn-outline btn-outline-dashed btn-outline-default').css({'background-color': '#1A8B44', 'color': 'white'});
            filterAndSearch();
        });

        // 3. Add create community dynamic creation
        $('#create-community-form').on('submit', function(e) {
            e.preventDefault();
            
            const name = $('#comm-name').val();
            const desc = $('#comm-desc').val();
            let cat = $('#comm-cat').val();
            if (!cat) cat = 'my-communities';
            const activeColor = $('.theme-color-btn.active').attr('data-color') || '#1A8B44';
            
            let icon = 'bi-cpu';
            let bgClass = 'bg-light-success';
            let textClass = 'text-success';
            
            const nameLower = name.toLowerCase();
            const catLower = cat.toLowerCase();
            
            if (nameLower.includes('life')) {
                icon = 'bi-heart-fill';
                bgClass = 'bg-light-danger';
                textClass = 'text-danger';
            } else if (nameLower.includes('fresh') || nameLower.includes('study') || nameLower.includes('group')) {
                icon = 'bi-people-fill';
                bgClass = 'bg-light-primary';
                textClass = 'text-primary';
            } else if (nameLower.includes('food') || nameLower.includes('trip')) {
                icon = 'bi-cup-hot-fill';
                bgClass = 'bg-light-warning';
                textClass = 'text-warning';
            } else if (nameLower.includes('cosplay') || nameLower.includes('artist') || nameLower.includes('culture') || nameLower.includes('hub')) {
                icon = 'bi-palette-fill';
                bgClass = 'bg-light-info';
                textClass = 'text-info';
            } else if (nameLower.includes('enroll') || nameLower.includes('thesis') || nameLower.includes('advice')) {
                icon = 'bi-journal-bookmark-fill';
                bgClass = 'bg-light-info';
                textClass = 'text-info';
            } else if (nameLower.includes('innovat')) {
                icon = 'bi-lightbulb-fill';
                bgClass = 'bg-light-warning';
                textClass = 'text-warning';
            } else if (catLower === 'feu alabang') {
                icon = 'bi-building-fill';
                bgClass = 'bg-light-warning';
                textClass = 'text-warning';
            } else if (catLower === 'feu diliman') {
                icon = 'bi-mortarboard-fill';
                bgClass = 'bg-light-primary';
                textClass = 'text-primary';
            }

            const newCard = `
            <div class="col-md-4 col-lg-3 community-item" data-category="${cat}" style="display: none;">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body p-6 text-center d-flex flex-column">
                        <div class="mb-4 d-flex justify-content-center">
                            <div class="w-60px h-60px rounded-3 d-flex align-items-center justify-content-center ${bgClass} ${textClass} fs-1 shadow-sm">
                                <i class="bi ${icon} fs-2hx"></i>
                            </div>
                        </div>
                        <h3 class="fs-6 fw-bolder mb-2 text-dark">
                            <a href="/Discourse/pages/version/community.php" class="text-dark text-hover-success">${name}</a>
                        </h3>
                        <p class="text-muted fs-8 mb-4 flex-grow-1">${desc}</p>
                        <div class="d-flex justify-content-center gap-4 mb-4">
                            <div class="border border-dashed border-gray-300 rounded px-3 py-2 w-50">
                                <div class="fs-7 fw-bold text-dark d-flex align-items-center justify-content-center">
                                    <i class="fas fa-users fs-8 me-1"></i> 1
                                </div>
                                <div class="fs-9 text-muted">Members</div>
                            </div>
                            <div class="border border-dashed border-gray-300 rounded px-3 py-2 w-50">
                                <div class="fs-7 fw-bold text-dark d-flex align-items-center justify-content-center">
                                    <i class="fas fa-edit fs-8 me-1"></i> 0
                                </div>
                                <div class="fs-9 text-muted">Posts</div>
                            </div>
                        </div>
                        <a href="/Discourse/pages/version/community.php" class="btn btn-sm w-100 d-flex align-items-center justify-content-center gap-2" style="background-color: ${activeColor}; color: white;">
                            <i class="fas fa-plus text-white fs-8"></i> JOIN COMMUNITY
                        </a>
                    </div>
                </div>
            </div>`;
            
            $('#communities-grid').prepend(newCard);
            $('#communities-grid .community-item:first').fadeIn(400);
            
            $('#create_community_modal').modal('hide');
            this.reset();
            
            // Switch to the 'All' or 'My Communities' tab to see it if filtered
            $('.filter-btn[data-filter="all"]').click();
        });
    });
  </script>
</body>

</html>
