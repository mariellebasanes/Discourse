if ($("#edith-btn-login").length == 0) {
  $("body").append(`
        <div 
            class="btn btn-dark btn-icon btn-sm position-fixed d-flex justify-content-center align-items-center cursor-pointer" 
            id="open-modal-feedback" 
            data-bs-toggle="tooltip"
            data-bs-custom-class="tooltip-inverse"
            title="Submit Feedback"
            style="bottom: 88px; right: 7px; z-index: 105
        ">
            <i class="bi bi-emoji-smile text-white"></i>
        </div>
    `);

  $(document).on("click", "#open-modal-feedback", function (event) {
    event.preventDefault();

    const modalHtml =
      `
            <div class="modal fade" id="modal-feedback" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form id="edith-feedback">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Submit Feedback to Us</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="feedback-type mb-5">
                                    <div class="row d-flex flex-column g-3">
                                        <button feedback="compliment" type="button" class="btn-feedback btn btn-outline btn-active-secondary btn-block text-start fw-bold"><i class="bi bi-chat-heart-fill text-danger"></i> Give a compliment</button>
                                        <button feedback="report" type="button" class="btn-feedback btn btn-outline btn-active-secondary btn-block text-start fw-bold"><i class="bi bi-flag-fill text-info"></i> Report a problem</button>
                                        <button feedback="suggestion" type="button" class="btn-feedback btn btn-outline btn-active-secondary btn-block text-start fw-bold"><i class="bi bi-lightbulb-fill text-warning"></i> Make a suggestion</button>
                                    </div>
                                </div>
                                <div class="feedback-content" style="display:none">
                                    <div>
                                        <label for="compliment" class="required form-label feedback-label">What did you like?</label>
                                        <label for="report" class="required form-label feedback-label">What went wrong?</label>
                                        <label for="suggestion" class="required form-label feedback-label">What can we do better?</label>
                                        <textarea id="description" required class="form-control form-control-solid" rows="5"/></textarea>
                                        <input id="location" type="text" class="d-none" value="` +
      $(location).attr("href").replace("https://edith.feutech.edu.ph", "") +
      `"/></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input class="d-none disabled" disabled readonly type="text" id="type">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-dark">Submit Feedback</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        `;

    $("body").append(modalHtml);

    $("#modal-feedback").modal("show");

    $("#modal-feedback").on("hidden.bs.modal", function () {
      $(this).remove();
    });
  });

  $(document).on("submit", "#edith-feedback", function (event) {
    event.preventDefault();

    var formData = new FormData();
    formData.append("type", $("#type").val());
    formData.append("description", $("#description").val());
    formData.append("location", $("#location").val());

    $.ajax({
      type: "POST",
      url: "/assets/core/feedback/feedback-add.php",
      data: formData,
      contentType: false,
      cache: false,
      processData: false,
      success: function (result) {
        $("#modal-feedback").modal("hide");
        toastr.success("Thank you for your feedback!");
      },
    });
  });

  $(document).on("click", ".btn-feedback", function () {
    var type = $(this).attr("feedback");
    $("#type").val(type);

    $(".feedback-label").hide();
    $(".feedback-content").show();

    $('[for="' + type + '"]').show();

    $(".btn-feedback").removeClass("btn-secondary");
    $(this).addClass("btn-secondary");
  });
}
