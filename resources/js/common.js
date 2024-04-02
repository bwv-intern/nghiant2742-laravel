export const messages = {
    errors: {
        E001: "{0} is required field.",
        E002: "{0} must be less than {1} characters. (Currently {2} characters)",
        E003: "{0} must be more than {1} characters. (Currently {2} characters)",
        E004: "Please enter your email address correctly.",
        E006: "The file size limit {0} has been exceeded.",
        E007: "File extension is incorrect. Please use {0}.",
        E008: "CSV format is incorrect. Please check header information.",
        E009: "{0} is duplicated.",
        E010: "Email or Password incorrect.",
        E011: "Re-password is not the same as Password.",
        E012: "{0} format is not correct. Please enter {1} only.",
        E014: "Save failed.",
        E015: "{0} does not exist.",
        E016: "Permission denied.",
        E017: "{0} must be less than {1}.",
    },
    infors: {
        I005: "There is no result.",
        I013: "Saved successfully.",
        I018: "Are you sure you want to delete the record with id {0}?",
    }
}

export function getMsgError(state, code, x = "", y = "", z = ""){
    const message = messages[state][code];
    return message.replace(/\{0\}/g, x).replace(/\{1\}/g, y).replace(/\{2\}/g, z);
}

$(function() {
    $('form').submit(function (e) { 
        let buttonName = $('.btnSubmit').text();
        $('.btnSubmit').html(`<span class="loader"></span>${buttonName}`)
        $('.btnSubmit').attr('disabled', true)
    });
})