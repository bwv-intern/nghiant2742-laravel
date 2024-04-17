import { initOverlay, getMsg } from "../../common";

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
            date_of_birth: {
                dateISO: ['Date', 'yyyy-mm-dd']
            }
        },
        invalidHandler: function(form, validator) {
            let errors = validator.numberOfInvalids();
            if (errors) {                    
                validator.errorList[0].element.focus();
            }
        },
        submitHandler: function(form) {
            let $form = $(form);
            // Filter to remove empty input
            let $validInputs = $form.find(':input').filter(function() {
                return $.trim($(this).val()) !== '';
            });
            $form.find(':input').not($validInputs).attr('disabled', true);
            $form.find(':submit').prop('disabled', true).addClass('btnDisabled');

            // init overlay
            initOverlay()
            // alert('Stop')
            $form.trigger( "submit" );
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
        
        let isConfirm = confirm(getMsg('infors', 'I018', id));
        
        if (isConfirm) {
            $('#deleteForm_' + id).submit();
        }
    });
    
})