$(document).ready(function () {
    $("#loginForm").validate({
        rules: {
            email: {
                required: true,
                email: true,
            },
            password: {
                required: true,
            },
        },
        messages: {
            email: {
                required: "Email is required field.",
                email: "Please enter your email address correctly.",
            },  
            password: {
                required: "Password is required field.",
            },   
        },
        invalidHandler: function(form, validator) {
            var errors = validator.numberOfInvalids();
            if (errors) {                    
                validator.errorList[0].element.focus();
            }
        } 
    });
})

$('#loginForm').submit(function (e) {
    $('#btnLogin').text('Loading...')
    $('#btnLogin').attr('disabled', true)
});
