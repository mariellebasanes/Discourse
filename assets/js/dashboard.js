/**
 * DISCOURSE — Dashboard Global JS
 * File: assets/js/dashboard.js
 *
 * Entry point for any cross-section interactions.
 * Individual section JS files handle their own logic.
 */

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
