import { getMsgError } from "../common";

$(document).ready(function () {
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
                $form.find('input').filter(function() {
                    return !this.value;
                }).prop('disabled', true);
                $form.submit();
            }
        } 
    });

    $("#btnClear").click(function() {
        var form = $("#userSearchForm");
        $("<input>").attr({
            type: "hidden",
            name: "clear",
            value: "clear"
        }).appendTo(form);
        form.submit();
    });
})