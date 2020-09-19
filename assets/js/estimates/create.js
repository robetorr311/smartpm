var form = document.querySelector('form#estimate_create');
var aliases = {
    client_id: 'Client Name',
    date: 'Date',
    title: 'Title',
    note: 'Note',
    sub_title: 'Sub Title',
    group:'Group',
    item: 'Item',
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
            validationJson[`desc_group[${ele_index_1}][${ele_index_2}][group]`] = {
                presence: true,
                numericality: {
                    notValid: ' contains invalid value'
                }
            };

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
            _aliases[`desc_group[${ele_index_1}][${ele_index_2}][group]`] = aliases.group;
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
    var blockItemChangeEvent = false;

    $('form#estimate_create #client_id').select2({
        width: '100%'
    });

    $('form#estimate_create .group-container select').select2({
        width: '100%'
    });

    $('form#estimate_create .group-container select, form#estimate_create .group-container input').on('input', itemValuesChange);

    $('input[type=radio][name=create_type]').change(function () {
        if (this.value == 'Create From Scratch') {
            $('select#create_type_assemblies_select').attr("disabled", true);
            $('#load_assembly').attr("disabled", true);
        } else if (this.value == 'Load From Assemblies') {
            $('select#create_type_assemblies_select').removeAttr("disabled");
            if ($('select#create_type_assemblies_select').val() == null) {
                $('#load_assembly').attr("disabled", true);
            } else {
                $('#load_assembly').removeAttr("disabled");
            }
        }
    });

    $('select#create_type_assemblies_select').select2({
        width: '100%'
    });

    $('select#create_type_assemblies_select').change(function () {
        if (this.value != null || this.value != '') {
            $('#load_assembly').removeAttr("disabled");
        } else {
            $('#load_assembly').attr("disabled", true);
        }
    });

    $('#load_assembly').click(function () {
        var selectedAssembly = $('select#create_type_assemblies_select').val();
        if (selectedAssembly != null || selectedAssembly != '') {
            $.ajax({
                url: '/assembly/ajax-record/' + selectedAssembly
            }).done(function (assembly) {
                assembly = JSON.parse(assembly);
                var groupContainers = $('.duplicate-container.group-container');
                if (groupContainers.length > 1) {
                    groupContainers.each(function (index) {
                        if (index > 0) {
                            $(this).find('.duplicate-buttons.group-duplicate-buttons span#remove').click();
                        }
                    });
                }
                var descriptionContainers = $('.duplicate-container.description-container');
                if (descriptionContainers.length > 1) {
                    descriptionContainers.each(function (index) {
                        if (index > 0) {
                            $(this).find('.duplicate-buttons span#remove').click();
                        }
                    });
                }
                var index = $('.duplicate-container.group-container').data('index');
                blockItemChangeEvent = true;
                $('.duplicate-container.group-container').find('input[name="desc_group[' + index + '][sub_title]"]').val(assembly.name);
                $('.duplicate-container.group-container').find('.duplicate-container.description-container select').val(assembly.items[0].item).change();
                $('.duplicate-container.group-container').find('.duplicate-container.description-container textarea.item_description').val(assembly.items[0].description);
                $('.duplicate-container.group-container').find('.duplicate-container.description-container input.item_unit').val(assembly.items[0].quantity_units);
                $('.duplicate-container.group-container').find('.duplicate-container.description-container input.item_price').val(assembly.items[0].unit_price);
                for (let i = 0; i < (assembly.items.length - 1); i++) {
                    $('.duplicate-container.group-container').find('.duplicate-container.description-container:last-child .duplicate-buttons span#add').click();
                    $('.duplicate-container.group-container').find('.duplicate-container.description-container:last-child select').val(assembly.items[i + 1].item).change();
                    $('.duplicate-container.group-container').find('.duplicate-container.description-container:last-child textarea.item_description').val(assembly.items[i + 1].description);
                    $('.duplicate-container.group-container').find('.duplicate-container.description-container:last-child input.item_unit').val(assembly.items[i + 1].quantity_units);
                    $('.duplicate-container.group-container').find('.duplicate-container.description-container:last-child input.item_price').val(assembly.items[i + 1].unit_price);
                }
                blockItemChangeEvent = false;
            });
        }
    });

    $('form#estimate_create').on('change', '.group-container .items-dropdown', function () {
        if (blockItemChangeEvent) {
            return;
        }
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

    $('form#estimate_create').on('click', '.duplicate-container.group-container .duplicate-buttons.group-duplicate-buttons span#add', function () {
        var index = 0;
        var parent_index = $(this).closest('.duplicate-container.group-container').data('index');
        // find next index for new controls
        $('.duplicate-container.group-container').each(function () {
            var ele_index = parseInt($(this).data('index'));
            if (ele_index >= index) {
                index = ele_index + 1;
            }
        });
        
        // find dropdown list

        // Groups dropdown
        var options_groups = '';
        $(this).closest('.duplicate-container.group-container').find('.groups-dropdown').first().find('option').each(function () {
            var option = $(this);
            var optionVal = option.val();
            options_groups += '<option value="' + optionVal + '"' + (optionVal == '' ? ' disabled selected' : '') + '>' + option.html() + '</option>';
        });

        // items dropdown
        var options_items = '';
        $(this).closest('.duplicate-container.group-container').find('.items-dropdown').first().find('option').each(function () {
            var option = $(this);
            var optionVal = option.val();
            options_items += '<option value="' + optionVal + '"' + (optionVal == '' ? ' disabled selected' : '') + '>' + option.html() + '</option>';
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
                                <label>Group<span class="red-mark">*</span></label>
                            </div>
                            <div class="col-md-3">
                                <label>Item<span class="red-mark">*</span></label>
                            </div>
                            <div class="col-md-5 no-vertical-padding">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Quantity</label>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Unit</label>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Price</label>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Total</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1"></div>
                        </div>
                        <div class="sortable-items">
                            <div data-index="0" class="row duplicate-container description-container">
                                <div class="col-md-6 no-vertical-padding">
                                    <div class="col-md-6">
                                        <i class="fa fa-bars handle" aria-hidden="true"></i>
                                        <select name="desc_group[${parent_index}][${index}][group]" class="form-control groups-dropdown">${options_groups}</select>
                                    </div>
                                    <div class="col-md-6">
                                        <select name="desc_group[${parent_index}][${index}][item]" class="form-control items-dropdown">${options_items}</select>
                                    </div>
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

    $('form#estimate_create').on('click', '.duplicate-container.group-container .duplicate-buttons.group-duplicate-buttons span#remove', function () {
        if ($('.duplicate-container.group-container').length > 1) {
            $(this).closest('.duplicate-container.group-container').remove();
        } else {
            alert('Minimum 1 description required!');
        }
    });

    $('form#estimate_create').on('click', '.duplicate-container.group-container .duplicate-container.description-container .duplicate-buttons span#add', function () {
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

        // Groups dropdown
        var options_groups = '';
        $(this).closest('.duplicate-container').find('.groups-dropdown').find('option').each(function () {
            var option = $(this);
            var optionVal = option.val();
            options_groups += '<option value="' + optionVal + '"' + (optionVal == '' ? ' disabled selected' : '') + '>' + option.html() + '</option>';
        });

        // Items dropdown
        var options_items = '';
        $(this).closest('.duplicate-container').find('.items-dropdown').find('option').each(function () {
            var option = $(this);
            var optionVal = option.val();
            options_items += '<option value="' + optionVal + '"' + (optionVal == '' ? ' disabled selected' : '') + '>' + option.html() + '</option>';
        });

        var htmlToAdd = `<div data-index="${index}" class="row duplicate-container description-container">
            <div class="col-md-6 no-vertical-padding">
                <div class="col-md-6">
                    <i class="fa fa-bars handle" aria-hidden="true"></i>
                    <select name="desc_group[${parent_index}][${index}][group]" class="form-control groups-dropdown">${options_groups}</select>
                    
                </div>
                <div class="col-md-6">
                    <select name="desc_group[${parent_index}][${index}][item]" class="form-control items-dropdown">${options_items}</select>
                    
                </div>
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

    $('form#estimate_create').on('click', '.duplicate-container.group-container .duplicate-container.description-container .duplicate-buttons span#remove', function () {
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

    // Get items by group id
    $('form#estimate_create').on('change', '.group-container .groups-dropdown', function () {
        
        var selectEl = $(this);
        var group_id = selectEl.val();
        $.ajax({
            url: '/group/get-group-items/',
            type: 'POST',
            data: {group_id : group_id}
        }).done(function (response) {
            var results = JSON.parse(response);
            var option_data = "<option value=''disabled selected>Select Item</option>";
            if(results.length > 0) {
               
                results.forEach((element) => {
                    
                    option_data += "<option value='"+element.id+"'>"+element.name+"</option>"; 
                });
               
            }
            selectEl.closest('.description-container').find('.items-dropdown').first().html(option_data);
        });
    });
});
