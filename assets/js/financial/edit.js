var form = document.querySelector('form#financial_edit');
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
            presence: true,
            numericality: {
                notValid: ' contains invalid value'
            }
        },
        method: {
            presence: true,
            numericality: {
                notValid: ' contains invalid value'
            }
        },
        bank_account: {
            presence: true,
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
    if ($('form#financial_edit #party_vendor').is(':checked')) {
        validationJson['vendor_id'] = {
            presence: true,
            numericality: {
                notValid: ' contains invalid value'
            }
        };
    }
    if ($('form#financial_edit #party_client').is(':checked')) {
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

$(document).ready(function() {
    if ($('form#financial_edit #party_vendor').is(':checked')) {
        $('form#financial_edit #vendor_id_row').show();
        $('form#financial_edit #client_id_row').hide();
    }
    if ($('form#financial_edit #party_client').is(':checked')) {
        $('form#financial_edit #client_id_row').show();
        $('form#financial_edit #vendor_id_row').hide();
    }

    $('form#financial_edit #party_vendor').change(function () {
        $('form#financial_edit #vendor_id_row').show();
        $('form#financial_edit #client_id_row').hide();
    });
    $('form#financial_edit #party_client').change(function () {
        $('form#financial_edit #client_id_row').show();
        $('form#financial_edit #vendor_id_row').hide();
    });

    $('form#financial_edit #vendor_id').select2({
        width: '100%'
    });
    $('form#financial_edit #client_id').select2({
        width: '100%'
    });
    $('form#financial_edit #job_id').select2({
        width: '100%'
    });
});