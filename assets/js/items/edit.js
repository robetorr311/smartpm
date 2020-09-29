var form = document.querySelector('form#item_edit');
var aliases = {
    name: 'Item Name',
    item_group_id: 'Item Group'
};
form.addEventListener("submit", function (e) {
    var values = validate.collectFormValues(form);
    var errors = validate(values, {
        name: {
            presence: true
        },
        item_group_id: {
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

$(document).ready(function () {
    $('form#item_edit #item_group_id').select2({
        width: '100%'
    });
});