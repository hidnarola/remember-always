/**
 * Common functions used 
 * @author KU 
 */
$(function () {
    //Display success/error flash messages
    if (s_msg != '') {
        new PNotify({
            title: 'Success!',
            text: s_msg,
            buttons: {
                sticker: false
            },
//            styling:'bootstrap3',
            type: 'success'
        });
    } else if (e_msg != '') {
        new PNotify({
            title: 'Error!',
            text: e_msg,
            buttons: {
                sticker: false
            },
            //            styling:'bootstrap3',
            type: 'error'
        });
    }
    if (reset_pwd == 1) {
        $('#resetpwd-modal').modal();
    }
    $("#owl-demo").owlCarousel({
        navigation: true, // Show next and prev buttons
        slideSpeed: 300,
        paginationSpeed: 400,
        singleItem: true
    });
    $("#testimonial").owlCarousel({
        autoPlay: 3000,
        items: 3,
        itemsDesktop: [1199, 3],
        itemsDesktopSmall: [979, 2]
    });

    $("#blog-carousel").owlCarousel({
        autoPlay: 3000,
        items: 3,
        itemsDesktop: [1199, 3],
        itemsDesktopSmall: [979, 2]
    });
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
        },
        submitHandler: function (form) {
            $('#login_form_btn').attr('disabled', true);
            form.submit();
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
                required: true,
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
                required: "Email is required",
                remote: jQuery.validator.format("Email already exist!")
            },
            password: {
                required: "Password is password",
                minlength: "Your password must be at least 5 characters long"
            },
            con_password: {
                required: "Confirm Password is required",
                minlength: "Your password must be at least 5 characters long",
                equalTo: "Please enter the same password as above"
            },
            firstname: {
                required: "Firstname is required",
            },
            lastname: {
                required: "Lastname is required",
            },
            terms_condition: {
                required: "Please accept terms and condition",
            }
        },
        submitHandler: function (form) {
            $('#signup_form_btn').attr('disabled', true);
            form.submit();
        }
    });
    $("#forgot_password_form").validate({
        rules: {
            email: {
                email: true,
                required: true,
                remote: site_url + 'login/check_email'
            }
        },
        messages: {
            email: {
                remote: jQuery.validator.format("Invalid Email Address")
            }
        },
        submitHandler: function (form) {
            $('#reset_password').attr('disabled', true);
            form.submit();
        }
    });

    $("#reset_password_form").validate({
        rules: {
            password: {
                required: true,
                minlength: 5
            },
            con_password: {
                required: true,
                minlength: 5,
                equalTo: "#password"
            },
        },
        messages: {
            password: {
                required: "Please enter a password",
                minlength: "Your password must be at least 5 characters long"
            },
            con_password: {
                required: "Please enter a password",
                minlength: "Your password must be at least 5 characters long",
                equalTo: "Please enter the same password as above"
            },
        },
        submitHandler: function (form) {
            $('#change_password_btn').attr('disabled', true);
            form.submit();
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
/**
 * Display Forgot password modal
 * @param string modalType
 */
function showForgotModal() {
    $('#login').modal('hide');
    $('#forgot-pwdmodal').modal();
}
function loginModal() {
    $('#forgot-pwdmodal').modal('hide');
    $('#login').modal();
}
function loginrestModal() {
    $('#resetpwd-modal').modal('hide');
    $('#login').modal();
}