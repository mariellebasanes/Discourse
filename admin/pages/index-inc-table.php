<section>

  <div class="d-flex align-items-center mb-5">
    <div>
      <h3 class="fw-bold text-gray-900 fs-3 mb-0"><?= htmlspecialchars($META_TITLE, ENT_NOQUOTES) ?></h3>
      <div class="pt-1 text-muted fw-semibold fs-5"><?= htmlspecialchars($META_DESC) ?></div>
    </div>
  </div>

  <div class="card border-0 shadow">

    <div class="card-header border-0 pt-10">
      <div class="row w-100">
        <div class="col-lg-4 col-md-5">
          <div class="d-flex align-items-center position-relative my-1 me-3">
            <i class="ki-duotone ki-magnifier fs-1 position-absolute ms-6">
              <span class="path1"></span>
              <span class="path2"></span>
            </i>
            <input type="text" datatable-filter="search" class="form-control form-control-solid w-250px ps-15"
              placeholder="Search records">
          </div>
        </div>

        <div class="col-lg-8 col-md-7 text-md-end">
          <a href="#" class="btn btn-primary fw-bold" onclick="KTApp.showPageLoading()">
            <i class="bi bi-plus fs-2 text-white"></i>Add Record
          </a>
        </div>
      </div>
    </div>

    <div class="card-body py-10 table-responsive">
      <table id="EdITH-TABLE" class="table table-row-bordered gy-5 gs-7 align-middle w-100">
        <thead>
          <tr class="fw-bold text-muted">
            <th>ID</th>
            <th class="text-end"></th>
          </tr>
        </thead>
      </table>
    </div>

  </div>
</section>

<script>
  $(document).ready(function () {

    var MBGDATATABLE = $('#EdITH-TABLE').DataTable({
      order: [[0, 'desc']],
      searchDelay: 500,
      responsive: true,
      "ordering": true,
      "processing": true,
      "serverSide": true,
      "searching": true,
      ajax: {
        url: 'index-ajax-fetch.php',
        type: 'GET'
      },
      columns: [
        { data: 0, searchable: false, visible: false },
        { data: 1, searchable: true, visible: true, responsivePriority: 1 },
        { data: 2, searchable: true, visible: true },
        { data: 3, searchable: true, visible: true }
      ],
      "columnDefs": [
        {
          "targets": 0,
          render: function (data, type, row) { return row[0]; }
        },
        {
          "targets": 1,
          "width": "85%",
          render: function (data, type, row) { return row[1]; }
        },
        {
          "targets": 2,
          "orderable": false,
          render: function (data, type, row) { return row[4]; }
        },
        {
          "targets": 3,
          "orderable": false,
          "width": "25%",
          "class": "text-end",
          render: function (data, type, row) {
            return `
                            <div>
                                <button type="button" class="btn btn-clean btn-sm btn-icon btn-circle btn-active-light-primary rounded-circle ms-5 rotate" data-kt-menu-trigger="{default: \'click\', lg: \'hover\'}" data-kt-menu-placement="bottom-end">
                                    <i class="fa-solid fa-ellipsis fa-sm"></i>
                                </button>
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-auto min-w-200 mw-300px py-3" data-kt-menu="true">
                                    <div class="menu-item px-3">
                                        <a href="/sample/${row[3]}" class="menu-link px-3" target="_blank">
                                            <i class="bi bi-pencil-square me-2"></i>
                                            View
                                        </a>
                                    </div>
                                    <div class="menu-item px-3">
                                        <a href="/sample/manage/${row[3]}" class="menu-link px-3" onclick="KTApp.showPageLoading()">
                                            <i class="bi bi-pencil-square me-2"></i>
                                            Edit
                                        </a>
                                    </div>
                                    <div class="menu-item px-3">
                                        <a href="javascript:void(0)" id="${row[0]}" class="menu-link px-3 menu-delete" table="pages">
                                            <i class="bi bi-trash me-2"></i>
                                            Move to trash
                                        </a>
                                    </div>
                                </div>
                            </div>
                        `;
          }
        }
      ]
    });

    let searchTimeout;
    $('[datatable-filter="search"]').keyup(function () {
      clearTimeout(searchTimeout);
      let searchValue = $(this).val();

      searchTimeout = setTimeout(function () {
        MBGDATATABLE.search(searchValue).draw();
      }, 500);
    });

    MBGDATATABLE.on('draw', function () {
      KTMenu.createInstances();
      $("html, body").animate({ scrollTop: 0 }, 600);
    });

    /** DELETE RECORD
    ********************************************************/
    $('#EdITH-TABLE').on('click', '.menu-delete', function (e) {
      var id = $(this).attr("id");
      var table = $(this).attr("table");

      let confirmAction = confirm("Are you sure you want to delete this record?");
      if (confirmAction) {
        var formData = new FormData();
        formData.append('id', id);
        formData.append('table', table);

        $.ajax({
          type: "POST",
          url: "index-ajax-delete.php",
          data: formData,
          contentType: false,
          cache: false,
          processData: false,
          success: function (response) {
            MBGDATATABLE.ajax.reload();
            toastr.success(response.message);
          }
        });
      }
    });

  });
</script>
