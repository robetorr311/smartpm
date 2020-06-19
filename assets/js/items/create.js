var form = document.querySelector('form#item_create');
var aliases = {
    item_name: 'Item Name'
};
form.addEventListener("submit", function (e) {
    
    var values = validate.collectFormValues(form);
    var errors = validate(values, {
        item_name: {
            presence: true
        }, 
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