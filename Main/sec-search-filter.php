<div class="mb-5" id="discourse-search-filter">

  <!-- Search + New Post Row -->
  <div class="d-flex flex-column flex-sm-row align-items-stretch align-items-sm-center gap-3 mb-5">
    <div class="position-relative flex-grow-1">
      <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-4 text-gray-500 pe-none fs-6"></i>
      <input
        type="text"
        class="form-control bg-white rounded-pill ps-12 fs-6 text-gray-700"
        placeholder="Search discussions, topics, people, communities..."
        id="discourse-search-input"
      />
    </div>
    <a href="/Discourse/pages/view/create-post.php" 
   class="btn btn-sm rounded-pill fw-bold fs-7 px-4 py-3 d-inline-flex align-items-center justify-content-center gap-1"
   style="background:#0b301f; color:#fff;">
  <i class="bi bi-plus-lg me-1 fs-7"></i> New Post
</a>
  </div>
  

  <!-- Tab Filters + Topics Dropdown Row -->
<div class="d-flex align-items-center justify-content-between border-bottom border-2 border-gray-200 mb-5">
  <ul class="nav nav-line-tabs nav-line-tabs-2x border-transparent fs-6 fw-bold mb-0" id="discoursePostTabs" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active px-3 py-2 px-sm-4 py-sm-3 fs-7 fs-sm-6" id="tab-hot" data-bs-toggle="tab" data-bs-target="#posts-hot" type="button" role="tab" aria-controls="posts-hot" aria-selected="true">
        <i class="bi bi-fire me-1"></i> HOT
      </button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link px-3 py-2 px-sm-4 py-sm-3 fs-7 fs-sm-6" id="tab-new" data-bs-toggle="tab" data-bs-target="#posts-new" type="button" role="tab" aria-controls="posts-new" aria-selected="false">
        <i class="bi bi-lightning-charge me-1"></i> NEW
      </button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link px-3 py-2 px-sm-4 py-sm-3 fs-7 fs-sm-6" id="tab-top" data-bs-toggle="tab" data-bs-target="#posts-top" type="button" role="tab" aria-controls="posts-top" aria-selected="false">
        <i class="bi bi-trophy me-1"></i> TOP
      </button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link px-3 py-2 px-sm-4 py-sm-3 fs-7 fs-sm-6" id="tab-rising" data-bs-toggle="tab" data-bs-target="#posts-rising" type="button" role="tab" aria-controls="posts-rising" aria-selected="false">
        <i class="bi bi-graph-up-arrow me-1"></i> RISING
      </button>
    </li>
  </ul>

    <!-- All Topics Dropdown -->
    <div class="dropdown">
      <button class="btn btn-sm btn-light rounded-pill border border-gray-300 text-gray-700 fs-7 px-4 py-2 dropdown-toggle" type="button" id="topicsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
        All Topics
      </button>
      <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 p-2 fs-7 min-w-150px" aria-labelledby="topicsDropdown">
        <li><a class="dropdown-item rounded-2 py-2 px-4 text-gray-700 text-hover-success bg-hover-light-success fs-7" href="#community-page">Technology</a></li>
        <li><a class="dropdown-item rounded-2 py-2 px-4 text-gray-700 text-hover-success bg-hover-light-success fs-7" href="#community-page">Culture</a></li>
        <li><a class="dropdown-item rounded-2 py-2 px-4 text-gray-700 text-hover-success bg-hover-light-success fs-7" href="#community-page">Gaming</a></li>
        <li><a class="dropdown-item rounded-2 py-2 px-4 text-gray-700 text-hover-success bg-hover-light-success fs-7" href="#community-page">FEU</a></li>
        <li><a class="dropdown-item rounded-2 py-2 px-4 text-gray-700 text-hover-success bg-hover-light-success fs-7" href="#community-page">Ideas</a></li>
        <li><a class="dropdown-item rounded-2 py-2 px-4 text-gray-700 text-hover-success bg-hover-light-success fs-7" href="#community-page">Creative</a></li>
        <li><a class="dropdown-item rounded-2 py-2 px-4 text-gray-700 text-hover-success bg-hover-light-success fs-7" href="#community-page">Science</a></li>
        <li><a class="dropdown-item rounded-2 py-2 px-4 text-gray-700 text-hover-success bg-hover-light-success fs-7" href="#community-page">News</a></li>
        <li><a class="dropdown-item rounded-2 py-2 px-4 text-gray-700 text-hover-success bg-hover-light-success fs-7" href="#community-page">AI</a></li>
        <li><a class="dropdown-item rounded-2 py-2 px-4 text-gray-700 text-hover-success bg-hover-light-success fs-7" href="#community-page">Academics</a></li>
        <li><a class="dropdown-item rounded-2 py-2 px-4 text-gray-700 text-hover-success bg-hover-light-success fs-7" href="#community-page">Lifestyle</a></li>
        <li><a class="dropdown-item rounded-2 py-2 px-4 text-gray-700 text-hover-success bg-hover-light-success fs-7" href="#community-page">Sports</a></li>
      </ul>
    </div>
  </div>

</div>