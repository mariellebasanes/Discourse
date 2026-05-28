<?php
define('MBG', TRUE);
include($_SERVER['DOCUMENT_ROOT'] . '/functions-new.php');

// IS_LOGGED_IN($_SERVER['REQUEST_URI']);
// $SQL = "SELECT * FROM posts WHERE slug = ?";

$META_TITLE = "Edit Post";
$META_DESC  = "Edit your existing post.";
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

              <div style="background: linear-gradient(135deg, #0b3220 0%, #1a5c38 60%, #2D6A4F 100%); padding: 28px 0 22px;">
                <div class="app-container container-xxl">
                  <div class="d-flex align-items-start justify-content-between">
                    <div>
                      <i class="bi bi-pencil-square text-white opacity-75 fs-7"></i>
                      <span class="text-white opacity-75 fs-8 fw-bold text-uppercase ls-1">Editing Post</span>
                      <h2 class="text-white fs-2 fw-bolder mb-1">Edit Post</h2>
                      <p class="text-white opacity-65 fs-6 mb-0">Make changes to your existing post.</p>
                    </div>
                    <a href="javascript:history.back();" class="btn btn-sm btn-light fw-bold mt-2">
                      <i class="bi bi-arrow-left me-1"></i> Back
                    </a>
                  </div>
                </div>
              </div>

              <div id="kt_app_content" class="flex-column-fluid">
                <div class="app-container container-xxl">
                  <div class="row g-5 align-items-start py-5">

                    <div class="col-lg-8">
                      <div class="card border-0 shadow-sm">

                        <div class="card-header border-0 bg-light d-flex align-items-center gap-3 px-5" style="min-height: 60px;">
                          <div class="d-flex align-items-center gap-3">
                            <div class="bg-light-success rounded-2 p-2 d-flex align-items-center justify-content-center" style="width:32px;height:32px;background-color:#e8ede9 !important;">
                              <i class="bi bi-pencil fs-6" style="color:#3a5c45"></i>
                            </div>
                            <h5 class="mb-0 fw-bold fs-6 text-gray-800">Edit Post Content</h5>
                          </div>
                        </div>

                        <div class="card-body p-5">

                          <div class="alert alert-warning d-flex align-items-center gap-2 mb-5">
                            <i class="bi bi-exclamation-triangle-fill text-warning flex-shrink-0"></i>
                            <span class="fs-7">Editing a post will mark it as <strong>edited</strong> with a timestamp visible to all readers. Significant changes to meaning are discouraged.</span>
                          </div>

                          <div class="mb-5">
                            <label class="form-label text-uppercase fw-bold text-gray-600 fs-8">
                              Title <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control form-control-solid" id="edit_title"
                              value="FEU Tech library study rooms — worth booking or just use the hallway?">
                          </div>

                          <div class="mb-5">
                            <label class="form-label text-uppercase fw-bold text-gray-600 fs-8">
                              Body <span class="text-muted fw-normal fs-8" style="text-transform:none;letter-spacing:0;">— optional</span>
                            </label>

                            <div class="dc-toolbar" id="edit-toolbar">
                              <button class="btn btn-sm btn-icon btn-light-success" style="background-color:#e8ede9;color:#3a5c45;" title="Bold" onclick="fmt('bold')"><b>B</b></button>
                              <button class="btn btn-sm btn-icon btn-light-success" title="Italic" onclick="fmt('italic')">
                                <i style="font-style:italic;color:#3a5c45;">I</i>
                              </button> 
                              <button class="btn btn-sm btn-icon btn-light-success" style="background-color:#e8ede9;color:#3a5c45;" title="Strikethrough" onclick="fmt('strikeThrough')"><s>S</s></button>
                              <button class="btn btn-sm btn-icon btn-light-success" style="background-color:#e8ede9;color:#3a5c45;" title="Superscript" onclick="fmt('superscript')">x<sup>2</sup></button>
                              <button class="btn btn-sm btn-icon btn-light-success" style="background-color:#e8ede9;color:#3a5c45;" title="Paragraph" onclick="fmt('formatBlock','p')">¶T</button>
                              <span class="dc-tb-sep"></span>
                              <button class="btn btn-sm btn-icon btn-light-success" style="background-color:#e8ede9;color:#3a5c45;" title="Insert Link" onclick="openModal('modal-link')">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                  <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71" />
                                  <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71" />
                                </svg>
                              </button>
                              <button class="btn btn-sm btn-icon btn-light-success" style="background-color:#e8ede9;color:#3a5c45;" title="Insert Image" onclick="document.getElementById('replaceImageInput').click()">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                  <rect x="3" y="3" width="18" height="18" rx="2" />
                                  <circle cx="8.5" cy="8.5" r="1.5" />
                                  <polyline points="21 15 16 10 5 21" />
                                </svg>
                              </button>
                              <button class="btn btn-sm btn-icon btn-light-success" style="background-color:#e8ede9;color:#3a5c45;" title="Embed Video" onclick="openModal('modal-video')">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                  <circle cx="12" cy="12" r="10" />
                                  <polygon points="10 8 16 12 10 16 10 8" />
                                </svg>
                              </button>
                              <span class="dc-tb-sep"></span>
                              <button class="btn btn-sm btn-icon btn-light-success" style="background-color:#e8ede9;color:#3a5c45;" title="Ordered List" onclick="insertList('ol')">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                  <line x1="9" y1="6" x2="20" y2="6" />
                                  <line x1="9" y1="12" x2="20" y2="12" />
                                  <line x1="9" y1="18" x2="20" y2="18" />
                                  <path d="M4 6h1v4" />
                                  <path d="M4 10h2" />
                                  <path d="M6 18H4c0-1 2-2 2-3s-1-1.5-2-1" />
                                </svg>
                              </button>
                              <button class="btn btn-sm btn-icon btn-light-success" style="background-color:#e8ede9;color:#3a5c45;" title="Unordered List" onclick="insertList('ul')">
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
                              <button class="btn btn-sm btn-icon btn-light-success" style="background-color:#e8ede9;color:#3a5c45;" title="Inline Code" onclick="fmt('insertHTML','<code style=&quot;background:#f0faf5;border-radius:4px;padding:1px 5px;font-family:monospace;font-size:12px;color:#1a5c38;&quot;>code</code>')">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                  <polyline points="16 18 22 12 16 6" />
                                  <polyline points="8 6 2 12 8 18" />
                                </svg>
                              </button>
                              <button class="btn btn-sm btn-icon btn-light-success" style="background-color:#e8ede9;color:#3a5c45;" title="Blockquote" onclick="fmt('formatBlock','blockquote')">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                  <path d="M3 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2H4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2 1 0 1 0 1 1v1c0 1-1 2-2 2s-1 .008-1 1.031V20c0 1 0 1 1 1zm12 0c3 0 7-1 7-8V5c0-1.25-.757-2.017-2-2h-4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2 1 0 1 0 1 1v1c0 1-1 2-2 2s-1 .008-1 1.031V20c0 1 0 1 1 1z" />
                                </svg>
                              </button>
                              <button class="btn btn-sm btn-icon btn-light-success" style="background-color:#e8ede9;color:#3a5c45;" title="Code Block" onclick="insertCodeBlock()">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                  <polyline points="16 18 22 12 16 6" />
                                  <polyline points="8 6 2 12 8 18" />
                                  <line x1="12" y1="3" x2="12" y2="21" stroke-width="1.5" />
                                </svg>
                              </button>
                              <button class="btn btn-sm btn-icon btn-light-success" style="background-color:#e8ede9;color:#3a5c45;" title="Spoiler" onclick="insertSpoiler()">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                  <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94" />
                                  <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19" />
                                  <line x1="1" y1="1" x2="23" y2="23" />
                                </svg>
                              </button>
                              <button class="btn btn-sm btn-icon btn-light-success" style="background-color:#e8ede9;color:#3a5c45;" title="Insert Table" onclick="insertTable()">
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

                            <div id="edit_body_editor" class="dc-editor-area" contenteditable="true"
                              data-placeholder="Body text (optional)">Finally tried booking one of the new study rooms in the library. Honest review: the booking system is clunky, the AC is questionable, but the soundproofing is actually great. Worth it for group study if you plan ahead.<br><br>Not ideal for solo cramming though — the chairs are surprisingly uncomfortable for long sessions.</div>

                            <div class="dc-image-wrapper" id="imageWrapper" style="display:block;">
                              <img src="https://www.feu.edu.ph/wp-content/uploads/2023/06/thumbnail__a3-1.jpg"
                                alt="Attached image" class="dc-img-inserted" id="attachedImage"
                                style="max-height:220px;width:100%;object-fit:cover;margin:0;">
                              <div class="dc-image-overlay">
                                <button class="dc-image-action-btn dc-image-replace-btn"
                                  onclick="document.getElementById('replaceImageInput').click()" title="Replace image">
                                  <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                    <polyline points="17 8 12 3 7 8" />
                                    <line x1="12" y1="3" x2="12" y2="15" />
                                  </svg>
                                  Replace
                                </button>
                                <button class="dc-image-action-btn dc-image-remove-btn" onclick="removeImage()" title="Remove image">
                                  <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <polyline points="3 6 5 6 21 6" />
                                    <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                                    <path d="M10 11v6" />
                                    <path d="M14 11v6" />
                                    <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2" />
                                  </svg>
                                  Remove
                                </button>
                              </div>
                            </div>

                            <div class="dc-no-image-placeholder" id="noImagePlaceholder"
                              onclick="document.getElementById('replaceImageInput').click()">
                              <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#c8e6c9" stroke-width="1.5" style="display:block;margin:0 auto 6px;">
                                <rect x="3" y="3" width="18" height="18" rx="2" />
                                <circle cx="8.5" cy="8.5" r="1.5" />
                                <polyline points="21 15 16 10 5 21" />
                              </svg>
                              Click to add an image
                            </div>

                            <input type="file" id="replaceImageInput" accept="image/*" class="d-none" onchange="replaceImage(event)">

                            <div class="dc-media-bar">
                              <button class="btn btn-sm btn-light text-gray-600 d-inline-flex align-items-center gap-1" onclick="document.getElementById('replaceImageInput').click()">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                  <rect x="3" y="3" width="18" height="18" rx="2" />
                                  <circle cx="8.5" cy="8.5" r="1.5" />
                                  <polyline points="21 15 16 10 5 21" />
                                </svg>
                                Image
                              </button>
                              <button class="btn btn-sm btn-light text-gray-600 d-inline-flex align-items-center gap-1">
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
                              <button class="btn btn-sm btn-light text-gray-600 d-inline-flex align-items-center gap-1">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                  <line x1="18" y1="20" x2="18" y2="10" />
                                  <line x1="12" y1="20" x2="12" y2="4" />
                                  <line x1="6" y1="20" x2="6" y2="14" />
                                </svg>
                                Poll
                              </button>
                            </div>
                          </div>
                          <div class="mt-5">
                            <div class="p-1">
                              <h6 class="text-uppercase fw-bold text-gray-600 fs-8 mb-4 d-flex align-items-center gap-2">
                                <i class="bi bi-clock text-gray-600"></i> Edit History
                              </h6>

                              <div class="d-flex align-items-center gap-3 py-2">
                                <span class="rounded-circle flex-shrink-0" style="width:8px;height:8px;display:inline-block;background-color:#3a5c45;"></span>
                                <div>
                                  <span class="fw-bold text-gray-900 fs-7">New</span>
                                  <span class="text-muted fs-8"> — current version being edited</span>
                                </div>
                              </div>

                              <div class="d-flex align-items-center gap-3 py-2">
                                <span class="rounded-circle bg-gray-400 flex-shrink-0" style="width: 8px; height: 8px;"></span>
                                <div>
                                  <span class="fw-bold text-gray-600 fs-7">Original</span>
                                  <span class="text-muted fs-8"> — published version</span>
                                </div>
                              </div>

                            </div>
                          </div>

                        </div>
                      </div>
                    </div>
                    <div class="col-lg-4">

                      <div class="card border-0 shadow-sm mb-5">
                        <div class="card-body p-5">
                          <p class="fs-6 text-gray-600 mb-5">Your edits will be visible to everyone in the community.</p>
                          <button class="btn btn-success w-100 fw-bold" onclick="savePost()">
                            <i class="bi bi-check-lg me-1"></i> Save Changes
                          </button>
                          <button class="btn btn-light w-100 fw-bold mt-3" onclick="history.back()">Cancel</button>
                        </div>
                      </div>

                      <div class="card border border-danger mb-5" style="background:#fff5f5;">
                        <div class="card-body p-4">
                          <h6 class="text-uppercase fw-bold text-danger fs-8 mb-3 d-flex align-items-center gap-2">
                            <i class="bi bi-exclamation-triangle-fill"></i> Danger Zone
                          </h6>
                          <p class="fs-7 text-muted mb-4">Permanently remove this post and all its comments. This cannot be undone.</p>
                          <button class="btn btn-light-danger w-100 fw-bold" onclick="confirmDelete()">
                            <i class="bi bi-trash me-1"></i> Delete Post
                          </button>
                        </div>
                      </div>

                      <div class="card border-0 shadow-sm mb-5">
                        <div class="card-header border-0 bg-light d-flex align-items-center gap-3 px-5" style="min-height: 60px;">
                          <div class="d-flex align-items-center gap-3">
                            <div class="bg-light-success rounded-2 p-2 d-flex align-items-center justify-content-center" style="width:32px;height:32px;background-color:#e8ede9 !important;">
                              <i class="bi bi-info-circle fs-6"style="color:#3a5c45;"></i>
                            </div>
                            <h5 class="mb-0 fw-bold fs-6 text-gray-800">Edit Guidelines</h5>
                          </div>
                        </div>
                        <div class="card-body p-5">
                          <ul class="list-unstyled d-flex flex-column gap-3 mb-0">
                            <li class="d-flex align-items-start gap-3 fs-7 text-gray-600">
                              <span class="fw-bold flex-shrink-0"style="color:#3a5c45;">✓</span>
                              <span>Keep your <strong>title</strong> clear and informative for better discoverability</span>
                            </li>
                            <li class="d-flex align-items-start gap-3 fs-7 text-gray-600">
                              <span class="fw-bold flex-shrink-0"style="color:#3a5c45;">✓</span>
                              <span>Substantial edits may be <strong>flagged</strong> to show the post was modified</span>
                            </li>
                            <li class="d-flex align-items-start gap-3 fs-7 text-gray-600">
                              <span class="fw-bold flex-shrink-0"style="color:#3a5c45;">✓</span>
                              <span>You can <strong>delete</strong> a post from the danger zone if needed</span>
                            </li>
                          </ul>
                        </div>
                      </div>

                      <div class="card border bg-light-success" style="background-color:#e8ede9;border-color:#c2d4c8 !important;">
                        <div class="card-body p-5">
                          <p class="fs-6 fw-bold mb-3" style="color:#3a5c45;">Community Rules</p>
                          <ul class="list-unstyled d-flex flex-column gap-2 mb-0">
                            <li class="d-flex align-items-start gap-2 fs-7 "style="color:#3a5c45;"><span class="fw-bold flex-shrink-0" >✓</span>Be respectful and constructive</li>
                            <li class="d-flex align-items-start gap-2 fs-7 "style="color:#3a5c45;"><span class="fw-bold flex-shrink-0" >✓</span>No personal attacks or harassment</li>
                            <li class="d-flex align-items-start gap-2 fs-7 "style="color:#3a5c45;"><span class="fw-bold flex-shrink-0" >✓</span>Keep posts relevant to FEU Tech</li>
                            <li class="d-flex align-items-start gap-2 fs-7 "style="color:#3a5c45;"><span class="fw-bold flex-shrink-0" >✓</span>Verify information before sharing</li>
                          </ul>
                        </div>
                      </div>

                    </div>
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
    const editor = document.getElementById('edit_body_editor');

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
      const html = `<table style="border-collapse:collapse;width:100%;margin:8px 0;"><thead><tr>
        <th contenteditable="true" style="border:1px solid #e4e6ef;padding:6px 10px;background:#f0faf5;font-size:13px;">Header 1</th>
        <th contenteditable="true" style="border:1px solid #e4e6ef;padding:6px 10px;background:#f0faf5;font-size:13px;">Header 2</th>
        <th contenteditable="true" style="border:1px solid #e4e6ef;padding:6px 10px;background:#f0faf5;font-size:13px;">Header 3</th>
      </tr></thead><tbody><tr>
        <td contenteditable="true" style="border:1px solid #e4e6ef;padding:6px 10px;font-size:13px;">Cell</td>
        <td contenteditable="true" style="border:1px solid #e4e6ef;padding:6px 10px;font-size:13px;">Cell</td>
        <td contenteditable="true" style="border:1px solid #e4e6ef;padding:6px 10px;font-size:13px;">Cell</td>
      </tr></tbody></table><p><br></p>`;
      insertAtCursor(html);
    }

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
          ta.style.display = 'block';
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

    function removeImage() {
      document.getElementById('imageWrapper').style.display = 'none';
      document.getElementById('noImagePlaceholder').style.display = 'block';
    }

    function replaceImage(event) {
      const file = event.target.files[0];
      if (!file) return;
      const reader = new FileReader();
      reader.onload = function(e) {
        document.getElementById('attachedImage').src = e.target.result;
        document.getElementById('imageWrapper').style.display = 'block';
        document.getElementById('noImagePlaceholder').style.display = 'none';
      };
      reader.readAsDataURL(file);
      event.target.value = '';
    }

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
      insertAtCursor(`<a href="${url}" target="_blank" style="color:#3a5c45;font-weight:600;">${txt}</a>`);
      closeModal('modal-link');
      document.getElementById('link-text').value = '';
      document.getElementById('link-url').value = '';
    }

    function insertVideo() {
      let url = document.getElementById('video-url').value.trim();
      if (!url) return;
      const ytMatch = url.match(/(?:youtube\.com\/watch\?v=|youtu\.be\/)([A-Za-z0-9_-]{11})/);
      if (ytMatch) url = `https://www.youtube.com/embed/${ytMatch[1]}`;
      insertAtCursor(`<iframe style="width:100%;aspect-ratio:16/9;border-radius:8px;margin:8px 0;border:none;" src="${url}" allowfullscreen></iframe><p><br></p>`);
      closeModal('modal-video');
      document.getElementById('video-url').value = '';
    }

    function savePost() {
      const title = document.getElementById('edit_title').value.trim();
      if (!title) {
        document.getElementById('edit_title').focus();
        return;
      }
      typeof KTApp !== 'undefined' && KTApp.showPageLoading();
    }

    function confirmDelete() {
      if (confirm('Are you sure you want to permanently delete this post? This cannot be undone.')) {
        typeof KTApp !== 'undefined' && KTApp.showPageLoading();
      }
    }
  </script>
</body>

</html>