$(document).ready(function () {
    const courseModal = document.getElementById('course_details_modal');
    if (!courseModal) return;

    $('.course-card-mini').on('click', function () {
        const $card = $(this);
        const code = $card.data('course-code');
        const title = $card.data('course-title');
        const lessonsStr = $card.data('course-lessons') || '';
        const status = $card.data('course-status');
        const type = $card.find('.course-type-bar').text().toLowerCase();

        // Populate Modal Fields
        $('#modal_course_code').text(code);
        $('#modal_course_title').text(title);
        $('#modal_course_status_text').text(status);

        // Map colors/icons based on type
        const typeColors = {
            'ite': '#008080',
            'ged': '#800000',
            'cs': '#004080',
            'it': '#00a8a8',
            'cpe': '#404040'
        };

        const themeColor = typeColors[type] || '#0047AB';
        $('#modal_course_code').css('background-color', themeColor + ' !important');
        $('#modal_course_type_bg').css('background-color', themeColor);

        // Populate Lessons
        const $lessonsContainer = $('#modal_course_lessons');
        $lessonsContainer.empty();

        if (lessonsStr) {
            const lessons = lessonsStr.split(',').map(s => s.trim());
            lessons.forEach(lesson => {
                $lessonsContainer.append(`<span class="lesson-tag">${lesson}</span>`);
            });
        } else {
            $lessonsContainer.append('<div class="text-gray-400 fs-7 italic">Curriculum details coming soon...</div>');
        }

        // Status Badge Logic
        const $statusBadge = $('#modal_status_badge');
        const $statusIcon = $('#modal_status_icon');
        const $statusI = $('#modal_status_i');

        $statusBadge.removeClass('badge-light-success badge-light-warning');
        $statusIcon.removeClass('bg-light-success bg-light-warning');
        $statusI.removeClass('ki-check-circle ki-time text-success text-warning');

        if (status === 'PASSED') {
            $statusBadge.addClass('badge-light-success text-success').text('PASSED');
            $statusIcon.addClass('bg-light-success');
            $statusI.addClass('ki-check-circle text-success');
        } else {
            $statusBadge.addClass('badge-light-warning text-warning').text('PENDING');
            $statusIcon.addClass('bg-light-warning');
            $statusI.addClass('ki-time text-warning');
        }
    });

    // Optional: Log analytics or handle modal close
    $(courseModal).on('hidden.bs.modal', function () {
        // Reset or additional logic if needed
    });
});
