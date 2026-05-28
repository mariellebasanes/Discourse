function generateSkeletonNotifications(count){
    for (let index = 0; index < count; index++) {
        $(".notifications-body").append(`
            <div class="skeleton-item">
                <div class="d-flex justify-content-between align-items-center my-3 p-5 rounded bg-light">
                    <div class="d-flex align-items-center w-100">
                        <div class="skeleton-content position-relative w-40px h-40px rounded-circle bg-dark opacity-10" style="flex-shrink: 0;"></div>
                        <div class="d-flex flex-column w-100 ms-3">
                            <div class="skeleton-content position-relative bg-dark opacity-10 h-15px w-100 rounded mb-3"></div>
                            <div class="skeleton-content position-relative bg-dark opacity-10 h-15px w-75 rounded"></div>
                        </div>
                    </div>
                </div>
            </div>
        `);
    }
}

function fetchNotifications() {
    if (fetching || noMoreData) {  $('.skeleton-item').remove(); return; }

    fetching = true;
    generateSkeletonNotifications(2);

    $.ajax({
        url: '/assets/core/notifications/notifications-fetch.php',
        method: 'POST',
        data: { userId: userId, offset: offset },
        success: function (html) {
            setTimeout(function(){
                $('.skeleton-item').remove();

                if (!html.trim()) {
                    noMoreData = true;
                    if ($('.no-more').length === 0) { 
                        $('.notifications-body').append(`
                            <div class="no-more col-12 mt-3 pe-0">
                                <p class="bg-light rounded mx-4 p-3 text-center small fw-bold mb-0">No more notifications to fetch.</p>
                            </div>`);
                    }

                    $(".notification-count").remove();
                    return;
                }
                    
                const tempContainer = $('<div>').html(html);
                let newNotifications = 0;

                tempContainer.find('.notification-item').each(function () {
                    const notificationId = $(this).data('id');
                    
                    if ($(`.notifications-body .notification-item[data-id="${notificationId}"]`).length === 0) {
                        $('.notifications-body').append($(this));
                        newNotifications++;
                    }
                });

                decreaseNotificationCount(newNotifications);

                offset += 5;
            }, 100);
        },
        error: function (xhr, status, error) {
            console.error('Error fetching notifications:', error);
        },
        complete: function () {
            fetching = false;
        }
    });
}

function decreaseNotificationCount(fetchedCount) {
    let notificationCountElement = $(".notification-count");
    let currentCount = parseInt(notificationCountElement.text()) || 0;

    if (currentCount > 0) {
        let newCount = Math.max(currentCount - fetchedCount, 0);
        notificationCountElement.text(newCount);

        // If all unread notifications are loaded, remove the badge
        if (newCount === 0) {
            notificationCountElement.remove();
        }
    }
}

let offset = 0;
let userId = $("#edith_notifications").attr("user");
let fetching = false;
let noMoreData = false;
let initialized = false;

document.addEventListener("DOMContentLoaded", function() {
        
    generateSkeletonNotifications(6);

    var menuElement = document.querySelector("#edith_notifications");
    var menu = KTMenu.getInstance(menuElement);
    
    menu.on('kt.menu.dropdown.show', function() {
        if (!initialized) {
            fetchNotifications();
            initialized = true;
        }
    });

    // Infinite Scroll
    let debounceTimer;
    $('.notifications-body').on('scroll', function () {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            if ($(this).scrollTop() + $(this).innerHeight() >= this.scrollHeight - 1) {
                fetchNotifications();
            }
        }, 100);
    });

    
});