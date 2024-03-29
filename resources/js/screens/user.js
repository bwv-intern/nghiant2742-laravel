import { getMsgError } from "../common";

$(document).ready(function () {
    $("#userSearchForm").validate({
        rules: {
            email: {
                email: true,
            },
            fullname: {
            },
            phone: {
                number: true
            },
        },
        messages: {
            email: {
                email: getMsgError('errors', 'E004'),
            },  
            // fullname: {
            //     required: getMsgError('errors', 'E001', 'Fullname'),
            // }, 
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
            $('#btnSearchUser').html('<span class="loader"></span>Search')
            $('#btnSearchUser').attr('disabled', true)

            $form.find('input').filter(function() {
                return !this.value;
            }).prop('disabled', true);
            
            $form.submit();
        } 
    });

    $("#paginationForm button").click(function() {
        var page = $(this).data("page");
        var form = $("#paginationForm");
        
        $("<input>").attr({
            type: "hidden",
            name: "page",
            value: page
        }).appendTo(form);

        form.submit();
    });
})
