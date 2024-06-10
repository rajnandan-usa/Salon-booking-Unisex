$(document).ready(function () {
    // Initialize FullCalendar for date picker
    $('#appointment-date').fullCalendar({
        initialView: 'dayGridMonth',
        selectable: true,
        dateClick: function (info) {
            $('#appointment-date').val(info.dateStr);
        }
    });

    // Initialize time picker
    $('#appointment-time').timepicker({
        timeFormat: 'h:mm p',
        interval: 15,
        minTime: '10:00am',
        maxTime: '6:00pm',
        defaultTime: '10',
        startTime: '10:00',
        dynamic: false,
        dropdown: true,
        scrollbar: true
    });
});
