

(function () {
  'use strict';

  // Fade-in on load via rAF double-frame trick
  document.addEventListener('DOMContentLoaded', function () {
    const hero = document.getElementById('discourse-hero');
    if (hero) {
      hero.style.opacity    = '0';
      hero.style.transform  = 'translateY(12px)';
      hero.style.transition = 'opacity 0.5s ease, transform 0.5s ease';

      requestAnimationFrame(function () {
        requestAnimationFrame(function () {
          hero.style.opacity   = '1';
          hero.style.transform = 'translateY(0)';
        });
      });
    }
  });
})();