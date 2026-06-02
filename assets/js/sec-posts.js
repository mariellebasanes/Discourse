
(function () {
  'use strict';

  document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('[data-dc="post-card"]').forEach(function (card) {
      const upBtn   = card.querySelector('.dc-vote-up');
      const downBtn = card.querySelector('.dc-vote-down');
      const countEl = card.querySelector('.dc-vote-count');

      if (!upBtn || !downBtn || !countEl) return;

      let currentVote = null;
      let baseCount   = parseInt(countEl.textContent.replace(/,/g, ''), 10) || 0;

      function updateDisplay() {
        let display = baseCount;
        if (currentVote === 'up')   display = baseCount + 1;
        if (currentVote === 'down') display = baseCount - 1;

        countEl.textContent = display.toLocaleString();

        if (currentVote === 'up') {
          upBtn.classList.add('text-success');
          upBtn.querySelector('i').className = 'bi bi-hand-thumbs-up-fill p-0';
        } else {
          upBtn.classList.remove('text-success');
          upBtn.querySelector('i').className = 'bi bi-hand-thumbs-up p-0';
        }

        if (currentVote === 'down') {
          downBtn.classList.add('text-danger');
          downBtn.querySelector('i').className = 'bi bi-hand-thumbs-down-fill p-0';
        } else {
          downBtn.classList.remove('text-danger');
          downBtn.querySelector('i').className = 'bi bi-hand-thumbs-down p-0';
        }
      }

      upBtn.addEventListener('click', function (e) {
        e.preventDefault();
        currentVote = currentVote === 'up' ? null : 'up';
        updateDisplay();
      });

      downBtn.addEventListener('click', function (e) {
        e.preventDefault();
        currentVote = currentVote === 'down' ? null : 'down';
        updateDisplay();
      });
    });

    // ── Poll Engine ───────────────────────────────────────────
    // discourse-poll-option kept as JS hook class (not a style class).
    // discourse-poll-options / show-results / selected kept for CSS state toggling.
    document.querySelectorAll('.discourse-poll-option').forEach(function (option) {
      option.addEventListener('click', function () {
        const container = this.closest('.discourse-poll-options');

        container.querySelectorAll('.discourse-poll-option').forEach(function (btn) {
          btn.classList.remove('selected');
        });

        this.classList.add('selected');
        container.classList.add('show-results');
      });
    });

  });
})();


  // ── Post card: Comment / Share / Save ─────────────────────
  (function () {
    var feedToast = document.getElementById('dc-feed-toast');

    function showFeedToast(msg) {
      if (!feedToast) return;
      feedToast.querySelector('span').textContent = msg;
      feedToast.style.display = 'flex';
      clearTimeout(window._dcFeedToast);
      window._dcFeedToast = setTimeout(function () { feedToast.style.display = 'none'; }, 2200);
    }

    // Comment — toggle quick comment drawer
    document.querySelectorAll('.dc-post-comment').forEach(function (btn) {
      btn.addEventListener('click', function (e) {
        e.preventDefault();
        var card = this.closest('[data-dc="post-card"]');
        var drawer = card ? card.querySelector('.dc-quick-comment-drawer') : null;
        if (drawer) {
          $(drawer).slideToggle(200);
          var input = drawer.querySelector('input');
          if (input) input.focus();
        }
      });
    });

    // Handle quick comment submission
    $(document).on('submit', '.dc-quick-comment-form', function(e) {
      e.preventDefault();
      var form = this;
      var input = form.querySelector('input[type="text"]');
      var commentText = input.value.trim();
      var postIdInput = form.querySelector('input[name="post_id"]');
      var postId = postIdInput ? postIdInput.value : '';
      if (!commentText || !postId) return;

      var card = form.closest('[data-dc="post-card"]');
      var commentsList = card ? card.querySelector('.dc-quick-comments-list') : null;
      var commentCountBtn = card ? card.querySelector('.dc-post-comment') : null;

      function escapeHtml(text) {
        return text
          .replace(/&/g, "&amp;")
          .replace(/</g, "&lt;")
          .replace(/>/g, "&gt;")
          .replace(/"/g, "&quot;")
          .replace(/'/g, "&#039;");
      }

      $.ajax({
        url: '/Discourse/pages/version/add-comment-action.php',
        method: 'POST',
        data: {
          post_id: postId,
          body: commentText
        },
        dataType: 'json',
        success: function(response) {
          if (response.success) {
            var avatar = window.currentUser ? window.currentUser.avatar : '/Discourse/assets/images/anonymous.png';
            var displayName = window.currentUser ? window.currentUser.displayName : 'You';
            
            var newCommentHtml = `
              <div class="d-flex align-items-start gap-2 fs-7 animate__animated animate__fadeIn">
                <img src="${avatar}" class="h-25px w-25px rounded-circle" alt="User avatar">
                <div class="bg-light p-2 rounded-3 flex-grow-1">
                  <div class="d-flex justify-content-between">
                    <span class="fw-bold text-gray-800">${displayName}</span>
                    <span class="text-muted fs-9">just now</span>
                  </div>
                  <p class="text-gray-700 m-0 mt-1">${escapeHtml(commentText)}</p>
                </div>
              </div>
            `;
            
            if (commentsList) {
              commentsList.insertAdjacentHTML('beforeend', newCommentHtml);
              commentsList.scrollTop = commentsList.scrollHeight;
            }

            input.value = '';

            if (commentCountBtn) {
              var countText = commentCountBtn.textContent.replace(/Comments?/g, '').trim();
              var count = parseInt(countText, 10) || 0;
              count++;
              commentCountBtn.innerHTML = '<i class="bi bi-chat me-1"></i> ' + count + (count === 1 ? ' Comment' : ' Comments');
            }

            showFeedToast('Comment posted!');
          } else {
            alert(response.message || 'Failed to post comment.');
          }
        },
        error: function() {
          alert('Error communicating with database.');
        }
      });
    });

    // Share — copy URL, brief blue highlight, toast
    document.querySelectorAll('.dc-post-share').forEach(function (btn) {
      btn.addEventListener('click', function () {
        var card = this.closest('[data-dc="post-card"]');
        var titleLink = card ? card.querySelector('a.dc-post-title-link') : null;
        var url = titleLink && titleLink.href ? titleLink.href : window.location.href;
        try { navigator.clipboard.writeText(url); } catch (e) {}
        this.style.color = '#0d6efd';
        var self = this;
        setTimeout(function () { self.style.color = ''; }, 2000);
        showFeedToast('Link copied!');
      });
    });

    // Save — toggle bookmark state, toast on save
    $(document).on('click', '.dc-post-save', function(e) {
      e.preventDefault();
      var btn = this;
      var card = btn.closest('[data-dc="post-card"]');
      if (!card) return;
      var postId = card.getAttribute('data-post-id');
      if (!postId) return;

      $.ajax({
        url: '/Discourse/pages/version/save-post-action.php',
        method: 'POST',
        data: { post_id: postId },
        dataType: 'json',
        success: function(res) {
          if (res.success) {
            var saved = res.saved;
            btn.dataset.on = saved ? '1' : '0';
            btn.style.cssText = saved ? 'background:rgba(13,110,253,.12);color:#0d6efd;border-color:#0d6efd;' : '';
            btn.innerHTML = saved
              ? '<i class="bi bi-bookmark-fill me-1"></i> Saved'
              : '<i class="bi bi-bookmark me-1"></i> Save';
            
            showFeedToast(saved ? 'Post saved!' : 'Post unsaved!');
          } else {
            alert(res.message || 'Error processing request.');
          }
        },
        error: function() {
          alert('Error communicating with database.');
        }
      });
    });
  })();

  (function() {
    function initSeeMore() {
      document.querySelectorAll('.dc-body-clamp').forEach(function(span) {
        var link = span.nextElementSibling;
        if (!link || !link.classList.contains('dc-see-more-link')) return;
        // Only show link if content overflows 3 lines
        if (span.scrollHeight > span.clientHeight + 2) {
          link.classList.remove('d-none');
        }
      });
    }
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', initSeeMore);
    } else {
      initSeeMore();
    }
  })();

  function dcToggleBody(e, link) {
    e.preventDefault();
    var span = link.previousElementSibling;
    if (!span) return;
    var expanded = span.classList.toggle('dc-expanded');
    link.textContent = expanded ? 'See Less' : 'See More';
  }
