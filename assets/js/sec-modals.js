/**
 * DISCOURSE — Modals & Dropdowns JS
 * File: assets/js/sec-modals.js
 *
 * Handles:
 *  - Notifications "Mark all read"
 *  - Profile dropdown (positioned below navbar avatar)
 *  - Report Post modal option selection
 */

(function () {
  'use strict';

  document.addEventListener('DOMContentLoaded', function () {

    // ── Mark all notifications read ─────────────────────────
    const markAllBtn = document.getElementById('discourse-mark-all-read');
    if (markAllBtn) {
      markAllBtn.addEventListener('click', function () {
        document.querySelectorAll('.discourse-notif-unread').forEach(function (item) {
          item.classList.remove('discourse-notif-unread');
          const dot = item.querySelector('.discourse-notif-dot');
          if (dot) dot.classList.add('discourse-notif-dot-read');
        });
        this.style.opacity = '0.4';
        this.disabled = true;
      });
    }

    // ── Report modal — selectable options ───────────────────
    const reportOptions = document.querySelectorAll('.discourse-report-option');
    reportOptions.forEach(function (option) {
      option.addEventListener('click', function () {
        reportOptions.forEach(function (o) {
          o.classList.remove('discourse-report-option-active');
        });
        this.classList.add('discourse-report-option-active');
      });
    });

    // ── Report submit feedback ──────────────────────────────
    const reportSubmit = document.getElementById('discourseReportSubmit');
    if (reportSubmit) {
      reportSubmit.addEventListener('click', function () {
        const selected = document.querySelector('.discourse-report-option-active');
        const reason   = selected ? selected.dataset.option : 'unknown';

        console.log('[Discourse] Report submitted. Reason:', reason);

        // Swap button text briefly then close modal
        this.innerHTML = '<i class="bi bi-check-circle me-2"></i> Report Submitted!';
        this.style.background = '#388e3c';

        setTimeout(function () {
          const modal = bootstrap.Modal.getInstance(document.getElementById('modalReportPost'));
          if (modal) modal.hide();

          // Reset button after hide
          setTimeout(function () {
            reportSubmit.innerHTML = '<i class="bi bi-send me-2"></i> Submit Report';
            reportSubmit.style.background = '';
          }, 400);
        }, 1000);
      });
    }

    // ── Reset report modal state on close ──────────────────
    const reportModal = document.getElementById('modalReportPost');
    if (reportModal) {
      reportModal.addEventListener('hidden.bs.modal', function () {
        reportOptions.forEach(function (o, i) {
          o.classList.toggle('discourse-report-option-active', i === 0);
        });
      });
    }

  });
})();
