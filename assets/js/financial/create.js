var form = document.querySelector('form#financial_create');
var aliases = {
    vendor_id: 'Party Name',
    client_id: 'Party Name',
    transaction_date: 'Transaction Date',
    job_id: 'Job',
    amount: 'Amount',
    type: 'Type',
    subtype: 'Sub Type',
    accounting_code: 'Accounting Code',
    method: 'Method',
    bank_account: 'Bank Account',
    state: 'State'
};
form.addEventListener("submit", function (e) {
    var values = validate.collectFormValues(form);
    var validationJson = {
        party: {
            presence: true,
            inclusion: {
                within: ['1', '2'],
                message: ' contains invalid value'
            }
        },
        transaction_date: {
            presence: true,
            date: true
        },
        job_id: {
            presence: true,
            numericality: {
                notValid: ' contains invalid value'
            }
        },
        amount: {
            presence: true,
            numericality: {
                notValid: ' contains invalid value'
            }
        },
        type: {
            presence: true,
            numericality: {
                notValid: ' contains invalid value'
            }
        },
        subtype: {
            presence: true,
            numericality: {
                notValid: ' contains invalid value'
            }
        },
        accounting_code: {
            numericality: {
                notValid: ' contains invalid value'
            }
        },
        method: {
            numericality: {
                notValid: ' contains invalid value'
            }
        },
        bank_account: {
            numericality: {
                notValid: ' contains invalid value'
            }
        },
        state: {
            presence: true,
            numericality: {
                notValid: ' contains invalid value'
            }
        },
    };
    if ($('form#financial_create #party_vendor').is(':checked')) {
        validationJson['vendor_id'] = {
            presence: true,
            numericality: {
                notValid: ' contains invalid value'
            }
        };
    }
    if ($('form#financial_create #party_client').is(':checked')) {
        validationJson['client_id'] = {
            presence: true,
            numericality: {
                notValid: ' contains invalid value'
            }
        };
    }
    var errors = validate(values, validationJson, {
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
    if ($('form#financial_create #party_vendor').is(':checked')) {
        $('form#financial_create #vendor_id_row').show();
        $('form#financial_create #client_id_row').hide();
    }
    if ($('form#financial_create #party_client').is(':checked')) {
        $('form#financial_create #client_id_row').show();
        $('form#financial_create #vendor_id_row').hide();
    }

    $('form#financial_create #party_vendor').change(function () {
        $('form#financial_create #vendor_id_row').show();
        $('form#financial_create #client_id_row').hide();
        $('form#financial_create #job_id').val('');
        $('form#financial_create #job_id').prop('disabled', false);
        $('form#financial_create #job_id_hidden').remove();
        $('form#financial_create #job_id').change();
    });
    $('form#financial_create #party_client').change(function () {
        $('form#financial_create #client_id_row').show();
        $('form#financial_create #vendor_id_row').hide();
        var selectedClient = $('form#financial_create #client_id').val();
        $('form#financial_create #job_id').val(selectedClient);
        $('form#financial_create #job_id').prop('disabled', true);
        if ($('form#financial_create #job_id_hidden').length) {
            $('form#financial_create #job_id_hidden').val(selectedClient);
        } else {
            $('form#financial_create #job_id').after('<input id="job_id_hidden" type="hidden" name="job_id" value="' + selectedClient + '" />');
        }
        $('form#financial_create #job_id').change();
    });

    $('form#financial_create #vendor_id').select2({
        width: '100%'
    });
    $('form#financial_create #client_id').select2({
        width: '100%'
    });
    $('form#financial_create #job_id').select2({
        width: '100%'
    });

    $('form#financial_create #client_id').change(function () {
        var selectedClient = $(this).val();
        $('form#financial_create #job_id').val(selectedClient);
        $('form#financial_create #job_id').prop('disabled', true);
        if ($('form#financial_create #job_id_hidden').length) {
            $('form#financial_create #job_id_hidden').val(selectedClient);
        } else {
            $('form#financial_create #job_id').after('<input id="job_id_hidden" type="hidden" name="job_id" value="' + selectedClient + '" />');
        }
        $('form#financial_create #job_id').change();
    });
});