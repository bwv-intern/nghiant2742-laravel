import { initOverlay } from "../../common";

$(function() {
    // Handle export 
    $('#btnExport').on('click', function() {

        if (!$("#userSearchForm").valid()){
            return;
        }

        // Get the export URL from the 'data-target' attribute of the button
        const exportUrl = $(this).data('target');

        // Initialize an object to store query parameters from the search form
        const queryParams = {};

        // Get the values of input fields if they are not empty
        if ($('#email').val() !== '') {
            queryParams.email = $('#email').val();
        }
        $('#userSearchForm input[type=checkbox]').each(function() {
            if ($(this).is(':checked')) {
                const paramName = $(this).attr('name');
                const paramValue = $(this).val();
                // If queryParams[paramName] already exists, convert it to an array and push the new value
                if (queryParams[paramName]) {
                    if (!Array.isArray(queryParams[paramName])) {
                        queryParams[paramName] = [queryParams[paramName]];
                    }
                    queryParams[paramName].push(paramValue);
                } else {
                    // If queryParams[paramName] doesn't exist, initialize it as a single value or an array
                    queryParams[paramName] = paramValue;
                }
            }
        });
        if ($('#date_of_birth').val() !== '') {
            queryParams.date_of_birth = $('#date_of_birth').val();
        }
        if ($('#name').val() !== '') {
            queryParams.name = $('#name').val();
        }
        if ($('#phone').val() !== '') {
            queryParams.phone = $('#phone').val();
        }

        // Create the URL for the export request by concatenating the query parameters from the queryParams object
        let url = exportUrl + '?' + $.param(queryParams);

        // init overlay
        initOverlay()
        window.location.href = url;
        $.ajax({
            type: "GET",
            url: url,
            success: function (response) {
                if (response) {
                    // Remove the 'disabled' class from the export button
                    $('#btnExport').removeClass("disabled");
                    // Hide the overlay
                    $('#overlay').css('display', 'none');
                }
            }
        });
    });

})