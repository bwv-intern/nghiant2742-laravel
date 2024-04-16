import { initOverlay } from "../../common";

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
            // init overlay
            initOverlay()
            form.submit();
        },
        invalidHandler: function(event, validator) {
            // Khi xảy ra điều kiện không hợp lệ, xóa lớp 'disabled' và 'btnDisabled' từ button submit
            $(validator.currentForm).find(':submit').prop('disabled', false).removeClass('disabled');
        }
    });
})