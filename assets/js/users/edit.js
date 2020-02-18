var form = document.querySelector('form#user_edit');
var aliases = {
    first_name: 'First Name',
    last_name: 'Last Name',
    level: 'Level',
    office_phone: 'Office Phone',
    home_phone: 'Home Phone',
    cell_1: 'Cell 1',
    cell_2: 'Cell 2',
    notifications: 'Notifications',
    is_active: 'Status'
};
form.addEventListener("submit", function (e) {
    var values = validate.collectFormValues(form);
    var errors = validate(values, {
        first_name: {
            presence: true
        },
        last_name: {
            presence: true
        },
        level: {
            presence: true,
            numericality: {
                notValid: ' contains invalid value'
            }
        },
        office_phone: {
            numericality: {
                notValid: ' contains invalid value'
            }
        },
        home_phone: {
            numericality: {
                notValid: ' contains invalid value'
            }
        },
        cell_1: {
            numericality: {
                notValid: ' contains invalid value'
            }
        },
        cell_2: {
            numericality: {
                notValid: ' contains invalid value'
            }
        },
        notifications: {
            presence: true,
            numericality: {
                notValid: ' contains invalid value'
            }
        },
        is_active: {
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
        displayValidationError(errors);
    }
});