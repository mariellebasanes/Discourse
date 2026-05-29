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
                <?php 
                $commDetails1 = getCommunityIconDetails('FEUTech'); 
                ?>
                <a href="/Discourse/pages/version/community.php" class="d-flex align-items-center gap-2 text-decoration-none">
                  <div class="d-flex align-items-center justify-content-center rounded-2"
                       style="width: 24px; height: 24px; background-color: <?php echo $commDetails1['bg_hex']; ?>;">
                    <i class="bi <?php echo $commDetails1['icon']; ?> fs-8"
                       style="color: <?php echo $commDetails1['color_hex']; ?>;"></i>
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
                  <span class="badge rounded px-3 py-1 fs-8 fw-bold text-white" style="<?php echo getCategoryBadgeStyle('TECHNOLOGY'); ?>">TECHNOLOGY</span>
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
          <div class="dc-quick-comment-drawer border-top border-gray-200 mt-4 pt-4 px-5" style="display: none; background-color: #fcfdfc;">
            <div class="dc-quick-comments-list mb-4 d-flex flex-column gap-3" style="max-height: 180px; overflow-y: auto;">
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
                <button type="submit" class="btn btn-sm btn-success rounded-pill px-4 fw-bold" style="background:#0b301f; color:#fff;">Post</button>
              </div>
            </form>
          </div>
        </div>

      </div>
    </div>

    <!-- ── Post Card 2 ─────────────────────────────────────── -->
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
                <?php 
                $commDetails2 = getCommunityIconDetails('FEUTech'); 
                ?>
                <a href="/Discourse/pages/version/community.php" class="d-flex align-items-center gap-2 text-decoration-none">
                  <div class="d-flex align-items-center justify-content-center rounded-2"
                       style="width: 24px; height: 24px; background-color: <?php echo $commDetails2['bg_hex']; ?>;">
                    <i class="bi <?php echo $commDetails2['icon']; ?> fs-8"
                       style="color: <?php echo $commDetails2['color_hex']; ?>;"></i>
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
                <img src="/Discourse/assets/images/catalina.webp" alt="John Doe" class="h-40px w-40px rounded-circle" />
                <div class="d-flex flex-column">
                  <a href="/Discourse/pages/version/profile-other.php" class="fs-6 fw-bold text-gray-800 text-hover-primary">John Doe</a>
                  <span class="text-muted fs-8"><i class="bi bi-clock me-1 fs-8"></i>1d ago</span>
                </div>
              </div>
            </div>

            <!-- Row 3: Title + Excerpt -->
            <div class="col-12 mb-2">
              <div class="d-flex flex-column gap-2 text-start">
                <div>
                  <span class="badge rounded px-3 py-1 fs-8 fw-bold text-white" style="<?php echo getCategoryBadgeStyle('TECHNOLOGY'); ?>">TECHNOLOGY</span>
                </div>
                <a href="/Discourse/pages/version/view-post.php" class="text-gray-800 text-hover-primary fs-5 fw-bold dc-post-title-link">
                  Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec.
                </a>
                <div class="dc-body-wrap">
                  <span class="fs-7 text-gray-700 dc-body-clamp">
                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc, quis gravida magna mi a libero. Fusce vulputate eleifend sapien. Vestibulum purus quam, scelerisque ut, mollis sed, nonummy id, metus. Nullam accumsan lorem in dui. Cras ultricies mi eu turpis hendrerit fringilla. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; In ac dui quis mi consectetuer lacinia. Nam pretium turpis et arcu. Duis arcu tortor, suscipit eget, imperdiet nec, imperdiet iaculis, ipsum. Sed aliquam ultrices mauris. Integer ante arcu, accumsan a, consectetuer eget, posuere ut, mauris. Praesent adipiscing. Phasellus ullamcorper ipsum rutrum nunc. Nunc nonummy metus. Vestib
                  </span>
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
          <div class="dc-quick-comment-drawer border-top border-gray-200 mt-4 pt-4 px-5" style="display: none; background-color: #fcfdfc;">
            <div class="dc-quick-comments-list mb-4 d-flex flex-column gap-3" style="max-height: 180px; overflow-y: auto;">
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
                <button type="submit" class="btn btn-sm btn-success rounded-pill px-4 fw-bold" style="background:#0b301f; color:#fff;">Post</button>
              </div>
            </form>
          </div>
        </div>

      </div>
    </div>

    <!-- ── Post Card 3 (Anonymous) ────────────────────────── -->
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
                <?php 
                $commDetails3 = getCommunityIconDetails('FEUTech'); 
                ?>
                <a href="/Discourse/pages/version/community.php" class="d-flex align-items-center gap-2 text-decoration-none">
                  <div class="d-flex align-items-center justify-content-center rounded-2"
                       style="width: 24px; height: 24px; background-color: <?php echo $commDetails3['bg_hex']; ?>;">
                    <i class="bi <?php echo $commDetails3['icon']; ?> fs-8"
                       style="color: <?php echo $commDetails3['color_hex']; ?>;"></i>
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
                <img src="/Discourse/assets/images/anonymous.png" alt="Anonymous" class="h-40px w-40px rounded-circle" />
                <div class="d-flex flex-column">
                  <a href="javascript:void(0)" class="fs-6 fw-bold text-gray-800 text-hover-primary">Anonymous</a>
                  <span class="text-muted fs-8"><i class="bi bi-clock me-1 fs-8"></i>1d ago</span>
                </div>
              </div>
            </div>

            <!-- Row 3: Title + Excerpt -->
            <div class="col-12 mb-2">
              <div class="d-flex flex-column gap-2 text-start">
                <div>
                  <span class="badge rounded px-3 py-1 fs-8 fw-bold text-white" style="<?php echo getCategoryBadgeStyle('TECHNOLOGY'); ?>">TECHNOLOGY</span>
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

          <!-- Actions Row -->
          <div class="row">
            <div class="d-flex justify-content-start align-items-center w-100 px-5">
              <button class="btn btn-sm dc-post-comment"><i class="bi bi-chat me-1"></i> 1 Comment</button>
              <button class="btn btn-sm dc-post-share"><i class="bi bi-share me-1"></i> Share</button>
              <button class="btn btn-sm dc-post-save"><i class="bi bi-bookmark me-1"></i> Save</button>
            </div>
          </div>

          <!-- Inline Quick Comment Drawer -->
          <div class="dc-quick-comment-drawer border-top border-gray-200 mt-4 pt-4 px-5" style="display: none; background-color: #fcfdfc;">
            <div class="dc-quick-comments-list mb-4 d-flex flex-column gap-3" style="max-height: 180px; overflow-y: auto;">
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
                <button type="submit" class="btn btn-sm btn-success rounded-pill px-4 fw-bold" style="background:#0b301f; color:#fff;">Post</button>
              </div>
            </form>
          </div>
        </div>

      </div>
    </div>

    <!-- ── Post Card 4 ─────────────────────────────────────── -->
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
                <?php 
                $commDetails4 = getCommunityIconDetails('FEUTech'); 
                ?>
                <a href="/Discourse/pages/version/community.php" class="d-flex align-items-center gap-2 text-decoration-none">
                  <div class="d-flex align-items-center justify-content-center rounded-2"
                       style="width: 24px; height: 24px; background-color: <?php echo $commDetails4['bg_hex']; ?>;">
                    <i class="bi <?php echo $commDetails4['icon']; ?> fs-8"
                       style="color: <?php echo $commDetails4['color_hex']; ?>;"></i>
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
                <img src="/Discourse/assets/images/catalina.webp" alt="John Doe" class="h-40px w-40px rounded-circle" />
                <div class="d-flex flex-column">
                  <a href="/Discourse/pages/version/profile-other.php" class="fs-6 fw-bold text-gray-800 text-hover-primary">John Doe</a>
                  <span class="text-muted fs-8"><i class="bi bi-clock me-1 fs-8"></i>1d ago</span>
                </div>
              </div>
            </div>

            <!-- Row 3: Title + Excerpt -->
            <div class="col-12 mb-2">
              <div class="d-flex flex-column gap-2 text-start">
                <div>
                  <span class="badge rounded px-3 py-1 fs-8 fw-bold text-white" style="<?php echo getCategoryBadgeStyle('TECHNOLOGY'); ?>">TECHNOLOGY</span>
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

          <!-- Actions Row -->
          <div class="row">
            <div class="d-flex justify-content-start align-items-center w-100 px-5">
              <button class="btn btn-sm dc-post-comment"><i class="bi bi-chat me-1"></i> 1 Comment</button>
              <button class="btn btn-sm dc-post-share"><i class="bi bi-share me-1"></i> Share</button>
              <button class="btn btn-sm dc-post-save"><i class="bi bi-bookmark me-1"></i> Save</button>
            </div>
          </div>

          <!-- Inline Quick Comment Drawer -->
          <div class="dc-quick-comment-drawer border-top border-gray-200 mt-4 pt-4 px-5" style="display: none; background-color: #fcfdfc;">
            <div class="dc-quick-comments-list mb-4 d-flex flex-column gap-3" style="max-height: 180px; overflow-y: auto;">
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
                <button type="submit" class="btn btn-sm btn-success rounded-pill px-4 fw-bold" style="background:#0b301f; color:#fff;">Post</button>
              </div>
            </form>
          </div>
        </div>

      </div>
    </div>

    <!-- ── Post Card 5 — POLL ──────────────────────────────── -->
    <div class="card border-0 shadow mb-5" data-dc="post-card">
      <div class="d-flex">

        <!-- Vote Column -->
        <div class="d-flex flex-column align-items-center gap-1 p-3" style="width:55px;flex-shrink:0;background-color:#e8ede9;">
          <button class="btn btn-sm btn-tertiary dc-vote-up" title="Upvote">
            <i class="bi bi-hand-thumbs-up p-0"></i>
          </button>
          <span class="fs-7 fw-bold text-gray-600 dc-vote-count">456</span>
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
                <?php 
                $commDetails5 = getCommunityIconDetails('FEULife'); 
                ?>
                <a href="/Discourse/pages/version/community.php" class="d-flex align-items-center gap-2 text-decoration-none">
                  <div class="d-flex align-items-center justify-content-center rounded-2"
                       style="width: 24px; height: 24px; background-color: <?php echo $commDetails5['bg_hex']; ?>;">
                    <i class="bi <?php echo $commDetails5['icon']; ?> fs-8"
                       style="color: <?php echo $commDetails5['color_hex']; ?>;"></i>
                  </div>
                  <span class="fw-bold text-gray-800 text-hover-primary fs-7">c/FEULife</span>
                </a>
                <button class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#modalReportPost">
                  <i class="bi bi-flag me-1"></i> Report
                </button>
              </div>
            </div>

            <!-- Row 2: Avatar + Author name + Timestamp -->
            <div class="col-12 mb-2">
              <div class="d-flex gap-3 align-items-center">
                <img src="/Discourse/assets/images/catalina.webp" alt="Marco Torres" class="h-40px w-40px rounded-circle" />
                <div class="d-flex flex-column">
                  <a href="/Discourse/pages/version/profile-other.php" class="fs-6 fw-bold text-gray-800 text-hover-primary">Marco Torres</a>
                  <span class="text-muted fs-8"><i class="bi bi-clock me-1 fs-8"></i>4h ago</span>
                </div>
              </div>
            </div>

            <!-- Row 3: Title + Excerpt -->
            <div class="col-12 mb-2">
              <div class="d-flex flex-column gap-2 text-start">
                <div>
                  <span class="badge rounded px-3 py-1 fs-8 fw-bold text-white" style="<?php echo getCategoryBadgeStyle('FEU'); ?>">FEU</span>
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

          <!-- Actions Row -->
          <div class="row mt-2">
            <div class="d-flex justify-content-start align-items-center w-100 px-5">
              <button class="btn btn-sm dc-post-comment"><i class="bi bi-chat me-1"></i> 1 Comment</button>
              <button class="btn btn-sm dc-post-share"><i class="bi bi-share me-1"></i> Share</button>
              <button class="btn btn-sm dc-post-save"><i class="bi bi-bookmark me-1"></i> Save</button>
            </div>
          </div>

          <!-- Inline Quick Comment Drawer -->
          <div class="dc-quick-comment-drawer border-top border-gray-200 mt-4 pt-4 px-5" style="display: none; background-color: #fcfdfc;">
            <div class="dc-quick-comments-list mb-4 d-flex flex-column gap-3" style="max-height: 180px; overflow-y: auto;">
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
                <button type="submit" class="btn btn-sm btn-success rounded-pill px-4 fw-bold" style="background:#0b301f; color:#fff;">Post</button>
              </div>
            </form>
          </div>
        </div>

      </div>
    </div>

    <!-- ── Post Card 6 ─────────────────────────────────────── -->
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
                <?php 
                $commDetails6 = getCommunityIconDetails('FEUTech'); 
                ?>
                <a href="/Discourse/pages/version/community.php" class="d-flex align-items-center gap-2 text-decoration-none">
                  <div class="d-flex align-items-center justify-content-center rounded-2"
                       style="width: 24px; height: 24px; background-color: <?php echo $commDetails6['bg_hex']; ?>;">
                    <i class="bi <?php echo $commDetails6['icon']; ?> fs-8"
                       style="color: <?php echo $commDetails6['color_hex']; ?>;"></i>
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
                <img src="/Discourse/assets/images/catalina.webp" alt="Catalina Smith" class="h-40px w-40px rounded-circle" />
                <div class="d-flex flex-column">
                  <a href="/Discourse/pages/version/profile.php" class="fs-6 fw-bold text-gray-800 text-hover-primary">Catalina Smith</a>
                  <span class="text-muted fs-8"><i class="bi bi-clock me-1 fs-8"></i>1d ago</span>
                </div>
              </div>
            </div>

            <!-- Row 3: Title + Excerpt -->
            <div class="col-12 mb-2">
              <div class="d-flex flex-column gap-2 text-start">
                <div>
                  <span class="badge rounded px-3 py-1 fs-8 fw-bold text-white" style="<?php echo getCategoryBadgeStyle('TECHNOLOGY'); ?>">TECHNOLOGY</span>
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

          <!-- Actions Row -->
          <div class="row">
            <div class="d-flex justify-content-start align-items-center w-100 px-5">
              <button class="btn btn-sm dc-post-comment"><i class="bi bi-chat me-1"></i> 1 Comment</button>
              <button class="btn btn-sm dc-post-share"><i class="bi bi-share me-1"></i> Share</button>
              <button class="btn btn-sm dc-post-save"><i class="bi bi-bookmark me-1"></i> Save</button>
            </div>
          </div>

          <!-- Inline Quick Comment Drawer -->
          <div class="dc-quick-comment-drawer border-top border-gray-200 mt-4 pt-4 px-5" style="display: none; background-color: #fcfdfc;">
            <div class="dc-quick-comments-list mb-4 d-flex flex-column gap-3" style="max-height: 180px; overflow-y: auto;">
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
                <button type="submit" class="btn btn-sm btn-success rounded-pill px-4 fw-bold" style="background:#0b301f; color:#fff;">Post</button>
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
