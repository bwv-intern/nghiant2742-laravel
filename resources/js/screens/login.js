import { getMsgError } from "../common";

$(document).ready(function () {
    $("#loginForm").validate({
        rules: {
            email: {
                required: true,
                email: true,
            },
            password: {
                required: true,
            },
        },
        messages: {
            email: {
                required: getMsgError('errors', 'E001', 'Email'),
                email: getMsgError('errors', 'E004'),
            },  
            password: {
                required: getMsgError('errors', 'E001', 'Password'),
            },   
        },
        invalidHandler: function(form, validator) {
            var errors = validator.numberOfInvalids();
            if (errors) {                    
                validator.errorList[0].element.focus();
            }
        },
        submitHandler: function(form) {
            var $form = $(form);
            $('.btnSubmit').html('<span class="loader"></span>Login')
            $('.btnSubmit').attr('disabled', true)
            $form.submit();
        } 
    });
})
