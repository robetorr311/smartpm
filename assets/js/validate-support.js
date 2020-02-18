validate.extend(validate.validators.datetime, {
    parse: function (value, options) {
        return +moment.utc(value);
    },
    format: function (value, options) {
        var format = options.dateOnly ? "YYYY-MM-DD" : "YYYY-MM-DD hh:mm:ss";
        return moment.utc(value).format(format);
    }
});

function displayValidationError(errors, errDiv = 'validation-errors') {
    var htmlErrors = "";
    htmlErrors += '<div class="alert alert-danger fade in alert-dismissable" title="Error:"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>';
    errors.forEach(error => {
        htmlErrors += '<p>' + error + '</p>';
    });
    htmlErrors += '</div>';
    document.getElementById(errDiv).innerHTML = htmlErrors;
    document.getElementById(errDiv).scrollIntoView();
}