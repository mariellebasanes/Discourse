<?php
define('MBG', TRUE);
include($_SERVER['DOCUMENT_ROOT'] . '/functions-new.php');

$META_TITLE = "Poll: How do you actually study for finals? Be honest.";
$META_DESC  = "A poll from FEU Tech Discourse community.";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php HEAD_ESSENTIALS(); ?>
  <link href="/Discourse/assets/css/dashboard.css" rel="stylesheet" type="text/css" />
  <link href="/Discourse/assets/css/sec-posts.css" rel="stylesheet" type="text/css" />
  <link href="/Discourse/assets/css/sec-modals.css" rel="stylesheet" type="text/css" />

  <style>
    .bg-light-success                          { background-color: #e8ede9 !important; }
    .btn-light-success                         { background-color: #e8ede9 !important; color: #3a5c45 !important; }
    .btn-light-success:hover,
    .btn-light-success:focus                   { background-color: #dce8df !important; color: #3a5c45 !important; }
    .badge-light-success                       { background-color: #dce8df; color: #3a5c45; }
    .border-success                            { border-color: #c2d4c8 !important; }
    .btn-success                               { background-color: #3a5c45 !important; border-color: #3a5c45 !important; }
    .btn-success:hover,
    .btn-success:focus,
    .btn-success:active                        { background-color: #2e4a38 !important; border-color: #2e4a38 !important; }
  </style>
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

              <div style="background: linear-gradient(135deg, #0b3220 0%, #1a5c38 60%, #3a5c45 100%); padding: 28px 0 22px;">
                <div class="app-container container-xxl position-relative">
                  <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap">
                    <div>
                      <div class="d-flex align-items-center gap-2 mb-2">
                        <i class="bi bi-eye-fill text-white opacity-75 fs-7"></i>
                        <span class="text-white opacity-75 fs-8 fw-bold text-uppercase ls-1">Viewing Post</span>
                      </div>
                      <h1 class="text-white fs-2 fw-bolder mb-1">
                        <span class="me-2">📊</span>How do you actually study for finals? Be honest.
                      </h1>
                      <p class="text-white opacity-65 fs-7 mb-0">
                        <span class="me-1">FEU · Academic Life</span>·
                        <span class="mx-1">Posted by Marco Torres</span>·
                        <span class="mx-1">4h ago · 442 votes</span>
                      </p>
                    </div>
                    <a href="/Discourse/index.php" class="btn btn-sm btn-light fw-bold flex-shrink-0 mt-2">
                      <i class="bi bi-arrow-left me-1"></i> Back to Feed
                    </a>
                  </div>
                </div>
              </div>
              <div id="kt_app_content" class="flex-column-fluid">
                <div class="app-container container-xxl py-5">
                  <div class="row g-5 align-items-start">

                    <div class="col-lg-8">
                      <div class="card border-0 shadow mb-5">

                        <div class="card-body pb-0 pt-5 px-5">

                        
                          <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="badge badge-light-success rounded-pill px-5 py-2 fs-8" style="color:#3a5c45;">FEUTech</span>
                            <button class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#modalReportPost">
                              <i class="bi bi-flag me-1"></i> Report
                            </button>
                          </div>

                          <div class="d-flex gap-3 align-items-center mb-4">
                            <img src="/Discourse/assets/images/catalina.webp" alt="Marco Torres" class="h-40px w-40px rounded-circle" />
                            <div class="d-flex flex-column">
                              <a href="#" class="fs-6 fw-bold text-gray-800 text-hover-primary">Marco Torres</a>
                              <span class="text-muted fs-8"><i class="bi bi-clock me-1 fs-8"></i>4h ago</span>
                            </div>
                            <span class="badge badge-light-success rounded-pill px-5 py-2 fs-8" style="color:#3a5c45;">ACADEMIC LIFE</span>
                          </div>

                          <h2 class="fs-3 fw-bold text-gray-800 mb-4">
                            📊 Poll: How do you actually study for finals? Be honest.
                          </h2>
                        </div>

                        <div class="card-body pt-0 px-5">
                          <div class="dc-post-body-wrap">
                            <div class="dc-body-text">
                              <p class="fs-6 text-gray-700 mb-5">
                                Curious how my fellow FEU Tech students survive finals season. Drop your honest answer below 👇
                              </p>
                            </div>
                            <a href="#" class="dc-see-more-link d-none" onclick="dcTogglePostBody(event, this)">See More</a>
                          </div>

                          <?php 
                          // Control variable: Gawing true kapag bumoto na (mula sa DB) para lumitaw ang results
                          // When true, JS/CSS .show-results state activates gradient fill + percentage reveal.
                          $HAS_VOTED = false; 
                          ?>

                          <h6 class="fs-6 fw-bold text-gray-800 mb-4">Choose your study strategy:</h6>

                          <!-- discourse-poll-options: JS in sec-posts.js handles .show-results + .selected on click -->
                          <!-- PHP adds 'show-results' class when $HAS_VOTED = true (from DB) -->
                          <div class="d-flex flex-column gap-2 mb-3 discourse-poll-options<?= $HAS_VOTED ? ' show-results' : '' ?>">

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

                          <p class="text-muted fs-8 mb-0 border-top pt-3 mt-2">
                            <i class="bi bi-people-fill me-1"></i>442 votes · 3 days left ·
                            <a href="#" class=" fw-semibold fs-8" style="color:#3a5c45;">Feu-voted</a>
                          </p>
                        </div>

                        <div class="card-body pt-0 px-5 pb-0">
                          <div class="d-flex justify-content-between align-items-center border-top border-bottom py-3">
                            <div class="d-flex flex-wrap gap-1">
                                            <button class="btn btn-sm fw-semibold" id="postLikeBtn"
  onclick="(function(b){{
    var liked=b.dataset.on==='1';
    liked=!liked;
    var dis=document.getElementById('postDislikeBtn');
    if(liked){{dis.dataset.on='0';dis.style.cssText='';dis.innerHTML='<i class=\'bi bi-hand-thumbs-down\'></i> Dislike';}}
    b.dataset.on=liked?'1':'0';
    b.style.cssText=liked?'background:rgba(23,198,112,.15);color:#17c671;border-color:#17c671;':'';
    b.innerHTML=liked?'<i class=\'bi bi-hand-thumbs-up-fill\'></i> Like <span>441</span>':'<i class=\'bi bi-hand-thumbs-up\'></i> Like <span>441</span>';
  }})(this)">
  <i class="bi bi-hand-thumbs-up"></i> Like <span>441</span>
</button>
<button class="btn btn-sm" id="postDislikeBtn"
  onclick="(function(b){{
    var on=b.dataset.on==='1';
    on=!on;
    var like=document.getElementById('postLikeBtn');
    if(on){{like.dataset.on='0';like.style.cssText='';like.innerHTML='<i class=\'bi bi-hand-thumbs-up\'></i> Like <span>441</span>';}}
    b.dataset.on=on?'1':'0';
    b.style.cssText=on?'background:rgba(220,53,69,.12);color:#dc3545;border-color:#dc3545;':'';
    b.innerHTML=on?'<i class=\'bi bi-hand-thumbs-down-fill\'></i> Dislike':'<i class=\'bi bi-hand-thumbs-down\'></i> Dislike';
  }})(this)">
  <i class="bi bi-hand-thumbs-down"></i> Dislike
</button>
<button class="btn btn-sm">
  <i class="bi bi-chat"></i> 2 Comments
</button>
<button class="btn btn-sm" id="postShareBtn"
  onclick="(function(b){{
    try{{navigator.clipboard.writeText(window.location.href);}}catch(e){{}}
    var t=document.getElementById('dc-toast');
    t.querySelector('span').textContent='Link copied!';
    t.style.display='flex';
    clearTimeout(window._t);
    window._t=setTimeout(function(){{t.style.display='none';}},2200);
    b.style.color='#0d6efd';
    setTimeout(function(){{b.style.color='';}},2000);
  }})(this)">
  <i class="bi bi-share"></i> Share
</button>
<button class="btn btn-sm" id="postSaveBtn"
  onclick="(function(b){{
    var on=b.dataset.on==='1';
    on=!on;
    b.dataset.on=on?'1':'0';
    b.style.cssText=on?'background:rgba(13,110,253,.12);color:#0d6efd;border-color:#0d6efd;':'';
    b.innerHTML=on?'<i class=\'bi bi-bookmark-fill\'></i> Saved':'<i class=\'bi bi-bookmark\'></i> Save';
    if(on){{var t=document.getElementById('dc-toast');t.querySelector('span').textContent='Saved!';t.style.display='flex';clearTimeout(window._t2);window._t2=setTimeout(function(){{t.style.display='none';}},2200);}}
  }})(this)">
  <i class="bi bi-bookmark"></i> Save
</button>
</div>
<!-- Toast -->
<div id="dc-toast" class="d-none d-flex align-items-center gap-2 mt-3 px-4 py-2 bg-light border rounded-2 fs-6 text-gray-700">
  <i class="bi bi-check-circle-fill text-success"></i><span></span>
</div>
                          </div>
                        </div>

                        <div class="card-body px-5 py-5">
                          <h6 class="fs-6 fw-bold text-gray-800 mb-4">
                            Comments <span class="text-muted fw-normal fs-7">2</span>
                          </h6>

                          <div class="d-flex gap-3 mb-4">
                            <img src="/Discourse/assets/images/catalina.webp" alt="Sofia Karin" class="h-35px w-35px rounded-circle flex-shrink-0" />
                            <div class="bg-light rounded-3 p-4 flex-grow-1">
                              <div class="d-flex align-items-center gap-3 mb-2">
                                <span class="fs-7 fw-bold text-gray-800">Sofia Karin</span>
                                <span class="text-muted fs-8">30m ago</span>
                              </div>
                              <p class="fs-7 text-gray-700 mb-2">The last option is way too relatable lmao.</p>
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

                          <div class="d-flex gap-3 mb-4">
                            <img src="/Discourse/assets/images/anonymous.png" alt="Anonymous" class="h-35px w-35px rounded-circle flex-shrink-0" />
                            <div class="bg-light rounded-3 p-4 flex-grow-1">
                              <div class="d-flex align-items-center gap-3 mb-2">
                                <span class="fs-7 fw-bold text-gray-800">Anonymous</span>
                                <span class="text-muted fs-8">30m ago</span>
                              </div>
                              <p class="fs-7 text-gray-700 mb-2">Group chats are the actual syllabus honestly.</p>
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
                    <div class="col-lg-4">

                      <div class="card border-0 shadow-sm mb-5">
                        <div class="card-header border-0 bg-light py-4">
                          <h6 class="card-title mb-0 fw-bold fs-6">About the Author</h6>
                        </div>
                        <div class="card-body p-5">
                          <div class="d-flex align-items-center gap-3 mb-5">
                            <img src="/Discourse/assets/images/catalina.webp" alt="Marco Torres" class="h-50px w-50px rounded-circle" />
                            <div>
                              <a href="#" class="fs-6 fw-bold text-gray-800 text-hover-primary d-block">Marco Torres</a>
                              <span class="text-muted fs-8 d-block">1302/2047 · Computer Engineering</span>
                            </div>
                          </div>
                          <div class="d-flex justify-content-around text-center mb-5">
                            <div>
                              <div class="fs-5 fw-bold text-gray-800">22</div>
                              <div class="text-muted fs-8">Posts</div>
                            </div>
                            <div>
                              <div class="fs-5 fw-bold text-gray-800">876</div>
                              <div class="text-muted fs-8">Followers</div>
                            </div>
                            <div>
                              <div class="fs-5 fw-bold text-gray-800">64</div>
                              <div class="text-muted fs-8">Following</div>
                            </div>
                          </div>
                          <a href="#" class="btn btn-sm btn-light-success w-100 fw-bold">
                            <i class="bi bi-person-plus-fill me-1" style="color:#3a5c45;"></i> Follow
                          </a>
                        </div>
                      </div>

                      <div class="card border-0 shadow-sm mb-5">
                        <div class="card-header border-0 bg-light py-4">
                          <h6 class="card-title mb-0 fw-bold fs-6">More Polls</h6>
                        </div>
                        <div class="card-body p-0">
                          <a href="#" class="d-flex align-items-start gap-3 p-4 border-bottom text-decoration-none text-hover-primary">
                            <span class="badge badge-light-success rounded-pill px-3 py-2 fs-8 flex-shrink-0" style="color:#3a5c45;">#21</span>
                            <div>
                              <div class="fs-7 fw-semibold text-gray-800 mb-1">What's the hardest part of the CS program?</div>
                              <div class="text-muted fs-8">FEU · 4h ago · 80 pts</div>
                            </div>
                          </a>
                          <a href="#" class="d-flex align-items-start gap-3 p-4 text-decoration-none text-hover-primary">
                            <span class="badge badge-light-success rounded-pill px-3 py-2 fs-8 flex-shrink-0" style="color:#3a5c45;">#21</span>
                            <div>
                              <div class="fs-7 fw-semibold text-gray-800 mb-1">Best FEU canteen stall, definitive</div>
                              <div class="text-muted fs-8">FEU · 3d ago · 105 votes</div>
                            </div>
                          </a>
                        </div>
                      </div>

                      <div class="card border-0 shadow-sm mb-5">
                        <div class="card-header border-0 bg-light py-4">
                          <h6 class="card-title mb-0 fw-bold fs-6">Poll Stats</h6>
                        </div>
                        <div class="card-body p-5">
                          <div class="d-flex flex-column gap-3">
                            <div class="d-flex justify-content-between align-items-center">
                              <span class="fs-7 text-gray-600">Total votes</span>
                              <span class="fs-7 fw-bold text-gray-800">442</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                              <span class="fs-7 text-gray-600">Time remaining</span>
                              <span class="badge badge-light-warning fs-8 fw-bold">3 days</span>
                            </div>
                            <div class="separator my-1"></div>
                            <div class="d-flex justify-content-between align-items-center">
                              <span class="fs-8 text-gray-600">Start early…</span>
                              <span class="fs-8 fw-semibold text-gray-700">28 votes</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                              <span class="fs-8 text-gray-600">Cram the night before</span>
                              <span class="fs-8 fw-semibold text-gray-700">104 votes</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                              <span class="fs-8 text-gray-600">Group chats &amp; papers</span>
                              <span class="fs-8 fw-semibold text-gray-700">87 votes</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                              <span class="fs-8 text-gray-600">Pray and submit</span>
                              <span class="fs-8 fw-bold text-success">222</span>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="card border border-success bg-light-success">
                        <div class="card-body p-5">
                          <p class="fs-6 fw-bold mb-3" style="color:#3a5c45;">Community Rules</p>
                          <ul class="list-unstyled d-flex flex-column gap-2 mb-0">
                            <li class="d-flex align-items-start gap-2 fs-7" style="color:#3a5c45;"><span class="fw-bold flex-shrink-0">✓</span>Be respectful and constructive</li>
                            <li class="d-flex align-items-start gap-2 fs-7" style="color:#3a5c45;"><span class="fw-bold flex-shrink-0">✓</span>No personal attacks or harassment</li>
                            <li class="d-flex align-items-start gap-2 fs-7" style="color:#3a5c45;"><span class="fw-bold flex-shrink-0">✓</span>Keep posts relevant to FEU Tech</li>
                            <li class="d-flex align-items-start gap-2 fs-7" style="color:#3a5c45;"><span class="fw-bold flex-shrink-0">✓</span>Verify information before sharing</li>
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
  <?php include($_SERVER['DOCUMENT_ROOT'] . '/Discourse/partials/_discourse-modals.php'); ?>
  <script src="/Discourse/assets/plugins/global/plugins.bundle.js"></script>
  <script src="/Discourse/assets/js/scripts.bundle.js"></script>
  <script src="/Discourse/assets/js/dashboard.js"></script>
  <script src="/Discourse/assets/js/sec-posts.js"></script>
  
<script>
document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.dc-comment-like').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var bubble = this.closest('.bg-light');
      var dislike = bubble.querySelector('.dc-comment-dislike');
      var on = this.classList.toggle('text-success');
      this.querySelector('i').className = on ? 'bi bi-hand-thumbs-up-fill' : 'bi bi-hand-thumbs-up';
      if (on) { dislike.classList.remove('text-danger'); dislike.querySelector('i').className = 'bi bi-hand-thumbs-down'; }
    });
  });
  document.querySelectorAll('.dc-comment-dislike').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var bubble = this.closest('.bg-light');
      var like = bubble.querySelector('.dc-comment-like');
      var on = this.classList.toggle('text-danger');
      this.querySelector('i').className = on ? 'bi bi-hand-thumbs-down-fill' : 'bi bi-hand-thumbs-down';
      if (on) { like.classList.remove('text-success'); like.querySelector('i').className = 'bi bi-hand-thumbs-up'; }
    });
  });
  document.querySelectorAll('.dc-reply-btn').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var box = this.closest('.bg-light').querySelector('.dc-reply-box');
      box.classList.toggle('d-none');
      if (!box.classList.contains('d-none')) box.querySelector('textarea').focus();
    });
  });
  document.querySelectorAll('.dc-reply-cancel').forEach(function (btn) {
    btn.addEventListener('click', function () {
      this.closest('.dc-reply-box').classList.add('d-none');
    });
  });
  var anonAvatar = '/Discourse/assets/images/anonymous.png';
  document.querySelectorAll('.dc-anon-toggle').forEach(function (cb) {
    var row = cb.closest('.d-flex.gap-3');
    var avatarImg = row ? row.querySelector('img') : null;
    var originalSrc = avatarImg ? avatarImg.src : null;
    cb.addEventListener('change', function () {
      if (avatarImg) avatarImg.src = this.checked ? anonAvatar : originalSrc;
    });
  });
});
</script>

<style>
  .dc-post-body-wrap .dc-body-text {
    display: -webkit-box !important;
    -webkit-line-clamp: 3 !important;
    -webkit-box-orient: vertical !important;
    overflow: hidden !important;
  }
  .dc-post-body-wrap .dc-body-text.dc-expanded {
    display: block !important;
    -webkit-line-clamp: unset !important;
    overflow: visible !important;
  }
  .dc-see-more-link {
    color: #3a5c45 !important;
    font-weight: 600 !important;
    cursor: pointer !important;
    font-size: 0.85rem;
    text-decoration: none !important;
    display: inline-block;
    margin-top: 4px;
  }
  .dc-see-more-link:hover { text-decoration: underline !important; }
</style>
<script>
(function() {
  function initPostBody() {
    document.querySelectorAll('.dc-post-body-wrap').forEach(function(wrap) {
      var textDiv = wrap.querySelector('.dc-body-text');
      var link = wrap.querySelector('.dc-see-more-link');
      if (!textDiv || !link) return;
      if (textDiv.scrollHeight > textDiv.clientHeight + 2) {
        link.classList.remove('d-none');
      }
    });
  }
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initPostBody);
  } else {
    initPostBody();
  }
})();
function dcTogglePostBody(e, link) {
  e.preventDefault();
  var wrap = link.closest('.dc-post-body-wrap');
  var textDiv = wrap ? wrap.querySelector('.dc-body-text') : null;
  if (!textDiv) return;
  var expanded = textDiv.classList.toggle('dc-expanded');
  link.textContent = expanded ? 'See Less' : 'See More';
}
</script>
</body>

</html>