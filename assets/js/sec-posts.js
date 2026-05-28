
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
