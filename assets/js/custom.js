/**
 * Common functions used 
 * @author KU 
 */
$(function () {

    // Login Form validation
    $("#login-form").validate({
        rules: {
            email: {
                required: true,
                email: true,
            },
            password: {
                required: true,
            }
        },
        messages: {
            email: {
                required: "Enter your email",
            },
            password: {
                required: "Enter your password",
            }
        }
    });
    // Signup Form validation
    $("#signup-form").validate({
        rules: {
            email: {
                email: true,
                required: true,
                remote: site_url + 'signup/check_email'
            },
            firstname: {
                required: true,
            },
            lastname: {
                required: true,
            },
            password: {
                minlength: 5
            },
            con_password: {
                required: true,
                minlength: 5,
                equalTo: "#password"
            },
            terms_condition: {
                required: true,
            }
        },
        messages: {
            email: {
                remote: jQuery.validator.format("Email already exist!")
            },
            firstname: {
                required: "Firstname is required",
            },
            lastname: {
                required: "Lastname is required",
            },
            password: {
                required: "Enter your password",
                minlength: jQuery.validator.format("At least {0} characters required")
            },
            con_password: {
                required: "Please enter a password",
                minlength: "Your password must be at least 5 characters long",
                equalTo: "Please enter the same password as above"
            },
            terms_condition: {
                required: "Please accept terms and condition",
            }
        }
    });

});
/**
 * Display Login/signup modal
 * @param string modalType
 */
function showModal(modalType) {
    $('#login').modal();
    $('.nav-tabs a[href="#' + modalType + '"]').tab('show');
}
