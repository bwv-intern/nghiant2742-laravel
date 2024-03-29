$(function () {
    const sidebarItem = $('.sidebar a');
    for (let index = 0; index < sidebarItem.length; index++) {
        const element = sidebarItem[index];
        const url = element.href;
        const endpoint = new URL(url).pathname;
        const currentURL = window.location.href;
        
        if (currentURL.includes(endpoint)) {
            element.classList.add('activeItem');
        }
    }

    $('.projectName').click(function (e) { 
        e.preventDefault();
        window.location.href = '/admin';
    });
});