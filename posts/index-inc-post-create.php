<?php
define('MBG', TRUE);
include_once(dirname(__DIR__) . '/functions-new.php');

// Fetch all communities
$db_communities = [];
if ($EDITH) {
    $res = $EDITH->query("SELECT * FROM communities ORDER BY title ASC");
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $db_communities[] = $row;
        }
    }
}

// Build community to topics map
$community_topics_map = [
    "" => ["Technology", "Culture", "Gaming", "FEU", "Ideas", "Creative", "Science", "News", "AI", "Academics", "Lifestyle", "Entertainment", "Music", "Politics", "Issues", "Sports", "Others"]
];

$seed_defaults = [
    "FEU LIFE" => ["FEULife", "CampusLife", "Enrollment", "Events"],
    "FEU ALABANG LIFE" => ["AlabangLife", "CampusLife", "Enrollment", "Events"],
    "Freshies" => ["Freshies", "Advice", "General"],
    "Enrollment" => ["Enrollment", "Diliman", "Requirements"],
    "Cosplaying" => ["Cosplay", "Anime", "Gaming", "Events"],
    "FEU TECH DEV" => ["Development", "Programming", "WebDev", "Projects"],
    "Food Trip Around TECH" => ["Food", "Restaurants", "TechArea"],
    "Thesis Advice" => ["Thesis", "Advice", "Research", "Defense"],
    "Alabang Innovators" => ["Startups", "Innovation", "Tech"],
    "Diliman Artists" => ["Art", "Creative", "Design"],
    "Tech Support" => ["TechSupport", "IT", "Help"],
    "Study Group" => ["Study", "Groups", "Academics"]
];

foreach ($db_communities as $comm) {
    $title = $comm['title'];
    $title_key = str_replace(' ', '', strtolower($title));
    
    // If community has custom topics, use ONLY those
    if (!empty($comm['custom_topics'])) {
        $topics = array_filter(array_map('trim', explode(',', $comm['custom_topics'])));
        $topics = array_values($topics);
    } else {
        // Fall back to seed defaults or general
        $topics = ["GENERAL"];
        foreach ($seed_defaults as $s_title => $s_topics) {
            if (str_replace(' ', '', strtolower($s_title)) === $title_key) {
                $topics = $s_topics;
                break;
            }
        }
    }
    $community_topics_map[$title] = $topics;
}

// Read default selected community from query parameter
$default_community = isset($_GET['c']) ? trim($_GET['c']) : '';


$META_TITLE = "Create a Post - Discourse";

// Generate initials for the current logged-in user
$name_parts = explode(' ', $ACCOUNT['display_name'] ?? 'Yourself');
$initials = '';
foreach ($name_parts as $part) {
    $initials .= strtoupper(substr($part, 0, 1));
}
$initials = substr($initials, 0, 2);
if (empty($initials)) {
    $initials = 'Y';
}
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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="/Discourse/assets/css/sec-modals.css?v=1.0.1" rel="stylesheet">

  <!-- jQuery -->
  <script src="/Discourse/assets/js/jquery.js"></script>

  <link href="/Discourse/assets/css/discourse-css/create-post.css" rel="stylesheet" type="text/css" />
  <link href="/Discourse/assets/css/dc-editor.css" rel="stylesheet">
</head>

<body id="kt_app_body" data-kt-app-page-loading-enabled="true" data-kt-app-page-loading="on"
  data-kt-app-layout="light-header" class="app-default">
  <?php include(dirname(__DIR__) . "/partials/_page-loader.php"); ?>
  <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
    <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
      <?php include(dirname(__DIR__) . "/partials/_header.php"); ?>
      <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
        <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
          <div class="d-flex flex-column flex-column-fluid">
            <main>
              
              <!-- Banner -->
              <div class="page-banner w-100 py-10 mb-8">
                <div class="app-container container-xxl d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-yellow fw-bold fs-8 text-uppercase tracking-wider mb-1 d-block">NEW POST</span>
                        <h1 class="text-white fw-bolder fs-2tx mb-2">Create a Post</h1>
                        <p class="text-white text-opacity-75 fs-7 mb-0">Share something with the Paraverse community</p>
                    </div>
                    <button class="btn btn-sm btn-outline btn-outline-white text-white border-white border-opacity-25 px-6" onclick="window.location.href='/Discourse/index.php'">Back</button>
                </div>
              </div>

              <div class="app-container container-xxl pb-10">
                <form id="createPostForm" action="/Discourse/posts/index-ajax-add-post.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="redirect_back" value="/Discourse/posts/index.php?action=create">
                <textarea name="body" id="body-hidden" style="display:none;"></textarea>
                <div class="row g-6">
                    <!-- Main Form -->
                    <div class="col-lg-8">
                        <div class="card border border-gray-300 shadow-none rounded-2">
                            <div class="card-body p-8">
                                
                                 <div class="d-flex align-items-center justify-content-between mb-8">
                                     <div class="d-flex align-items-center gap-3">
                                         <div id="community-preview-icon" class="w-25px h-25px bg-light-success rounded d-flex align-items-center justify-content-center" style="background-color: rgba(23, 198, 83, 0.12) !important; color: #17c653 !important;">
                                             <i class="bi bi-pencil-fill fs-7" style="color: #17c653 !important;"></i>
                                         </div>
                                         <h3 class="fw-bolder text-dark fs-4 m-0">Post Content</h3>
                                     </div>
                                    <div id="identity-badge" class="d-flex align-items-center gap-2 bg-light-success px-4 py-2 rounded" style="background-color: rgba(23, 198, 83, 0.12) !important; border: 1px solid rgba(23, 198, 83, 0.2) !important;">
                                        <div id="identity-avatar" class="w-15px h-15px bg-success rounded-circle text-white d-flex align-items-center justify-content-center fs-9" style="background-color: #17c653 !important; color: #fff !important;"><?php echo htmlspecialchars($initials); ?></div>
                                        <span id="identity-text" class="text-success fw-bold fs-8" style="color: #17c653 !important;">Posting as <?php echo htmlspecialchars($ACCOUNT['display_name'] ?? 'yourself'); ?></span>
                                    </div>
                                </div>
                                
                                <!-- Form Fields -->
                                <div class="mb-6">
                                    <label class="form-label fs-8 fw-bold text-gray-700 text-uppercase">TITLE *</label>
                                    <input type="text" name="title" id="post_title" class="form-control form-control-solid border" placeholder="What's on your mind? Give it a good headline..." required>
                                </div>
                                
                                 <div class="row g-4 mb-6">
                                     <div class="col-md-6">
                                          <label class="form-label fs-8 fw-bold text-gray-700 text-uppercase">COMMUNITY</label>
                                          <?php if (!empty($default_community)) { 
                                              $default_logo = '';
                                              $default_icon = 'bi-people-fill';
                                              $default_color = '#1A8B44';
                                              foreach ($db_communities as $comm) {
                                                  if (strcasecmp($comm['title'], $default_community) === 0) {
                                                      $default_logo = $comm['logo_url'] ?? '';
                                                      $default_icon = $comm['icon'] ?? 'bi-people-fill';
                                                      $default_color = $comm['theme_color'] ?? '#1A8B44';
                                                      break;
                                                  }
                                              }
                                          ?>
                                              <select class="form-select form-select-solid border" data-control="select2" data-hide-search="true" disabled>
                                                  <option value="<?php echo htmlspecialchars($default_community); ?>" selected
                                                          data-logo="<?php echo htmlspecialchars($default_logo); ?>"
                                                          data-icon="<?php echo htmlspecialchars($default_icon); ?>"
                                                          data-color="<?php echo htmlspecialchars($default_color); ?>">
                                                      <?php echo htmlspecialchars(strtoupper($default_community)); ?>
                                                  </option>
                                              </select>
                                              <input type="hidden" name="community" value="<?php echo htmlspecialchars($default_community); ?>">
                                          <?php } else { ?>
                                              <select name="community" class="form-select form-select-solid border" data-control="select2" data-hide-search="true" data-placeholder="Select a community...">
                                                  <option value="">No community</option>
                                                  <?php foreach ($db_communities as $comm): ?>
                                                      <option value="<?php echo htmlspecialchars($comm['title']); ?>"
                                                              data-logo="<?php echo htmlspecialchars($comm['logo_url'] ?? ''); ?>"
                                                              data-icon="<?php echo htmlspecialchars($comm['icon'] ?? 'bi-people-fill'); ?>"
                                                              data-color="<?php echo htmlspecialchars($comm['theme_color'] ?? '#1A8B44'); ?>">
                                                          <?php echo htmlspecialchars(strtoupper($comm['title'])); ?>
                                                      </option>
                                                  <?php endforeach; ?>
                                              </select>
                                          <?php } ?>
                                     </div>
                                     <div class="col-md-6">
                                         <label class="form-label fs-8 fw-bold text-gray-700 text-uppercase">TOPIC *</label>
                                         <select name="topic" id="topic-select" class="form-select form-select-solid border" data-control="select2" data-hide-search="true" data-placeholder="Select a topic..." required>
                                             <option></option>
                                         </select>
                                     </div>
                                </div>
                                
                                 <div class="mb-6">
                                     <label class="form-label fs-8 fw-bold text-gray-700 text-uppercase">Cover Photo (Optional)</label>
                                     <div class="d-flex align-items-center gap-3">
                                         <input type="file" name="image" id="cover_photo_input" class="form-control form-control-solid border" accept="image/*" style="display:none;" onchange="previewCoverPhoto(this)">
                                         <button type="button" class="btn btn-light bg-white border border-gray-300 text-dark fw-bold" onclick="document.getElementById('cover_photo_input').click()">
                                             <i class="bi bi-image me-1"></i> Choose Image
                                         </button>
                                         <span id="cover-photo-filename" class="text-muted fs-8">No file chosen</span>
                                     </div>
                                 </div>
                                 
                                 <div class="mb-6">
                                     <label class="form-label fs-8 fw-bold text-gray-700 text-uppercase">TAGS</label>
                                     <div class="d-flex flex-wrap align-items-center gap-2 form-control form-control-solid border p-2" id="tag-wrap" onclick="document.getElementById('tag-input').focus()" style="min-height: 45px; cursor: text;">
                                         <input type="text" id="tag-input" class="border-0 bg-transparent flex-grow-1" placeholder="Type a tag and press Enter..." style="outline: none; min-width: 150px; font-size: 13px;">
                                     </div>
                                     <input type="hidden" name="tags" id="tags-hidden" value="">
                                </div>

                                <div class="mb-0">
                                     <label class="form-label fs-8 fw-bold text-gray-700 text-uppercase">BODY *</label>

                                     <!-- Toolbar -->
                                     <div class="dc-toolbar" id="dc-toolbar">
                                       <button type="button" class="btn btn-sm btn-icon btn-light-success" title="Bold" onclick="fmt('bold')"><b>B</b></button>
                                       <button type="button" class="btn btn-sm btn-icon btn-light-success" title="Italic" onclick="fmt('italic')"><i style="font-style:italic;color:#3a5c45;">I</i></button>
                                       <button type="button" class="btn btn-sm btn-icon btn-light-success" title="Strikethrough" onclick="fmt('strikeThrough')"><s>S</s></button>
                                       <button type="button" class="btn btn-sm btn-icon btn-light-success" title="Superscript" onclick="fmt('superscript')">x<sup>2</sup></button>
                                       <button type="button" class="btn btn-sm btn-icon btn-light-success" title="Paragraph" onclick="fmt('formatBlock','p')">¶T</button>
                                       <span class="dc-tb-sep"></span>
                                       <button type="button" class="btn btn-sm btn-icon btn-light-success" title="Insert Link" onclick="openModal('modal-link')">
                                         <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
                                       </button>
                                       <button type="button" class="btn btn-sm btn-icon btn-light-success" title="Insert Image" onclick="openModal('modal-image')">
                                         <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                       </button>
                                       <button type="button" class="btn btn-sm btn-icon btn-light-success" title="Embed Video" onclick="openModal('modal-video')">
                                         <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><polygon points="10 8 16 12 10 16 10 8"/></svg>
                                       </button>
                                       <span class="dc-tb-sep"></span>
                                       <button type="button" class="btn btn-sm btn-icon btn-light-success" title="Ordered List" onclick="insertList('ol')">
                                         <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="9" y1="6" x2="20" y2="6"/><line x1="9" y1="12" x2="20" y2="12"/><line x1="9" y1="18" x2="20" y2="18"/><path d="M4 6h1v4"/><path d="M4 10h2"/><path d="M6 18H4c0-1 2-2 2-3s-1-1.5-2-1"/></svg>
                                       </button>
                                       <button type="button" class="btn btn-sm btn-icon btn-light-success" title="Unordered List" onclick="insertList('ul')">
                                         <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="9" y1="6" x2="20" y2="6"/><line x1="9" y1="12" x2="20" y2="12"/><line x1="9" y1="18" x2="20" y2="18"/><circle cx="4" cy="6" r="1.5" fill="currentColor"/><circle cx="4" cy="12" r="1.5" fill="currentColor"/><circle cx="4" cy="18" r="1.5" fill="currentColor"/></svg>
                                       </button>
                                       <span class="dc-tb-sep"></span>
                                       <button type="button" class="btn btn-sm btn-icon btn-light-success" title="Inline Code" onclick="insertInlineCode()">
                                         <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
                                       </button>
                                       <button type="button" class="btn btn-sm btn-icon btn-light-success" title="Blockquote" onclick="fmt('formatBlock','blockquote')">
                                         <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M3 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2H4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2 1 0 1 0 1 1v1c0 1-1 2-2 2s-1 .008-1 1.031V20c0 1 0 1 1 1zm12 0c3 0 7-1 7-8V5c0-1.25-.757-2.017-2-2h-4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2 1 0 1 0 1 1v1c0 1-1 2-2 2s-1 .008-1 1.031V20c0 1 0 1 1 1z"/></svg>
                                       </button>
                                       <button type="button" class="btn btn-sm btn-icon btn-light-success" title="Code Block" onclick="insertCodeBlock()">
                                         <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/><line x1="12" y1="3" x2="12" y2="21" stroke-width="1.5"/></svg>
                                       </button>
                                       <button type="button" class="btn btn-sm btn-icon btn-light-success" title="Spoiler" onclick="insertSpoiler()">
                                         <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                                       </button>
                                       <button type="button" class="btn btn-sm btn-icon btn-light-success" title="Insert Table" onclick="insertTable()">
                                         <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="3" y1="15" x2="21" y2="15"/><line x1="9" y1="3" x2="9" y2="21"/><line x1="15" y1="3" x2="15" y2="21"/></svg>
                                       </button>
                                       <button type="button" class="btn btn-sm btn-icon btn-light-success" title="Insert Poll" onclick="insertPollBuilder()">
                                         <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                                       </button>
                                       <a class="dc-tb-switch" href="#" onclick="toggleMarkdown(event)">Switch to Markdown</a>
                                     </div>

                                     <!-- Editor -->
                                     <div id="dc-editor" class="dc-editor-area" contenteditable="true"
                                       data-placeholder="Body text (required)"
                                       style="height:300px !important;overflow-y:auto !important;border-bottom:1.5px solid #e4e6ef !important;border-radius:0 0 8px 8px !important;"></div>

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
                                
                                <div class="form-check form-switch form-check-custom form-check-solid mb-6">
                                    <input class="form-check-input h-20px w-30px" type="checkbox" value="1" id="is_anonymous" name="is_anonymous" style="cursor: pointer;" />
                                    <label class="form-check-label fw-bold text-gray-700 fs-8 text-uppercase" for="is_anonymous" style="cursor: pointer;">
                                        Post Anonymously
                                    </label>
                                </div>

                                <button type="button" class="btn w-100 btn-green mb-3 fw-bold" onclick="submitPost()">
                                    <i class="bi bi-send me-1"></i> Publish Post
                                </button>
                                <button type="button" class="btn w-100 btn-light bg-white border border-gray-300 text-dark fw-bold" onclick="discardPost()">Discard</button>
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
                </form>
              </div>
             </main>
           </div>
           <?php include(dirname(__DIR__) . "/partials/_discourse-modals.php"); ?>
           <?php include(dirname(__DIR__) . "/partials/_footer.php"); ?>
        </div>
      </div>
    </div>
  </div>
  <?php include(dirname(__DIR__) . "/partials/_scrolltop.php"); ?>

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

  <script>window.DC_EDITOR_ID = 'dc-editor';</script>
  <script src="/Discourse/assets/js/dc-editor.js"></script>

  <script>
  $(document).ready(function() {
      var userInitials = <?php echo json_encode($initials); ?>;
      var userDisplayName = <?php echo json_encode($ACCOUNT['display_name'] ?? 'yourself'); ?>;

      $('#is_anonymous').on('change', function() {
          if ($(this).is(':checked')) {
              $('#identity-badge')
                  .removeClass('bg-light-success')
                  .addClass('bg-light-secondary border border-gray-300')
                  .css({ 'background-color': '', 'border': '' });
              $('#identity-avatar')
                  .removeClass('bg-success')
                  .addClass('bg-secondary text-gray-700')
                  .css({ 'background-color': '', 'color': '' })
                  .text('A');
              $('#identity-text')
                  .removeClass('text-success')
                  .addClass('text-gray-700')
                  .css('color', '')
                  .text('Posting anonymously');
          } else {
              $('#identity-badge')
                  .removeClass('bg-light-secondary border border-gray-300')
                  .addClass('bg-light-success')
                  .css({ 'background-color': 'rgba(23, 198, 83, 0.12)', 'border': '1px solid rgba(23, 198, 83, 0.2)' });
              $('#identity-avatar')
                  .removeClass('bg-secondary text-gray-700')
                  .addClass('bg-success')
                  .css({ 'background-color': '#17c653', 'color': '#fff' })
                  .text(userInitials);
              $('#identity-text')
                  .removeClass('text-gray-700')
                  .addClass('text-success')
                  .css('color', '#17c653')
                  .text('Posting as ' + userDisplayName);
          }
      });

      // ── Dynamic Topic Badges Mapping ──
      const communityTopics = <?php echo json_encode($community_topics_map); ?>;
      const communitySelect = $('select[name="community"]');
      const topicSelect = $('select[name="topic"]');
      const previewIcon = $('#community-preview-icon');

      function hexToRgba(hex, alpha) {
          hex = hex.replace('#', '');
          var r, g, b;
          if (hex.length === 3) {
              r = parseInt(hex.charAt(0) + hex.charAt(0), 16);
              g = parseInt(hex.charAt(1) + hex.charAt(1), 16);
              b = parseInt(hex.charAt(2) + hex.charAt(2), 16);
          } else {
              r = parseInt(hex.substring(0, 2), 16) || 0;
              g = parseInt(hex.substring(2, 4), 16) || 0;
              b = parseInt(hex.substring(4, 6), 16) || 0;
          }
          return 'rgba(' + r + ', ' + g + ', ' + b + ', ' + alpha + ')';
      }

      function formatCommunity(option) {
          if (!option.id) {
              return option.text;
          }
          var element = option.element;
          var logo = $(element).data('logo');
          var icon = $(element).data('icon') || 'bi-people-fill';
          var color = $(element).data('color') || '#1A8B44';
          
          if (logo) {
              return $(
                  '<span class="d-flex align-items-center gap-2">' +
                  '  <span class="w-20px h-20px rounded d-inline-block" style="background-image: url(\'' + logo + '\'); background-size: cover; background-position: center; flex-shrink: 0;"></span>' +
                  '  <span>' + option.text + '</span>' +
                  '</span>'
              );
          } else {
              var rgbaBg = hexToRgba(color, 0.1);
              return $(
                  '<span class="d-flex align-items-center gap-2">' +
                  '  <span class="w-20px h-20px rounded d-flex align-items-center justify-content-center" style="background-color: ' + rgbaBg + '; color: ' + color + '; flex-shrink: 0;">' +
                  '    <i class="bi ' + icon + ' fs-8" style="color: ' + color + ' !important;"></i>' +
                  '  </span>' +
                  '  <span>' + option.text + '</span>' +
                  '</span>'
              );
          }
      }

      // Re-initialize Select2 for community dropdown to use custom templating
      if (communitySelect.length && typeof communitySelect.select2 === 'function') {
          if (communitySelect.hasClass("select2-hidden-accessible")) {
              communitySelect.select2('destroy');
          }
          communitySelect.select2({
              minimumResultsForSearch: Infinity,
              templateResult: formatCommunity,
              templateSelection: formatCommunity,
              escapeMarkup: function(m) { return m; }
          });
      }

      const disabledSelect = $('.col-md-6 select[disabled]');
      if (disabledSelect.length && typeof disabledSelect.select2 === 'function') {
          if (disabledSelect.hasClass("select2-hidden-accessible")) {
              disabledSelect.select2('destroy');
          }
          disabledSelect.select2({
              minimumResultsForSearch: Infinity,
              templateResult: formatCommunity,
              templateSelection: formatCommunity,
              escapeMarkup: function(m) { return m; }
          });
      }

      function updateCommunityIcon() {
          const selectedOption = communitySelect.find('option:selected');
          const is_disabled_select = $('.col-md-6 select[disabled]');
          const opt = is_disabled_select.length ? is_disabled_select.find('option:selected') : selectedOption;
          
          if (!opt.length || !opt.val()) {
              previewIcon.css({
                  'background-image': '',
                  'background-color': 'rgba(23, 198, 83, 0.12)',
                  'color': '#17c653'
              }).html('<i class="bi bi-pencil-fill fs-7" style="color: #17c653 !important;"></i>');
              return;
          }
          
          const logo = opt.data('logo');
          const icon = opt.data('icon') || 'bi-people-fill';
          const color = opt.data('color') || '#1A8B44';
          
          if (logo) {
              previewIcon.css({
                  'background-image': 'url("' + logo + '")',
                  'background-size': 'cover',
                  'background-position': 'center',
                  'background-color': '',
                  'color': ''
              }).html('');
          } else {
              const rgbaBg = hexToRgba(color, 0.1);
              previewIcon.css({
                  'background-image': '',
                  'background-color': rgbaBg,
                  'color': color
              }).html('<i class="bi ' + icon + ' fs-7" style="color: ' + color + ' !important;"></i>');
          }
      }

      function updateTopics() {
          const selectedComm = $('input[name="community"]').val() || communitySelect.val() || "";
          const topics = communityTopics[selectedComm] || communityTopics[""];
          
          topicSelect.empty();
          topicSelect.append('<option></option>'); // Placeholder option for select2
          topics.forEach(function(t) {
              topicSelect.append(new Option(t, t.toUpperCase()));
          });
          topicSelect.trigger('change');
          updateCommunityIcon();
      }

      // Initialize on load
      updateTopics();

      // Listen for changes
      communitySelect.on('change', updateTopics);

      // Hashtag input chips logic
      (function() {
          const tagInput = $('#tag-input');
          const tagWrap = $('#tag-wrap');
          const tagsHidden = $('#tags-hidden');
          if (!tagInput.length || !tagWrap.length) return;
          
          let tags = [];

          tagInput.on('keydown', function(e) {
              if ((e.key === 'Enter' || e.key === ',') && tagInput.val().trim()) {
                  e.preventDefault();
                  let val = tagInput.val().trim().replace(/,/g, '');
                  if (val) {
                      if (!val.startsWith('#')) {
                          val = '#' + val;
                      }
                      if (!tags.includes(val)) {
                          tags.push(val);
                          renderTags();
                      }
                  }
                  tagInput.val('');
              }
              if (e.key === 'Backspace' && !tagInput.val() && tags.length) {
                  tags.pop();
                  renderTags();
              }
          });

          function renderTags() {
              tagWrap.find('.badge').remove();
              tags.forEach(function(tag, i) {
                  const badge = $('<span class="badge rounded-pill px-3 py-2 fs-8 d-inline-flex align-items-center gap-1"></span>')
                      .css({'background-color': '#dce8df', 'color': '#3a5c45'})
                      .text(tag);
                  const closeBtn = $('<button type="button" class="btn-close btn-close-sm ms-1" style="font-size:9px; cursor: pointer;"></button>')
                      .on('click', function(e) {
                          e.stopPropagation();
                          tags.splice(i, 1);
                          renderTags();
                      });
                  badge.append(closeBtn);
                  badge.insertBefore(tagInput);
              });
              tagsHidden.val(tags.join(','));
          }

          // In case form submission happens, ensure the hidden input is synced
          $('#createPostForm').on('submit', function() {
              tagsHidden.val(tags.join(','));
          });
      })();

      window.previewCoverPhoto = function(input) {
          var filenameSpan = document.getElementById('cover-photo-filename');
          if (input.files && input.files[0]) {
              filenameSpan.textContent = input.files[0].name;
          } else {
              filenameSpan.textContent = "No file chosen";
          }
      };

      window.submitPost = function() {
          var titleInput = document.getElementById('post_title');
          if (!titleInput || !titleInput.value.trim()) {
              alert('Please enter a post title.');
              if (titleInput) titleInput.focus();
              return;
          }
          
          var topicSelect = document.getElementById('topic-select');
          if (!topicSelect || !topicSelect.value) {
              alert('Please select a topic.');
              if (topicSelect) $(topicSelect).select2('open');
              return;
          }
          
          // Sync editor contents to hidden textarea
          var editor = document.getElementById('dc-editor');
          var bodyHidden = document.getElementById('body-hidden');
          if (editor && bodyHidden) {
              bodyHidden.value = typeof window.getEditorHtml === 'function' ? window.getEditorHtml() : editor.innerHTML;
          }
          
          if (typeof KTApp !== 'undefined') KTApp.showPageLoading();
          document.getElementById('createPostForm').submit();
      };
      
      window.discardPost = function() {
          if (confirm('Are you sure you want to discard this post? Your changes will be lost.')) {
              window.location.href = '/Discourse/index.php';
          }
      };
  });
  </script>
</body>

</html>
