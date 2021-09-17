$(function() {
    $('select').select2();

    $('[data-bs-toggle="tooltip"]').tooltip();

    $('#cokiealert > span.btn').click(function() {
        $.ajax({
            url: '/accept-cookie',
            type: 'post',
            success: function(json) {
                $('#cokiealert').hide();
            }
        });
    });
});
