import { getMsgError, initOverlay } from "../common";

$(document).ready(function () {

    // Validate search form before submitting
    $("#userSearchForm").validate({
        rules: {
            email: {
                email: true,
            },
            phone: {
                number: true
            },
        },
        messages: {
            email: {
                email: getMsgError('errors', 'E004'),
            },  
            phone: {
                number: getMsgError('errors', 'E012', 'Phone', 'number'),
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
            if ($(form).valid()) {

                // init overlay
                initOverlay()
                $form.submit();
            }
        } 
    });

    // Handle event clear search form
    $("#btnClear").click(function() {
        var form = $("#userSearchForm");
        $("<input>").attr({
            type: "hidden",
            name: "clear",
            value: "clear"
        }).appendTo(form);
        initOverlay()
        form.submit();
    });

    // Validate add user form
    $("#addUserForm").validate({
        rules: {
            name: {
                required: true,
            },
            email: {
                required: true,
                customEmail: true
            },
            password: {
                required: true,
                min: 6,
            },
            re_password: {
                required: true,
                equalTo: "#password",
                min: 6,
            },
            phone: {
                number: true
            },
        },
        messages: {
            name: {
                required: getMsgError('errors', 'E001', 'Name')
            },
            email: {
                required: getMsgError('errors', 'E001', 'Email'),
                customEmail: getMsgError('errors', 'E004')
            },
            password: {
                required: getMsgError('errors', 'E001', 'Password')
            },
            re_password: {
                required: getMsgError('errors', 'E001', 'Re-password')
            },
            phone: {
                number: getMsgError('errors', 'E012', 'Phone', 'number'),
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
            if ($(form).valid()) {
                // Init overlay
                initOverlay()
                $form.submit();
            }
        } 
    });

    $.validator.addMethod("customEmail", function(value, element) {
        return /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(value);
    }, getMsgError('errors', 'E004'));
    
    // Event focusout To validate required field
    $("#addUserForm input[name='email'], #addUserForm input[name='name'], #addUserForm input[name='password'], #addUserForm input[name='re_password'] ").on('focusout', function() {
        $(this).valid();
    });
    
})