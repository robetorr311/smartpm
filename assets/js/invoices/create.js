var form = document.querySelector('form#invoice_create');
var aliases = {
    date: 'Date',
    client_id: 'Client',
    item: 'Item',
    amount: 'Amount'
};
form.addEventListener("submit", function (e) {
    var _aliases = aliases;
    var values = validate.collectFormValues(form);
    var validationJson = {
        client_id: {
            presence: true,
            numericality: {
                notValid: ' contains invalid value'
            }
        },
        date: {
            presence: true,
            date: true
        }
    };

    $('.duplicate-container.items-container').each(function () {
        var ele_index = parseInt($(this).data('index'));
        validationJson[`items[${ele_index}][name]`] = {
            presence: true
        };
        validationJson[`items[${ele_index}][amount]`] = {
            presence: true,
            numericality: {
                notValid: ' contains invalid value'
            }
        };

        _aliases[`items[${ele_index}][name]`] = aliases.item;
        _aliases[`items[${ele_index}][amount]`] = aliases.amount;
    });

    var errors = validate(values, validationJson, {
        format: 'flat',
        prettify: function prettify(string) {
            return _aliases[string] || validate.prettify(string);
        }
    });
    if (errors) {
        e.preventDefault();
        displayValidationError(errors);
    }
});

$(document).ready(function () {
    $('form#invoice_create #client_id').select2({
        width: '100%'
    });

    $('form#invoice_create').on('click', '.duplicate-container.items-container .duplicate-buttons span#add', function () {
        var index = 0;

        // find next index for new controls
        $('.duplicate-container.items-container').each(function () {
            var ele_index = parseInt($(this).data('index'));
            if (ele_index >= index) {
                index = ele_index + 1;
            }
        });

        var htmlToAdd = `<div data-index="${index}" class="row duplicate-container items-container">
            <div class="col-md-8">
                <input class="form-control" placeholder="Item" name="items[${index}][name]" type="text">
            </div>
            <div class="col-md-3 col-xs-8">
                <input class="form-control" placeholder="Amount" name="items[${index}][amount]" type="number">
            </div>
            <div class="col-md-1 col-xs-4 duplicate-buttons">
                <span id="add"><i class="fa fa-plus-square-o text-success" aria-hidden="true"></i></span>
                <span id="remove" class="pull-right"><i class="fa fa-minus-square-o text-danger" aria-hidden="true"></i></span>
            </div>
        </div>`;

        $(this).closest('.duplicate-container').after(htmlToAdd);
    });

    $('form#invoice_create').on('click', '.duplicate-container.items-container .duplicate-buttons span#remove', function () {
        if ($('.duplicate-container.items-container .duplicate-buttons').length > 1) {
            $(this).closest('.duplicate-container.items-container').remove();
        } else {
            alert('Minimum 1 item required!');
        }
    });
});