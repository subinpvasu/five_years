/**
 * This class contains the Adminuser helper class declaration, along with the "Providers" tab
 * event handlers. By deviding the backend/users tab functionality into separate files
 * it is easier to maintain the code.
 * 
 * @class AdminUserHelper
 */
var AdminUserHelper = function() {
    this.filterResults = {}; // Store the results for later use.
};

/**
 * Bind the event handlers for the backend/users "Providers" tab.
 */
AdminUserHelper.prototype.bindEventHandlers = function() {
    /**
     * Event: Filter Providers Form "Submit"
     * 
     * Filter the provider records with the given key string.
     */
    $('#filter-adminuser form').submit(function(event) {
        var key = $('#filter-adminuser .key').val();
        $('.selected-row').removeClass('selected-row');
        AdminUserBackendUser.helper.resetForm();
        AdminUserBackendUser.helper.filter(key);
        return false;
    });

    /**
     * Event: Clear Filter Button "Click"
     */
    $('#filter-adminuser .clear').click(function() {
        AdminUserBackendUser.helper.filter('');
        $('#filter-adminuser .key').val('');
    });

    /**
     * Event: Filter Provider Row "Click"
     * 
     * Display the selected provider data to the user.
     */
    $(document).on('click', '.adminuser-row', function() {
        if ($('#filter-adminuser .filter').prop('disabled')) {
            $('#filter-adminuser .results').css('color', '#AAA');
            return; // Exit because we are currently on edit mode.
        }
        
        var providerId = $(this).attr('data-id');
        var provider = {};
        console.log(AdminUserBackendUser.helper.filterResults);
        $.each(AdminUserBackendUser.helper.filterResults, function(index, item) {
            if (item.id === providerId) {
                provider = item;
                return false;
            }
        });
        AdminUserBackendUser.helper.resetForm();
        AdminUserBackendUser.helper.display(provider);
        $('#filter-adminuser .selected-row').removeClass('selected-row');
        $(this).addClass('selected-row');
        $('#edit-adminuser, #delete-adminuser').prop('disabled', false);
    });

    /**
     * Event: Add New provider Button "Click"
     */
    $('#add-adminuser').click(function() {
        AdminUserBackendUser.helper.resetForm();
        $('#filter-adminuser button').prop('disabled', true);
        $('#filter-adminuser .results').css('color', '#AAA');
        $('#adminuser .add-edit-delete-group').hide();
        $('#adminuser .save-cancel-group').show();
        $('#adminuser .details').find('input, textarea').prop('readonly', false);
        $('#adminuser-password, #adminuser-password-confirm').addClass('required');
        $('#adminuser-notifications').prop('disabled', false);
        $('#adminuser').find('.add-break, .edit-break, .delete-break, #reset-working-plan').prop('disabled', false);
        //$('#provider-services input[type="checkbox"]').prop('disabled', false);
        $('#adminuser input[type="checkbox"]').prop('disabled', false);

        // Apply default working plan
        AdminUserBackendUser.wp.setup(GlobalVariables.workingPlan);
        AdminUserBackendUser.wp.timepickers(false);
    });

    /**
     * Event: Edit provider Button "Click"
     */
    $('#edit-adminuser').click(function() {
        $('#adminuser .add-edit-delete-group').hide();
        $('#adminuser .save-cancel-group').show();
        $('#filter-adminuser button').prop('disabled', true);
        $('#filter-adminuser .results').css('color', '#AAA');
        $('#adminuser .details').find('input, textarea').prop('readonly', false);
        $('#adminuser-password, #adminuser-password-confirm').removeClass('required');
        $('#adminuser-notifications').prop('disabled', false);
        //$('#provider-services input[type="checkbox"]').prop('disabled', false);
        $('#adminuser').find('.add-break, .edit-break, .delete-break, #reset-working-plan, #duration').prop('disabled', false);
        $('#adminuser input[type="checkbox"]').prop('disabled', false);
        AdminUserBackendUser.wp.timepickers(false);
    });

    /**
     * Event: Delete adminuser Button "Click"
     */
    $('#delete-adminuser').click(function() {
        var adminuserId = $('#adminuser-id').val();

        var messageBtns = {};
        messageBtns[EALang['delete']] = function() {
            AdminUserBackendUser.helper.delete(adminuserId);
            $('#message_box').dialog('close');
        };
        messageBtns[EALang['cancel']] = function() {
            $('#message_box').dialog('close');
        };

        GeneralFunctions.displayMessageBox(EALang['delete_provider'], 
                EALang['delete_record_prompt'], messageBtns);
    });

    /**
     * Event: Save adminuser Button "Click"
     */
    $('#save-adminuser').click(function() {
        var adminuser = {
            'first_name': $('#adminuser-first-name').val(),
            'last_name': $('#adminuser-last-name').val(),
            'email': $('#adminuser-email').val(),
            'mobile_number': $('#adminuser-mobile-number').val(),
            'phone_number': $('#adminuser-phone-number').val(),
            'address': $('#adminuser-address').val(),
            'city': $('#adminuser-city').val(),
            'state': $('#adminuser-state').val(),
            'zip_code': $('#adminuser-zip-code').val(),
            'notes': $('#adminuser-notes').val(),
            'settings': {
                //'username': $('#provider-username').val(),
                'working_plan': JSON.stringify(AdminUserBackendUser.wp.get()),
                'notifications': $('#adminuser-notifications').hasClass('active'),
                'duration': $('#duration').val()
            }
        };

        // Include provider services.
        ////provider.services = [];
        //$('#provider-services input[type="checkbox"]').each(function() {
        //    if ($(this).prop('checked')) {
        //        provider.services.push($(this).attr('data-id'));
        //    }
        //});

        // Include password if changed.
        if ($('#adminuser-password').val() !== '') {
            adminuser.password = $('#adminuser-password').val();
        }

        // Include id if changed.
        if ($('#adminuser-id').val() !== '') {
            adminuser.id = $('#adminuser-id').val();
        }

        if (!AdminUserBackendUser.helper.validate(adminuser)) return;

        AdminUserBackendUser.helper.save(adminuser);
    });

    /**
     * Event: Cancel Provider Button "Click"
     * 
     * Cancel add or edit of an provider record.
     */
    $('#cancel-adminuser').click(function() {
        var id = $('#filter-adminuser .selected-row').attr('data-id');
        AdminUserBackendUser.helper.resetForm();
        if (id != '') {
            AdminUserBackendUser.helper.select(id, true);
        }
    });

    /**
     * Event: Display Provider Details "Click"
     */
    $('#adminuser .display-details').click(function() {
        $('#adminuser .switch-view .current').removeClass('current');
        $(this).addClass('current');
        $('.working-plan-view').hide('fade', function() {
            $('.details-view').show('fade');
        });
    });

    /**
     * Event: Display Provider Working Plan "Click"
     */
    $('#adminuser .display-working-plan').click(function() {
        $('#adminuser .switch-view .current').removeClass('current');
        $(this).addClass('current');
        $('.details-view').hide('fade', function() {
            $('.working-plan-view').show('fade');
        });
    });
    
    /**
     * Event: Reset Working Plan Button "Click".
     */
    $('#reset-working-plan').click(function() {
        $('.breaks').empty();
        $('.work-start, .work-end').val('');
        AdminUserBackendUser.wp.setup(GlobalVariables.workingPlan);
        AdminUserBackendUser.wp.timepickers(false);
    });
};

/**
 * Save provider record to database.
 * 
 * @param {object} provider Contains the admin record data. If an 'id' value is provided
 * then the update operation is going to be executed.
 */
AdminUserHelper.prototype.save = function(adminuser) {
    //////////////////////////////////////////////////
    //console.log('AdminUser data to save:', adminuser);
    //////////////////////////////////////////////////
    
    var postUrl = GlobalVariables.baseUrl + '/index.php/backend_api/ajax_save_admin_user';
    var postData = { 
        'csrfToken': GlobalVariables.csrfToken,
        'admin': JSON.stringify(adminuser)
    };
    
    $.post(postUrl, postData, function(response) {
        ///////////////////////////////////////////////////
        console.log('Save AdminUser Response:', response);
        ///////////////////////////////////////////////////
        if (!GeneralFunctions.handleAjaxExceptions(response)) return;
        Backend.displayNotification(EALang['provider_saved']);
        AdminUserBackendUser.helper.resetForm();
        //console.log(response);

        $('#filter-adminuser .key').val('');
        AdminUserBackendUser.helper.filter(GlobalVariables.user.email, response.id, true);

    }, 'json');
};

/**
 * Delete a provider record from database.
 * 
 * @param {numeric} id Record id to be deleted. 
 */
AdminUserHelper.prototype.delete = function(id) {
    var postUrl = GlobalVariables.baseUrl + '/index.php/backend_api/ajax_delete_provider';
    var postData = { 
        'csrfToken': GlobalVariables.csrfToken,
        'provider_id': id
    };
    
    $.post(postUrl, postData, function(response) {
        /////////////////////////////////////////////////////
        //console.log('Delete provider response:', response);
        /////////////////////////////////////////////////////
        if (!GeneralFunctions.handleAjaxExceptions(response)) return;
        Backend.displayNotification(EALang['provider_deleted']);
        AdminUserBackendUser.helper.resetForm();
        AdminUserBackendUser.helper.filter($('#filter-adminuser .key').val());
    }, 'json');
};

/**
 * Validates a provider record.
 * 
 * @param {object} provider Contains the admin data to be validated.
 * @returns {bool} Returns the validation result.
 */
AdminUserHelper.prototype.validate = function(provider) {
    $('#adminuser .required').css('border', '');
    $('#adminuser-password, #adminuser-password-confirm').css('border', '');
    
    try {
        // Validate required fields.
        var missingRequired = false;
        $('#adminuser .required').each(function() {
            if ($(this).val() == '' || $(this).val() == undefined) {
                $(this).css('border', '2px solid red');
                missingRequired = true;
            }
        });
        if (missingRequired) {
            throw EALang['fields_are_required'];
        }
        
        // Validate passwords.
        if ($('#adminuser-password').val() != $('#adminuser-password-confirm').val()) {
            $('#adminuser-password, #adminuser-password-confirm').css('border', '2px solid red');
            throw EALang['passwords_mismatch'];
        }
        
        if ($('#adminuser-password').val().length < AdminUserBackendUser.MIN_PASSWORD_LENGTH
                && $('#adminuser-password').val() != '') {
            $('#adminuser-password, #adminuser-password-confirm').css('border', '2px solid red');
            throw EALang['password_length_notice'].replace('$number', AdminUserBackendUser.MIN_PASSWORD_LENGTH);
        }
        
        // Validate user email.
        if (!GeneralFunctions.validateEmail($('#adminuser-email').val())) {
            $('#adminuser-email').css('border', '2px solid red');
            throw EALang['invalid_email'];
        }
        
        // Check if username exists
        if ($('#adminuser-email').attr('already-exists') ==  'true') {
            $('#adminuser-email').css('border', '2px solid red');
            throw EALang['username_already_exists'];
        } 
        
        return true;
    } catch(exc) {
        $('#adminuser .form-message').text(exc);
        $('#adminuser .form-message').show();
        return false;
    }
};

/**
 * Resets the admin tab form back to its initial state. 
 */
AdminUserHelper.prototype.resetForm = function() {
    $('#filter-adminuser .selected-row').removeClass('selected-row');
    $('#filter-adminuser button').prop('disabled', false);
    $('#filter-adminuser .results').css('color', '');
    
    $('#adminuser .add-edit-delete-group').show();
    $('#adminuser .save-cancel-group').hide();
    $('#adminuser .details').find('input, textarea').prop('readonly', true);
    $('#adminuser .form-message').hide();
    $('#adminuser-notifications').removeClass('active');
    $('#adminuser-notifications').prop('disabled', true);
    //$('#provider-services input[type="checkbox"]').prop('disabled', true);
    $('#adminuser .required').css('border', '');
    $('#adminuser-password, #adminuser-password-confirm').css('border', '');
    $('#adminuser .add-break, #reset-working-plan').prop('disabled', true);
    $('#adminuser #duration').prop('disabled', true);
    AdminUserBackendUser.wp.timepickers(true);
    $('#adminuser .working-plan input[type="text"]').timepicker('destroy');
    $('#adminuser .working-plan input[type="checkbox"]').prop('disabled', true);
    $('.breaks').find('.edit-break, .delete-break').prop('disabled', true);

    $('#edit-adminuser, #delete-adminuser').prop('disabled', true);
    $('#adminuser .details').find('input, textarea').val('');
    $('#adminuser input[type="checkbox"]').prop('checked', false);
    //$('#provider-services input[type="checkbox"]').prop('checked', false);
    $('#adminuser .breaks tbody').empty();

};

/**
 * Display a provider record into the admin form.
 * 
 * @param {object} provider Contains the provider record data.
 */
AdminUserHelper.prototype.display = function(adminuser) {
    $('#adminuser-id').val(adminuser.id);
    $('#adminuser-first-name').val(adminuser.first_name);
    $('#adminuser-last-name').val(adminuser.last_name);
    $('#adminuser-email').val(adminuser.email);
    $('#adminuser-mobile-number').val(adminuser.mobile_number);
    $('#adminuser-phone-number').val(adminuser.phone_number);
    $('#adminuser-address').val(adminuser.address);
    $('#adminuser-city').val(adminuser.city);
    $('#adminuser-state').val(adminuser.state);
    $('#adminuser-zip-code').val(adminuser.zip_code);
    $('#adminuser-notes').val(adminuser.notes);
    
    //$('#provider-username').val(provider.settings.username);
    if (adminuser.settings.notifications == true) {
        $('#adminuser-notifications').addClass('active');
    } else {
        $('#adminuser-notifications').removeClass('active');
    }
    
    //$('#provider-services input[type="checkbox"]').prop('checked', false);
    //$.each(provider.services, function(index, serviceId) {
    //    $('#provider-services input[type="checkbox"]').each(function() {
    //        if ($(this).attr('data-id') == serviceId) {
    //            $(this).prop('checked', true);
    //        }
    //    });
    //});
    
    // Display working plan
    $('#adminuser .breaks tbody').empty();
    var workingPlan = $.parseJSON(adminuser.settings.working_plan);
    AdminUserBackendUser.wp.setup(workingPlan);
    $('.breaks').find('.edit-break, .delete-break').prop('disabled', true);
};

/**
 * Filters adminuser records depending a string key.
 * 
 * @param {string} key This is used to filter the provider records of the database.
 * @param {numeric} selectId (OPTIONAL = undefined) If set, when the function is complete
 * a result row can be set as selected. 
 * @param {bool} display (OPTIONAL = false) If true then the selected record will be also 
 * displayed.
 */
AdminUserHelper.prototype.filter = function(key, selectId, display) {
    if (display == undefined) display = false;
    
    var postUrl = GlobalVariables.baseUrl + '/index.php/backend_api/ajax_filter_adminuser';
    var postData = { 
        'csrfToken': GlobalVariables.csrfToken,
        'key': key 
    };
    
    $.post(postUrl, postData, function(response) {
        //////////////////////////////////////////////////////
        console.log('Filter providers response:', response);
        //////////////////////////////////////////////////////
        
        if (!GeneralFunctions.handleAjaxExceptions(response)) return;
        
        AdminUserBackendUser.helper.filterResults = response;
        
        
        $('#filter-adminuser .results').data('jsp').destroy;
        $('#filter-adminuser .results').html('');
        $.each(response, function(index, adminuser) {
            var html = AdminUserHelper.prototype.getFilterHtml(adminuser);
            $('#filter-adminuser .results').append(html);
        });
        $('#filter-adminuser .results').jScrollPane({ mouseWheelSpeed: 70 });
        
        if (response.length == 0) {
            $('#filter-adminuser .results').html('<em>' + EALang['no_records_found'] + '</em>')
        }

        //Display call
        AdminUserBackendUser.helper.resetForm();
        AdminUserBackendUser.helper.display(response[0]);
        $('#edit-adminuser, #delete-adminuser').prop('disabled', false);
        
        if (selectId != undefined) {
            AdminUserBackendUser.helper.select(selectId, display);
        }
    }, 'json');
};

/**
 * Get an provider row html code that is going to be displayed on the filter results list.
 * 
 * @param {object} provider Contains the provider record data.
 * @returns {string} The html code that represents the record on the filter results list.
 */
AdminUserHelper.prototype.getFilterHtml = function(adminuser) {
    var name = adminuser.first_name + ' ' + adminuser.last_name;
    var info = adminuser.email;
    info = (adminuser.mobile_number != '' && adminuser.mobile_number != null)
            ? info + ', ' + adminuser.mobile_number : info;
    info = (adminuser.phone_number != '' && adminuser.phone_number != null)
            ? info + ', ' + adminuser.phone_number : info;
    
    var html =
            '<div class="adminuser-row" data-id="' + adminuser.id + '">' +
                '<strong>' + name + '</strong><br>' +
                info + '<br>' + 
            '</div><hr>';

    return html;
};

/**
 * Initialize the editable functionality to the break day table cells.
 * 
 * @param {object} $selector The cells to be initialized.
 */
AdminUserHelper.prototype.editableBreakDay = function($selector) {
    var weekDays = {};
    weekDays[EALang['monday']] = 'Monday';
    weekDays[EALang['tuesday']] = 'Tuesday';
    weekDays[EALang['wednesday']] = 'Wednesday';
    weekDays[EALang['thursday']] = 'Thursday';
    weekDays[EALang['friday']] = 'Friday';
    weekDays[EALang['saturday']] = 'Saturday';
    weekDays[EALang['sunday']] = 'Sunday';


    $selector.editable(function(value, settings) {
        return value;
    }, {
        'type': 'select',
        // 'data': '{ "Monday": "Monday", "Tuesday": "Tuesday", "Wednesday": "Wednesday", '
        //         + '"Thursday": "Thursday", "Friday": "Friday", "Saturday": "Saturday", '
        //         + '"Sunday": "Sunday", "selected": "Monday"}',
        'data': weekDays,
        'event': 'edit',
        'height': '30px',
        'submit': '<button type="button" class="hidden submit-editable">Submit</button>',
        'cancel': '<button type="button" class="hidden cancel-editable">Cancel</button>',
        'onblur': 'ignore',
        'onreset': function(settings, td) {
            if (!AdminUserBackendUser.enableCancel) return false; // disable ESC button
        },
        'onsubmit': function(settings, td) {
            if (!AdminUserBackendUser.enableSubmit) return false; // disable Enter button
        }
    });
};

/**
 * Initialize the editable functionality to the break time table cells.
 * 
 * @param {object} $selector The cells to be initialized.
 */        
AdminUserHelper.prototype.editableBreakTime = function($selector) {
    $selector.editable(function(value, settings) {
        // Do not return the value because the user needs to press the "Save" button.
        return value;
    }, {
        'event': 'edit',
        'height': '25px',
        'submit': '<button type="button" class="hidden submit-editable">Submit</button>',
        'cancel': '<button type="button" class="hidden cancel-editable">Cancel</button>',
        'onblur': 'ignore',
        'onreset': function(settings, td) {
            if (!AdminUserBackendUser.enableCancel) return false; // disable ESC button
        },
        'onsubmit': function(settings, td) {
            if (!AdminUserBackendUser.enableSubmit) return false; // disable Enter button
        }
    });
};

/**
 * Select and display a providers filter result on the form.
 * 
 * @param {numeric} id Record id to be selected.
 * @param {bool} display (OPTIONAL = false) If true the record will be displayed on the form.
 */
AdminUserHelper.prototype.select = function(id, display) {
    if (display == undefined) display = false;
    
    // Select record in filter results.
    $('#filter-adminuser .adminuser-row').each(function() {
        if ($(this).attr('data-id') == id) {
            $(this).addClass('selected-row');
            return false;
        }
    });
    
    // Display record in form (if display = true).
    if (display) {
        $.each(AdminUserBackendUser.helper.filterResults, function(index, adminuser) {
            if (adminuser.id == id) {
                AdminUserBackendUser.helper.display(adminuser);
                $('#edit-adminuser, #delete-adminuser').prop('disabled', false);
                return false;
            }
        });
    }
};