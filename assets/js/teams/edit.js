var form = document.querySelector('form#team_edit');
var aliases = {
    name: 'Team Name',
    manager: 'Manager',
    team_leader: 'Team Leader'
};
form.addEventListener("submit", function (e) {
    var values = validate.collectFormValues(form);
    var errors = validate(values, {
        name: {
            presence: true
        },
        manager: {
            presence: true,
            numericality: {
                notValid: ' contains invalid value'
            }
        },
        team_leader: {
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