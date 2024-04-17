import { initOverlay } from "../common";

$(function () {
    $("#loginForm").validate({
        rules: {
            email: {
                required: ['Email'],
                email: true,
            },
            password: {
                required: ['Password'],
            },
        },
        onfocusout: function(element) {
            $(element).valid();
        },
        invalidHandler: function(form, validator) {
            var errors = validator.numberOfInvalids();
            if (errors) {                    
                validator.errorList[0].element.focus();
            }
        },
        submitHandler: function (form) {
            $(form).find(':submit').prop('disabled', true).addClass('btnDisabled');
            initOverlay();
            form.submit();
        },
    });


})