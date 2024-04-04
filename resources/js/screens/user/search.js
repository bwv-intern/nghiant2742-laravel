import { initOverlay } from "../../common";

$(function() {
    // Validate search form before submitting
    $("#userSearchForm").validate({
        rules: {
            email: {
                email: true,
            },
            phone: {
                number: ['Phone', 'number']
            },
        },
        invalidHandler: function(form, validator) {
            let errors = validator.numberOfInvalids();
            if (errors) {                    
                validator.errorList[0].element.focus();
            }
        },
        submitHandler: function(form) {
            let $form = $(form);
            if ($(form).valid()) {
                // Filter to remove empty input
                let $validInputs = $form.find(':input').filter(function() {
                    return $.trim($(this).val()) !== '';
                });
                $form.find(':input').not($validInputs).attr('disabled', true);

                // init overlay
                initOverlay()
                // alert('Stop')
                $form.trigger( "submit" );
            }
        } 
    });

    // Handle event clear search form
    $("#btnClear").on( "click", function() {
        const currentURL = window.location.href;
        const url = new URL(currentURL);
        if (url.search) {
            let url = currentURL + "&clear=true";
            initOverlay()
            window.location.href = url;
        } else {
            $("#userSearchForm").trigger("reset");
        }
    });

    // Handle delete user 
    $('.deleteBtn').on('click', function(event) {
        event.preventDefault();
        
        var id = $(this).data('id');
        
        let isConfirm = confirm(`Are you sure you want to delete the record with id ${id}?`);
        
        if (isConfirm) {
            $('#deleteForm_' + id).submit();
        }
    });
    
})