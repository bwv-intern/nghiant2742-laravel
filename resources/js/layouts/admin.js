$(function () {
    const currentURL = window.location.pathname;
    $('.sidebar a').each(function() {
        const url = this.pathname;
        if (currentURL.includes(url)) {
            $(this).addClass('activeItem');
        }
    });

    $('.projectName').on("click", function (e) {
        e.preventDefault();
        window.location.href = '/admin';
    });

    $('.btnSidebar').on("click", function (e) {
        $('.sidebar').removeClass("d-none");
    });

    $('.btnSidebar-close').on("click", function (e) {
        $('.sidebar').addClass("d-none");
    });
});
