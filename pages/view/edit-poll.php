<?php
define('MBG', TRUE);
include($_SERVER['DOCUMENT_ROOT'] . '/functions-new.php');

// IS_LOGGED_IN($_SERVER['REQUEST_URI']);
// $SQL = "SELECT * FROM polls WHERE slug = ?";

$META_TITLE = "Edit Poll";
$META_DESC  = "Edit your existing poll.";
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

              <div style="background: linear-gradient(135deg, #0b3220 0%, #1a5c38 60%, #2D6A4F 100%); padding: 30px 0;">
                <div class="app-container container-xxl">
                  <div class="d-flex align-items-center justify-content-between">
                    <div>
                      <div class="d-flex align-items-center gap-2 mb-1">
                        <i class="bi bi-pencil-square text-white opacity-75 fs-6"></i>
                        <span class="text-white opacity-75 fs-8 fw-bold text-uppercase ls-1">Editing Poll</span>
                      </div>
                      <h2 class="text-white fs-2 fw-bolder mb-1">Edit Poll</h2>
                      <p class="text-white opacity-65 fs-6 mb-0">Update your poll question, options, or settings.</p>
                    </div>
                    <div>
                      <a href="javascript:history.back();" class="btn btn-sm btn-light fw-bold">
                        <i class="bi bi-arrow-left me-1"></i> Back
                      </a>
                    </div>
                  </div>
                </div>
              </div>

              <div id="kt_app_content" class="flex-column-fluid">
                <div class="app-container container-xxl">
                  <div class="row g-5 align-items-start py-5">

                    <div class="col-lg-8">
                      <div class="card border-0 shadow-sm">

                        <div class="card-header border-0 bg-light py-4">
                          <div class="d-flex align-items-center gap-3 w-100">
                            <div class="bg-light-success rounded-2 p-2 d-flex align-items-center justify-content-center" style="width:32px;height:32px;background-color:#e8ede9 !important;">
                              <i class="bi bi-bar-chart fs-6" style="color:#3a5c45;"></i>
                            </div>
                            <h5 class="card-title mb-0 fw-bold fs-6">Edit Poll</h5>
                          </div>
                        </div>

                        <div class="card-body p-5">

                          <div class="mb-5">
                            <label class="form-label text-uppercase fw-bold text-gray-600 fs-8">
                              Poll Question / Title <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control form-control-solid" id="poll_title"
                              value="What's the hardest part of the CS program at FEU Tech?">
                          </div>

                          <div class="mb-5">
                            <label class="form-label text-uppercase fw-bold text-gray-600 fs-8">Context</label>

                            <div class="dc-toolbar" id="poll-edit-toolbar">
                              <button class="btn btn-sm btn-icon btn-light-success" style="background-color:#e8ede9;color:#3a5c45;" title="Bold" onclick="fmt('bold')"><b>B</b></button>
                              <button class="btn btn-sm btn-icon btn-light-success" style="background-color:#e8ede9;" title="Italic" onclick="fmt('italic')">
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
                              <button class="btn btn-sm btn-icon btn-light-success" style="background-color:#e8ede9;color:#3a5c45;" title="Insert Image" onclick="document.getElementById('pollReplaceImageInput').click()">
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

                            <div id="poll_context_editor" class="dc-editor-area" contenteditable="true"
                              data-placeholder="Add some context for your poll (optional)"
                              style="height:300px !important;overflow-y:auto !important;">Been talking to a lot of classmates lately and everyone seems to struggle with different things. Curious what the community thinks — drop your vote below!</div>

                            <div class="dc-image-wrapper" id="pollImageWrapper">
                              <div class="dc-image-overlay">
                                <button class="dc-image-action-btn dc-image-replace-btn"
                                  onclick="document.getElementById('pollReplaceImageInput').click()" title="Replace image">
                                  <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                    <polyline points="17 8 12 3 7 8" />
                                    <line x1="12" y1="3" x2="12" y2="15" />
                                  </svg>
                                  Replace
                                </button>
                                <button class="dc-image-action-btn dc-image-remove-btn" onclick="pollRemoveImage()" title="Remove image">
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

                            <div class="dc-no-image-placeholder" id="pollNoImagePlaceholder"
                              onclick="document.getElementById('pollReplaceImageInput').click()">
                              <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#c8e6c9" stroke-width="1.5" style="display:block;margin:0 auto 6px;">
                                <rect x="3" y="3" width="18" height="18" rx="2" />
                                <circle cx="8.5" cy="8.5" r="1.5" />
                                <polyline points="21 15 16 10 5 21" />
                              </svg>
                              Click to add an image
                            </div>

                            <input type="file" id="pollReplaceImageInput" accept="image/*" class="d-none" onchange="pollReplaceImage(event)">

                            <div class="dc-media-bar">
                              <button class="btn btn-sm btn-light text-gray-600 d-inline-flex align-items-center gap-1" onclick="document.getElementById('pollReplaceImageInput').click()">
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
                            </div>
                          </div>

                          <div class="mb-5">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                              <span class="text-uppercase fw-bold text-gray-600 fs-8">Current Vote Results</span>
                              <span class="fs-8 text-muted">Votes shown are locked — options cannot be deleted</span>
                            </div>

                            <div class="d-flex align-items-center gap-2 p-3 bg-light border rounded-3 mb-2" id="opt-0">
                              <span class="text-muted fs-6" style="cursor:grab;">⠿</span>
                              <input type="text" class="form-control form-control-solid flex-grow-1" value="Math subjects (Calculus, Discrete Math)">
                              <span class="text-muted fs-8 fw-semibold text-nowrap">41 votes</span>
                              <button class="btn btn-sm btn-icon btn-light" title="Remove option" disabled style="opacity:0.35;cursor:not-allowed;">
                                <i class="ki-duotone ki-cross fs-6"><span class="path1"></span><span class="path2"></span></i>
                              </button>
                            </div>

                            <div class="d-flex align-items-center gap-2 p-3 bg-light border rounded-3 mb-2" id="opt-1">
                              <span class="text-muted fs-6" style="cursor:grab;">⠿</span>
                              <input type="text" class="form-control form-control-solid flex-grow-1" value="Programming fundamentals in 1st year">
                              <span class="text-muted fs-8 fw-semibold text-nowrap">28 votes</span>
                              <button class="btn btn-sm btn-icon btn-light" title="Remove option" disabled style="opacity:0.35;cursor:not-allowed;">
                                <i class="ki-duotone ki-cross fs-6"><span class="path1"></span><span class="path2"></span></i>
                              </button>
                            </div>

                            <div class="d-flex align-items-center gap-2 p-3 bg-light border rounded-3 mb-2" id="opt-2">
                              <span class="text-muted fs-6" style="cursor:grab;">⠿</span>
                              <input type="text" class="form-control form-control-solid flex-grow-1" value="Thesis / capstone requirements">
                              <span class="text-muted fs-8 fw-semibold text-nowrap">89 votes</span>
                              <button class="btn btn-sm btn-icon btn-light" title="Remove option" disabled style="opacity:0.35;cursor:not-allowed;">
                                <i class="ki-duotone ki-cross fs-6"><span class="path1"></span><span class="path2"></span></i>
                              </button>
                            </div>

                            <div class="d-flex align-items-center gap-2 p-3 bg-light border rounded-3 mb-2" id="opt-3">
                              <span class="text-muted fs-6" style="cursor:grab;">⠿</span>
                              <input type="text" class="form-control form-control-solid flex-grow-1" value="Balancing acads with org life">
                              <span class="text-muted fs-8 fw-semibold text-nowrap">47 votes</span>
                              <button class="btn btn-sm btn-icon btn-light" title="Remove option" disabled style="opacity:0.35;cursor:not-allowed;">
                                <i class="ki-duotone ki-cross fs-6"><span class="path1"></span><span class="path2"></span></i>
                              </button>
                            </div>

                            <div id="new-options-wrap"></div>

                            <button class="btn btn-light-success w-100 fw-bold border border-dashed mt-2" onclick="addPollOption()" type="button" style="background-color:#e8ede9;color:#3a5c45;border-color:#c2d4c8 !important;">
                              <i class="ki-duotone ki-plus fs-5 me-1" style="color:#3a5c45;"><span class="path1"></span><span class="path2"></span></i>
                              Add another option
                            </button>

                            <div class="alert alert-warning d-flex align-items-start gap-2 mt-4 mb-0">
                              <i class="bi bi-info-circle-fill text-warning flex-shrink-0 mt-1"></i>
                              <span class="fs-7">You can <strong>rename poll options</strong> and add new ones. Existing vote counts are preserved. You cannot remove an option that already has votes cast for it.</span>
                            </div>
                          </div>

                          <div class="mb-5">
                            <div class="row g-4">
                              <div class="col-sm-6">
                                <label class="form-label text-uppercase fw-bold text-gray-600 fs-8">Poll Duration</label>
                                <select class="form-select form-select-solid" id="poll_duration">
                                  <option>1 day</option>
                                  <option>3 days</option>
                                  <option selected>5 days</option>
                                  <option>7 days</option>
                                  <option>14 days</option>
                                  <option>30 days</option>
                                  <option>No limit</option>
                                </select>
                                <small class="text-muted d-block mt-1 fs-8">Time remaining when you save</small>
                              </div>
                              <div class="col-sm-6">
                                <label class="form-label text-uppercase fw-bold text-gray-600 fs-8">Allow Multiple Votes</label>
                                <div class="d-flex align-items-center justify-content-between p-3 bg-light border rounded-3">
                                  <div>
                                    <span class="fs-6 fw-semibold text-gray-800 d-block">Single choice</span>
                                    <span class="fs-8 text-muted">Allow only one vote</span>
                                  </div>
                                  <label class="dc-toggle mb-0">
                                    <input type="checkbox" id="multi_vote">
                                    <span class="dc-toggle-slider"></span>
                                  </label>
                                </div>
                              </div>
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
                                <span class="rounded-circle bg-gray-400 flex-shrink-0" style="width:8px;height:8px;"></span>
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
                          <button class="btn w-100 fw-bold" style="background-color:#1a4731;color:#fff;" onclick="savePoll()">
                            <i class="bi bi-check-lg me-1"></i> Save Changes
                          </button>
                          <button class="btn btn-light w-100 fw-bold mt-3" onclick="history.back()">Cancel</button>
                        </div>
                      </div>

                      <div class="card border-0 bg-light mb-5">
                        <div class="card-body p-5">
                          <h6 class="text-uppercase fw-bold text-gray-600 fs-8 mb-4 d-flex align-items-center gap-2">
                            <i class="bi bi-bar-chart text-gray-600"></i> Poll State
                          </h6>
                          <div class="d-flex justify-content-between align-items-center py-3 border-bottom border-gray-200">
                            <span class="fs-7 text-muted">Total votes</span>
                            <span class="fs-7 fw-bold text-gray-800">225</span>
                          </div>
                          <div class="d-flex justify-content-between align-items-center py-3 border-bottom border-gray-200">
                            <span class="fs-7 text-muted">Options</span>
                            <span class="fs-7 fw-bold text-gray-800">4</span>
                          </div>
                          <div class="d-flex justify-content-between align-items-center py-3 border-bottom border-gray-200">
                            <span class="fs-7 text-muted">Leading option</span>
                            <span class="fs-7 fw-bold text-gray-800">Thesis/Capstone</span>
                          </div>
                          <div class="d-flex justify-content-between align-items-center py-3">
                            <span class="fs-7 text-muted">Time left</span>
                            <span class="fs-7 fw-bold text-gray-800">2 days left</span>
                          </div>
                        </div>
                      </div>

                      <div class="card border border-danger mb-5" style="background:#fff5f5;">
                        <div class="card-body p-5">
                          <h6 class="text-uppercase fw-bold text-danger fs-8 mb-3 d-flex align-items-center gap-2">
                            <i class="bi bi-exclamation-triangle-fill"></i> Danger Zone
                          </h6>
                          <p class="fs-7 text-muted mb-4">Permanently remove this post and all its contents. This cannot be undone.</p>
                          <button class="btn btn-light-danger w-100 fw-bold" onclick="confirmDelete()">
                            <i class="bi bi-trash me-1"></i> Delete Post
                          </button>
                        </div>
                      </div>

                      <div class="card border-0 shadow-sm mb-5">
                        <div class="card-header border-0 bg-light py-4 ps-7">
                          <div class="d-flex align-items-center gap-3 w-100">
                            <div class="bg-light-success rounded-2 p-2 d-flex align-items-center justify-content-center" style="width:32px;height:32px;background-color:#e8ede9 !important;">
                              <i class="bi bi-info-circle fs-6" style="color:#3a5c45;"></i>
                            </div>
                            <h5 class="card-title mb-0 fw-bold fs-6">Edit Guidelines</h5>
                          </div>
                        </div>
                        <div class="card-body p-5">
                          <ul class="list-unstyled d-flex flex-column gap-3 mb-0">
                            <li class="d-flex align-items-start gap-2 fs-7 text-gray-600"><span class="fw-bold flex-shrink-0" style="color:#3a5c45;">✓</span><span>Keep your <strong>title</strong> clear and informative for better discoverability</span></li>
                            <li class="d-flex align-items-start gap-2 fs-7 text-gray-600"><span class="fw-bold flex-shrink-0" style="color:#3a5c45;">✓</span><span>Substantial edits may be <strong>flagged</strong> to show the post was modified</span></li>
                            <li class="d-flex align-items-start gap-2 fs-7 text-gray-600"><span class="fw-bold flex-shrink-0" style="color:#3a5c45;">✓</span><span>You can <strong>delete</strong> a post from the danger zone if needed</span></li>
                            <li class="d-flex align-items-start gap-2 fs-7 text-gray-600"><span class="fw-bold flex-shrink-0" style="color:#3a5c45;">✓</span><span>For polls, only option labels can be changed; votes already cast remain valid</span></li>
                          </ul>
                        </div>
                      </div>

                      <div class="card border mb-5" style="background-color:#e8ede9;border-color:#c2d4c8 !important;">
                        <div class="card-body p-5">
                          <p class="fs-6 fw-bold mb-3" style="color:#3a5c45;">Community Rules</p>
                          <ul class="list-unstyled d-flex flex-column gap-3 mb-0">
                            <li class="d-flex align-items-start gap-2 fs-7" style="color:#3a5c45;"><span class="fw-bold flex-shrink-0">✓</span><span>Be respectful and constructive</span></li>
                            <li class="d-flex align-items-start gap-2 fs-7" style="color:#3a5c45;"><span class="fw-bold flex-shrink-0">✓</span><span>No personal attacks or harassment</span></li>
                            <li class="d-flex align-items-start gap-2 fs-7" style="color:#3a5c45;"><span class="fw-bold flex-shrink-0">✓</span><span>Keep posts relevant to FEU Tech</span></li>
                            <li class="d-flex align-items-start gap-2 fs-7" style="color:#3a5c45;"><span class="fw-bold flex-shrink-0">✓</span><span>Verify information before sharing</span></li>
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
    // ── Context editor (copied from edit-post) ──
    const editor = document.getElementById('poll_context_editor');

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
      while (div.firstChild) { lastNode = div.firstChild; frag.appendChild(div.firstChild); }
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
        let ta = document.getElementById('poll-md-textarea');
        if (!ta) {
          ta = document.createElement('textarea');
          ta.id = 'poll-md-textarea';
          ta.className = 'dc-editor-area';
          ta.style.borderTop = '1.5px solid #e4e6ef';
          editor.parentNode.insertBefore(ta, editor.nextSibling);
        }
        ta.value = md;
        ta.style.display = 'block';
        e.target.textContent = 'Switch to Visual';
      } else {
        const ta = document.getElementById('poll-md-textarea');
        if (ta) { editor.innerHTML = ta.value.replace(/\n/g, '<br>'); ta.style.display = 'none'; }
        editor.contentEditable = 'true';
        editor.style.display = 'block';
        e.target.textContent = 'Switch to Markdown';
      }
    }

    function pollRemoveImage() {
      document.getElementById('pollImageWrapper').style.display = 'none';
      document.getElementById('pollNoImagePlaceholder').style.display = 'block';
    }

    function pollReplaceImage(event) {
      const file = event.target.files[0];
      if (!file) return;
      const reader = new FileReader();
      reader.onload = function(e) {
        let img = document.getElementById('pollAttachedImage');
        if (!img) {
          img = document.createElement('img');
          img.id = 'pollAttachedImage';
          img.className = 'dc-img-inserted';
          img.style.cssText = 'max-height:220px;width:100%;object-fit:cover;margin:0;';
          document.getElementById('pollImageWrapper').prepend(img);
        }
        img.src = e.target.result;
        document.getElementById('pollImageWrapper').style.display = 'block';
        document.getElementById('pollNoImagePlaceholder').style.display = 'none';
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

    // ── Poll options ──
    let newOptionCount = 0;

    function addPollOption() {
      newOptionCount++;
      const wrap = document.getElementById('new-options-wrap');
      const row = document.createElement('div');
      row.className = 'd-flex align-items-center gap-2 p-3 bg-light border rounded-3 mb-2';
      row.id = 'new-opt-' + newOptionCount;
      row.innerHTML = `
        <span class="text-muted fs-6" style="cursor:grab;">⠿</span>
        <input type="text" class="form-control form-control-solid flex-grow-1" placeholder="New option ${newOptionCount}...">
        <span class="text-muted fs-8 fw-semibold text-nowrap">0 votes</span>
        <button class="btn btn-sm btn-icon btn-light-danger" title="Remove option" onclick="removeOption('new-opt-${newOptionCount}')" type="button">
          <i class="ki-duotone ki-cross fs-6"><span class="path1"></span><span class="path2"></span></i>
        </button>
      `;
      wrap.appendChild(row);
      row.querySelector('input').focus();
    }

    function removeOption(id) {
      const el = document.getElementById(id);
      if (el) el.remove();
    }

    function savePoll() {
      const title = document.getElementById('poll_title').value.trim();
      if (!title) {
        document.getElementById('poll_title').focus();
        return;
      }
      KTApp && KTApp.showPageLoading();
      // TODO: AJAX save
    }

    function confirmDelete() {
      if (confirm('Are you sure you want to permanently delete this poll? This cannot be undone.')) {
        KTApp && KTApp.showPageLoading();
        // TODO: AJAX delete
      }
    }
  </script>
</body>

</html>