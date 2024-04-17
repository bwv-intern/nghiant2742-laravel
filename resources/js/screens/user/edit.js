import { initOverlay } from "../../common";

$(function() {
    // Validate add user form
    $("#updateUserForm").validate({
        rules: {
            name: {
                required: ['Name'],
            },
            email: {
                required: ['Email'],
                email: true,
                maxlength: 50
            },
            password: {
                required: function(element) {
                    if ($("#re_password").val().length > 0) {
                        return ['Passoword'];
                    }
                    return false
                },
            },
            re_password: {
                required: function(element) {
                    if ($("#password").val().length > 0) {
                        return ['Re-password'];
                    }
                    return false
                },
                equalTo: "#password",
            },
            phone: {
                number: ['Phone', 'number'],
                maxlength: 20
            },
            date_of_birth: {
                dateISO: ['Date', 'yyyy-mm-dd']
            }
        },
        onfocusout: function(element) {
            $(element).valid();
        },
        invalidHandler: function(form, validator) {
            let errors = validator.numberOfInvalids();
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