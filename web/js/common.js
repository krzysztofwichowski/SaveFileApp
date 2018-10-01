$(document).ready(function () {
    $('form#form_details').on('submit', function (e) {
        e.preventDefault();

        var data = new FormData($(this)[0]);

        $.ajax({
            url: '/upload',
            type: 'POST',
            enctype: 'multipart/form-data',
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            success: function (response) {
                alert(response.success);
            },
            error: function (response) {
                alert(response.success);
            }
        })
    });
})