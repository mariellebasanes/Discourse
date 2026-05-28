<section>
  <div class="w-100 overflow-hidden position-relative">
    <div class="burst-background" id="burst"
      style="background: repeating-conic-gradient(rgb(241, 241, 244) 0deg, rgb(241, 241, 244) 10deg, rgba(255, 255, 255, 0.3) 10deg, rgba(255, 255, 255, 0.3) 20deg);">
    </div>
    
    <div class="vignette-background" id="vignette"
      style="background: radial-gradient(circle, transparent 0%, rgb(241, 241, 244) 75%);"></div>
    <div class="app-container container-xxl">

      <div class="text-center pt-lg-15 pt-10 mb-10">
        <h1 class="fw-bolder text-gray-800"><?= htmlspecialchars($META_TITLE) ?></h1>
        <p class="text-gray-700"></p>
      </div>
    </div>
  </div>
  
</section>

<div class="container-xxl app-container py-lg-15 py-10">
  <div class="row d-flex justify-content-center">
    <div class="col-lg-9"></div>
  </div>
</div>

<script>
  $(document).ready(function () {
    const slug = "<?= $END_URL ?>";

    $.ajax({
      url: "/sample/pages/view/index-ajax-page.php",
      data: { slug: slug },
      dataType: "json",
      success: function (response) {
      }
    });
  });
</script>