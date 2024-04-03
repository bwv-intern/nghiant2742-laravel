$(function () {
    const currentURL = window.location.pathname;
    $('.sidebar a').each(function() {
        const url = this.pathname;
        if (currentURL === url) {
            $(this).addClass('activeItem');
        }
    });

    $('.projectName').on("click", function (e) {
        e.preventDefault();
        window.location.href = '/admin';
    });
});
