var form = document.querySelector('form#vendor_edit');
var aliases = {
    email_id: 'Email ID'
};
form.addEventListener("submit", function (e) {
    var values = validate.collectFormValues(form);
    var errors = validate(values, {
        name: {
            presence: true
        },
        email_id: {
            email: true
        }
    }, {
        format: 'flat',
        prettify: function prettify(string) {
            return aliases[string] || validate.prettify(string);
        }
    });
    if (errors) {
        e.preventDefault();
        displayValidationError(errors);
    }
});

var form_contact = document.querySelector('form#vendor_contact');
form_contact.addEventListener("submit", function (e) {
    var values = validate.collectFormValues(form_contact);
    var errors = validate(values, {
        name: {
            presence: true
        },
        email_id: {
            email: true
        }
    }, {
        format: 'flat',
        prettify: function prettify(string) {
            return aliases[string] || validate.prettify(string);
        }
    });
    if (errors) {
        e.preventDefault();
        displayValidationError(errors, 'validation-errors-contact');
    }
});