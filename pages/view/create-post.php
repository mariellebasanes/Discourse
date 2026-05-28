<?php
/* Refactored: custom CSS → Bootstrap/Metronic utilities */
define('MBG', TRUE);
include($_SERVER['DOCUMENT_ROOT'] . '/functions-new.php');
// IS_LOGGED_IN($_SERVER['REQUEST_URI']);
$META_TITLE = "Create a Post";
$META_DESC = "Share something with the Paraverse community.";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php HEAD_ESSENTIALS(); ?>
  <link href="/Discourse/assets/css/dashboard.css" rel="stylesheet">
  <link href="/Discourse/assets/css/dc-editor.css" rel="stylesheet">
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

              <!-- Hero -->
              <div style="background: linear-gradient(135deg, #0b3220 0%, #1a5c38 60%, #2D6A4F 100%); padding: 28px 0 22px;">
                <div class="app-container container-xxl">
                  <div class="d-flex align-items-start justify-content-between">
                    <div>
                      <i class="bi bi-pencil-square text-white opacity-75 fs-7"></i>
                      <span class="text-white opacity-75 fs-8 fw-bold text-uppercase ls-1">New Post</span>
                      <h2 class="text-white fs-2 fw-bolder mb-1">Create a Post</h2>
                      <p class="text-white opacity-65 fs-6 mb-0">Share something with the Paraverse community.</p>
                    </div>
                    <a href="/Discourse/" class="btn btn-sm btn-light fw-bold mt-2" onclick="KTApp.showPageLoading()">
                      <i class="bi bi-arrow-left me-1"></i> Back
                    </a>
                  </div>
                </div>
              </div>

              <!-- Content -->
              <div id="kt_app_content">
                <div class="app-container container-xxl">
                  <div class="row g-5 align-items-start py-5">

                    <!-- LEFT COLUMN -->
                    <div class="col-lg-8">
                      <div class="card border-0 shadow-sm">

                        <!-- Card Header -->
                        <div class="card-header border-0 bg-light d-flex align-items-center gap-3 py-4">
                          <div class="bg-light-success rounded-2 p-2 d-flex align-items-center justify-content-center" style="width:32px;height:32px;">
                            <i class="bi bi-pencil-square fs-6" style="color:#2D6A4F;"></i>
                          </div>
                          <h5 class="card-title mb-0 fw-bold fs-6">Post Content</h5>
                          <div class="ms-auto">
                            <!-- Posting as dropdown -->
                            <div class="dropdown">
                              <div class="d-inline-flex align-items-center gap-2 bg-light-success border border-success rounded-pill px-3 py-2 dropdown-toggle"
                                id="identityDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="cursor:pointer;">
                                <img id="display_identity_avatar"
                                  src="/Discourse/assets/images/avatars/300-1.jpg" alt="You"
                                  class="rounded-circle" style="width:22px;height:22px;object-fit:cover;"
                                  onerror="this.src='https://ui-avatars.com/api/?name=You&background=2D6A4F&color=fff&size=32'">
                                <span id="display_identity_text" class="fs-7 fw-bold" style="color:#2D6A4F;">Posting as yourself</span>
                              </div>
                              <ul class="dropdown-menu dropdown-menu-end menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3"
                                aria-labelledby="identityDropdown">
                                <li>
                                  <a class="dropdown-item menu-link px-4 active" href="#"
                                    onclick="changeIdentity(event, 'Posting as yourself', '/Discourse/assets/images/avatars/300-1.jpg')">
                                    <span class="menu-icon"><i class="bi bi-person fs-5 me-2"></i></span>
                                    <span class="menu-title">Yourself</span>
                                  </a>
                                </li>
                                <li>
                                  <a class="dropdown-item menu-link px-4" href="#"
                                    onclick="changeIdentity(event, 'Posting anonymously', 'https://ui-avatars.com/api/?name=A&background=7e8299&color=fff&size=32')">
                                    <span class="menu-icon"><i class="bi bi-eye-slash fs-5 text-danger me-2"></i></span>
                                    <span class="menu-title text-danger">Anonymous</span>
                                  </a>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>

                        <!-- Card Body -->
                        <div class="card-body p-5">

                          <!-- Title -->
                          <div class="mb-5">
                            <label class="form-label text-uppercase fw-bold text-gray-600 fs-8">
                              Title <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control form-control-solid" id="post_title"
                              placeholder="What's on your mind? (Give it a good headline...)">
                          </div>

                          <!-- Community + Topic -->
                          <div class="row g-4 mb-5">
                            <div class="col-sm-6">
                              <label class="form-label text-uppercase fw-bold text-gray-600 fs-8">
                                Community <span class="text-danger">*</span>
                              </label>
                              <select class="form-select form-select-solid">
                                <option value="">No community</option>
                                <option>CS Department</option>
                                <option>General</option>
                                <option>FEU Tech</option>
                              </select>
                            </div>
                            <div class="col-sm-6">
                              <label class="form-label text-uppercase fw-bold text-gray-600 fs-8">
                                Topic <span class="text-danger">*</span>
                              </label>
                              <select class="form-select form-select-solid">
                                <option value="">Select a topic...</option>
                                <option>Technology</option>
                                <option>Culture</option>
                                <option>Gaming</option>
                                <option>FEU</option>
                                <option>Ideas</option>
                                <option>Creative</option>
                                <option>Science</option>
                                <option>News</option>
                                <option>AI</option>
                                <option>Academics</option>
                                <option>Lifestyle</option>
                                <option>Entertainment</option>
                                <option>Music</option>
                                <option>Politics</option>
                                <option>Issues</option>
                                <option>Sports</option>
                                <option>Others</option>
                              </select>
                            </div>
                          </div>

                          <!-- Tags -->
                          <div class="mb-5">
                            <label class="form-label text-uppercase fw-bold text-gray-600 fs-8">Tags</label>
                            <div class="dc-tag-wrap" id="tag-wrap" onclick="document.getElementById('tag-input').focus()">
                              <input type="text" class="dc-tag-input" id="tag-input" placeholder="Type a tag and press Enter...">
                            </div>
                          </div>

                          <!-- Body editor -->
                          <div class="mb-0">
                            <label class="form-label text-uppercase fw-bold text-gray-600 fs-8">
                              Body <span class="text-muted fw-normal fs-8" style="text-transform:none;letter-spacing:0;">— optional</span>
                            </label>

                            <!-- Toolbar -->
                            <div class="dc-toolbar" id="dc-toolbar">
                              <button class="btn btn-sm btn-icon btn-light-success" style="color:#2D6A4F;" title="Bold" onclick="fmt('bold')"><b>B</b></button>
                              <button class="btn btn-sm btn-icon btn-light-success" title="Italic" onclick="fmt('italic')">
                                <i style="font-style:italic; color: #2D6A4F !important;">I</i>
                              </button> <button class="btn btn-sm btn-icon btn-light-success" style="color:#2D6A4F;" title="Strikethrough" onclick="fmt('strikeThrough')"><s>S</s></button>
                              <button class="btn btn-sm btn-icon btn-light-success" style="color:#2D6A4F;" title="Superscript" onclick="fmt('superscript')">x<sup>2</sup></button>
                              <button class="btn btn-sm btn-icon btn-light-success" style="color:#2D6A4F;" title="Paragraph" onclick="fmt('formatBlock','p')">¶T</button>
                              <span class="dc-tb-sep"></span>
                              <button class="btn btn-sm btn-icon btn-light-success" style="color:#2D6A4F;" title="Insert Link" onclick="openModal('modal-link')">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                  <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71" />
                                  <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71" />
                                </svg>
                              </button>
                              <button class="btn btn-sm btn-icon btn-light-success" style="color:#2D6A4F;" title="Insert Image" onclick="openModal('modal-image')">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                  <rect x="3" y="3" width="18" height="18" rx="2" />
                                  <circle cx="8.5" cy="8.5" r="1.5" />
                                  <polyline points="21 15 16 10 5 21" />
                                </svg>
                              </button>
                              <button class="btn btn-sm btn-icon btn-light-success" style="color:#2D6A4F;" title="Embed Video" onclick="openModal('modal-video')">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                  <circle cx="12" cy="12" r="10" />
                                  <polygon points="10 8 16 12 10 16 10 8" />
                                </svg>
                              </button>
                              <span class="dc-tb-sep"></span>
                              <button class="btn btn-sm btn-icon btn-light-success" style="color:#2D6A4F;" title="Ordered List" onclick="insertList('ol')">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                  <line x1="9" y1="6" x2="20" y2="6" />
                                  <line x1="9" y1="12" x2="20" y2="12" />
                                  <line x1="9" y1="18" x2="20" y2="18" />
                                  <path d="M4 6h1v4" />
                                  <path d="M4 10h2" />
                                  <path d="M6 18H4c0-1 2-2 2-3s-1-1.5-2-1" />
                                </svg>
                              </button>
                              <button class="btn btn-sm btn-icon btn-light-success" style="color:#2D6A4F;" title="Unordered List" onclick="insertList('ul')">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                  <line x1="9" y1="6" x2="20" y2="6" />
                                  <line x1="9" y1="12" x2="20" y2="12" />
                                  <line x1="9" y1="18" x2="20" y2="18" />
                                  <circle cx="4" cy="6" r="1.5" fill="currentColor" />
                                  <circle cx="4" cy="12" r="1.5" fill="currentColor" />
                                  <circle cx="4" cy="18" r="1.5" fill="currentColor" />
                                </svg>
                              </button>
                              <span class="dc-tb-sep"></span>
                              <button class="btn btn-sm btn-icon btn-light-success" style="color:#2D6A4F;" title="Inline Code"
                                onclick="fmt('insertHTML','<code style=&quot;background:#f0faf5;border-radius:4px;padding:1px 5px;font-family:monospace;font-size:12px;color:#1a5c38;&quot;>code</code>')">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                  <polyline points="16 18 22 12 16 6" />
                                  <polyline points="8 6 2 12 8 18" />
                                </svg>
                              </button>
                              <button class="btn btn-sm btn-icon btn-light-success" style="color:#2D6A4F;" title="Blockquote" onclick="fmt('formatBlock','blockquote')">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                  <path d="M3 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2H4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2 1 0 1 0 1 1v1c0 1-1 2-2 2s-1 .008-1 1.031V20c0 1 0 1 1 1zm12 0c3 0 7-1 7-8V5c0-1.25-.757-2.017-2-2h-4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2 1 0 1 0 1 1v1c0 1-1 2-2 2s-1 .008-1 1.031V20c0 1 0 1 1 1z" />
                                </svg>
                              </button>
                              <button class="btn btn-sm btn-icon btn-light-success" style="color:#2D6A4F;" title="Code Block" onclick="insertCodeBlock()">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                  <polyline points="16 18 22 12 16 6" />
                                  <polyline points="8 6 2 12 8 18" />
                                  <line x1="12" y1="3" x2="12" y2="21" stroke-width="1.5" />
                                </svg>
                              </button>
                              <button class="btn btn-sm btn-icon btn-light-success" style="color:#2D6A4F;" title="Spoiler" onclick="insertSpoiler()">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                  <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94" />
                                  <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19" />
                                  <line x1="1" y1="1" x2="23" y2="23" />
                                </svg>
                              </button>
                              <button class="btn btn-sm btn-icon btn-light-success" style="color:#2D6A4F;" title="Insert Table" onclick="insertTable()">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                  <rect x="3" y="3" width="18" height="18" rx="2" />
                                  <line x1="3" y1="9" x2="21" y2="9" />
                                  <line x1="3" y1="15" x2="21" y2="15" />
                                  <line x1="9" y1="3" x2="9" y2="21" />
                                  <line x1="15" y1="3" x2="15" y2="21" />
                                </svg>
                              </button>
                              <a class="dc-tb-switch" href="#" onclick="toggleMarkdown(event)">Switch to Markdown</a>
                            </div>

                            <!-- Editor -->
                            <div id="dc-editor" class="dc-editor-area" contenteditable="true"
                              data-placeholder="Body text (optional)"></div>

                            <!-- Media bar -->
                            <div class="dc-media-bar">
                              <button class="btn btn-sm btn-light text-gray-600 d-inline-flex align-items-center gap-1" onclick="openModal('modal-link')">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                  <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71" />
                                  <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71" />
                                </svg>
                                Link
                              </button>
                              <button class="btn btn-sm btn-light text-gray-600 d-inline-flex align-items-center gap-1" style="color:#2D6A4F;" onclick="openModal('modal-image')">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                  <rect x="3" y="3" width="18" height="18" rx="2" />
                                  <circle cx="8.5" cy="8.5" r="1.5" />
                                  <polyline points="21 15 16 10 5 21" />
                                </svg>
                                Image
                              </button>
                              <button class="btn btn-sm btn-light text-gray-600 d-inline-flex align-items-center gap-1" onclick="openModal('modal-video')">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                  <circle cx="12" cy="12" r="10" />
                                  <polygon points="10 8 16 12 10 16 10 8" />
                                </svg>
                                Video
                              </button>
                              <button class="btn btn-sm btn-light text-gray-600 d-inline-flex align-items-center gap-1" onclick="insertList('ul')">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                  <line x1="9" y1="6" x2="20" y2="6" />
                                  <line x1="9" y1="12" x2="20" y2="12" />
                                  <line x1="9" y1="18" x2="20" y2="18" />
                                  <circle cx="4" cy="6" r="1.5" fill="currentColor" />
                                  <circle cx="4" cy="12" r="1.5" fill="currentColor" />
                                  <circle cx="4" cy="18" r="1.5" fill="currentColor" />
                                </svg>
                                List
                              </button>
                              <button class="btn btn-sm btn-light text-gray-600 d-inline-flex align-items-center gap-1" onclick="insertSpoiler()">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                  <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94" />
                                  <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19" />
                                  <line x1="1" y1="1" x2="23" y2="23" />
                                </svg>
                                Spoiler
                              </button>
                              <button class="btn btn-sm btn-light text-gray-600 d-inline-flex align-items-center gap-1" onclick="insertCodeBlock()">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                  <polyline points="16 18 22 12 16 6" />
                                  <polyline points="8 6 2 12 8 18" />
                                </svg>
                                Code
                              </button>
                              <button class="btn btn-sm btn-light text-gray-600 d-inline-flex align-items-center gap-1" onclick="insertTable()">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                  <rect x="3" y="3" width="18" height="18" rx="2" />
                                  <line x1="3" y1="9" x2="21" y2="9" />
                                  <line x1="3" y1="15" x2="21" y2="15" />
                                  <line x1="9" y1="3" x2="9" y2="21" />
                                  <line x1="15" y1="3" x2="15" y2="21" />
                                </svg>
                                Table
                              </button>
                              <button class="btn btn-sm btn-light text-gray-600 d-inline-flex align-items-center gap-1" onclick="insertPollBuilder()">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                  <line x1="18" y1="20" x2="18" y2="10" />
                                  <line x1="12" y1="20" x2="12" y2="4" />
                                  <line x1="6" y1="20" x2="6" y2="14" />
                                </svg>
                                Poll
                              </button>
                            </div>

                          </div><!-- /body field -->

                        </div><!-- /card-body -->
                      </div><!-- /card -->
                    </div><!-- /col-lg-8 -->

                    <!-- RIGHT / SIDEBAR -->
                    <div class="col-lg-4">

                      <!-- Publish Card -->
                      <div class="card border-0 shadow-sm mb-5">
                        <div class="card-body p-5">
                          <p class="fs-5 fw-bold text-gray-800 mb-2">Publish</p>
                          <p class="fs-6 text-muted mb-5">Ready to share? Your post will be visible to the entire Paraverse community.</p>
                          <button class="btn btn-success w-100 fw-bold" onclick="submitPost()">
                            <i class="bi bi-send me-1"></i> Publish Post
                          </button>
                          <button class="btn btn-light w-100 fw-bold mt-3" onclick="discardPost()">Discard</button>
                        </div>
                      </div>

                      <!-- Posting Tips -->
                      <div class="card border-0 shadow-sm mb-5">
                        <div class="card-body p-5">
                          <p class="fs-6 fw-bold text-gray-800 mb-4">Posting Tips</p>
                          <div class="d-flex flex-column gap-3">
                            <div class="d-flex gap-3 align-items-start">
                              <span class="text-warning fs-6 fw-bold flex-shrink-0">→</span>
                              <span class="fs-7 text-gray-600">Use <strong>anonymous mode</strong> for sensitive topics — your identity stays hidden.</span>
                            </div>
                            <div class="d-flex gap-3 align-items-start">
                              <span class="text-warning fs-6 fw-bold flex-shrink-0">→</span>
                              <span class="fs-7 text-gray-600">A great <strong>title</strong> drives more engagement. Be specific!</span>
                            </div>
                            <div class="d-flex gap-3 align-items-start">
                              <span class="text-warning fs-6 fw-bold flex-shrink-0">→</span>
                              <span class="fs-7 text-gray-600">Click <strong>Poll</strong> in the toolbar to attach a poll to your post.</span>
                            </div>
                            <div class="d-flex gap-3 align-items-start">
                              <span class="text-warning fs-6 fw-bold flex-shrink-0">→</span>
                              <span class="fs-7 text-gray-600">Tag the right <strong>community</strong> for better reach and discoverability.</span>
                            </div>
                          </div>
                        </div>
                      </div>

                      <!-- Community Rules -->
                      <div class="card border border-success bg-light-success">
                        <div class="card-body p-5">
                          <p class="fs-6 fw-bold mb-3" style="color:#2D6A4F;">Community Rules</p>
                          <ul class="list-unstyled d-flex flex-column gap-2 mb-0">
                            <li class="d-flex align-items-start gap-2 fs-7 " style="color:#2D6A4F;"><span class="fw-bold flex-shrink-0">✓</span>Be respectful and constructive</li>
                            <li class="d-flex align-items-start gap-2 fs-7 " style="color:#2D6A4F;"><span class="fw-bold flex-shrink-0">✓</span>No personal attacks or harassment</li>
                            <li class="d-flex align-items-start gap-2 fs-7 " style="color:#2D6A4F;"><span class="fw-bold flex-shrink-0">✓</span>Keep posts relevant to FEU Tech</li>
                            <li class="d-flex align-items-start gap-2 fs-7 " style="color:#2D6A4F;"><span class="fw-bold flex-shrink-0">✓</span>Verify information before sharing</li>
                          </ul>
                        </div>
                      </div>

                    </div><!-- /col-lg-4 -->

                  </div><!-- /row -->
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

  <!-- Link Modal -->
  <div class="modal fade" id="modal-link" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content rounded-4">
        <div class="modal-header border-0 pb-0">
          <h5 class="modal-title fw-bold fs-5">Insert Link</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body pt-3">
          <div class="mb-4">
            <label class="form-label text-uppercase fw-bold text-gray-600 fs-8">Display Text</label>
            <input type="text" class="form-control form-control-solid" id="link-text" placeholder="Link text...">
          </div>
          <div class="mb-2">
            <label class="form-label text-uppercase fw-bold text-gray-600 fs-8">URL</label>
            <input type="url" class="form-control form-control-solid" id="link-url" placeholder="https://...">
          </div>
        </div>
        <div class="modal-footer border-0 pt-0 gap-2">
          <button class="btn btn-light fw-bold" data-bs-dismiss="modal">Cancel</button>
          <button class="btn btn-success fw-bold" onclick="insertLink()">Insert Link</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Image Modal -->
  <div class="modal fade" id="modal-image" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content rounded-4">
        <div class="modal-header border-0 pb-0">
          <h5 class="modal-title fw-bold fs-5">Insert Image</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body pt-3">
          <div class="mb-4">
            <label class="form-label text-uppercase fw-bold text-gray-600 fs-8">Image URL</label>
            <input type="url" class="form-control form-control-solid" id="img-url" placeholder="https://example.com/image.jpg">
          </div>
          <div class="mb-4">
            <label class="form-label text-uppercase fw-bold text-gray-600 fs-8">
              Alt Text <span class="text-muted fw-normal fs-8" style="text-transform:none;letter-spacing:0;">optional</span>
            </label>
            <input type="text" class="form-control form-control-solid" id="img-alt" placeholder="Describe the image...">
          </div>
          <p class="fs-8 text-muted mb-2">Or upload a file:</p>
          <input type="file" class="form-control" id="img-file" accept="image/*">
        </div>
        <div class="modal-footer border-0 pt-0 gap-2">
          <button class="btn btn-light fw-bold" data-bs-dismiss="modal">Cancel</button>
          <button class="btn btn-success fw-bold" onclick="insertImage()">Insert Image</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Video Modal -->
  <div class="modal fade" id="modal-video" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content rounded-4">
        <div class="modal-header border-0 pb-0">
          <h5 class="modal-title fw-bold fs-5">Embed Video</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body pt-3">
          <p class="fs-7 text-muted mb-4">Paste a YouTube or direct video URL below.</p>
          <div class="mb-2">
            <label class="form-label text-uppercase fw-bold text-gray-600 fs-8">Video URL</label>
            <input type="url" class="form-control form-control-solid" id="video-url" placeholder="https://youtube.com/watch?v=...">
          </div>
        </div>
        <div class="modal-footer border-0 pt-0 gap-2">
          <button class="btn btn-light fw-bold" data-bs-dismiss="modal">Cancel</button>
          <button class="btn btn-success fw-bold" onclick="insertVideo()">Embed Video</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    // ── Tag input ──
    const tagInput = document.getElementById('tag-input');
    const tagWrap = document.getElementById('tag-wrap');
    const tags = [];

    tagInput.addEventListener('keydown', e => {
      if ((e.key === 'Enter' || e.key === ',') && tagInput.value.trim()) {
        e.preventDefault();
        const v = tagInput.value.trim().replace(/,/g, '');
        if (v && !tags.includes(v)) {
          tags.push(v);
          renderTags();
        }
        tagInput.value = '';
      }
      if (e.key === 'Backspace' && !tagInput.value && tags.length) {
        tags.pop();
        renderTags();
      }
    });

    function renderTags() {
      tagWrap.querySelectorAll('.badge').forEach(t => t.remove());
      tags.forEach((tag, i) => {
        const t = document.createElement('span');
        t.className = 'badge badge-light-success rounded-pill px-3 py-2 fs-8 d-inline-flex align-items-center gap-1';
        t.innerHTML = tag + '<button type="button" class="btn-close btn-close-sm ms-1" style="font-size:9px;"></button>';
        t.querySelector('.btn-close').onclick = () => {
          tags.splice(i, 1);
          renderTags();
        };
        tagWrap.insertBefore(t, tagInput);
      });
    }

    // ── Editor helpers ──
    const editor = document.getElementById('dc-editor');

    function fmt(cmd, val = null) {
      editor.focus();
      document.execCommand(cmd, false, val);
    }

    function insertAtCursor(html) {
      editor.focus();
      const sel = window.getSelection();
      if (!sel.rangeCount) return;
      const range = sel.getRangeAt(0);
      range.deleteContents();
      const div = document.createElement('div');
      div.innerHTML = html;
      const frag = document.createDocumentFragment();
      let lastNode;
      while (div.firstChild) {
        lastNode = div.firstChild;
        frag.appendChild(div.firstChild);
      }
      range.insertNode(frag);
      if (lastNode) {
        const r2 = range.cloneRange();
        r2.setStartAfter(lastNode);
        r2.collapse(true);
        sel.removeAllRanges();
        sel.addRange(r2);
      }
    }

    function insertList(type) {
      editor.focus();
      document.execCommand(type === 'ol' ? 'insertOrderedList' : 'insertUnorderedList', false, null);
    }

    function insertCodeBlock() {
      insertAtCursor('<div class="dc-code-block" contenteditable="true" spellcheck="false">// Your code here...</div><p><br></p>');
    }

    function insertSpoiler() {
      insertAtCursor('<div class="dc-spoiler"><div class="dc-spoiler-label">⚠ Spoiler — click to reveal</div><div class="dc-spoiler-content" contenteditable="true">Hidden content here...</div></div><p><br></p>');
    }

    function insertTable() {
      const html = `<table class="dc-table-preview"><thead><tr>
        <th contenteditable="true">Header 1</th>
        <th contenteditable="true">Header 2</th>
        <th contenteditable="true">Header 3</th>
      </tr></thead><tbody><tr>
        <td contenteditable="true">Cell</td><td contenteditable="true">Cell</td><td contenteditable="true">Cell</td>
      </tr><tr>
        <td contenteditable="true">Cell</td><td contenteditable="true">Cell</td><td contenteditable="true">Cell</td>
      </tr></tbody></table><p><br></p>`;
      insertAtCursor(html);
    }

    let pollCount = 0;

    function insertPollBuilder() {
      pollCount++;
      const id = 'poll-' + pollCount;
      const html = `<div class="dc-poll-builder" id="${id}">
        <div class="dc-poll-builder-title">
          <span>📊 Poll Options</span>
          <button onclick="document.getElementById('${id}').remove()" style="background:none;border:none;color:#a1a5b7;cursor:pointer;font-size:13px;">Remove</button>
        </div>
        <div class="dc-poll-opts">
          <div class="dc-poll-opt-row"><span style="color:#b5b5c3;cursor:grab;">⠿</span><input type="text" placeholder="Option 1"><button class="dc-poll-opt-del" onclick="this.parentElement.remove()">×</button></div>
          <div class="dc-poll-opt-row"><span style="color:#b5b5c3;cursor:grab;">⠿</span><input type="text" placeholder="Option 2"><button class="dc-poll-opt-del" onclick="this.parentElement.remove()">×</button></div>
        </div>
        <button class="dc-poll-add" onclick="addPollOpt('${id}')">+ Add option</button>
      </div><p><br></p>`;
      insertAtCursor(html);
    }

    function addPollOpt(id) {
      const wrap = document.querySelector('#' + id + ' .dc-poll-opts');
      const n = wrap.querySelectorAll('.dc-poll-opt-row').length + 1;
      const row = document.createElement('div');
      row.className = 'dc-poll-opt-row';
      row.innerHTML = `<span style="color:#b5b5c3;cursor:grab;">⠿</span><input type="text" placeholder="Option ${n}"><button class="dc-poll-opt-del" onclick="this.parentElement.remove()">×</button>`;
      wrap.appendChild(row);
    }

    // ── Markdown toggle ──
    let mdMode = false;

    function toggleMarkdown(e) {
      e.preventDefault();
      mdMode = !mdMode;
      if (mdMode) {
        const md = editor.innerHTML
          .replace(/<b>(.*?)<\/b>/gi, '**$1**').replace(/<i>(.*?)<\/i>/gi, '_$1_')
          .replace(/<br\s*\/?>/gi, '\n').replace(/<[^>]+>/g, '')
          .replace(/&amp;/g, '&').replace(/&lt;/g, '<').replace(/&gt;/g, '>');
        editor.contentEditable = 'false';
        editor.style.display = 'none';
        let ta = document.getElementById('md-textarea');
        if (!ta) {
          ta = document.createElement('textarea');
          ta.id = 'md-textarea';
          ta.className = 'dc-editor-area';
          ta.style.borderTop = '1.5px solid #e4e6ef';
          ta.style.borderRadius = '0 0 8px 8px';
          editor.parentNode.insertBefore(ta, editor.nextSibling);
        }
        ta.value = md;
        ta.style.display = 'block';
        e.target.textContent = 'Switch to Visual';
      } else {
        const ta = document.getElementById('md-textarea');
        if (ta) {
          editor.innerHTML = ta.value.replace(/\n/g, '<br>');
          ta.style.display = 'none';
        }
        editor.contentEditable = 'true';
        editor.style.display = 'block';
        e.target.textContent = 'Switch to Markdown';
      }
    }

    // ── Modal helpers (Bootstrap 5) ──
    function openModal(id) {
      new bootstrap.Modal(document.getElementById(id)).show();
    }

    function closeModal(id) {
      bootstrap.Modal.getInstance(document.getElementById(id))?.hide();
    }

    function insertLink() {
      const txt = document.getElementById('link-text').value || document.getElementById('link-url').value;
      const url = document.getElementById('link-url').value;
      if (!url) return;
      insertAtCursor(`<a href="${url}" target="_blank" style="color:#2D6A4F;font-weight:600;">${txt}</a>`);
      closeModal('modal-link');
      document.getElementById('link-text').value = '';
      document.getElementById('link-url').value = '';
    }

    function insertImage() {
      const file = document.getElementById('img-file').files[0];
      const url = document.getElementById('img-url').value;
      const alt = document.getElementById('img-alt').value || 'Image';
      if (file) {
        const reader = new FileReader();
        reader.onload = e => {
          insertAtCursor(`<img src="${e.target.result}" alt="${alt}" class="dc-img-inserted">`);
        };
        reader.readAsDataURL(file);
      } else if (url) {
        insertAtCursor(`<img src="${url}" alt="${alt}" class="dc-img-inserted">`);
      }
      closeModal('modal-image');
      document.getElementById('img-url').value = '';
      document.getElementById('img-alt').value = '';
      document.getElementById('img-file').value = '';
    }

    function insertVideo() {
      let url = document.getElementById('video-url').value.trim();
      if (!url) return;
      const ytMatch = url.match(/(?:youtube\.com\/watch\?v=|youtu\.be\/)([A-Za-z0-9_-]{11})/);
      if (ytMatch) url = `https://www.youtube.com/embed/${ytMatch[1]}`;
      insertAtCursor(`<iframe class="dc-video-embed" src="${url}" allowfullscreen></iframe><p><br></p>`);
      closeModal('modal-video');
      document.getElementById('video-url').value = '';
    }

    // ── Submit / Discard ──
    function submitPost() {
      const title = document.getElementById('post_title').value.trim();
      if (!title) {
        document.getElementById('post_title').focus();
        return;
      }
      typeof KTApp !== 'undefined' && KTApp.showPageLoading();
      // TODO: AJAX submit
    }

    function discardPost() {
      if (confirm('Discard this post? Your changes will be lost.')) window.history.back();
    }

    function changeIdentity(event, text, avatarUrl) {
      event.preventDefault();
      document.getElementById('display_identity_text').innerText = text;
      document.getElementById('display_identity_avatar').src = avatarUrl;
      const links = document.querySelectorAll('#identityDropdown + .dropdown-menu .dropdown-item');
      links.forEach(link => link.classList.remove('active'));
      event.currentTarget.classList.add('active');
    }
  </script>
</body>

</html>