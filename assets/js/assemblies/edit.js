var form = document.querySelector('form#assembly_edit');
var aliases = {
    name: 'Name',
    items: 'Item'
};
form.addEventListener("submit", function (e) {
    var _aliases = aliases;
    var values = validate.collectFormValues(form);
    var validationJson = {
        name: {
            presence: true
        }
    };

    $('.duplicate-container').each(function (index, el) {
        var ele_index_1 = parseInt($(this).data('index'));
        validationJson[`items[${ele_index_1}][item_id]`] = {
            presence: true,
            numericality: {
                notValid: ' contains invalid value'
            }
        };
        _aliases[`items[${ele_index_1}][item_id]`] = aliases.items;
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
    
    $('form#assembly_edit select').select2({
        width: '100%'
    });

    $('form#assembly_edit').on('change', '.description-container select', function () {
        var selectEl = $(this);
        var itemId = selectEl.val();
        $.ajax({
            url: '/item/ajax-record/' + itemId
        }).done(function (item) {
            item = JSON.parse(item);
            selectEl.closest('.description-container').find('textarea.item-description').val(item.description);
        });
    });

    $('form#assembly_edit').on('click', '.duplicate-container.description-container .duplicate-buttons span#add', function () {
        var index = 0;

        // find next index for new controls
        $('.duplicate-container.description-container').each(function () {
            var ele_index = parseInt($(this).data('index'));
            if (ele_index >= index) {
                index = ele_index + 1;
            }
        });

        // find dropdown list
        var options = '';
        $(this).closest('.duplicate-container').find('select').find('option').each(function () {
            var option = $(this);
            var optionVal = option.val();
            options += '<option value="' + optionVal + '"' + (optionVal == '' ? ' disabled selected' : '') + '>' + option.html() + '</option>';
        });

        var htmlToAdd = `<div data-index="${index}" class="row duplicate-container description-container">
        <div class="col-md-11 col-xs-8">
                <select name="items[${index}][item_id]" class="form-control">${options}</select>
                <textarea class="form-control item-description" name="items[${index}][description]" placeholder="Description"></textarea>
            </div>
            <div class="col-md-1 col-xs-4 duplicate-buttons">
                <span id="add"><i class="fa fa-plus-square-o text-success" aria-hidden="true"></i></span>
                <span id="remove" class="pull-right"><i class="fa fa-minus-square-o text-danger" aria-hidden="true"></i></span>
            </div>
        </div>`;

        $(this).closest('.duplicate-container').after(htmlToAdd);
        $(this).closest('.duplicate-container').next().find('select').select2({
            width: '100%'
        });
    });

    $('form#assembly_edit').on('click', '.duplicate-container.description-container .duplicate-buttons span#remove', function () {
        if ($('.duplicate-container.description-container').length > 2) {
            $(this).closest('.duplicate-container.description-container').remove();
        } else {
            alert('Minimum 2 Items required!');
        }
    });
});