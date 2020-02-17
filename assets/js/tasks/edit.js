var form = document.querySelector('form#task_edit');
var aliases = {
    name: 'Task Name',
    type: 'Type',
    level: 'Importance Level',
    assigned_to: 'Assigned To',
    status: 'Status'
};
form.addEventListener("submit", function (e) {
    var values = validate.collectFormValues(form);
    var errors = validate(values, {
        name: {
            presence: true
        },
        type: {
            presence: true,
            numericality: {
                notValid: ' contains invalid value'
            }
        },
        level: {
            presence: true,
            numericality: {
                notValid: ' contains invalid value'
            }
        },
        assigned_to: {
            presence: true,
            numericality: {
                notValid: ' contains invalid value'
            }
        },
        status: {
            presence: true,
            numericality: {
                notValid: ' contains invalid value'
            }
        }
    }, {
        format: 'flat',
        prettify: function prettify(string) {
            return aliases[string] || validate.prettify(string);
        }
    });
    if (errors) {
        e.preventDefault();
        displayValidationError(errors, 'validation-errors-edit');
    }
});

var noteForm = document.querySelector('form#task_note');
var aliases = {
    note: 'Your Note'
};
noteForm.addEventListener("submit", function (e) {
    var values = validate.collectFormValues(noteForm);
    var errors = validate(values, {
        note: {
            presence: true
        }
    }, {
        format: 'flat',
        prettify: function prettify(string) {
            return aliases[string] || validate.prettify(string);
        }
    });
    if (errors) {
        e.preventDefault();
        displayValidationError(errors, 'validation-errors-note');
    }
});