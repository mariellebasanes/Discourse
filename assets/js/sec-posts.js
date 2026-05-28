/**
 * Refactored: selectors updated to match Bootstrap/Metronic utility markup.
 * DISCOURSE — Posts Feed JS
 * File: assets/js/sec-posts.js
 */

(function () {
  'use strict';

  document.addEventListener('DOMContentLoaded', function () {

    // ── Vote Engine ───────────────────────────────────────────
    // Selector updated: data-dc="post-card" replaces .discourse-post-card
    // Button selectors updated: .dc-vote-up/down replaces .discourse-vote-up/down
    // Count selector updated: .dc-vote-count replaces .discourse-vote-count
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