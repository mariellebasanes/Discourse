<?php
define('MBG', TRUE);
include_once(dirname(dirname(__DIR__)) . '/functions-new.php');

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
        // Fall back to seed defaults or general topics
        $topics = ["Technology","Culture","Gaming","FEU","Ideas","Creative","Science","News","AI","Academics","Lifestyle","Entertainment","Music","Politics","Issues","Sports","Others"];
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
                    <button class="btn btn-sm btn-outline btn-outline-white text-white border-white border-opacity-25 px-6" onclick="window.location.href='/Discourse/index.php'">Back</button>
                </div>
              </div>

              <div class="app-container container-xxl pb-10">
                <form id="createPostForm" action="/Discourse/pages/version/create-post-action.php" method="POST">
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
                                    <div id="identity-badge" class="d-flex align-items-center gap-2 bg-light-success px-4 py-2 rounded">
                                        <div id="identity-avatar" class="w-15px h-15px bg-success rounded-circle text-white d-flex align-items-center justify-content-center fs-9"><?php echo htmlspecialchars($initials); ?></div>
                                        <span id="identity-text" class="text-success fw-bold fs-8">Posting as <?php echo htmlspecialchars($ACCOUNT['display_name'] ?? 'yourself'); ?></span>
                                    </div>
                                </div>
                                
                                <!-- Form Fields -->
                                <div class="mb-6">
                                    <label class="form-label fs-8 fw-bold text-gray-700 text-uppercase">TITLE *</label>
                                    <input type="text" name="title" class="form-control form-control-solid border" placeholder="What's on your mind? Give it a good headline..." required>
                                </div>
                                
                                <div class="row g-4 mb-6">
                                    <div class="col-md-6">
                                        <label class="form-label fs-8 fw-bold text-gray-700 text-uppercase">COMMUNITY</label>
                                        <select name="community" class="form-select form-select-solid border" data-control="select2" data-hide-search="true" data-placeholder="Select a community...">
                                            <option value="">No community</option>
                                            <?php foreach ($db_communities as $comm): ?>
                                                <?php 
                                                $isSelected = (strcasecmp($comm['title'], $default_community) === 0);
                                                ?>
                                                <option value="<?php echo htmlspecialchars($comm['title']); ?>" <?php echo $isSelected ? 'selected' : ''; ?>>
                                                    <?php echo htmlspecialchars(strtoupper($comm['title'])); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fs-8 fw-bold text-gray-700 text-uppercase">TOPIC *</label>
                                        <select name="topic" class="form-select form-select-solid border" data-control="select2" data-hide-search="true" data-placeholder="Select a topic..." required>
                                            <option></option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="mb-6">
                                    <label class="form-label fs-8 fw-bold text-gray-700 text-uppercase">TAGS</label>
                                    <input type="text" name="tags" class="form-control form-control-solid border" placeholder="Type a tag and press Enter...">
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
                                             <textarea name="body" class="form-control form-control-flush border-0 p-0 fs-6" rows="8" placeholder="Body text (optional)"></textarea>
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
                                
                                <div class="form-check form-switch form-check-custom form-check-solid mb-6">
                                    <input class="form-check-input h-20px w-30px" type="checkbox" value="1" id="is_anonymous" name="is_anonymous" style="cursor: pointer;" />
                                    <label class="form-check-label fw-bold text-gray-700 fs-8 text-uppercase" for="is_anonymous" style="cursor: pointer;">
                                        Post Anonymously
                                    </label>
                                </div>

                                <button type="submit" class="btn w-100 btn-green mb-3 fw-bold">Publish Post</button>
                                <button type="button" class="btn w-100 btn-light bg-white border border-gray-300 text-dark fw-bold" onclick="window.location.href='/Discourse/index.php'">Discard</button>
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
          <?php include(dirname(dirname(__DIR__)) . "/partials/_footer.php"); ?>
        </div>
      </div>
    </div>
  </div>
  <?php include(dirname(dirname(__DIR__)) . "/partials/_scrolltop.php"); ?>

  <script>
  $(document).ready(function() {
      var userInitials = <?php echo json_encode($initials); ?>;
      var userDisplayName = <?php echo json_encode($ACCOUNT['display_name'] ?? 'yourself'); ?>;

      $('#is_anonymous').on('change', function() {
          if ($(this).is(':checked')) {
              $('#identity-badge')
                  .removeClass('bg-light-success')
                  .addClass('bg-light-secondary border border-gray-300');
              $('#identity-avatar')
                  .removeClass('bg-success')
                  .addClass('bg-secondary text-gray-700')
                  .text('A');
              $('#identity-text')
                  .removeClass('text-success')
                  .addClass('text-gray-700')
                  .text('Posting anonymously');
          } else {
              $('#identity-badge')
                  .removeClass('bg-light-secondary border border-gray-300')
                  .addClass('bg-light-success');
              $('#identity-avatar')
                  .removeClass('bg-secondary text-gray-700')
                  .addClass('bg-success')
                  .text(userInitials);
              $('#identity-text')
                  .removeClass('text-gray-700')
                  .addClass('text-success')
                  .text('Posting as ' + userDisplayName);
          }
      });

      // ── Dynamic Topic Badges Mapping ──
      const communityTopics = <?php echo json_encode($community_topics_map); ?>;
      const communitySelect = $('select[name="community"]');
      const topicSelect = $('select[name="topic"]');

      function updateTopics() {
          const selectedComm = communitySelect.val() || "";
          const topics = communityTopics[selectedComm] || communityTopics[""];
          
          topicSelect.empty();
          topicSelect.append('<option></option>'); // Placeholder option for select2
          topics.forEach(function(t) {
              topicSelect.append(new Option(t, t.toUpperCase()));
          });
          topicSelect.trigger('change');
      }

      // Initialize on load
      updateTopics();

      // Listen for changes
      communitySelect.on('change', updateTopics);
  });
  </script>
</body>

</html>
