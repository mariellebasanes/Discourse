<section>
  <div class="card border-0 shadow">

    <div class="card-header border-0 pt-10">
      <h3 class="card-title align-items-start flex-column">
        <span class="card-label fw-bold fs-2 mb-1"><?= htmlspecialchars($META_TITLE) ?></span>
        <span class="fs-6 my-0 pt-1 text-gray-600"><?= htmlspecialchars($META_DESC ?? "") ?>
        </span>
      </h3>
      <div class="card-toolbar">
        <a href="#" onclick="KTApp.showPageLoading()" class="btn btn-primary fw-bold">
          <i class="bi bi-arrow-left fs-2 text-white"></i>Back to Records
        </a>
      </div>
    </div>


    <div class="card-body py-10 table-responsive">
      <form id="edith_form" class="row form needs-validation" method="post" novalidate>

        <div class="col-12 d-none">
          <div class="fv-row mb-10">
            <input id="id" type="text" class="form-control mb-2" value="<?= intval($RECORD['id'] ?? 0) ?>">
          </div>
        </div>

        <div class="d-flex justify-content-end mt-5">
          <a href="#" onclick="KTApp.showPageLoading()" class="btn btn-secondary me-3">Cancel</a>
          <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>

      </form>
    </div>
  </div>
</section>

<script>
  $(document).ready(function () {
    $('#edith_form').submit(function (e) {
      e.preventDefault();

      const form = $(this);
      const button = form.find('[type="submit"]');

      button.prop('disabled', true).removeClass("btn-primary").addClass("btn-secondary");

      const formData = new FormData();
      formData.append("id", $("#id").val());

      $.ajax({
        url: "/sample/admin/pages/manage/index-ajax-save.php",
        method: "POST",
        data: formData,
        dataType: "json",
        processData: false,
        contentType: false,
        success: function (res) {
          if (res.status === "success") {
            window.location.href = "/";
          } else {
            toastr.error(res.message || "An error occurred.");
            button.prop('disabled', false).removeClass("btn-secondary").addClass("btn-primary");
          }
        },
        error: function () {
          toastr.error("Request failed.");
          button.prop('disabled', false).removeClass("btn-secondary").addClass("btn-primary");
        }
      });
    });
  });
</script>
