
$("#country, #state").on("change", function() {
    var country = $("#country").val();
    var state = $("#state").val();

    ajaxRequest(country, state, 0);
});

$(".btn").on("click", function() {
    var country = $("#country").val();
    var state = $("#state").val();
    var start = $(this).data('start');

    ajaxRequest(country, state, start);
});

function ajaxRequest(country, state, start) {
    $.ajax({
        method: 'GET',
        url: '/',
        data: {
            country: country,
            state: state,
            start: start
        },
        success: function(response) {

            $("#phone_list").empty();
            tbody = $(response).find("#phone_list");
            $("#phone_list").append(tbody.contents());

            var next_start = $(response).find("#next").data('start');
            $("#prev").data('start', next_start - 10);
            $("#next").data('start', next_start);
            if (next_start > 5) {
                $("#prev").attr('disabled', false);
            } else {
                $("#prev").attr('disabled', true);
            }
        }
    });
}

