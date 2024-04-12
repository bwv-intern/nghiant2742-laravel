$(function () {
    $("#importForm").validate({
        rules: {
            csv_file: {
                required: ['File'],
                extension: true,
                filesize: 5000
            }
        },
        submitHandler: function(form) {
            let $form = $(form);
            $(form).find(':submit').prop('disabled', true).addClass('btnDisabled');
            $form.trigger('submit');
        }
    });
})