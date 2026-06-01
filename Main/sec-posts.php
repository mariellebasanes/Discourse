<?php
if (!function_exists('getCommunityIconDetails')) {
  function getCommunityIconDetails($name, $category = null)
  {
    $name_lower = strtolower($name);

    $icon       = "bi-cpu";
    $bg_class   = "bg-light-success";
    $text_class = "text-success";

    if (strpos($name_lower, 'life') !== false) {
      $icon       = "bi-heart-fill";
      $bg_class   = "bg-light-danger";
      $text_class = "text-danger";
    } elseif (strpos($name_lower, 'culture') !== false || strpos($name_lower, 'hub') !== false) {
      $icon       = "bi-music-note-beamed";
      $bg_class   = "bg-light-primary";
      $text_class = "text-primary";
    } elseif (strpos($name_lower, 'fresh') !== false || strpos($name_lower, 'study') !== false || strpos($name_lower, 'group') !== false) {
      $icon       = "bi-people-fill";
      $bg_class   = "bg-light-info";
      $text_class = "text-info";
    } elseif (strpos($name_lower, 'food') !== false || strpos($name_lower, 'trip') !== false) {
      $icon       = "bi-cup-hot-fill";
      $bg_class   = "bg-light-warning";
      $text_class = "text-warning";
    } elseif (strpos($name_lower, 'cosplay') !== false || strpos($name_lower, 'artist') !== false) {
      $icon       = "bi-palette-fill";
      $bg_class   = "bg-light-primary";
      $text_class = "text-primary";
    } elseif (strpos($name_lower, 'enroll') !== false || strpos($name_lower, 'thesis') !== false || strpos($name_lower, 'advice') !== false) {
      $icon       = "bi-journal-bookmark-fill";
      $bg_class   = "bg-light-warning";
      $text_class = "text-warning";
    } elseif (strpos($name_lower, 'innovat') !== false) {
      $icon       = "bi-lightbulb-fill";
      $bg_class   = "bg-light-warning";
      $text_class = "text-warning";
    } elseif (strpos($name_lower, 'alabang') !== false) {
      $icon       = "bi-building-fill";
      $bg_class   = "bg-light-warning";
      $text_class = "text-warning";
    } elseif (strpos($name_lower, 'diliman') !== false) {
      $icon       = "bi-mortarboard-fill";
      $bg_class   = "bg-light-info";
      $text_class = "text-info";
    }

    return [
      'icon'       => $icon,
      'bg_class'   => $bg_class,
      'text_class' => $text_class,
      'bg_hex'     => '',
      'color_hex'  => '',
    ];
  }
}

if (!function_exists('getCategoryBadgeStyle')) {
  function getCategoryBadgeStyle($category)
  {
    $cat = strtoupper(trim($category));
    switch ($cat) {
      case 'TECHNOLOGY':
        return ['class' => 'badge-light-primary',  'icon' => 'bi-cpu',               'icon_color' => 'text-primary'];
      case 'CULTURE':
        return ['class' => 'badge-light-danger',   'icon' => 'bi-palette',           'icon_color' => 'text-danger'];
      case 'GAMING':
        return ['class' => 'badge-light-warning',  'icon' => 'bi-controller',        'icon_color' => 'text-warning'];
      case 'FEU':
        return ['class' => 'badge-light-warning',  'icon' => 'bi-building',          'icon_color' => 'text-warning'];
      case 'IDEAS':
        return ['class' => 'badge-light-info',     'icon' => 'bi-lightbulb',         'icon_color' => 'text-info'];
      case 'CREATIVE':
        return ['class' => 'badge-light-primary',  'icon' => 'bi-stars',             'icon_color' => 'text-primary'];
      case 'SCIENCE':
        return ['class' => 'badge-light-info',     'icon' => 'bi-droplet-half',      'icon_color' => 'text-info'];
      case 'NEWS':
        return ['class' => 'badge-light-danger',   'icon' => 'bi-newspaper',         'icon_color' => 'text-danger'];
      case 'AI':
        return ['class' => 'badge-light-success',  'icon' => 'bi-robot',             'icon_color' => 'text-success'];
      case 'ACADEMICS':
        return ['class' => 'badge-light-warning',  'icon' => 'bi-book',              'icon_color' => 'text-warning'];
      case 'LIFESTYLE':
        return ['class' => 'badge-light-info',     'icon' => 'bi-emoji-smile',       'icon_color' => 'text-info'];
      case 'ENTERTAINMENT':
        return ['class' => 'badge-light-primary',  'icon' => 'bi-film',              'icon_color' => 'text-primary'];
      case 'MUSIC':
        return ['class' => 'badge-light-danger',   'icon' => 'bi-music-note',        'icon_color' => 'text-danger'];
      case 'POLITICS':
        return ['class' => 'badge-light-dark',     'icon' => 'bi-megaphone',         'icon_color' => 'text-dark'];
      case 'ISSUES':
        return ['class' => 'badge-light-danger',   'icon' => 'bi-exclamation-circle', 'icon_color' => 'text-danger'];
      case 'SPORTS':
        return ['class' => 'badge-light-warning',  'icon' => 'bi-trophy',            'icon_color' => 'text-warning'];
      default:
        return ['class' => 'badge-light-secondary', 'icon' => 'bi-tag',               'icon_color' => 'text-secondary'];
    }
  }
}
?>

<div class="tab-content" id="discoursePostTabsContent">

  <!-- ── HOT Tab (default active) ──────────────────────────── -->
  <div class="tab-pane fade show active" id="posts-hot" role="tabpanel" aria-labelledby="tab-hot">

    <!-- ── Post Card 1 ─────────────────────────────────────── -->
    <div class="card border-0 shadow mb-5" data-dc="post-card">
      <div class="d-flex">

        <!-- Vote Column -->
        <div class="d-flex flex-column align-items-center gap-1 p-3" style="width:55px;flex-shrink:0;background-color:#e8ede9;">
          <button class="btn btn-sm btn-tertiary dc-vote-up" title="Upvote">
            <i class="bi bi-hand-thumbs-up p-0"></i>
          </button>
          <span class="fs-7 fw-bold text-gray-600 dc-vote-count">214</span>
          <button class="btn btn-sm btn-tertiary dc-vote-down" title="Downvote">
            <i class="bi bi-hand-thumbs-down p-0"></i>
          </button>
        </div>

        <!-- Post Content -->
        <div class="d-flex flex-column py-5 flex-grow-1">
          <div class="row g-0 px-5">

            <!-- Row 1: Community badge + Report button -->
            <div class="col-12 mb-2">
              <div class="d-flex justify-content-between align-items-center">
                <?php $commDetails1 = getCommunityIconDetails('FEUTech'); ?>
                <a href="/Discourse/pages/version/community.php" class="d-flex align-items-center gap-2 text-decoration-none">
                  <div class="d-flex align-items-center justify-content-center rounded-2 <?php echo $commDetails1['bg_class']; ?>"
                    style="width:24px;height:24px;">
                    <i class="bi <?php echo $commDetails1['icon']; ?> fs-8 <?php echo $commDetails1['text_class']; ?>"></i>
                  </div>
                  <span class="fw-bold text-gray-800 text-hover-primary fs-7">c/FEUTech</span>
                </a>
                <button class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#modalReportPost">
                  <i class="bi bi-flag me-1"></i> Report
                </button>
              </div>
            </div>

            <!-- Row 2: Avatar + Author name + Timestamp -->
            <div class="col-12 mb-2">
              <div class="d-flex gap-3 align-items-center">
                <img src="/Discourse/assets/images/catalina.webp" alt="Ravi Joshi" class="h-40px w-40px rounded-circle" />
                <div class="d-flex flex-column">
                  <a href="/Discourse/pages/version/profile-other.php" class="fs-6 fw-bold text-gray-800 text-hover-primary">Ravi Joshi</a>
                  <span class="text-muted fs-8"><i class="bi bi-clock me-1 fs-8"></i>1d ago</span>
                </div>
              </div>
            </div>

            <!-- Row 3: Title + Excerpt -->
            <div class="col-12 mb-2">
              <div class="d-flex flex-column gap-2 text-start">
                <div>
                  <?php $badge1 = getCategoryBadgeStyle('TECHNOLOGY'); ?>
                  <a href="/Discourse/pages/view/topic.php?t=TECHNOLOGY" class="badge <?php echo $badge1['class']; ?> rounded-pill px-3 py-2 fs-8 fw-bold text-decoration-none">
                    <i class="bi <?php echo $badge1['icon']; ?> <?php echo $badge1['icon_color']; ?> me-1"></i>
                    TECHNOLOGY
                  </a>
                </div>
                <a href="/Discourse/pages/version/view-post.php" class="text-gray-800 text-hover-primary fs-5 fw-bold dc-post-title-link">
                  The silent revolution in edge AI — why on-device inference is changing everything
                </a>
                <div class="dc-body-wrap">
                  <span class="fs-7 text-gray-700 dc-body-clamp"> A decade optimizing for server-side compute, but the thermal envelope of modern SoCs has quietly crossed a threshold nobody was paying attention to. Here's why 2025 is the last year data centers dominate...</span>
                  <a href="#" class="dc-see-more-link fw-semibold cursor-pointer d-none" onclick="dcToggleBody(event, this)">See More</a>
                </div>
              </div>
            </div>

          </div>

          <!-- Actions Row -->
          <div class="row">
            <div class="d-flex justify-content-start align-items-center w-100 px-5">
              <button class="btn btn-sm dc-post-comment"><i class="bi bi-chat me-1"></i> 1 Comment</button>
              <button class="btn btn-sm dc-post-share"><i class="bi bi-share me-1"></i> Share</button>
              <button class="btn btn-sm dc-post-save"><i class="bi bi-bookmark me-1"></i> Save</button>
            </div>
          </div>

          <!-- Inline Quick Comment Drawer -->
          <div class="dc-quick-comment-drawer border-top border-gray-200 mt-4 pt-4 px-5" style="display:none;background-color:#fcfdfc;">
            <div class="dc-quick-comments-list mb-4 d-flex flex-column gap-3" style="max-height:180px;overflow-y:auto;">
              <div class="d-flex align-items-start gap-2 fs-7">
                <img src="https://ui-avatars.com/api/?name=Sofia+Karim&background=f3f4f6&color=d97706&rounded=true" class="h-25px w-25px rounded-circle" alt="Sofia Karim">
                <div class="bg-light p-2 rounded-3 flex-grow-1">
                  <div class="d-flex justify-content-between">
                    <span class="fw-bold text-gray-800">Sofia Karim</span>
                    <span class="text-muted fs-9">2h ago</span>
                  </div>
                  <p class="text-gray-700 m-0 mt-1">This is a game changer! On-device inference keeps user data private and offline.</p>
                </div>
              </div>
            </div>
            <form class="dc-quick-comment-form">
              <div class="d-flex align-items-center gap-2">
                <img src="/Discourse/assets/images/catalina.webp" class="h-30px w-30px rounded-circle" alt="User avatar" />
                <input type="text" class="form-control form-control-sm rounded-pill px-4 fs-7 bg-white border border-gray-300" placeholder="Write a quick comment..." required />
                <button type="submit" class="btn btn-sm btn-success rounded-pill px-4 fw-bold" style="background:#0b301f;color:#fff;">Post</button>
              </div>
            </form>
          </div>
        </div>

      </div>
    </div>

    <!-- ── Post Card 2 ─────────────────────────────────────── -->
    <div class="card border-0 shadow mb-5" data-dc="post-card">
      <div class="d-flex">

        <div class="d-flex flex-column align-items-center gap-1 p-3" style="width:55px;flex-shrink:0;background-color:#e8ede9;">
          <button class="btn btn-sm btn-tertiary dc-vote-up" title="Upvote"><i class="bi bi-hand-thumbs-up p-0"></i></button>
          <span class="fs-7 fw-bold text-gray-600 dc-vote-count">214</span>
          <button class="btn btn-sm btn-tertiary dc-vote-down" title="Downvote"><i class="bi bi-hand-thumbs-down p-0"></i></button>
        </div>

        <div class="d-flex flex-column py-5 flex-grow-1">
          <div class="row g-0 px-5">

            <div class="col-12 mb-2">
              <div class="d-flex justify-content-between align-items-center">
                <?php $commDetails2 = getCommunityIconDetails('FEUTech'); ?>
                <a href="/Discourse/pages/version/community.php" class="d-flex align-items-center gap-2 text-decoration-none">
                  <div class="d-flex align-items-center justify-content-center rounded-2 <?php echo $commDetails2['bg_class']; ?>"
                    style="width:24px;height:24px;">
                    <i class="bi <?php echo $commDetails2['icon']; ?> fs-8 <?php echo $commDetails2['text_class']; ?>"></i>
                  </div>
                  <span class="fw-bold text-gray-800 text-hover-primary fs-7">c/FEUTech</span>
                </a>
                <button class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#modalReportPost">
                  <i class="bi bi-flag me-1"></i> Report
                </button>
              </div>
            </div>

            <div class="col-12 mb-2">
              <div class="d-flex gap-3 align-items-center">
                <img src="/Discourse/assets/images/catalina.webp" alt="John Doe" class="h-40px w-40px rounded-circle" />
                <div class="d-flex flex-column">
                  <a href="/Discourse/pages/version/profile-other.php" class="fs-6 fw-bold text-gray-800 text-hover-primary">John Doe</a>
                  <span class="text-muted fs-8"><i class="bi bi-clock me-1 fs-8"></i>1d ago</span>
                </div>
              </div>
            </div>

            <div class="col-12 mb-2">
              <div class="d-flex flex-column gap-2 text-start">
                <div>
                  <?php $badge2 = getCategoryBadgeStyle('IDEAS'); ?>
                  <a href="/Discourse/pages/view/topic.php?t=IDEAS" class="badge <?php echo $badge2['class']; ?> rounded-pill px-3 py-2 fs-8 fw-bold text-decoration-none">
                    <i class="bi <?php echo $badge2['icon']; ?> <?php echo $badge2['icon_color']; ?> me-1"></i>
                    IDEAS
                  </a>
                </div>
                <a href="/Discourse/pages/version/view-post.php" class="text-gray-800 text-hover-primary fs-5 fw-bold dc-post-title-link">
                  Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec.
                </a>
                <div class="dc-body-wrap">
                  <span class="fs-7 text-gray-700 dc-body-clamp">
                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus.
                  </span>
                  <a href="#" class="dc-see-more-link fw-semibold cursor-pointer d-none" onclick="dcToggleBody(event, this)">See More</a>
                </div>
              </div>
            </div>

          </div>

          <div class="row">
            <div class="d-flex justify-content-start align-items-center w-100 px-5">
              <button class="btn btn-sm dc-post-comment"><i class="bi bi-chat me-1"></i> 1 Comment</button>
              <button class="btn btn-sm dc-post-share"><i class="bi bi-share me-1"></i> Share</button>
              <button class="btn btn-sm dc-post-save"><i class="bi bi-bookmark me-1"></i> Save</button>
            </div>
          </div>

          <div class="dc-quick-comment-drawer border-top border-gray-200 mt-4 pt-4 px-5" style="display:none;background-color:#fcfdfc;">
            <div class="dc-quick-comments-list mb-4 d-flex flex-column gap-3" style="max-height:180px;overflow-y:auto;">
              <div class="d-flex align-items-start gap-2 fs-7">
                <img src="https://ui-avatars.com/api/?name=Marco+Torres&background=e0f2fe&color=0369a1&rounded=true" class="h-25px w-25px rounded-circle" alt="Marco Torres">
                <div class="bg-light p-2 rounded-3 flex-grow-1">
                  <div class="d-flex justify-content-between">
                    <span class="fw-bold text-gray-800">Marco Torres</span>
                    <span class="text-muted fs-9">3h ago</span>
                  </div>
                  <p class="text-gray-700 m-0 mt-1">Totally agree with the points mentioned here. Looking forward to more updates.</p>
                </div>
              </div>
            </div>
            <form class="dc-quick-comment-form">
              <div class="d-flex align-items-center gap-2">
                <img src="/Discourse/assets/images/catalina.webp" class="h-30px w-30px rounded-circle" alt="User avatar" />
                <input type="text" class="form-control form-control-sm rounded-pill px-4 fs-7 bg-white border border-gray-300" placeholder="Write a quick comment..." required />
                <button type="submit" class="btn btn-sm btn-success rounded-pill px-4 fw-bold" style="background:#0b301f;color:#fff;">Post</button>
              </div>
            </form>
          </div>
        </div>

      </div>
    </div>

    <!-- ── Post Card 3 (Anonymous) ────────────────────────── -->
    <div class="card border-0 shadow mb-5" data-dc="post-card">
      <div class="d-flex">

        <div class="d-flex flex-column align-items-center gap-1 p-3" style="width:55px;flex-shrink:0;background-color:#e8ede9;">
          <button class="btn btn-sm btn-tertiary dc-vote-up" title="Upvote"><i class="bi bi-hand-thumbs-up p-0"></i></button>
          <span class="fs-7 fw-bold text-gray-600 dc-vote-count">214</span>
          <button class="btn btn-sm btn-tertiary dc-vote-down" title="Downvote"><i class="bi bi-hand-thumbs-down p-0"></i></button>
        </div>

        <div class="d-flex flex-column py-5 flex-grow-1">
          <div class="row g-0 px-5">

            <div class="col-12 mb-2">
              <div class="d-flex justify-content-between align-items-center">
                <?php $commDetails3 = getCommunityIconDetails('FEUTech'); ?>
                <a href="/Discourse/pages/version/community.php" class="d-flex align-items-center gap-2 text-decoration-none">
                  <div class="d-flex align-items-center justify-content-center rounded-2 <?php echo $commDetails3['bg_class']; ?>"
                    style="width:24px;height:24px;">
                    <i class="bi <?php echo $commDetails3['icon']; ?> fs-8 <?php echo $commDetails3['text_class']; ?>"></i>
                  </div>
                  <span class="fw-bold text-gray-800 text-hover-primary fs-7">c/FEUTech</span>
                </a>
                <button class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#modalReportPost">
                  <i class="bi bi-flag me-1"></i> Report
                </button>
              </div>
            </div>

            <div class="col-12 mb-2">
              <div class="d-flex gap-3 align-items-center">
                <img src="/Discourse/assets/images/anonymous.png" alt="Anonymous" class="h-40px w-40px rounded-circle" />
                <div class="d-flex flex-column">
                  <a href="javascript:void(0)" class="fs-6 fw-bold text-gray-800 text-hover-primary">Anonymous</a>
                  <span class="text-muted fs-8"><i class="bi bi-clock me-1 fs-8"></i>1d ago</span>
                </div>
              </div>
            </div>

            <div class="col-12 mb-2">
              <div class="d-flex flex-column gap-2 text-start">
                <div>
                  <?php $badge3 = getCategoryBadgeStyle('ISSUES'); ?>
                  <a href="/Discourse/pages/view/topic.php?t=ISSUES" class="badge <?php echo $badge3['class']; ?> rounded-pill px-3 py-2 fs-8 fw-bold text-decoration-none">
                    <i class="bi <?php echo $badge3['icon']; ?> <?php echo $badge3['icon_color']; ?> me-1"></i>
                    ISSUES
                  </a>
                </div>
                <a href="/Discourse/pages/version/view-post.php?anon=1" class="text-gray-800 text-hover-primary fs-5 fw-bold dc-post-title-link">
                  What if FEU had a no-grade-penalty mental health leave policy?
                </a>
                <div class="dc-body-wrap">
                  <span class="fs-7 text-gray-700 dc-body-clamp"> Just thinking — a lot of students I know failed a whole semester because they were dealing with severe anxiety during midterms. The university had no mechanism to help them — just a...</span>
                  <a href="#" class="dc-see-more-link fw-semibold cursor-pointer d-none" onclick="dcToggleBody(event, this)">See More</a>
                </div>
              </div>
            </div>

          </div>

          <div class="row">
            <div class="d-flex justify-content-start align-items-center w-100 px-5">
              <button class="btn btn-sm dc-post-comment"><i class="bi bi-chat me-1"></i> 1 Comment</button>
              <button class="btn btn-sm dc-post-share"><i class="bi bi-share me-1"></i> Share</button>
              <button class="btn btn-sm dc-post-save"><i class="bi bi-bookmark me-1"></i> Save</button>
            </div>
          </div>

          <div class="dc-quick-comment-drawer border-top border-gray-200 mt-4 pt-4 px-5" style="display:none;background-color:#fcfdfc;">
            <div class="dc-quick-comments-list mb-4 d-flex flex-column gap-3" style="max-height:180px;overflow-y:auto;">
              <div class="d-flex align-items-start gap-2 fs-7">
                <img src="/Discourse/assets/images/catalina.webp" class="h-25px w-25px rounded-circle" alt="Ravi Joshi">
                <div class="bg-light p-2 rounded-3 flex-grow-1">
                  <div class="d-flex justify-content-between">
                    <span class="fw-bold text-gray-800">Ravi Joshi</span>
                    <span class="text-muted fs-9">5h ago</span>
                  </div>
                  <p class="text-gray-700 m-0 mt-1">Mental health leaves with academic accommodations would be so helpful, especially during midterms.</p>
                </div>
              </div>
            </div>
            <form class="dc-quick-comment-form">
              <div class="d-flex align-items-center gap-2">
                <img src="/Discourse/assets/images/catalina.webp" class="h-30px w-30px rounded-circle" alt="User avatar" />
                <input type="text" class="form-control form-control-sm rounded-pill px-4 fs-7 bg-white border border-gray-300" placeholder="Write a quick comment..." required />
                <button type="submit" class="btn btn-sm btn-success rounded-pill px-4 fw-bold" style="background:#0b301f;color:#fff;">Post</button>
              </div>
            </form>
          </div>
        </div>

      </div>
    </div>

    <!-- ── Post Card 4 ─────────────────────────────────────── -->
    <div class="card border-0 shadow mb-5" data-dc="post-card">
      <div class="d-flex">

        <div class="d-flex flex-column align-items-center gap-1 p-3" style="width:55px;flex-shrink:0;background-color:#e8ede9;">
          <button class="btn btn-sm btn-tertiary dc-vote-up" title="Upvote"><i class="bi bi-hand-thumbs-up p-0"></i></button>
          <span class="fs-7 fw-bold text-gray-600 dc-vote-count">214</span>
          <button class="btn btn-sm btn-tertiary dc-vote-down" title="Downvote"><i class="bi bi-hand-thumbs-down p-0"></i></button>
        </div>

        <div class="d-flex flex-column py-5 flex-grow-1">
          <div class="row g-0 px-5">

            <div class="col-12 mb-2">
              <div class="d-flex justify-content-between align-items-center">
                <?php $commDetails4 = getCommunityIconDetails('FEUTech'); ?>
                <a href="/Discourse/pages/version/community.php" class="d-flex align-items-center gap-2 text-decoration-none">
                  <div class="d-flex align-items-center justify-content-center rounded-2 <?php echo $commDetails4['bg_class']; ?>"
                    style="width:24px;height:24px;">
                    <i class="bi <?php echo $commDetails4['icon']; ?> fs-8 <?php echo $commDetails4['text_class']; ?>"></i>
                  </div>
                  <span class="fw-bold text-gray-800 text-hover-primary fs-7">c/FEUTech</span>
                </a>
                <button class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#modalReportPost">
                  <i class="bi bi-flag me-1"></i> Report
                </button>
              </div>
            </div>

            <div class="col-12 mb-2">
              <div class="d-flex gap-3 align-items-center">
                <img src="/Discourse/assets/images/catalina.webp" alt="John Doe" class="h-40px w-40px rounded-circle" />
                <div class="d-flex flex-column">
                  <a href="/Discourse/pages/version/profile-other.php" class="fs-6 fw-bold text-gray-800 text-hover-primary">John Doe</a>
                  <span class="text-muted fs-8"><i class="bi bi-clock me-1 fs-8"></i>1d ago</span>
                </div>
              </div>
            </div>

            <div class="col-12 mb-2">
              <div class="d-flex flex-column gap-2 text-start">
                <div>
                  <?php $badge4 = getCategoryBadgeStyle('ENTERTAINMENT'); ?>
                  <a href="/Discourse/pages/view/topic.php?t=ENTERTAINMENT" class="badge <?php echo $badge4['class']; ?> rounded-pill px-3 py-2 fs-8 fw-bold text-decoration-none">
                    <i class="bi <?php echo $badge4['icon']; ?> <?php echo $badge4['icon_color']; ?> me-1"></i>
                    ENTERTAINMENT
                  </a>
                </div>
                <a href="/Discourse/pages/version/view-post.php?sample=1" class="text-gray-800 text-hover-primary fs-5 fw-bold dc-post-title-link">
                  Lorem ipsum dolor sit amet consectetur adipiscing elit.
                </a>
                <div class="dc-body-wrap">
                  <span class="fs-7 text-gray-700 dc-body-clamp"> Lorem ipsum dolor sit amet consectetur adipiscing elit. Quisque faucibus ex sapien vitae pellentesque sem placerat. In id cursus mi pretium tellus duis convallis. Tempus leo eu aenean sed diam uma tempor.</span>
                  <a href="#" class="dc-see-more-link fw-semibold cursor-pointer d-none" onclick="dcToggleBody(event, this)">See More</a>
                </div>
              </div>
            </div>

          </div>

          <div class="row">
            <div class="d-flex justify-content-start align-items-center w-100 px-5">
              <button class="btn btn-sm dc-post-comment"><i class="bi bi-chat me-1"></i> 1 Comment</button>
              <button class="btn btn-sm dc-post-share"><i class="bi bi-share me-1"></i> Share</button>
              <button class="btn btn-sm dc-post-save"><i class="bi bi-bookmark me-1"></i> Save</button>
            </div>
          </div>

          <div class="dc-quick-comment-drawer border-top border-gray-200 mt-4 pt-4 px-5" style="display:none;background-color:#fcfdfc;">
            <div class="dc-quick-comments-list mb-4 d-flex flex-column gap-3" style="max-height:180px;overflow-y:auto;">
              <div class="d-flex align-items-start gap-2 fs-7">
                <img src="/Discourse/assets/images/catalina.webp" class="h-25px w-25px rounded-circle" alt="Catalina Smith">
                <div class="bg-light p-2 rounded-3 flex-grow-1">
                  <div class="d-flex justify-content-between">
                    <span class="fw-bold text-gray-800">Catalina Smith</span>
                    <span class="text-muted fs-9">1h ago</span>
                  </div>
                  <p class="text-gray-700 m-0 mt-1">Excellent writeup! Easy to follow and super insightful.</p>
                </div>
              </div>
            </div>
            <form class="dc-quick-comment-form">
              <div class="d-flex align-items-center gap-2">
                <img src="/Discourse/assets/images/catalina.webp" class="h-30px w-30px rounded-circle" alt="User avatar" />
                <input type="text" class="form-control form-control-sm rounded-pill px-4 fs-7 bg-white border border-gray-300" placeholder="Write a quick comment..." required />
                <button type="submit" class="btn btn-sm btn-success rounded-pill px-4 fw-bold" style="background:#0b301f;color:#fff;">Post</button>
              </div>
            </form>
          </div>
        </div>

      </div>
    </div>

    <!-- ── Post Card 5 — POLL ──────────────────────────────── -->
    <div class="card border-0 shadow mb-5" data-dc="post-card">
      <div class="d-flex">

        <div class="d-flex flex-column align-items-center gap-1 p-3" style="width:55px;flex-shrink:0;background-color:#e8ede9;">
          <button class="btn btn-sm btn-tertiary dc-vote-up" title="Upvote"><i class="bi bi-hand-thumbs-up p-0"></i></button>
          <span class="fs-7 fw-bold text-gray-600 dc-vote-count">456</span>
          <button class="btn btn-sm btn-tertiary dc-vote-down" title="Downvote"><i class="bi bi-hand-thumbs-down p-0"></i></button>
        </div>

        <div class="d-flex flex-column py-5 flex-grow-1">
          <div class="row g-0 px-5">

            <div class="col-12 mb-2">
              <div class="d-flex justify-content-between align-items-center">
                <?php $commDetails5 = getCommunityIconDetails('FEULife'); ?>
                <a href="/Discourse/pages/version/community.php" class="d-flex align-items-center gap-2 text-decoration-none">
                  <div class="d-flex align-items-center justify-content-center rounded-2 <?php echo $commDetails5['bg_class']; ?>"
                    style="width:24px;height:24px;">
                    <i class="bi <?php echo $commDetails5['icon']; ?> fs-8 <?php echo $commDetails5['text_class']; ?>"></i>
                  </div>
                  <span class="fw-bold text-gray-800 text-hover-primary fs-7">c/FEULife</span>
                </a>
                <button class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#modalReportPost">
                  <i class="bi bi-flag me-1"></i> Report
                </button>
              </div>
            </div>

            <div class="col-12 mb-2">
              <div class="d-flex gap-3 align-items-center">
                <img src="/Discourse/assets/images/catalina.webp" alt="Marco Torres" class="h-40px w-40px rounded-circle" />
                <div class="d-flex flex-column">
                  <a href="/Discourse/pages/version/profile-other.php" class="fs-6 fw-bold text-gray-800 text-hover-primary">Marco Torres</a>
                  <span class="text-muted fs-8"><i class="bi bi-clock me-1 fs-8"></i>4h ago</span>
                </div>
              </div>
            </div>

            <div class="col-12 mb-2">
              <div class="d-flex flex-column gap-2 text-start">
                <div>
                  <?php $badge5 = getCategoryBadgeStyle('FEU'); ?>
                  <a href="/Discourse/pages/view/topic.php?t=FEU" class="badge <?php echo $badge5['class']; ?> rounded-pill px-3 py-2 fs-8 fw-bold text-decoration-none">
                    <i class="bi <?php echo $badge5['icon']; ?> <?php echo $badge5['icon_color']; ?> me-1"></i>
                    FEU
                  </a>
                </div>
                <a href="/Discourse/pages/version/view-post.php?poll=1" class="text-gray-800 text-hover-primary fs-5 fw-bold dc-post-title-link">
                  📊 Poll: How do you actually study for finals? Be honest.
                </a>
                <span class="fs-7 text-gray-700 mb-2 dc-body-clamp">
                  Curious how my fellow FEU Tech students survive finals season. Drop your honest answer below 👇
                </span>
                <a href="#" class="dc-see-more-link fw-semibold cursor-pointer d-none" onclick="dcToggleBody(event, this)">See More</a>
              </div>
            </div>

            <!-- Poll Options -->
            <div class="col-12 mb-2">
              <div class="d-flex flex-column gap-2 mb-2 discourse-poll-options">
                <button class="discourse-poll-option" data-poll-id="finals-poll" data-option="0" style="--target-width: 28%;">
                  <span class="fs-7 fw-bold text-gray-800">Start early, study consistently</span>
                  <span class="fs-7 fw-bold text-gray-800 discourse-poll-percentage">28%</span>
                </button>
                <button class="discourse-poll-option" data-poll-id="finals-poll" data-option="1" style="--target-width: 45%;">
                  <span class="fs-7 fw-bold text-gray-800">Cram the night before</span>
                  <span class="fs-7 fw-bold text-gray-800 discourse-poll-percentage">45%</span>
                </button>
                <button class="discourse-poll-option" data-poll-id="finals-poll" data-option="2" style="--target-width: 19%;">
                  <span class="fs-7 fw-bold text-gray-800">Rely on group chats and past papers</span>
                  <span class="fs-7 fw-bold text-gray-800 discourse-poll-percentage">19%</span>
                </button>
                <button class="discourse-poll-option" data-poll-id="finals-poll" data-option="3" style="--target-width: 8%;">
                  <span class="fs-7 fw-bold text-gray-800">Pray and submit anyway</span>
                  <span class="fs-7 fw-bold text-gray-800 discourse-poll-percentage">8%</span>
                </button>
              </div>
              <span class="fs-8 text-muted">442 votes · 3 days left</span>
            </div>

          </div>

          <div class="row mt-2">
            <div class="d-flex justify-content-start align-items-center w-100 px-5">
              <button class="btn btn-sm dc-post-comment"><i class="bi bi-chat me-1"></i> 1 Comment</button>
              <button class="btn btn-sm dc-post-share"><i class="bi bi-share me-1"></i> Share</button>
              <button class="btn btn-sm dc-post-save"><i class="bi bi-bookmark me-1"></i> Save</button>
            </div>
          </div>

          <div class="dc-quick-comment-drawer border-top border-gray-200 mt-4 pt-4 px-5" style="display:none;background-color:#fcfdfc;">
            <div class="dc-quick-comments-list mb-4 d-flex flex-column gap-3" style="max-height:180px;overflow-y:auto;">
              <div class="d-flex align-items-start gap-2 fs-7">
                <img src="/Discourse/assets/images/catalina.webp" class="h-25px w-25px rounded-circle" alt="Catalina Smith">
                <div class="bg-light p-2 rounded-3 flex-grow-1">
                  <div class="d-flex justify-content-between">
                    <span class="fw-bold text-gray-800">Catalina Smith</span>
                    <span class="text-muted fs-9">4h ago</span>
                  </div>
                  <p class="text-gray-700 m-0 mt-1">I cram the night before but always tell myself I'll start early next time 😂</p>
                </div>
              </div>
            </div>
            <form class="dc-quick-comment-form">
              <div class="d-flex align-items-center gap-2">
                <img src="/Discourse/assets/images/catalina.webp" class="h-30px w-30px rounded-circle" alt="User avatar" />
                <input type="text" class="form-control form-control-sm rounded-pill px-4 fs-7 bg-white border border-gray-300" placeholder="Write a quick comment..." required />
                <button type="submit" class="btn btn-sm btn-success rounded-pill px-4 fw-bold" style="background:#0b301f;color:#fff;">Post</button>
              </div>
            </form>
          </div>
        </div>

      </div>
    </div>

    <!-- ── Post Card 6 ─────────────────────────────────────── -->
    <div class="card border-0 shadow mb-5" data-dc="post-card">
      <div class="d-flex">

        <div class="d-flex flex-column align-items-center gap-1 p-3" style="width:55px;flex-shrink:0;background-color:#e8ede9;">
          <button class="btn btn-sm btn-tertiary dc-vote-up" title="Upvote"><i class="bi bi-hand-thumbs-up p-0"></i></button>
          <span class="fs-7 fw-bold text-gray-600 dc-vote-count">214</span>
          <button class="btn btn-sm btn-tertiary dc-vote-down" title="Downvote"><i class="bi bi-hand-thumbs-down p-0"></i></button>
        </div>

        <div class="d-flex flex-column py-5 flex-grow-1">
          <div class="row g-0 px-5">

            <div class="col-12 mb-2">
              <div class="d-flex justify-content-between align-items-center">
                <?php $commDetails6 = getCommunityIconDetails('FEUTech'); ?>
                <a href="/Discourse/pages/version/community.php" class="d-flex align-items-center gap-2 text-decoration-none">
                  <div class="d-flex align-items-center justify-content-center rounded-2 <?php echo $commDetails6['bg_class']; ?>"
                    style="width:24px;height:24px;">
                    <i class="bi <?php echo $commDetails6['icon']; ?> fs-8 <?php echo $commDetails6['text_class']; ?>"></i>
                  </div>
                  <span class="fw-bold text-gray-800 text-hover-primary fs-7">c/FEUTech</span>
                </a>
                <button class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#modalReportPost">
                  <i class="bi bi-flag me-1"></i> Report
                </button>
              </div>
            </div>

            <div class="col-12 mb-2">
              <div class="d-flex gap-3 align-items-center">
                <img src="/Discourse/assets/images/catalina.webp" alt="Catalina Smith" class="h-40px w-40px rounded-circle" />
                <div class="d-flex flex-column">
                  <a href="/Discourse/pages/version/profile.php" class="fs-6 fw-bold text-gray-800 text-hover-primary">Catalina Smith</a>
                  <span class="text-muted fs-8"><i class="bi bi-clock me-1 fs-8"></i>1d ago</span>
                </div>
              </div>
            </div>

            <div class="col-12 mb-2">
              <div class="d-flex flex-column gap-2 text-start">
                <div>
                  <?php $badge6 = getCategoryBadgeStyle('ACADEMICS'); ?>
                  <a href="/Discourse/pages/view/topic.php?t=ACADEMICS" class="badge <?php echo $badge6['class']; ?> rounded-pill px-3 py-2 fs-8 fw-bold text-decoration-none">
                    <i class="bi <?php echo $badge6['icon']; ?> <?php echo $badge6['icon_color']; ?> me-1"></i>
                    ACADEMICS
                  </a>
                </div>
                <a href="/Discourse/pages/version/view-post.php?img=1" class="text-gray-800 text-hover-primary fs-5 fw-bold dc-post-title-link">
                  FEU Tech library study rooms — worth booking or just use the hallway?
                </a>
                <div class="dc-body-wrap">
                  <span class="fs-7 text-gray-700 dc-body-clamp"> Finally tried booking one of the new study rooms in the library. Honest review: the booking system is clunky, the AC is questionable, but the...</span>
                  <a href="#" class="dc-see-more-link fw-semibold cursor-pointer d-none" onclick="dcToggleBody(event, this)">See More</a>
                </div>
              </div>
            </div>

          </div>

          <div class="row">
            <div class="d-flex justify-content-start align-items-center w-100 px-5">
              <button class="btn btn-sm dc-post-comment"><i class="bi bi-chat me-1"></i> 1 Comment</button>
              <button class="btn btn-sm dc-post-share"><i class="bi bi-share me-1"></i> Share</button>
              <button class="btn btn-sm dc-post-save"><i class="bi bi-bookmark me-1"></i> Save</button>
            </div>
          </div>

          <div class="dc-quick-comment-drawer border-top border-gray-200 mt-4 pt-4 px-5" style="display:none;background-color:#fcfdfc;">
            <div class="dc-quick-comments-list mb-4 d-flex flex-column gap-3" style="max-height:180px;overflow-y:auto;">
              <div class="d-flex align-items-start gap-2 fs-7">
                <img src="/Discourse/assets/images/catalina.webp" class="h-25px w-25px rounded-circle" alt="Ravi Joshi">
                <div class="bg-light p-2 rounded-3 flex-grow-1">
                  <div class="d-flex justify-content-between">
                    <span class="fw-bold text-gray-800">Ravi Joshi</span>
                    <span class="text-muted fs-9">30m ago</span>
                  </div>
                  <p class="text-gray-700 m-0 mt-1">Hallway is always too noisy for group discussions, booking a room is definitely worth it!</p>
                </div>
              </div>
            </div>
            <form class="dc-quick-comment-form">
              <div class="d-flex align-items-center gap-2">
                <img src="/Discourse/assets/images/catalina.webp" class="h-30px w-30px rounded-circle" alt="User avatar" />
                <input type="text" class="form-control form-control-sm rounded-pill px-4 fs-7 bg-white border border-gray-300" placeholder="Write a quick comment..." required />
                <button type="submit" class="btn btn-sm btn-success rounded-pill px-4 fw-bold" style="background:#0b301f;color:#fff;">Post</button>
              </div>
            </form>
          </div>
        </div>

      </div>
    </div>

  </div><!-- end #posts-hot -->

  <!-- ── NEW Tab ────────────────────────────────────────────── -->
  <div class="tab-pane fade" id="posts-new" role="tabpanel" aria-labelledby="tab-new">
    <div class="text-center text-muted py-5">
      <i class="bi bi-lightning-charge fs-1 d-block mb-2"></i>
      New posts will appear here.
    </div>
  </div>

  <!-- ── TOP Tab ────────────────────────────────────────────── -->
  <div class="tab-pane fade" id="posts-top" role="tabpanel" aria-labelledby="tab-top">
    <div class="text-center text-muted py-5">
      <i class="bi bi-trophy fs-1 d-block mb-2"></i>
      Top posts will appear here.
    </div>
  </div>

  <!-- ── Feed Toast (Share / Save feedback) ─────────────────── -->
  <div id="dc-feed-toast" style="display:none;position:fixed;bottom:1.5rem;right:1.5rem;z-index:1090;" class="d-flex align-items-center gap-2 px-4 py-2 bg-light border rounded-2 fs-6 text-gray-700 shadow-sm">
    <i class="bi bi-check-circle-fill text-success"></i><span></span>
  </div>

  <!-- ── RISING Tab ─────────────────────────────────────────── -->
  <div class="tab-pane fade" id="posts-rising" role="tabpanel" aria-labelledby="tab-rising">
    <div class="text-center text-muted py-5">
      <i class="bi bi-graph-up-arrow fs-1 d-block mb-2"></i>
      Rising posts will appear here.
    </div>
  </div>

</div>