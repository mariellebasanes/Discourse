
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

    // Comment — navigate to the post's view page (use the title link href on the card)
    document.querySelectorAll('.dc-post-comment').forEach(function (btn) {
      btn.addEventListener('click', function () {
        var card = this.closest('[data-dc="post-card"]');
        var titleLink = card ? card.querySelector('a.text-gray-800.fw-bold') : null;
        if (titleLink && titleLink.href) {
          window.location.href = titleLink.href;
        }
      });
    });

    // Share — copy URL, brief blue highlight, toast
    document.querySelectorAll('.dc-post-share').forEach(function (btn) {
      btn.addEventListener('click', function () {
        var card = this.closest('[data-dc="post-card"]');
        var titleLink = card ? card.querySelector('a.text-gray-800.fw-bold') : null;
        var url = titleLink && titleLink.href ? titleLink.href : window.location.href;
        try { navigator.clipboard.writeText(url); } catch (e) {}
        this.style.color = '#0d6efd';
        var self = this;
        setTimeout(function () { self.style.color = ''; }, 2000);
        showFeedToast('Link copied!');
      });
    });

    // Save — toggle bookmark state, toast on save
    document.querySelectorAll('.dc-post-save').forEach(function (btn) {
      btn.addEventListener('click', function () {
        var on = this.dataset.on === '1';
        on = !on;
        this.dataset.on = on ? '1' : '0';
        this.style.cssText = on ? 'background:rgba(13,110,253,.12);color:#0d6efd;border-color:#0d6efd;' : '';
        this.innerHTML = on
          ? '<i class="bi bi-bookmark-fill me-1"></i> Saved'
          : '<i class="bi bi-bookmark me-1"></i> Save';
        if (on) showFeedToast('Page saved!');
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
