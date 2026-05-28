<button class="btn btn-light btn-active-dark btn-circle btn-icon shadow-lg fs-1 btn-toggle chat-toggle cursor-pointer">💬</button>
<div class="chat-container shadow-lg mb-3 overflow-hidden position-fixed bg-white rounded-4">
    <div class="card border-0 d-flex flex-column justify-content-between h-100">
        <div class="h-100">
            <div class="bg-dark">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-start w-100 py-7">
                        <div class="d-flex align-items-center">
                            <img class="h-40px me-4" src="https://edith.feutech.edu.ph/assets/img/logo.png">
                            <div>
                                <h4 class="text-white mb-1">EdITH GPT</h4>
                                <h6 class="text-white opacity-75 mb-0">Generative AI Powered by GPT</h6>
                            </div>
                        </div>
                        <div>
                            <button type="button" class="btn p-0 btn-toggle"><i class="bi bi-x text-white fs-1"></i></button>
                            <button type="button" class="btn p-0 btn-fullscreen"><i class="bi bi-check text-white fs-1"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div id="chat-box" class="card-body scroll-y d-flex flex-column min-h-300px"></div>
        </div>
        <div class="card-footer border-top bg-light">
            <input type="text" id="user-input" class="form-control" placeholder="Type a message and hit enter...">
        </div>
    </div>
</div>