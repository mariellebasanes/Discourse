<!-- 2-column layout: Left feed + Right sidebar -->
<div class="discourse-dashboard-layout" id="discourse-dashboard">

  <!-- ── LEFT COLUMN ──────────────────────────────────────── -->
  <div class="discourse-feed-col">
    <?php include("Main/sec-hero.php"); ?>
    <?php include("Main/sec-search-filter.php"); ?>
    <?php include("Main/sec-posts.php"); ?>
  </div>

  <!-- ── RIGHT COLUMN ─────────────────────────────────────── -->
  <div class="discourse-sidebar-col">
    <?php include("Main/sec-sidebar.php"); ?>
  </div>

</div>