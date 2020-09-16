var form = document.querySelector('form#estimate_edit');
var aliases = {
    client_id: 'Client Name',
    date: 'Date',
    title: 'Title',
    note: 'Note',
    sub_title: 'Sub Title',
    item: 'Description',
    amount: 'Quantity',
    unit_price: 'Price'
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
        },
        title: {
            presence: true
        }
    };

    $('.duplicate-container.group-container').each(function () {
        var ele_index_1 = parseInt($(this).data('index'));
        validationJson[`desc_group[${ele_index_1}][sub_title]`] = {
            presence: true
        };
        _aliases[`desc_group[${ele_index_1}][sub_title]`] = aliases.sub_title;

        $(this).find('.duplicate-container.description-container').each(function () {
            var ele_index_2 = parseInt($(this).data('index'));
            validationJson[`desc_group[${ele_index_1}][${ele_index_2}][item]`] = {
                presence: true,
                numericality: {
                    notValid: ' contains invalid value'
                }
            };
            validationJson[`desc_group[${ele_index_1}][${ele_index_2}][amount]`] = {
                numericality: {
                    notValid: ' contains invalid value'
                }
            };
            validationJson[`desc_group[${ele_index_1}][${ele_index_2}][unit_price]`] = {
                numericality: {
                    notValid: ' contains invalid value'
                }
            };

            _aliases[`desc_group[${ele_index_1}][${ele_index_2}][item]`] = aliases.item;
            _aliases[`desc_group[${ele_index_1}][${ele_index_2}][amount]`] = aliases.amount;
            _aliases[`desc_group[${ele_index_1}][${ele_index_2}][unit_price]`] = aliases.unit_price;
        });
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
    $('form#estimate_edit #client_id').select2({
        width: '100%'
    });

    $('form#estimate_edit .group-container select').select2({
        width: '100%'
    });

    $('form#estimate_edit .group-container select, form#estimate_edit .group-container input').on('input', itemValuesChange);

    $('form#estimate_edit').on('change', '.group-container select', function () {
        var selectEl = $(this);
        var itemId = selectEl.val();
        $.ajax({
            url: '/item/ajax-record/' + itemId
        }).done(function (item) {
            var descriptionContainer = selectEl.closest('.description-container');
            item = JSON.parse(item);
            descriptionContainer.find('textarea.item_description').val(item.description);
            descriptionContainer.find('input.item_unit').val(item.quantity_units);
            descriptionContainer.find('input.item_price').val(item.unit_price);
        });
    });

    $('form#estimate_edit').on('click', '.duplicate-container.group-container .duplicate-buttons.group-duplicate-buttons span#add', function () {
        var index = 0;

        // find next index for new controls
        $('.duplicate-container.group-container').each(function () {
            var ele_index = parseInt($(this).data('index'));
            if (ele_index >= index) {
                index = ele_index + 1;
            }
        });

        // find dropdown list
        var options = '';
        $(this).closest('.duplicate-container.group-container').find('select').first().find('option').each(function () {
            var option = $(this);
            var optionVal = option.val();
            options += '<option value="' + optionVal + '"' + (optionVal == '' ? ' disabled selected' : '') + '>' + option.html() + '</option>';
        });

        var htmlToAdd = `<div data-index="${index}" class="duplicate-container group-container">
            <hr />
            <div class="row">
                <div class="col-md-12" style="background-color: #ddd;">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label>Sub Title<span class="red-mark">*</span></label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-11 col-xs-8">
                                <input class="form-control" placeholder="Sub Title" name="desc_group[${index}][sub_title]" type="text">
                            </div>
                            <div class="col-md-1 col-xs-4 duplicate-buttons group-duplicate-buttons">
                                <span id="add"><i class="fa fa-plus-square-o text-success" aria-hidden="true"></i></span>
                                <span id="remove" class="pull-right"><i class="fa fa-minus-square-o text-danger" aria-hidden="true"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label>Item<span class="red-mark">*</span></label>
                            </div>
                            <div class="col-md-2">
                                <label>Quantity</label>
                            </div>
                            <div class="col-md-2">
                                <label>Unit</label>
                            </div>
                            <div class="col-md-2">
                                <label>Price</label>
                            </div>
                            <div class="col-md-2">
                                <label>Total</label>
                            </div>
                            <div class="col-md-1"></div>
                        </div>
                        <div class="sortable-items">
                            <div data-index="0" class="row duplicate-container description-container">
                                <div class="col-md-6">
                                <i class="fa fa-bars handle" aria-hidden="true"></i>
                                    <select name="desc_group[${index}][0][item]" class="form-control">${options}</select>
                                    <textarea class="form-control item_description" name="desc_group[${index}][0][description]" placeholder="Description"></textarea>
                                </div>
                                <div class="col-md-5 no-vertical-padding">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <input class="form-control item_amount" placeholder="Quantity" name="desc_group[${index}][0][amount]" type="number">
                                        </div>
                                        <div class="col-md-3">
                                            <input class="form-control item_unit" placeholder="Unit" name="desc_group[${index}][0][quantity_units]" type="text">
                                        </div>
                                        <div class="col-md-3">
                                            <input class="form-control item_price" placeholder="Price" name="desc_group[${index}][0][unit_price]" type="number">
                                        </div>
                                        <div class="col-md-3">
                                            <span class="item_total">$0.00</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1 duplicate-buttons">
                                    <span id="add"><i class="fa fa-plus-square-o text-success" aria-hidden="true"></i></span>
                                    <span id="remove" class="pull-right"><i class="fa fa-minus-square-o text-danger" aria-hidden="true"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>`;

        $(this).closest('.duplicate-container.group-container').after(htmlToAdd);
        $(this).closest('.duplicate-container.group-container').next().find('select').select2({
            width: '100%'
        });
        $(this).closest('.duplicate-container.group-container').next().find('.sortable-items').sortable({
            handle: '.handle',
            invertSwap: true,
            animation: 150
        });
        
        $(this).closest('.duplicate-container.group-container').next().find('select, input').on('input', itemValuesChange);
    });

    $('form#estimate_edit').on('click', '.duplicate-container.group-container .duplicate-buttons.group-duplicate-buttons span#remove', function () {
        if ($('.duplicate-container.group-container').length > 1) {
            $(this).closest('.duplicate-container.group-container').remove();
        } else {
            alert('Minimum 1 description required!');
        }
    });

    $('form#estimate_edit').on('click', '.duplicate-container.group-container .duplicate-container.description-container .duplicate-buttons span#add', function () {
        var index = 0;
        var parent_index = $(this).closest('.duplicate-container.group-container').data('index');

        // find next index for new controls
        $(this).closest('.duplicate-container.group-container').find('.duplicate-container.description-container').each(function () {
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
            <div class="col-md-6">
                <i class="fa fa-bars handle" aria-hidden="true"></i>
                <select name="desc_group[${parent_index}][${index}][item]" class="form-control">${options}</select>
                <textarea class="form-control item_description" name="desc_group[${parent_index}][${index}][description]" placeholder="Description"></textarea>
            </div>
            <div class="col-md-5 no-vertical-padding">
                <div class="row">
                    <div class="col-md-3">
                        <input class="form-control item_amount" placeholder="Quantity" name="desc_group[${parent_index}][${index}][amount]" type="number">
                    </div>
                    <div class="col-md-3">
                        <input class="form-control item_unit" placeholder="Unit" name="desc_group[${parent_index}][${index}][quantity_units]" type="text">
                    </div>
                    <div class="col-md-3">
                        <input class="form-control item_price" placeholder="Price" name="desc_group[${parent_index}][${index}][unit_price]" type="number">
                    </div>
                    <div class="col-md-3">
                        <span class="item_total">$0.00</span>
                    </div>
                </div>
            </div>
            <div class="col-md-1 duplicate-buttons">
                <span id="add"><i class="fa fa-plus-square-o text-success" aria-hidden="true"></i></span>
                <span id="remove" class="pull-right"><i class="fa fa-minus-square-o text-danger" aria-hidden="true"></i></span>
            </div>
        </div>`;

        $(this).closest('.duplicate-container').after(htmlToAdd);
        $(this).closest('.duplicate-container').next().find('select').select2({
            width: '100%'
        });

        $(this).closest('.duplicate-container').next().find('select, input').on('input', itemValuesChange);
    });

    $('form#estimate_edit').on('click', '.duplicate-container.group-container .duplicate-container.description-container .duplicate-buttons span#remove', function () {
        if ($(this).closest('.duplicate-container.group-container').find('.duplicate-container.description-container .duplicate-buttons').length > 1) {
            $(this).closest('.duplicate-container.description-container').remove();
        } else {
            alert('Minimum 1 description required!');
        }
    });

    // ============== Drag & Drop Items ==============
    $('.sortable-items').sortable({
        handle: '.handle',
        invertSwap: true,
        animation: 150
    });

    // ============== Item Calculation on value change ==============
    function itemValuesChange() {
        var descriptionContainer = $(this).closest('.description-container');
        var qty = Number(descriptionContainer.find('input.item_amount').val());
        var price = Number(descriptionContainer.find('input.item_price').val());
        descriptionContainer.find('.item_total').html((qty * price).toLocaleString('en-US', {
            style: 'currency',
            currency: 'USD',
        }));
    }
});