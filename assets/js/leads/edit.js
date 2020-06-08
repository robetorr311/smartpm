var form = document.querySelector('form#lead_edit');
var aliases = {
    firstname: 'First Name',
    lastname: 'Last Name',
    address: 'Address',
    city: 'City',
    state: 'State',
    zip: 'Postal Code',
    phone1: 'Cell Phone',
    email: 'Email',
    lead_source: 'Lead Source',
    contract_date: 'Contract Date',
    contract_total: 'Contract Total'
};
form.addEventListener("submit", function (e) {
    var values = validate.collectFormValues(form);
    var errors = validate(values, {
        firstname: {
            presence: true
        },
        lastname: {
            presence: true
        },
        address: {
            presence: true
        },
        city: {
            presence: true
        },
        state: {
            presence: true
        },
        zip: {
            presence: true
        },
        phone1: {
            presence: true
        },
        email: {
            email: true
        },
        lead_source: {
            numericality: {
                notValid: ' contains invalid value'
            }
        },
        dumpster_status: {
            numericality: {
                notValid: ' contains invalid value'
            }
        },
        materials_status: {
            numericality: {
                notValid: ' contains invalid value'
            }
        },
        labor_status: {
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
var form_status = document.querySelector('form#lead_edit_status');
form_status.addEventListener("submit", function (e) {
    var values = validate.collectFormValues(form_status);
    var errors = validate(values, {
        contract_date: {
            datetime: {
                dateOnly: true
            }
        },
        contract_total: {
            numericality: {
                notValid: ' contains invalid value'
            }
        },
        status: {
            presence: true
        },
        category: {
            presence: true
        },
        type: {
            presence: true
        },
        classification: {
            presence: true
        }
    }, {
        format: 'flat',
        prettify: function prettify(string) {
            return aliases[string] || validate.prettify(string);
        }
    });
    if (errors) {
        e.preventDefault();
        displayValidationError(errors, 'validation-errors-status');
    }
});

$('#camera-uploads').change(function () {
    var file_data = $(this)[0].files;
    var jobid = $(this).data("jobid");
    var baseUrl = $(this).data("baseUrl");
    /*var len_files = file_data.length;
    var form_data = new FormData();
    for (var i = 0; i < len_files; i++) {
        form_data.append("photo[]", file_data[i]);
    }*/
    var len_files = file_data.length;
    for (var i = 0; i < len_files; i++) {
        var form_data = new FormData();
        form_data.append("photo[]", file_data[i]);
        $.ajax({
            url: baseUrl + 'lead/' + jobid + '/photo/upload', // point to server-side PHP script     
            dataType: 'text', // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function (php_script_response) {
                var obj = JSON.parse(php_script_response)
                if (obj.img && obj.img.length != 0) {
                    $.ajax({
                        type: 'POST',
                        url: baseUrl + 'lead/' + jobid + '/photo/save', // point to server-side PHP script     
                        data: {
                            id: jobid,
                            name: JSON.stringify(obj.img)
                        },
                        success: function (photoid) {
                            $('.camera-files-status div').show();
                        }
                    });
                } else if (obj.error) {
                    alert(obj.error);
                } else {
                    alert('Something went wrong!. File type not ok');
                }
            },
            error: function (jqXHR) {
                if (jqXHR.status == 413) {
                    alert('Large File, Max file size limit is 100MB.');
                } else {
                    alert('Something went wrong!. File type not ok');
                }
            }
        });
    }
});