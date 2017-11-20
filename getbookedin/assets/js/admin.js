/**
 * Created by user on 22-07-2015.
 */

var AdminSetting = {
    MIN_PASSWORD_LENGTH: 7
};

$(document).ready(function() {

    $('#save-admin').click(function() {
        var admin = {
            'first_name': $('#admin-first-name').val(),
            'last_name': $('#admin-last-name').val(),
            'email': $('#admin-email').val(),
            'mobile_number': $('#admin-mobile-number').val(),
            'phone_number': $('#admin-phone-number').val(),
            'address': $('#admin-address').val(),
            'city': $('#admin-city').val(),
            'state': $('#admin-state').val(),
            'zip_code': $('#admin-zip-code').val(),
            'notes': $('#admin-notes').val(),
            'settings': {
            }
        };

        //default service id
        //user.services = [];
        //user.services.push(13);

        // Include password if changed.
        if ($('#admin-password').val() !== '') {
            admin.password = $('#admin-password').val();
        }

        // Include id if changed.
        if ($('#admin-id').val() !== '') {
            admin.id = $('#admin-id').val();
        }

        if (!AdminSetting.validate()) return;

        AdminSetting.save(admin);

        //      BackendUsers.helper.save(user);
    });

    $('#cancel-admin').click(function() {
        AdminSetting.resetForm();
    });


    $('#subdomain_name').focusout(function() {
        var $input = $(this);
        var subdomain = {
            'subdomain': $input.val(),
            'user_id': $('#admin-id').val()
        };
        AdminSetting.subdomainvalidate(subdomain);
    });

    $('#save-subdomain').click(function() {
        var domain = {
            'subdomain_name': $('#subdomain_name').val(),
            'id_admin': $('#admin-id').val()
        };
        if (!AdminSetting.validateSubdomain()) return;

        AdminSetting.saveSubdomain(domain);

    });

    $('#cancel-subdomain').click(function() {
       AdminSetting.resetSubdomainForm();
    });

    $('#save-page').click(function() {
        /*
        var page = {
            'id_admin': $('#admin-id').val(),
            'logo': $('#uploadFile').val(),
            'header_color': $('#header_color').val(),
            'header_back_color': $('#header_back_color').val(),
            'header_caption': $('#header_caption').val(),
            'footer_back_color': $('#footer_back_color').val()
        };

        if(!AdminSetting.validatePage()) return;

        AdminSetting.savePage(page);
        */
    });

    $('#cancel-page').click(function() {
       AdminSetting.resetPageForm();
    });

});

AdminSetting.subdomainvalidate = function(subdomain) {

    var postUrl = GlobalVariables.baseUrl + '/index.php/admin/ajax_validate_subdomain';
    var postData = {
        'csrfToken': GlobalVariables.csrfToken,
        'subdomain': JSON.stringify(subdomain)
    };
        //JSON.stringify(subdomain);

    //console.log(postData);
    //console.log(postUrl);

    $.post(postUrl, postData, function(response) {
        ///////////////////////////////////////////////////////
        console.log('Validate subdomain Response:', response);
        ///////////////////////////////////////////////////////
        if (!GeneralFunctions.handleAjaxExceptions(response)) return;
        if (response == false) {
            $('#subdomain_name').css('border', '2px solid red');
            $('#subdomain_name').attr('already-exists', 'true');
            $('#subdomain_name').parents().eq(3).find('.form-message').text(EALang['subdomain_already_exists']);
            $('#subdomain_name').parents().eq(3).find('.form-message').show();
            $('#save-subdomain').prop('disabled');
        } else {
            $('#subdomain_name').css('border', '2px solid green');
            $('#subdomain_name').attr('already-exists', 'false');
            $('#subdomain_name').parents().eq(3).find('.form-message').text( EALang['subdomain_available']);
            $('#subdomain_name').parents().eq(3).find('.form-message').show();
        }
    }, 'json');

}

AdminSetting.saveSubdomain = function(domain) {
    var postUrl = GlobalVariables.baseUrl + '/index.php/admin/ajax_save_subdomain';
    var postData = {
        'csrfToken': GlobalVariables.csrfToken,
        'subdomain': JSON.stringify(domain)
    };

    console.log(postData);
    $.post(postUrl, postData, function(response) {
       ///////////////////////////////////////////////////////
        console.log(response);
        ////////////////////////////////////////////////////
        if (response.status) {
            window.location.href = GlobalVariables.baseUrl + '/index.php/admin/page';
        }
    }, 'json');

}

AdminSetting.validateSubdomain = function() {
    $('#subdomain .required').css('border', '');

    try {
        // Validate required fields.
        var missingRequired = false;
        $('#subdomain .required').each(function() {
            if ($(this).val() == '' || $(this).val() == undefined) {
                $(this).css('border', '2px solid red');
                missingRequired = true;
            }
        });
        if (missingRequired) {
            throw EALang['fields_are_required'];
        }


        return true;
    } catch(exc) {
        $('#subdomain .form-message').text(exc);
        $('#subdomain .form-message').show();
        return false;
    }
}

AdminSetting.validatePage = function() {
    $('#page .required').css('border', '');

    try {
        // Validate required fields.
        var missingRequired = false;
        $('#page .required').each(function() {
            if ($(this).val() == '' || $(this).val() == undefined) {
                $(this).css('border', '2px solid red');
                missingRequired = true;
            }
        });
        if (missingRequired) {
            throw EALang['fields_are_required'];
        }


        return true;
    } catch(exc) {
        $('#page .form-message').text(exc);
        $('#page .form-message').show();
        return false;
    }
}

AdminSetting.savePage = function(page) {

    var postUrl = GlobalVariables.baseUrl + '/index.php/admin/ajax_save_page';
    var postData = {
        'csrfToken': GlobalVariables.csrfToken,
        'page': JSON.stringify(page)
    };

    $.post(postUrl, postData, function(response) {
        ///////////////////////////////////////////////////
        console.log('Page save response:', response);
        //////////////////////////////////////////////////
        if (response.status) {
            window.location.href = GlobalVariables.baseUrl + '/index.php/admin/login';
        }

    }, 'json');
}
/**
 *
 * Save Admin record to database
 * @param {Object} user
 */
AdminSetting.save = function(admin) {

    var postUrl = GlobalVariables.baseUrl+ '/index.php/backend_api/ajax_save_admin_user';
    var postData = {
        'csrfToken': GlobalVariables.csrfToken,
        'admin': JSON.stringify(admin)
    };

    $.post(postUrl, postData, function(respnse) {
        ///////////////////////////////////////////////////////////////////////
        console.log('Saved admin:', respnse);
        //////////////////////////////////////////////////////////////////////

        if(!GeneralFunctions.handleAjaxExceptions(respnse)) return;

        //Backend.displayNotification(EALang['customer_saved']);


        if (respnse.status == "SUCCESS") {
            AdminSetting.resetForm();
            $('#admin .form-message').text(EALang['customer_saved']);
            $('#admin .form-message').show();
            window.location.href = GlobalVariables.baseUrl + '/index.php/admin/subdomain';
        } else {


            var txt =  GeneralFunctions.parseExceptions(respnse.exception);
            var messsage = "";
            $.each(txt, function(index, exception) {
                //parsedExceptions.push($.parseJSON(exception));
                messsage = exception['message'];
                console.log('TXT[0]:',exception);
                console.log('TXT[0]:',exception['message']);
            });

            $('#admin .form-message').text(messsage);
            $('#admin .form-message').show();
        }

    }, 'json');
}


/**
 *
 * To validate the admin details
 * @param user Object admin details
 * @returns {boolean}
 */
AdminSetting.validate = function() {
    $('#admin .required').css('border', '');
    $('#admin-password, #admin-password-confirm').css('border', '');

    try {
        // Validate required fields.
        var missingRequired = false;
        $('#admin .required').each(function() {
            if ($(this).val() == '' || $(this).val() == undefined) {
                $(this).css('border', '2px solid red');
                missingRequired = true;
            }
        });
        if (missingRequired) {
            throw EALang['fields_are_required'];
        }

        // Validate passwords.
        if ($('#admin-password').val() != $('#admin-password-confirm').val()) {
            $('#admin-password, #admin-password-confirm').css('border', '2px solid red');
            throw EALang['passwords_mismatch'];
        }

        if ($('#admin-password').val().length < AdminSetting.MIN_PASSWORD_LENGTH
            && $('#admin-password').val() != '') {
            $('#admin-password, #admin-password-confirm').css('border', '2px solid red');
            throw EALang['password_length_notice'].replace('$number', AdminSetting.MIN_PASSWORD_LENGTH);
        }

        // Validate admin email.
        if (!GeneralFunctions.validateEmail($('#admin-email').val())) {
            $('#admin-email').css('border', '2px solid red');
            throw EALang['invalid_email'];
        }

        // Check if username exists
        //if ($('#user-username').attr('already-exists') ==  'true') {
        //    $('#user-username').css('border', '2px solid red');
        //    throw EALang['username_already_exists'];
        //}

        return true;
    } catch(exc) {
        $('#admin .form-message').text(exc);
        $('#admin .form-message').show();
        return false;
    }
}

/**
 * Reset user form to initial state
 */
AdminSetting.resetForm = function() {

    $('#admin .form-message').hide();
    $('#admin .required').css('border', '');
    $('#admin-password, #admin-password-confirm').css('border', '');
    $('#admin').prop('disabled', true);

    $('#admin .user-view').find('input, textarea').val('');
    $('#admin input[type="checkbox"]').prop('checked', false);
    $('#admin .breaks tbody').empty();
}

AdminSetting.resetSubdomainForm = function() {
    $('#subdomain .form-message').hide();
    $('#subdomain .required').css('border', '');

    $('#subdomain .subdomain-settings').find('input, textarea').val('');

}

AdminSetting.resetPageForm = function() {
    $('#page .form-message').hide();
    $('#page .required').css('border', '');

    $('#page .page-settings').find('input, textarea').val('');
}
