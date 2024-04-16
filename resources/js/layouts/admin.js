$(function () {
    // Get the current URL of the page
    const currentURL = window.location.pathname;
    
    // Loop through each anchor tag inside the sidebar
    $('.sidebar a').each(function() {
        // Get the URL of the anchor tag
        const url = this.pathname;
        
        // Check if the current URL includes the URL of the anchor tag
        if (currentURL.includes(url)) {
            // Add the 'activeItem' class to the anchor tag if the URLs match
            $(this).addClass('activeItem');
        }
    });

    // Handle click event for elements with class 'projectName'
    $('.projectName').one("click", function (e) {
        // Prevent the default action of the click event
        e.preventDefault();
        
        // Redirect to the '/admin' page
        window.location.href = '/admin';
    });

    // Handle click event for elements with class 'btnSidebar'
    $('.btnSidebar').on("click", function (e) {
        // Remove the 'd-none' class from the sidebar
        $('.sidebar').removeClass("d-none");
    });

    // Handle click event for elements with class 'btnSidebar-close'
    $('.btnSidebar-close').on("click", function (e) {
        // Add the 'd-none' class to the sidebar
        $('.sidebar').addClass("d-none");
    });

    // Handle click event for elements with class 'sidebar-item', executes only once
    $(".sidebar-item").one("click", function(){
        // Add 'btn' and 'disabled' classes to the clicked sidebar item
        $(this).addClass("btn disabled");
    });

    // Handle click event for elements with a tag
    $('.link').one("click", function (e) {
        $(this).addClass("btn disabled");
    });
});
