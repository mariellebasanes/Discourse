
(function () {
  'use strict';

  document.addEventListener('DOMContentLoaded', function () {
    // Init Bootstrap tooltips if any
    const tooltipEls = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    tooltipEls.forEach(function (el) {
      new bootstrap.Tooltip(el);
    });

    console.log('[Discourse] Dashboard initialized.');
  });
})();

/* ── View-post: comment interactions ── */
function dcInitViewPost() {
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
}

/* ── View-post: post action buttons ── */
function dcInitPostActions() {
  var likeBtn = document.getElementById('postLikeBtn');
  var dislikeBtn = document.getElementById('postDislikeBtn');
  var saveBtn = document.getElementById('postSaveBtn');
  var toast = document.getElementById('dc-toast');

  function showToast(msg) {
    if (!toast) return;
    toast.querySelector('span').textContent = msg;
    toast.style.display = 'flex';
    clearTimeout(window._dcToast);
    window._dcToast = setTimeout(function () { toast.style.display = 'none'; }, 2200);
  }

  if (likeBtn) {
    likeBtn.addEventListener('click', function () {
      var liked = this.dataset.on === '1';
      liked = !liked;
      this.dataset.on = liked ? '1' : '0';
      if (liked && dislikeBtn) {
        dislikeBtn.dataset.on = '0';
        dislikeBtn.style.cssText = '';
        dislikeBtn.querySelector('i').className = 'bi bi-hand-thumbs-down';
        dislikeBtn.querySelector('span') && (dislikeBtn.innerHTML = '<i class="bi bi-hand-thumbs-down"></i> Dislike');
      }
      this.style.cssText = liked ? 'background:rgba(23,198,112,.15);color:#17c671;border-color:#17c671;' : '';
      var count = parseInt((this.querySelector('span') || {}).textContent || 0);
      this.querySelector('i').className = liked ? 'bi bi-hand-thumbs-up-fill' : 'bi bi-hand-thumbs-up';
    });
  }

  if (dislikeBtn) {
    dislikeBtn.addEventListener('click', function () {
      var on = this.dataset.on === '1';
      on = !on;
      this.dataset.on = on ? '1' : '0';
      if (on && likeBtn) {
        likeBtn.dataset.on = '0';
        likeBtn.style.cssText = '';
        likeBtn.querySelector('i').className = 'bi bi-hand-thumbs-up';
      }
      this.style.cssText = on ? 'background:rgba(220,53,69,.12);color:#dc3545;border-color:#dc3545;' : '';
      this.querySelector('i').className = on ? 'bi bi-hand-thumbs-down-fill' : 'bi bi-hand-thumbs-down';
    });
  }

  if (saveBtn) {
    saveBtn.addEventListener('click', function () {
      var on = this.dataset.on === '1';
      on = !on;
      this.dataset.on = on ? '1' : '0';
      this.style.cssText = on ? 'background:rgba(13,110,253,.12);color:#0d6efd;border-color:#0d6efd;' : '';
      this.innerHTML = on
        ? '<i class="bi bi-bookmark-fill"></i> Saved'
        : '<i class="bi bi-bookmark"></i> Save';
      if (on) showToast('Saved!');
    });
  }

  var shareBtn = document.getElementById('postShareBtn');
  if (!shareBtn) {
    shareBtn = document.querySelector('[onclick*="clipboard"]');
  }
  document.querySelectorAll('.btn[onclick*="clipboard"]').forEach(function (btn) {
    var onclickVal = btn.getAttribute('onclick');
    btn.removeAttribute('onclick');
    btn.addEventListener('click', function () {
      try { navigator.clipboard.writeText(window.location.href); } catch (e) {}
      this.style.color = '#0d6efd';
      setTimeout(function () { btn.style.color = ''; }, 2000);
      showToast('Link copied!');
    });
  });
}

/* ── View-post: See More / See Less ── */
function dcInitPostBody() {
  document.querySelectorAll('.dc-post-body-wrap').forEach(function (wrap) {
    var textDiv = wrap.querySelector('.dc-body-text');
    var link = wrap.querySelector('.dc-see-more-link');
    if (!textDiv || !link) return;
    if (textDiv.scrollHeight > textDiv.clientHeight + 2) {
      link.classList.remove('d-none');
    }
  });
}

function dcTogglePostBody(e, link) {
  e.preventDefault();
  var wrap = link.closest('.dc-post-body-wrap');
  var textDiv = wrap ? wrap.querySelector('.dc-body-text') : null;
  if (!textDiv) return;
  var expanded = textDiv.classList.toggle('dc-expanded');
  link.textContent = expanded ? 'See Less' : 'See More';
}

document.addEventListener('DOMContentLoaded', function () {
  if (document.querySelector('.dc-post-body-wrap')) {
    dcInitViewPost();
    dcInitPostActions();
    dcInitPostBody();
  }
});
