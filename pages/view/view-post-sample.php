<?php
define('MBG', TRUE);
include($_SERVER['DOCUMENT_ROOT'] . '/functions-new.php');

$META_TITLE = "Lorem ipsum dolor sit amet, consectetur adipiscing elit";
$META_DESC  = "A post from FEU Tech Discourse community.";
?>
<head>
    <?php HEAD_ESSENTIALS(); ?>
    <link href="/Discourse/assets/css/dashboard.css" rel="stylesheet" type="text/css" />
  <link href="/Discourse/assets/css/view-post.css" rel="stylesheet" type="text/css" />
    <link href="/Discourse/assets/css/sec-modals.css" rel="stylesheet" type="text/css" />

  
</head>

<body id="kt_app_body"
    data-kt-app-page-loading-enabled="true"
    data-kt-app-page-loading="on"
    data-kt-app-layout="light-header"
    data-kt-app-header-fixed="true"
    data-kt-app-header-fixed-mobile="true"
    class="app-default">

    <?php include($_SERVER['DOCUMENT_ROOT'] . '/Discourse/partials/_page-loader.php'); ?>

    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <div class="app-page flex-column flex-column-fluid" id="kt_app_page">

            <?php include($_SERVER['DOCUMENT_ROOT'] . '/Discourse/partials/_header.php'); ?>

            <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
                <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                    <div class="d-flex flex-column flex-column-fluid">
                        <main>

                            <!-- HERO -->
                            <div style="background: linear-gradient(135deg, #0b3220 0%, #1a5c38 60%, #3a5c45 100%); padding: 28px 0 22px;">
                                <div class="app-container container-xxl position-relative">
                                    <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                        <div>
                                            <div class="d-flex align-items-center gap-2 mb-2">
                                                <i class="bi bi-eye-fill text-white opacity-75 fs-7"></i>
                                                <span class="text-white opacity-75 fs-8 fw-bold text-uppercase ls-1">Viewing Post</span>
                                            </div>
                                            <h1 class="text-white fs-2 fw-bolder mb-1">Lorem ipsum dolor sit amet</h1>
                                            <p class="text-white opacity-65 fs-7 mb-0">
                                                <span class="me-1">Consectetur</span>·
                                                <span class="mx-1">Posted by John Doe</span>·
                                                <span class="mx-1">3h ago</span>
                                            </p>
                                        </div>
                                        <a href="/Discourse/index.php" class="btn btn-sm btn-light fw-bold flex-shrink-0 mt-2">
                                            <i class="bi bi-arrow-left me-1"></i> Back to Feed
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- END HERO -->

                            <div id="kt_app_content" class="flex-column-fluid">
                                <div class="app-container container-xxl py-5">
                                    <div class="row g-5 align-items-start">

                                        <!-- LEFT: Main Post -->
                                        <div class="col-lg-8">
                                            <div class="card border-0 shadow mb-5">

                                                <!-- Post Header -->
                                                <div class="card-body pb-0 pt-5 px-5">
                                                    <!-- Community badge + Report -->
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <span class="badge badge-light-success rounded-pill px-5 py-2 fs-8"style="color:#3a5c45;">LoremIpsum</span>
                                                        <button class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#modalReportPost">
                                                            <i class="bi bi-flag me-1"></i> Report
                                                        </button>
                                                    </div>

                                                    <!-- Author row -->
                                                    <div class="d-flex gap-3 align-items-center mb-4">
                                                        <img src="/Discourse/assets/images/catalina.webp" alt="John Doe" class="h-40px w-40px rounded-circle" />
                                                        <div class="d-flex flex-column">
                                                            <a href="#" class="fs-6 fw-bold text-gray-800 text-hover-primary">John Doe</a>
                                                            <span class="text-muted fs-8"><i class="bi bi-clock me-1 fs-8"></i>3h ago</span>
                                                        </div>
                                                        <span class="badge badge-light-success rounded-pill px-5 py-2 fs-8"style="color:#3a5c45;">CONSECTETUR</span>
                                                    </div>

                                                    <!-- Title -->
                                                    <h2 class="fs-3 fw-bold text-gray-800 mb-4">
                                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit — sed do eiusmod tempor
                                                    </h2>
                                                </div>

                                                <!-- Post Body -->
                                                <div class="card-body pt-0 px-5">
                                                  <div class="dc-post-body-wrap">
                                                    <div class="dc-body-text">
                                                      <p class="fs-6 text-gray-700 mb-3">
                                                          Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                                                      </p>
                                                      <p class="fs-6 text-gray-700 mb-3">
                                                          Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                                                      </p>
                                                      <p class="fs-6 text-gray-700 mb-4">
                                                          Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.
                                                      </p>
                                                    </div>
                                                    <a href="#" class="dc-see-more-link d-none" onclick="dcTogglePostBody(event, this)">See More</a>
                                                  </div>
                                                </div>

                                                <!-- Actions Row -->
                                                <div class="card-body pt-0 px-5 pb-0">
                                                    <div class="d-flex justify-content-between align-items-center border-top border-bottom py-3">
                                                        <div class="d-flex flex-wrap gap-1">

                                                            <button id="postLikeBtn" class="btn btn-sm">
                                                                <i class="bi bi-hand-thumbs-up"></i> Like <span>42</span>
                                                            </button>

                                                            <button id="postDislikeBtn" class="btn btn-sm">
                                                                <i class="bi bi-hand-thumbs-down"></i> Dislike
                                                            </button>

                                                            <button class="btn btn-sm">
                                                                <i class="bi bi-chat"></i> 3 Comments
                                                            </button>

                                                            <button id="postShareBtn" class="btn btn-sm">
                                                                <i class="bi bi-share"></i> Share
                                                            </button>

                                                            <button id="postSaveBtn" class="btn btn-sm">
                                                                <i class="bi bi-bookmark"></i> Save
                                                            </button>

                                                        </div>

                                                        <div id="dc-toast" style="display:none;" class="align-items-center gap-2 mt-3 px-4 py-2 bg-light border rounded-2 fs-6 text-gray-700">
                                                            <i class="bi bi-check-circle-fill text-success"></i><span></span>
                                                        </div>

                                                    </div>
                                                </div>
                                                <!-- Comments Section -->
                                                <div class="card-body px-5 py-5">
                                                    <h6 class="fs-6 fw-bold text-gray-800 mb-4">
                                                        Comments <span class="text-muted fw-normal fs-7">3</span>
                                                    </h6>

                                                    <!-- Comment 1 -->
                                                    <div class="d-flex gap-3 mb-4">
                                                        <img src="/Discourse/assets/images/catalina.webp" alt="Jane Doe" class="h-35px w-35px rounded-circle flex-shrink-0" />
                                                        <div class="bg-light rounded-3 p-4 flex-grow-1">
                                                            <div class="d-flex align-items-center gap-3 mb-2">
                                                                <span class="fs-7 fw-bold text-gray-800">Jane Doe</span>
                                                                <span class="text-muted fs-8">2h ago</span>
                                                            </div>
                                                            <p class="fs-7 text-gray-700 mb-2">Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip.</p>
                                                            <div class="d-flex align-items-center gap-2 mt-1">
                                                                <button class="btn btn-sm p-0 text-muted fs-8 dc-comment-like" title="Like">
                                                                    <i class="bi bi-hand-thumbs-up"></i>
                                                                </button>
                                                                <button class="btn btn-sm p-0 text-muted fs-8 dc-comment-dislike" title="Dislike">
                                                                    <i class="bi bi-hand-thumbs-down"></i>
                                                                </button>
                                                                <button class="btn btn-sm p-0 text-muted fs-8 dc-reply-btn" title="Reply">
                                                                    <i class="bi bi-reply me-1"></i>Reply
                                                                </button>
                                                            </div>
                                                            <div class="dc-reply-box mt-3 d-none">
                                                                <textarea class="form-control form-control-solid form-control-sm mb-2" rows="2" placeholder="Write a reply…"></textarea>
                                                                <div class="d-flex justify-content-end gap-2">
                                                                    <button class="btn btn-sm btn-light dc-reply-cancel">Cancel</button>
                                                                    <button class="btn btn-sm btn-success fw-bold"><i class="bi bi-send-fill me-1"></i>Reply</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Comment 2 -->
                                                    <div class="d-flex gap-3 mb-4">
                                                        <img src="/Discourse/assets/images/anonymous.png" alt="Anonymous" class="h-35px w-35px rounded-circle flex-shrink-0" />
                                                        <div class="bg-light rounded-3 p-4 flex-grow-1">
                                                            <div class="d-flex align-items-center gap-3 mb-2">
                                                                <span class="fs-7 fw-bold text-gray-800">Anonymous</span>
                                                                <span class="text-muted fs-8">1h ago</span>
                                                            </div>
                                                            <p class="fs-7 text-gray-700 mb-2">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                                                            <div class="d-flex align-items-center gap-2 mt-1">
                                                                <button class="btn btn-sm p-0 text-muted fs-8 dc-comment-like" title="Like">
                                                                    <i class="bi bi-hand-thumbs-up"></i>
                                                                </button>
                                                                <button class="btn btn-sm p-0 text-muted fs-8 dc-comment-dislike" title="Dislike">
                                                                    <i class="bi bi-hand-thumbs-down"></i>
                                                                </button>
                                                                <button class="btn btn-sm p-0 text-muted fs-8 dc-reply-btn" title="Reply">
                                                                    <i class="bi bi-reply me-1"></i>Reply
                                                                </button>
                                                            </div>
                                                            <div class="dc-reply-box mt-3 d-none">
                                                                <textarea class="form-control form-control-solid form-control-sm mb-2" rows="2" placeholder="Write a reply…"></textarea>
                                                                <div class="d-flex justify-content-end gap-2">
                                                                    <button class="btn btn-sm btn-light dc-reply-cancel">Cancel</button>
                                                                    <button class="btn btn-sm btn-success fw-bold"><i class="bi bi-send-fill me-1"></i>Reply</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Comment 3 -->
                                                    <div class="d-flex gap-3 mb-4">
                                                        <img src="/Discourse/assets/images/catalina.webp" alt="Smith Doe" class="h-35px w-35px rounded-circle flex-shrink-0" />
                                                        <div class="bg-light rounded-3 p-4 flex-grow-1">
                                                            <div class="d-flex align-items-center gap-3 mb-2">
                                                                <span class="fs-7 fw-bold text-gray-800">Smith Doe</span>
                                                                <span class="text-muted fs-8">30m ago</span>
                                                            </div>
                                                            <p class="fs-7 text-gray-700 mb-2">Excepteur sint occaecat cupidatat non proident, sunt in culpa.</p>
                                                            <div class="d-flex align-items-center gap-2 mt-1">
                                                                <button class="btn btn-sm p-0 text-muted fs-8 dc-comment-like" title="Like">
                                                                    <i class="bi bi-hand-thumbs-up"></i>
                                                                </button>
                                                                <button class="btn btn-sm p-0 text-muted fs-8 dc-comment-dislike" title="Dislike">
                                                                    <i class="bi bi-hand-thumbs-down"></i>
                                                                </button>
                                                                <button class="btn btn-sm p-0 text-muted fs-8 dc-reply-btn" title="Reply">
                                                                    <i class="bi bi-reply me-1"></i>Reply
                                                                </button>
                                                            </div>
                                                            <div class="dc-reply-box mt-3 d-none">
                                                                <textarea class="form-control form-control-solid form-control-sm mb-2" rows="2" placeholder="Write a reply…"></textarea>
                                                                <div class="d-flex justify-content-end gap-2">
                                                                    <button class="btn btn-sm btn-light dc-reply-cancel">Cancel</button>
                                                                    <button class="btn btn-sm btn-success fw-bold"><i class="bi bi-send-fill me-1"></i>Reply</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Comment Input -->
                                                    <div class="d-flex gap-3 mt-4">
                                                        <img src="/Discourse/assets/images/catalina.webp" alt="You" class="h-35px w-35px rounded-circle flex-shrink-0" />
                                                        <div class="flex-grow-1 d-flex flex-column gap-2">
                                                            <label class="d-flex align-items-center gap-2 text-muted fs-8 cursor-pointer mb-0">
                                                                <input type="checkbox" class="form-check-input dc-anon-toggle">
                                                                <i class="bi bi-eye-slash-fill"></i> Post anonymously
                                                            </label>
                                                            <textarea class="form-control form-control-solid" rows="2" placeholder="Write a comment…"></textarea>
                                                            <div class="d-flex justify-content-end">
                                                                <button class="btn btn-sm btn-success fw-bold">
                                                                    <i class="bi bi-send-fill me-1"></i> Post
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <!-- end LEFT -->

                                        <!-- RIGHT: Sidebar -->
                                        <div class="col-lg-4">

                                            <!-- About the Author -->
                                            <div class="card border-0 shadow-sm mb-5">
                                                <div class="card-header border-0 bg-light py-4">
                                                    <h6 class="card-title mb-0 fw-bold fs-6">About the Author</h6>
                                                </div>
                                                <div class="card-body p-5">
                                                    <div class="d-flex align-items-center gap-3 mb-5">
                                                        <img src="/Discourse/assets/images/catalina.webp" alt="John Doe" class="h-50px w-50px rounded-circle" />
                                                        <div>
                                                            <a href="#" class="fs-6 fw-bold text-gray-800 text-hover-primary d-block">John Doe</a>
                                                            <span class="text-muted fs-8 d-block">1000/2000 · Lorem Ipsum Dolor</span>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-around text-center mb-5">
                                                        <div>
                                                            <div class="fs-5 fw-bold text-gray-800">25</div>
                                                            <div class="text-muted fs-8">Posts</div>
                                                        </div>
                                                        <div>
                                                            <div class="fs-5 fw-bold text-gray-800">500</div>
                                                            <div class="text-muted fs-8">Followers</div>
                                                        </div>
                                                        <div>
                                                            <div class="fs-5 fw-bold text-gray-800">100</div>
                                                            <div class="text-muted fs-8">Following</div>
                                                        </div>
                                                    </div>
                                                    <a href="#" class="btn btn-sm btn-light-success w-100 fw-bold"style="color:#3a5c45;">
                                                        <i class="bi bi-person-plus-fill me-1"style="color:#3a5c45;"></i> Follow
                                                    </a>
                                                </div>
                                            </div>

                                            <!-- Related Posts -->
                                            <div class="card border-0 shadow-sm mb-5">
                                                <div class="card-header border-0 bg-light py-4">
                                                    <h6 class="card-title mb-0 fw-bold fs-6">Related Posts</h6>
                                                </div>
                                                <div class="card-body p-0">
                                                    <a href="#" class="d-flex align-items-start gap-3 p-4 border-bottom text-decoration-none text-hover-primary">
                                                        <span class="badge badge-light-success rounded-pill px-3 py-2 fs-8 flex-shrink-0"style="color:#3a5c45;">#01</span>
                                                        <div>
                                                            <div class="fs-7 fw-semibold text-gray-800 mb-1">Lorem ipsum dolor sit amet, consectetur adipiscing elit?</div>
                                                            <div class="text-muted fs-8">Consectetur · 4d ago</div>
                                                        </div>
                                                    </a>
                                                    <a href="#" class="d-flex align-items-start gap-3 p-4 border-bottom text-decoration-none text-hover-primary">
                                                        <span class="badge badge-light-success rounded-pill px-3 py-2 fs-8 flex-shrink-0"style="color:#3a5c45;">#02</span>
                                                        <div>
                                                            <div class="fs-7 fw-semibold text-gray-800 mb-1">Sed do eiusmod tempor incididunt ut labore et dolore?</div>
                                                            <div class="text-muted fs-8">Consectetur · 1w ago</div>
                                                        </div>
                                                    </a>
                                                    <a href="#" class="d-flex align-items-start gap-3 p-4 text-decoration-none text-hover-primary">
                                                        <span class="badge badge-light-success rounded-pill px-3 py-2 fs-8 flex-shrink-0"style="color:#3a5c45;">#03</span>
                                                        <div>
                                                            <div class="fs-7 fw-semibold text-gray-800 mb-1">Ut enim ad minim veniam, quis nostrud exercitation?</div>
                                                            <div class="text-muted fs-8">LoremIpsum · 2d ago</div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>

                                            <!-- Community Rules -->
                                            <div class="card border border-success bg-light-success">
                                                <div class="card-body p-5">
                                                    <p class="fs-6 fw-bold mb-3"style="color:#3a5c45;">Community Rules</p>
                                                    <ul class="list-unstyled d-flex flex-column gap-2 mb-0">
                                                        <li class="d-flex align-items-start gap-2 fs-7 "style="color:#3a5c45;"><span class="fw-bold flex-shrink-0"style="color:#3a5c45;">✓</span>Be respectful and constructive</li>
                                                        <li class="d-flex align-items-start gap-2 fs-7 "style="color:#3a5c45;"><span class="fw-bold flex-shrink-0"style="color:#3a5c45;">✓</span>No personal attacks or harassment</li>
                                                        <li class="d-flex align-items-start gap-2 fs-7 "style="color:#3a5c45;"><span class="fw-bold flex-shrink-0"style="color:#3a5c45;">✓</span>Keep posts relevant to FEU Tech</li>
                                                        <li class="d-flex align-items-start gap-2 fs-7 "style="color:#3a5c45;"><span class="fw-bold flex-shrink-0"style="color:#3a5c45;">✓</span>Verify information before sharing</li>
                                                    </ul>
                                                </div>
                                            </div>

                                        </div>
                                        <!-- end RIGHT -->

                                    </div>
                                </div>
                            </div>

                        </main>
                    </div>

                    <?php include($_SERVER['DOCUMENT_ROOT'] . '/Discourse/partials/_footer.php'); ?>

                </div>
            </div>
        </div>
    </div>

    <?php include($_SERVER['DOCUMENT_ROOT'] . '/Discourse/partials/_scrolltop.php'); ?>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/Discourse/partials/_discourse-modals.php'); ?>
    

  <script src="/Discourse/assets/js/dashboard.js"></script>
</body>