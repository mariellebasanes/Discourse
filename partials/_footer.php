<footer>
  <div class="app-container container-xxl">
    <div class="row d-flex align-items-end justify-content-between pt-10">
      <div class="col-lg-4 my-5 pe-lg-10">
        <a href="/discover/" class="d-flex align-items-center mb-5" onclick="KTApp.showPageLoading()">
          <div class="d-flex align-items-center">
            <span class="svg-icon svg-icon-2hx svg-icon-success me-2">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.3" d="M2 4V16C2 16.6 2.4 17 3 17H13L16.6 20.6C17.1 21.1 18 20.8 18 20V17H21C21.6 17 22 16.6 22 16V4C22 3.4 21.6 3 21 3H3C2.4 3 2 3.4 2 4Z" fill="currentColor"></path>
                    <path d="M18 9H6C5.4 9 5 8.6 5 8C5 7.4 5.4 7 6 7H18C18.6 7 19 7.4 19 8C19 8.6 18.6 9 18 9ZM16 12C16 11.4 15.6 11 15 11H6C5.4 11 5 11.4 5 12C5 12.6 5.4 13 6 13H15C15.6 13 16 12.6 16 12Z" fill="currentColor"></path>
                </svg>
            </span>
            <span class="fs-1 fw-bolder" style="color: #FFB800;">Discourse</span>
          </div>
        </a>
        <h3 class='text-dark fw-bold fs-4 mb-3'>Join Conversations and Connect with the Community!</h3>
        <p class='text-gray-600 fs-7 mb-0 lh-lg'>Paraverse Forums is a discussion platform where students can create posts, share thoughts, ask questions, and engage in different topics within the school community. Stay updated, interact with others, and discover trending discussions anytime in the app.</p>
      </div>

      <div class="col-lg-4 my-5">
        <div class="d-flex mb-5">
          <a href="https://feualabang.edu.ph/" target="_blank" class="me-1"><img class="h-50px"
              src="/Discourse/assets/img/logo/feu-alabang.webp"></a>
          <a href="https://feudiliman.edu.ph/" target="_blank" class="me-1"><img class="h-50px"
              src="/Discourse/assets/img/logo/feu-diliman.webp"></a>
          <a href="https://feutech.edu.ph/" target="_blank"><img class="h-50px"
              src="/Discourse/assets/img/logo/feu-tech.webp"></a>
        </div>
        <div class="d-flex">
          <a href="/" onclick="KTApp.showPageLoading()"><img src="/Discourse/assets/img/logo.png"
              class="h-35px me-4"></a>
          <p class='fs-lg mb-0'>
            <span class="d-block text-gray-600">Proudly made with <span class="text-danger">❤️</span> by the</span>
            <a href="/" class="fw-bold text-dark text-active-primary">Educational Innovation and Technology
              Hub</span></a>
          </p>
        </div>
        <a href="https://www.facebook.com/edith.feutech" target="_blank" class="btn btn-sm btn-facebook mt-5"><i
            class="fab fa-facebook-f fs-4"></i> Like us on Facebook</a>
      </div>
    </div>
    <div class="row">
      <div class="col">
        <p class="text-gray-600 mt-8 pt-8 border-top">© <?php echo date("Y"); ?> <strong>Educational Innovation and
            Technology Hub</strong>. All Rights Reserved. </p>
      </div>
    </div>
  </div>
</footer>

<script src="/Discourse/assets/plugins/global/plugins.bundle.js"></script>
<script src="/Discourse/assets/js/scripts.bundle.v2.01.js"></script>

<script>
  $(document).ready(function() {
    // Vote Buttons (Upvote / Downvote)
    $(document).on('click', '.vote-btn', function(e) {
      var $btn = $(this);
      
      // If it's a share or comment button, don't intercept the click
      if ($btn.find('.fa-share-alt').length > 0 || $btn.find('.fa-comment').length > 0) {
        return;
      }
      
      e.preventDefault();
      e.stopPropagation();
      
      var isUpvote = $btn.find('.fa-arrow-up').length > 0;
      var isDownvote = $btn.find('.fa-arrow-down').length > 0;
      
      // If this button is already active, deactivate it
      if ($btn.hasClass('active')) {
        $btn.removeClass('active btn-light-success btn-light-danger').addClass('btn-light-muted');
        $btn.find('i, span').removeClass('text-white');
      } else {
        // Find sibling vote buttons and deactivate them
        $btn.siblings('.vote-btn').each(function() {
          $(this).removeClass('active btn-light-success btn-light-danger').addClass('btn-light-muted');
          $(this).find('i, span').removeClass('text-white');
        });
        
        // Activate this button
        $btn.addClass('active').removeClass('btn-light-muted');
        if (isUpvote) {
          $btn.addClass('btn-light-success');
        } else if (isDownvote) {
          $btn.addClass('btn-light-danger');
        }
        $btn.find('i, span').addClass('text-white');
      }
    });

    // Follow Button
    $(document).on('click', '.follow-btn', function(e) {
      e.preventDefault();
      var $btn = $(this);
      if ($btn.text().trim() === 'Follow') {
        $btn.text('Following').removeClass('text-white').addClass('btn-light-success').css('background-color', '');
      } else {
        $btn.text('Follow').addClass('text-white').removeClass('btn-light-success').css('background-color', '#1A8B44');
      }
    });

    // Join Community Button
    $(document).on('click', 'button:contains("JOIN COMMUNITY")', function(e) {
      e.preventDefault();
      e.stopPropagation();
      var $btn = $(this);
      $btn.html('<i class="fas fa-check text-success fs-8"></i> <span class="text-success">JOINED</span>')
          .removeClass('btn-warning')
          .addClass('btn-light-success')
          .css({'background-color': '', 'color': ''});
    });
  });
</script>
