<?php
$META_TITLE = "Create a Post - Discourse";
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

  <link href="/Discourse/assets/css/discourse-css/create-post.css" rel="stylesheet" type="text/css" />
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
              <div class="page-banner w-100 py-10 mb-8">
                <div class="container-xxl d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-yellow fw-bold fs-8 text-uppercase tracking-wider mb-1 d-block">NEW POST</span>
                        <h1 class="text-white fw-bolder fs-2tx mb-2">Create a Post</h1>
                        <p class="text-white text-opacity-75 fs-7 mb-0">Share something with the Paraverse community</p>
                    </div>
                    <button class="btn btn-sm btn-outline btn-outline-white text-white border-white border-opacity-25 px-6" onclick="window.location.href='/Discourse/pages/version/community.php'">Back</button>
                </div>
              </div>

              <div class="app-container container-xxl pb-10">
                <div class="row g-6">
                    <!-- Main Form -->
                    <div class="col-lg-8">
                        <div class="card border border-gray-300 shadow-none rounded-2">
                            <div class="card-body p-8">
                                
                                <div class="d-flex align-items-center justify-content-between mb-8">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="w-25px h-25px bg-light-success rounded d-flex align-items-center justify-content-center"></div>
                                        <h3 class="fw-bolder text-dark fs-4 m-0">Post Content</h3>
                                    </div>
                                    <div class="d-flex align-items-center gap-2 bg-light-success px-4 py-2 rounded">
                                        <div class="w-15px h-15px bg-success rounded-circle text-white d-flex align-items-center justify-content-center fs-9">CS</div>
                                        <span class="text-success fw-bold fs-8">Posting as yourself</span>
                                        <i class="ki-duotone ki-down text-success fs-9 ms-2"></i>
                                    </div>
                                </div>
                                
                                <!-- Form Fields -->
                                <div class="mb-6">
                                    <label class="form-label fs-8 fw-bold text-gray-700 text-uppercase">TITLE *</label>
                                    <input type="text" class="form-control form-control-solid border" placeholder="What's on your mind? Give it a good headline...">
                                </div>
                                
                                <div class="row g-4 mb-6">
                                    <div class="col-md-6">
                                        <label class="form-label fs-8 fw-bold text-gray-700 text-uppercase">COMMUNITY</label>
                                        <select class="form-select form-select-solid border" data-control="select2" data-hide-search="true" data-placeholder="No community">
                                            <option></option>
                                            <option value="1">FEU TECH</option>
                                            <option value="2">FEU ALABANG</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fs-8 fw-bold text-gray-700 text-uppercase">TOPIC *</label>
                                        <select class="form-select form-select-solid border" data-control="select2" data-hide-search="true" data-placeholder="Select a topic...">
                                            <option></option>
                                            <option value="1">Technology</option>
                                            <option value="2">General</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="mb-6">
                                    <label class="form-label fs-8 fw-bold text-gray-700 text-uppercase">TAGS</label>
                                    <input type="text" class="form-control form-control-solid border" placeholder="Type a tag and press Enter...">
                                </div>
                                
                                <div>
                                    <label class="form-label fs-8 fw-bold text-gray-700 text-uppercase">BODY</label>
                                    <div class="border border-gray-300 rounded-2">
                                        <!-- Toolbar -->
                                        <div class="editor-toolbar p-3 d-flex align-items-center justify-content-between flex-wrap gap-3">
                                            <div class="d-flex align-items-center gap-1">
                                                <button class="btn btn-sm btn-icon btn-active-light-primary text-gray-600"><i class="ki-duotone ki-text-bold"><span class="path1"></span><span class="path2"></span></i></button>
                                                <button class="btn btn-sm btn-icon btn-active-light-primary text-gray-600"><i class="ki-duotone ki-text-italic"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i></button>
                                                <button class="btn btn-sm btn-icon btn-active-light-primary text-gray-600"><i class="ki-duotone ki-text-strikethrough"><span class="path1"></span><span class="path2"></span></i></button>
                                                <button class="btn btn-sm btn-icon btn-active-light-primary text-gray-600"><i class="ki-duotone ki-element-1"><span class="path1"></span><span class="path2"></span></i></button>
                                                <div class="h-20px border-end border-gray-300 mx-2"></div>
                                                <button class="btn btn-sm btn-icon btn-active-light-primary text-gray-600"><i class="ki-duotone ki-code"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i></button>
                                            </div>
                                            <a href="#" class="text-success fw-bold fs-8 text-hover-primary">Switch to Markdown</a>
                                        </div>
                                        
                                        <!-- Content Area -->
                                        <div class="editor-content p-4">
                                            <textarea class="form-control form-control-flush border-0 p-0 fs-6" rows="8" placeholder="Body text (optional)"></textarea>
                                        </div>
                                        
                                        <!-- Bottom Toolbar -->
                                        <div class="editor-bottom-toolbar p-3 d-flex align-items-center gap-4 flex-wrap px-6">
                                            <button class="btn btn-sm btn-active-light text-gray-600 fw-medium fs-8 p-0"><i class="ki-duotone ki-link me-1"><span class="path1"></span><span class="path2"></span></i> Link</button>
                                            <button class="btn btn-sm btn-active-light text-gray-600 fw-medium fs-8 p-0"><i class="ki-duotone ki-picture me-1"><span class="path1"></span><span class="path2"></span></i> Image</button>
                                            <button class="btn btn-sm btn-active-light text-gray-600 fw-medium fs-8 p-0"><i class="ki-duotone ki-video me-1"><span class="path1"></span><span class="path2"></span></i> Video</button>
                                            <button class="btn btn-sm btn-active-light text-gray-600 fw-medium fs-8 p-0"><i class="ki-duotone ki-row-horizontal me-1"><span class="path1"></span><span class="path2"></span></i> List</button>
                                            <button class="btn btn-sm btn-active-light text-gray-600 fw-medium fs-8 p-0"><i class="ki-duotone ki-eye-slash me-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i> Spoiler</button>
                                            <button class="btn btn-sm btn-active-light text-gray-600 fw-medium fs-8 p-0"><i class="ki-duotone ki-code me-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i> Code</button>
                                            <button class="btn btn-sm btn-active-light text-gray-600 fw-medium fs-8 p-0"><i class="ki-duotone ki-element-plus me-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i> Table</button>
                                            <button class="btn btn-sm btn-active-light text-gray-600 fw-medium fs-8 p-0"><i class="ki-duotone ki-chart-simple me-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i> Poll</button>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="col-lg-4">
                        
                        <!-- Publish Card -->
                        <div class="card card-publish mb-6 shadow-none">
                            <div class="card-body p-6">
                                <h5 class="fw-bolder text-dark mb-3 fs-5">Publish</h5>
                                <p class="text-muted fs-8 mb-6">Ready to share? Your post will be visible to the entire Paraverse community.</p>
                                <button class="btn w-100 btn-green mb-3 fw-bold" onclick="window.location.href='/Discourse/pages/version/community.php'">Publish Post</button>
                                <button class="btn w-100 btn-light bg-white border border-gray-300 text-dark fw-bold" onclick="window.location.href='/Discourse/pages/version/community.php'">Discard</button>
                            </div>
                        </div>
                        
                        <!-- Posting Tips -->
                        <div class="card border border-gray-300 shadow-none mb-6 rounded-2">
                            <div class="card-body p-6">
                                <h5 class="fw-bolder text-dark mb-5 fs-6">Posting Tips</h5>
                                <div class="d-flex flex-column gap-4">
                                    <div class="d-flex align-items-start gap-2">
                                        <i class="ki-duotone ki-arrow-right tips-bullet mt-1"><span class="path1"></span><span class="path2"></span></i>
                                        <p class="text-gray-700 fs-8 mb-0">Use <span class="fw-bolder">anonymous mode</span> for sensitive topics — your identity stays hidden.</p>
                                    </div>
                                    <div class="d-flex align-items-start gap-2">
                                        <i class="ki-duotone ki-arrow-right tips-bullet mt-1"><span class="path1"></span><span class="path2"></span></i>
                                        <p class="text-gray-700 fs-8 mb-0">A great <span class="fw-bolder">title</span> drives more engagement. Be specific!</p>
                                    </div>
                                    <div class="d-flex align-items-start gap-2">
                                        <i class="ki-duotone ki-arrow-right tips-bullet mt-1"><span class="path1"></span><span class="path2"></span></i>
                                        <p class="text-gray-700 fs-8 mb-0">Click <span class="fw-bolder">Poll</span> in the toolbar to attach a poll to your post.</p>
                                    </div>
                                    <div class="d-flex align-items-start gap-2">
                                        <i class="ki-duotone ki-arrow-right tips-bullet mt-1"><span class="path1"></span><span class="path2"></span></i>
                                        <p class="text-gray-700 fs-8 mb-0">Tag the right <span class="fw-bolder">community</span> for better reach and discoverability.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Community Rules -->
                        <div class="card rules-card shadow-none">
                            <div class="card-body p-6">
                                <h5 class="fw-bolder text-dark mb-4 fs-6">Community Rules</h5>
                                <div class="d-flex flex-column gap-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="ki-duotone ki-check fs-8"><span class="path1"></span><span class="path2"></span></i>
                                        <span class="text-dark fs-8">Be respectful and constructive</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="ki-duotone ki-check fs-8"><span class="path1"></span><span class="path2"></span></i>
                                        <span class="text-dark fs-8">No personal attacks or harassment</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="ki-duotone ki-check fs-8"><span class="path1"></span><span class="path2"></span></i>
                                        <span class="text-dark fs-8">Keep posts relevant to FEU Tech</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="ki-duotone ki-check fs-8"><span class="path1"></span><span class="path2"></span></i>
                                        <span class="text-dark fs-8">Verify information before sharing</span>
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
</body>

</html>
